<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\Category;
use App\Models\Product;

class SuggestionsController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = collect();

        // 1. Categories
        $categories = Category::where('name', 'like', "%{$query}%")
            ->limit(3)
            ->get()
            ->map(fn($c) => [
                'type' => 'category',
                'text' => $c->name,
                'url'  => route('search', ['q' => $c->name]),
            ]);
        $suggestions = $suggestions->concat($categories);

        // 2. Businesses
        $businesses = Business::where('status', 'active')
            ->where('name', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(fn($b) => [
                'type' => 'business',
                'text' => $b->name,
                'url'  => $b->getUrl(),
            ]);
        $suggestions = $suggestions->concat($businesses);

        // 3. Products
        $products = Product::where('name', 'like', "%{$query}%")
            ->whereHas('business', fn($q) => $q->where('status', 'active'))
            ->limit(5)
            ->get()
            ->map(fn($p) => [
                'type' => 'product',
                'text' => $p->name,
                'url'  => route('search', ['q' => $p->name]),
                'business' => $p->business->name,
            ]);
        $suggestions = $suggestions->concat($products);

        return response()->json($suggestions->unique('text')->values());
    }
}
