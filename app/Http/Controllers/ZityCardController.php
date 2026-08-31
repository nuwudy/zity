<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Product;
use Illuminate\Http\Request;

class ZityCardController extends Controller
{
    /**
     * Display the single-page digital Zity Card for a business/creator.
     */
    public function show(Request $request, string $slug)
    {
        // 1. Fetch business by slug with active products and relations
        $business = Business::where('slug', $slug)
            ->where('status', Business::STATUS_ACTIVE)
            ->with([
                'categories',
                'products' => function ($query) {
                    $query->where('is_active', true)->orderBy('id', 'desc');
                },
                'reviews' => function ($query) {
                    $query->latest()->take(5);
                }
            ])
            ->firstOrFail();

        // 2. Format products
        $products = $business->products;
        $productCategories = $products->pluck('category')->filter()->unique()->values();

        // 3. Prepare initial catalog payload for Alpine.js
        $catalogItems = [];

        // Add Products to catalog
        foreach ($products as $product) {
            $catalogItems[] = [
                'id' => 'prod_' . $product->id,
                'raw_id' => $product->id,
                'type' => 'product',
                'name' => $product->name,
                'category' => $product->category ?: 'General',
                'price' => (float) ($product->price ?? 0),
                'description' => $product->description ?? '',
                'image' => $product->image ? asset('storage/' . $product->image) : null,
            ];
        }

        // Add Services to catalog (if any)
        $services = $business->services ?? [];
        if (is_array($services)) {
            foreach ($services as $index => $service) {
                $serviceName = is_array($service) ? ($service['name'] ?? null) : $service;
                if (!empty($serviceName)) {
                    $catalogItems[] = [
                        'id' => 'serv_' . $index,
                        'raw_id' => $index,
                        'type' => 'service',
                        'name' => $serviceName,
                        'category' => 'Services',
                        'price' => 0.0, // Services can have 0 or quote price
                        'description' => is_array($service) && !empty($service['description']) ? $service['description'] : 'Professional service booking',
                        'image' => null,
                    ];
                }
            }
        }

        // Clean phone/whatsapp number (remove special characters)
        $rawWhatsapp = $business->whatsapp ?: $business->phone ?: '';
        $cleanWhatsapp = preg_replace('/[^0-9]/', '', $rawWhatsapp);
        // Default to India (91) prefix if 10-digit number is provided
        if (strlen($cleanWhatsapp) === 10) {
            $cleanWhatsapp = '91' . $cleanWhatsapp;
        }

        $rawPhone = $business->phone ?: $business->whatsapp ?: '';
        $cleanPhone = preg_replace('/[^0-9+]/', '', $rawPhone);

        return view('cards.show', compact(
            'business',
            'products',
            'productCategories',
            'catalogItems',
            'cleanWhatsapp',
            'cleanPhone'
        ));
    }
}
