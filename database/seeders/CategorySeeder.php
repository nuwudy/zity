<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Services
            ['name' => 'Plumbing', 'icon' => 'heroicon-o-wrench'],
            ['name' => 'Painter', 'icon' => 'heroicon-o-paint-brush'],
            ['name' => 'Electrician', 'icon' => 'heroicon-o-bolt'],
            ['name' => 'Carpenter', 'icon' => 'heroicon-o-scissors'],
            ['name' => 'Cleaning Services', 'icon' => 'heroicon-o-sparkles'],
            ['name' => 'Salon & Beauty', 'icon' => 'heroicon-o-sparkles'],
            ['name' => 'Mechanic & Auto', 'icon' => 'heroicon-o-cog'],
            ['name' => 'Tuitions', 'icon' => 'heroicon-o-academic-cap'],
            ['name' => 'Home Appliances', 'icon' => 'heroicon-o-home'],
            ['name' => 'Laundry', 'icon' => 'heroicon-o-sun'],
            ['name' => 'Pest Control', 'icon' => 'heroicon-o-bug-ant'],
            ['name' => 'Real Estate', 'icon' => 'heroicon-o-building-office'],
            ['name' => 'Courier & Logistics', 'icon' => 'heroicon-o-truck'],
            ['name' => 'Photography', 'icon' => 'heroicon-o-camera'],
            ['name' => 'Legal & Finance', 'icon' => 'heroicon-o-briefcase'],
            ['name' => 'Pet Care', 'icon' => 'heroicon-o-heart'],
            ['name' => 'Packers & Movers', 'icon' => 'heroicon-o-truck'],
            ['name' => 'Event Planning', 'icon' => 'heroicon-o-calendar-days'],
            ['name' => 'Security Services', 'icon' => 'heroicon-o-shield-check'],
            ['name' => 'Other Services', 'icon' => 'heroicon-o-ellipsis-horizontal'],

            // Products / E-commerce
            ['name' => 'Grocery', 'icon' => 'heroicon-o-shopping-cart'],
            ['name' => 'Supermarket', 'icon' => 'heroicon-o-shopping-bag'],
            ['name' => 'Fashion & Apparel', 'icon' => 'heroicon-o-shopping-bag'],
            ['name' => 'Electronics', 'icon' => 'heroicon-o-device-phone-mobile'],
            ['name' => 'Restaurant', 'icon' => 'heroicon-o-cake'],
            ['name' => 'Pharmacy', 'icon' => 'heroicon-o-beaker'],
            ['name' => 'Stationery', 'icon' => 'heroicon-o-book-open'],
            ['name' => 'Jewelry', 'icon' => 'heroicon-o-star'],
            ['name' => 'Furniture', 'icon' => 'heroicon-o-home-modern'],
            ['name' => 'Sports & Fitness', 'icon' => 'heroicon-o-fire'],
            ['name' => 'Toys & Kids', 'icon' => 'heroicon-o-gift'],
            ['name' => 'Automobile Parts', 'icon' => 'heroicon-o-cog-6-tooth'],
            ['name' => 'Computer & IT', 'icon' => 'heroicon-o-computer-desktop'],
            ['name' => 'Bakery & Sweets', 'icon' => 'heroicon-o-cake'],
            ['name' => 'Footwear', 'icon' => 'heroicon-o-tag'],
            ['name' => 'Other Products', 'icon' => 'heroicon-o-archive-box'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'icon' => $category['icon'],
                ]
            );
        }
    }
}
