<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Product;
use App\Models\SavedDeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the hybrid User Profile (Customer Area + Business Area).
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Get all businesses owned or associated with the user
        $businesses = $user->all_owned_businesses;

        // Fetch user's saved deals / bookmarks
        $savedDeals = SavedDeal::where('user_id', $user->id)
            ->with(['business', 'product'])
            ->latest()
            ->get();

        // Sample bookings / transactions count for customer area
        $bookingsCount = SavedDeal::where('user_id', $user->id)->where('type', 'booking')->count();
        $unlockedDealsCount = SavedDeal::where('user_id', $user->id)->where('type', 'unlocked')->count();

        return view('profile.index', compact('user', 'businesses', 'savedDeals', 'bookingsCount', 'unlockedDealsCount'));
    }

    /**
     * Show dedicated business management view or list.
     */
    public function myBusinesses()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $businesses = $user->all_owned_businesses;
        return view('profile.businesses', compact('user', 'businesses'));
    }

    /**
     * Toggle Save / Bookmark a deal.
     */
    public function toggleSaveDeal(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'require_login' => true], 401);
        }

        $productId = $request->input('product_id');
        $businessId = $request->input('business_id');
        $dealTitle = $request->input('deal_title');

        $existing = SavedDeal::where('user_id', $user->id)
            ->where(function ($q) use ($productId, $businessId, $dealTitle) {
                if ($productId) {
                    $q->where('product_id', $productId);
                } elseif ($businessId) {
                    $q->where('business_id', $businessId);
                } else {
                    $q->where('deal_title', $dealTitle);
                }
            })
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['success' => true, 'status' => 'removed', 'message' => 'Deal removed from saved items.']);
        }

        SavedDeal::create([
            'user_id' => $user->id,
            'business_id' => $businessId,
            'product_id' => $productId,
            'deal_title' => $dealTitle,
            'type' => 'saved',
        ]);

        return response()->json(['success' => true, 'status' => 'saved', 'message' => 'Deal saved to your profile!']);
    }

    /**
     * Unlock a deal using Zity Coins.
     */
    public function unlockDeal(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'require_login' => true], 401);
        }

        $coinsCost = (int) $request->input('coins', 10);
        $dealTitle = $request->input('deal_title', 'Special Deal');
        $productId = $request->input('product_id');
        $businessId = $request->input('business_id');

        if ($user->coins < $coinsCost) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough Zity Coins! You have ' . $user->coins . ' coins. Spin daily or refer friends to earn more.',
            ], 400);
        }

        // Deduct coins
        $user->coins = max(0, $user->coins - $coinsCost);
        $user->save();

        SavedDeal::create([
            'user_id' => $user->id,
            'business_id' => $businessId,
            'product_id' => $productId,
            'deal_title' => $dealTitle,
            'type' => 'unlocked',
            'coins_used' => $coinsCost,
        ]);

        return response()->json([
            'success' => true,
            'remaining_coins' => $user->coins,
            'message' => 'Deal unlocked successfully! 🎉 Coupon code generated.',
            'coupon_code' => 'ZITY' . strtoupper(substr(md5(time() . $user->id), 0, 6)),
        ]);
    }

    /**
     * Update Profile Information
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}
