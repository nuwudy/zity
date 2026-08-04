<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Business;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $recentSchools = Business::where('is_verified', true)->latest()->take(6)->get();
        return view('home', compact('categories', 'recentSchools'));
    }

    public function checkAvailability(Request $request)
    {
        $name = $request->query('name');
        if (!$name) {
            return response()->json(['available' => false, 'message' => 'Please enter a name']);
        }

        $slug = Str::slug($name);
        $exists = Business::where('slug', $slug)->exists();

        return response()->json([
            'available' => !$exists,
            'slug' => $slug,
            'message' => $exists ? 'Domain already taken' : 'Domain available!',
        ]);
    }

    public function registerShop(Request $request)
    {
        $request->validate([
            'shop_name'    => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'email'        => 'nullable|email|max:255',
            'password'     => 'required|string',
            'type'         => 'nullable|in:shop,service,both',
            'service_area' => 'nullable|string|max:255',
        ]);

        $slug = Str::slug($request->shop_name);
        
        // Reject if the slug is already taken (hard fail — no silent rename)
        if (Business::where('slug', $slug)->exists()) {
            return back()
                ->withErrors(['shop_name' => "The brand name \"$slug\" is already taken. Please choose a different name."])
                ->withInput();
        }

        // Handle User Email (Must be unique in users table)
        $userEmail = $request->email;
        if (!$userEmail || User::where('email', $userEmail)->exists()) {
            // Generate a unique fallback email if none provided or if provided is taken
            $userEmail = $slug . '@zity.in';
            $emailCount = 1;
            while (User::where('email', $userEmail)->exists()) {
                $userEmail = $slug . $emailCount++ . '@zity.in';
            }
        }

        $user = User::create([
            'name' => $request->shop_name . ' Admin',
            'email' => $userEmail,
            'password' => Hash::make($request->password),
            'role' => 'business_owner',
        ]);

        $business = Business::create([
            'name'            => $request->shop_name,
            'slug'            => $slug,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'whatsapp'        => $request->phone,
            'user_id'         => $user->id,
            'is_verified'     => false,
            'type'            => $request->input('type', 'shop'),
            'service_area'    => $request->service_area,
        ]);

        Auth::login($user);

        return redirect()->route('register.success', ['slug' => $slug]);
    }

    public function registerSuccess($slug)
    {
        $business = Business::where('slug', $slug)->firstOrFail();
        return view('register-success', compact('business'));
    }
}
