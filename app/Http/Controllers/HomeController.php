<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\Product;
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
        $recentSchools = Business::where('status', 'active')->orWhere('is_verified', true)->latest()->take(8)->get();
        
        // Fetch real deals / products from businesses or fallbacks
        $trendingProducts = Product::where('is_active', true)
            ->with('business')
            ->latest()
            ->take(12)
            ->get();

        // Sample / dynamic locations
        $popularLocations = [
            'Edappally', 'Kakkanad', 'Kaloor', 'Palarivattom',
            'Vyttila', 'Kundannoor', 'Aluva', 'Marine Drive', 'Panampilly Nagar', 'Fort Kochi'
        ];

        return view('home', compact('categories', 'recentSchools', 'trendingProducts', 'popularLocations'));
    }

    public function checkAvailability(Request $request)
    {
        $name = $request->query('name');
        if (!$name) {
            return response()->json(['available' => false, 'message' => 'Please enter a brand name']);
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
            'password'     => Auth::check() ? 'nullable|string' : 'required|string|min:6',
            'type'         => 'nullable|in:shop,service,both',
            'service_area' => 'nullable|string|max:255',
        ]);

        $slug = Str::slug($request->shop_name);
        
        if (Business::where('slug', $slug)->exists()) {
            return back()
                ->withErrors(['shop_name' => "The brand name \"$slug\" is already taken. Please choose a different name."])
                ->withInput();
        }

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role !== 'admin') {
                $user->role = 'business_owner';
                $user->save();
            }
        } else {
            $userEmail = $request->email;
            if (!$userEmail || User::where('email', $userEmail)->exists()) {
                $userEmail = $slug . '@zity.in';
                $emailCount = 1;
                while (User::where('email', $userEmail)->exists()) {
                    $userEmail = $slug . $emailCount++ . '@zity.in';
                }
            }

            $user = User::create([
                'name' => $request->shop_name . ' Admin',
                'email' => $userEmail,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 'business_owner',
                'coins' => 10,
                'credits' => 250.00,
            ]);

            Auth::login($user);
        }

        $business = Business::create([
            'name'            => $request->shop_name,
            'slug'            => $slug,
            'email'           => $request->email ?? $user->email,
            'phone'           => $request->phone,
            'whatsapp'        => $request->phone,
            'user_id'         => $user->id,
            'is_verified'     => true,
            'status'          => 'active',
            'type'            => $request->input('type', 'shop'),
            'service_area'    => $request->service_area ?? 'Kochi',
        ]);

        // Attach to pivot table if present
        if (method_exists($user, 'businesses')) {
            $user->businesses()->syncWithoutDetaching([$business->id]);
        }

        return redirect()->route('register.success', ['slug' => $slug]);
    }

    public function registerSuccess($slug)
    {
        $business = Business::where('slug', $slug)->firstOrFail();
        return view('register-success', compact('business'));
    }
}
