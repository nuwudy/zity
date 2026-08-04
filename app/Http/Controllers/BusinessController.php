<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Business;

class BusinessController extends Controller
{
    public function show(Request $request, Business $business)
    {
        $ogProduct = null;
        if ($request->has('product')) {
            $ogProduct = \App\Models\Product::find($request->query('product'));
        }

        if ($business->type === Business::TYPE_SERVICE) {
            return view('business.service', compact('business'));
        }

        $products = $business->products()->where('is_active', true)->get();
        // Product categories not yet implemented for filtering
        $productCategories = collect();

        return view('business.show', compact('business', 'products', 'productCategories', 'ogProduct'));
    }
}
