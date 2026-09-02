<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show login/register page or return modal view.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('profile.index');
        }
        return view('auth.login');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
            'website_hp' => 'nullable|string', // Honeypot field for bot protection
        ]);

        // Simple Bot Protection Check
        if ($request->filled('website_hp')) {
            return back()->withErrors(['login_id' => 'Suspicious activity detected.'])->withInput();
        }

        $loginId = trim($request->input('login_id'));
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Determine whether login_id is email or phone or name
        $field = filter_var($loginId, FILTER_VALIDATE_EMAIL) ? 'email' : (is_numeric(str_replace(['+', '-', ' '], '', $loginId)) ? 'phone' : 'name');

        if (Auth::attempt([$field => $loginId, 'password' => $password], $remember)) {
            $request->session()->regenerate();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('home'),
                    'user' => Auth::user(),
                ]);
            }

            return redirect()->intended(route('home'))->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        // Try phone fallback without country code if entered with +91
        $cleanedPhone = preg_replace('/^\+91|\D/', '', $loginId);
        if ($cleanedPhone && Auth::attempt(['phone' => $cleanedPhone, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials do not match our records.',
            ], 422);
        }

        return back()->withErrors([
            'login_id' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('login_id', 'remember'));
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'website_hp' => 'nullable|string', // Honeypot field
        ]);

        if ($request->filled('website_hp')) {
            return back()->withErrors(['email' => 'Suspicious activity detected.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'coins' => 10, // 10 Welcome Bonus Coins
            'credits' => 250.00, // Starting promo credits
            'is_profile_completed' => false,
            'is_verified' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        // Flash flag to display New User Welcome Reward Modal
        session()->flash('new_user_welcome', true);
        session()->flash('reward_coins', 10);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => route('home'),
                'coins' => 10,
                'user' => $user,
            ]);
        }

        return redirect()->route('home')->with('new_user_welcome', true);
    }

    /**
     * Complete profile setup after registration (+5 extra coins bonus).
     */
    public function completeProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|max:2048',
        ]);

        $updateData = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $updateData['avatar'] = $path;
        }

        // Award +5 coins if first time completing profile
        if (!$user->is_profile_completed) {
            $updateData['coins'] = $user->coins + 5;
            $updateData['is_profile_completed'] = true;
            $message = 'Profile updated successfully! You earned +5 bonus Zity Coins!';
        } else {
            $message = 'Profile updated successfully!';
        }

        $user->update($updateData);

        return redirect()->route('profile.index')->with('success', $message);
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('info', 'You have been logged out.');
    }
}
