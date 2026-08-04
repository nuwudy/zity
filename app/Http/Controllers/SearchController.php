<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (empty($query)) {
            return view('search', [
                'results'      => collect(),
                'query'        => '',
                'total'        => 0,
                'suggestions'  => Business::where('status', 'active')
                                    ->inRandomOrder()
                                    ->take(6)
                                    ->get(),
            ]);
        }

        // Break the query into words for flexible matching
        // e.g. "plumber in aluva" → search 'plumber', 'aluva'
        $terms = collect(preg_split('/\s+(in|at|near|from|around)\s+/i', $query))
            ->map(fn($t) => trim($t))
            ->filter()
            ->values();

        $businesses = Business::query()
            ->where('status', 'active')
            ->where(function ($q) use ($terms, $query) {
                // Full query match first
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('service_area', 'like', "%{$query}%")
                  ->orWhere('address', 'like', "%{$query}%")
                  ->orWhereHas('categories', fn($c) => $c->where('name', 'like', "%{$query}%"))
                  ->orWhereHas('products', fn($p) => $p->where('name', 'like', "%{$query}%")->orWhere('description', 'like', "%{$query}%"));

                // Also match individual terms
                foreach ($terms as $term) {
                    $q->orWhere('name', 'like', "%{$term}%")
                      ->orWhere('description', 'like', "%{$term}%")
                      ->orWhere('service_area', 'like', "%{$term}%")
                      ->orWhere('address', 'like', "%{$term}%")
                      ->orWhereHas('categories', fn($c) => $c->where('name', 'like', "%{$term}%"))
                      ->orWhereHas('products', fn($p) => $p->where('name', 'like', "%{$term}%")->orWhere('description', 'like', "%{$term}%"));
                }
            })
            ->with('categories')
            ->orderByDesc('is_verified')
            ->orderByDesc('created_at')
            ->get();

        return view('search', [
            'results'     => $businesses,
            'query'       => $query,
            'total'       => $businesses->count(),
            'suggestions' => collect(),
        ]);
    }
}
