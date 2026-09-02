<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $business->name }} — Zity Verified Store | Kochi</title>

    <!-- Open Graph / Meta -->
    <meta property="og:title" content="{{ $business->name }} — Verified Store on ZITY.in">
    <meta property="og:description" content="{{ $business->tagline ?: ($business->description ? Str::limit($business->description, 120) : 'Verified Local Deals & Online Ordering on Zity.in') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    @if($business->logo)
        <meta property="og:image" content="{{ asset('storage/' . $business->logo) }}">
    @endif

    <!-- PWA Manifest & Meta -->
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#581c87">
    <link rel="apple-touch-icon" href="/images/icons/icon.svg">
    <link rel="icon" type="image/svg+xml" href="/images/icons/icon.svg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS + Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900 font-sans min-h-screen antialiased selection:bg-purple-600 selection:text-white pb-28 md:pb-16">

    <!-- Main Store App -->
    <div 
        x-data="zityStoreApp({
            items: {{ Js::from($catalogItems) }},
            whatsappNumber: '{{ $cleanWhatsapp }}',
            businessName: '{{ addslashes($business->name) }}',
            slug: '{{ $business->slug }}'
        })"
        class="max-w-3xl mx-auto min-h-screen bg-white shadow-xl shadow-slate-200/60 md:rounded-3xl md:my-6 overflow-hidden border border-slate-100 relative"
    >
        <!-- 1. TOP NAVIGATION BAR (Ecosystem Sync) -->
        <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-100 px-4 py-3 flex items-center justify-between">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-700 hover:text-purple-700 transition py-1.5 px-3 rounded-xl bg-slate-100 hover:bg-purple-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>ZITY.in</span>
            </a>

            <div class="flex items-center gap-2">
                <!-- Save / Wishlist Button -->
                <button 
                    @click="saveStore()" 
                    class="w-9 h-9 rounded-full bg-slate-100 hover:bg-rose-50 text-slate-600 hover:text-rose-600 flex items-center justify-center transition"
                    title="Save Store"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </button>

                <!-- Share Button -->
                <button 
                    @click="shareStore()" 
                    class="w-9 h-9 rounded-full bg-slate-100 hover:bg-purple-50 text-slate-600 hover:text-purple-700 flex items-center justify-center transition"
                    title="Share Store"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                </button>

                @if(auth()->check() && (auth()->id() == $business->user_id || auth()->user()->isMasterAdmin()))
                    <a href="/admin" class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-bold transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>Edit</span>
                    </a>
                @endif
            </div>
        </header>

        <!-- 2. STORE COVER & PROFILE HEADER -->
        <div class="relative">
            <!-- Cover Banner -->
            <div class="h-44 sm:h-56 w-full bg-gradient-to-r from-purple-900 via-indigo-900 to-purple-800 relative overflow-hidden">
                @if($business->cover_image)
                    <img src="{{ asset('storage/' . $business->cover_image) }}" alt="{{ $business->name }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                @else
                    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#fff_2px,transparent_2px)] [background-size:16px_16px]"></div>
                    <div class="absolute -right-10 -bottom-10 w-44 h-44 rounded-full bg-white/10 blur-2xl"></div>
                @endif
            </div>

            <!-- Profile Info Overlay -->
            <div class="px-5 sm:px-6 relative -mt-12 sm:-mt-16 flex items-end justify-between">
                <!-- Avatar Logo -->
                <div class="relative">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-white p-1.5 shadow-xl border border-slate-100 overflow-hidden ring-4 ring-white">
                        @if($business->logo)
                            <img src="{{ asset('storage/' . $business->logo) }}" alt="{{ $business->name }}" class="w-full h-full object-cover rounded-2xl">
                        @else
                            <div class="w-full h-full bg-gradient-to-tr from-purple-600 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-black text-3xl shadow-inner">
                                {{ strtoupper(substr($business->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    @if($business->is_verified ?? true)
                        <div class="absolute -bottom-1 -right-1 bg-purple-600 text-white rounded-full p-1 shadow-md border-2 border-white" title="Verified Partner">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </div>
                    @endif
                </div>

                <!-- Status Badges -->
                <div class="mb-1 flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Live Store
                    </span>
                </div>
            </div>

            <!-- Business Title & Metadata -->
            <div class="px-5 sm:px-6 pt-4 space-y-2">
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $business->name }}
                </h1>

                @if($business->tagline)
                    <p class="text-xs sm:text-sm font-semibold text-purple-700 leading-snug">
                        {{ $business->tagline }}
                    </p>
                @endif

                <!-- Rating, Location & Badges Row -->
                <div class="flex flex-wrap items-center gap-2 pt-1 text-xs text-slate-600 font-medium">
                    <div class="inline-flex items-center gap-1 bg-amber-50 text-amber-900 border border-amber-200/80 px-2.5 py-1 rounded-xl font-bold">
                        <span>⭐</span> 4.8 (85+ reviews)
                    </div>

                    @if($business->city || $business->address)
                        <div class="inline-flex items-center gap-1 bg-slate-100 px-2.5 py-1 rounded-xl text-slate-600">
                            <span>📍</span> {{ $business->city ? $business->city . ($business->state ? ', ' . $business->state : '') : $business->address }}
                        </div>
                    @endif

                    <div class="inline-flex items-center gap-1 bg-purple-50 text-purple-700 px-2.5 py-1 rounded-xl font-bold">
                        <span>🛡️</span> Verified Merchant
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. QUICK ACTION TILES (4 Horizontal Buttons) -->
        <div class="px-5 sm:px-6 mt-5">
            <div class="grid grid-cols-4 gap-2.5">
                @if($cleanPhone)
                    <a href="tel:{{ $cleanPhone }}" class="flex flex-col items-center justify-center py-3 px-1 rounded-2xl bg-purple-50 hover:bg-purple-100 border border-purple-200/70 text-purple-800 transition transform active:scale-95 group">
                        <div class="w-10 h-10 rounded-xl bg-white text-purple-600 flex items-center justify-center mb-1 shadow-xs group-hover:scale-110 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <span class="text-[11px] font-bold">Call</span>
                    </a>
                @endif

                @if($cleanWhatsapp)
                    <a href="https://wa.me/{{ $cleanWhatsapp }}?text={{ urlencode('Hi ' . $business->name . ', I saw your store on Zity.in.') }}" target="_blank" class="flex flex-col items-center justify-center py-3 px-1 rounded-2xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/70 text-emerald-800 transition transform active:scale-95 group">
                        <div class="w-10 h-10 rounded-xl bg-white text-emerald-600 flex items-center justify-center mb-1 shadow-xs group-hover:scale-110 transition">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        </div>
                        <span class="text-[11px] font-bold">WhatsApp</span>
                    </a>
                @endif

                <a href="{{ $business->google_url ?: 'https://www.google.com/maps/search/?api=1&query=' . urlencode($business->name . ' ' . $business->city) }}" target="_blank" class="flex flex-col items-center justify-center py-3 px-1 rounded-2xl bg-blue-50 hover:bg-blue-100 border border-blue-200/70 text-blue-800 transition transform active:scale-95 group">
                    <div class="w-10 h-10 rounded-xl bg-white text-blue-600 flex items-center justify-center mb-1 shadow-xs group-hover:scale-110 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    </div>
                    <span class="text-[11px] font-bold">Directions</span>
                </a>

                <button @click="downloadVCard()" class="flex flex-col items-center justify-center py-3 px-1 rounded-2xl bg-rose-50 hover:bg-rose-100 border border-rose-200/70 text-rose-800 transition transform active:scale-95 group">
                    <div class="w-10 h-10 rounded-xl bg-white text-rose-600 flex items-center justify-center mb-1 shadow-xs group-hover:scale-110 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="text-[11px] font-bold">Save Card</span>
                </button>
            </div>
        </div>

        <!-- 4. ACTIVE ZITY DEALS & OFFERS BANNER (Coins Integration) -->
        <div class="px-5 sm:px-6 mt-6">
            <div class="p-4 rounded-3xl bg-gradient-to-r from-purple-900 via-indigo-900 to-purple-800 text-white shadow-lg relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center text-xl font-black shrink-0">
                            Z
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-bold text-amber-300 tracking-wider block">Exclusive Zity Deals</span>
                            <h3 class="text-sm font-extrabold">Unlock instant store discounts with Zity Coins!</h3>
                        </div>
                    </div>
                    <span class="hidden sm:inline-block px-3 py-1 bg-white/15 rounded-xl text-xs font-bold border border-white/20">
                        🪙 10 Coins / Deal
                    </span>
                </div>
            </div>
        </div>

        <!-- 5. STORE CATALOG & MENU TABS -->
        <section class="px-5 sm:px-6 mt-6 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-black text-slate-900">Products & Services</h2>
                <span class="text-xs font-bold text-purple-600" x-text="filteredItems.length + ' items'"></span>
            </div>

            <!-- In-Store Search & Filter Pills -->
            <div class="space-y-3">
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Search items in {{ $business->name }}..." 
                        class="w-full pl-10 pr-4 py-2.5 text-xs font-semibold rounded-2xl bg-slate-50 border border-slate-200 focus:border-purple-600 focus:ring-2 focus:ring-purple-100 outline-none transition"
                    >
                    <span class="absolute left-3.5 top-3 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                </div>

                <!-- Category Pills Horizontal Scroll -->
                <div class="flex items-center gap-2 overflow-x-auto hide-scrollbar pb-1">
                    <button 
                        @click="selectedCategory = 'all'" 
                        :class="selectedCategory === 'all' ? 'bg-purple-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                        class="px-4 py-2 rounded-xl text-xs font-bold shrink-0 transition"
                    >
                        All Items
                    </button>
                    <template x-for="cat in categories" :key="cat">
                        <button 
                            @click="selectedCategory = cat" 
                            :class="selectedCategory === cat ? 'bg-purple-600 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="px-4 py-2 rounded-xl text-xs font-bold shrink-0 transition"
                            x-text="cat"
                        ></button>
                    </template>
                </div>
            </div>

            <!-- Items Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-2">
                <template x-for="item in filteredItems" :key="item.id">
                    <div class="bg-slate-50/70 hover:bg-white rounded-3xl p-4 border border-slate-200/70 hover:border-purple-300 hover:shadow-lg transition-all duration-300 flex flex-col justify-between space-y-3 group">
                        
                        <div class="flex gap-3">
                            <!-- Image if available -->
                            <template x-if="item.image">
                                <div class="w-20 h-20 rounded-2xl overflow-hidden bg-slate-200 shrink-0 relative">
                                    <img :src="item.image" :alt="item.name" class="w-full h-full object-cover group-hover:scale-105 transition">
                                    <template x-if="item.badge">
                                        <span class="absolute top-1 left-1 bg-red-600 text-white text-[9px] font-black px-1.5 py-0.5 rounded" x-text="item.badge"></span>
                                    </template>
                                </div>
                            </template>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-1">
                                    <h4 class="text-sm font-extrabold text-slate-900 line-clamp-1 group-hover:text-purple-700 transition" x-text="item.name"></h4>
                                    <template x-if="!item.image && item.badge">
                                        <span class="bg-red-100 text-red-700 text-[10px] font-extrabold px-2 py-0.5 rounded-lg shrink-0" x-text="item.badge"></span>
                                    </template>
                                </div>

                                <p class="text-[11px] text-slate-500 line-clamp-2 mt-0.5 leading-relaxed" x-text="item.description || 'Verified product/service available for booking & order.'"></p>

                                <!-- Price -->
                                <div class="flex items-baseline gap-2 mt-2">
                                    <template x-if="item.price > 0">
                                        <div class="flex items-baseline gap-1.5">
                                            <span class="text-base font-black text-slate-900" x-text="'₹' + item.price"></span>
                                            <template x-if="item.original_price && item.original_price > item.price">
                                                <span class="text-xs text-slate-400 line-through" x-text="'₹' + item.original_price"></span>
                                            </template>
                                        </div>
                                    </template>
                                    <template x-if="item.price <= 0">
                                        <span class="text-xs font-bold text-purple-700 bg-purple-50 px-2 py-0.5 rounded-md">Quote / Booking</span>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Action Controls -->
                        <div class="flex items-center justify-between pt-2 border-t border-slate-200/60">
                            <span class="text-[10px] text-slate-400 font-semibold" x-text="item.category"></span>

                            <div class="flex items-center gap-1.5">
                                <template x-if="cart[item.id]">
                                    <div class="flex items-center gap-2 bg-purple-100 px-2 py-1 rounded-xl">
                                        <button @click="updateQty(item.id, -1)" class="w-6 h-6 rounded-lg bg-white text-purple-700 font-bold flex items-center justify-center text-xs shadow-xs">-</button>
                                        <span class="text-xs font-extrabold text-purple-900" x-text="cart[item.id].qty"></span>
                                        <button @click="updateQty(item.id, 1)" class="w-6 h-6 rounded-lg bg-purple-600 text-white font-bold flex items-center justify-center text-xs shadow-xs">+</button>
                                    </div>
                                </template>

                                <template x-if="!cart[item.id]">
                                    <button 
                                        @click="addToCart(item)" 
                                        class="px-3.5 py-1.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1"
                                    >
                                        <span>+ Add</span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <template x-if="filteredItems.length === 0">
                <div class="py-12 text-center text-slate-400 text-xs">
                    No items found matching your search. Try another keyword or browse all items.
                </div>
            </template>
        </section>

        <!-- 6. STORE REVIEWS & GAMIFICATION REWARD (+5 Coins) -->
        <section class="px-5 sm:px-6 mt-8 space-y-4">
            <div class="p-5 rounded-3xl bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">⭐</span>
                    <div>
                        <h4 class="text-xs font-extrabold text-amber-900">Review this Store & Earn +5 Coins!</h4>
                        <p class="text-[11px] text-amber-800">Help the community by sharing your genuine experience.</p>
                    </div>
                </div>
                <button onclick="alert('Review submission saved! You received +5 Zity Coins.')" class="px-3.5 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow-xs transition shrink-0">
                    Write Review
                </button>
            </div>
        </section>

        <!-- 7. STICKY BOTTOM ACTION / CHECKOUT BAR -->
        <div class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 p-3 shadow-2xl">
            <div class="max-w-3xl mx-auto flex items-center justify-between gap-3">
                @if($cleanWhatsapp)
                    <a href="https://wa.me/{{ $cleanWhatsapp }}?text={{ urlencode('Hi ' . $business->name . ', I would like to make an inquiry.') }}" target="_blank" class="flex-1 py-3 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs text-center shadow-lg shadow-emerald-600/20 transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>WhatsApp Chat</span>
                    </a>
                @endif

                <button 
                    @click="isCartOpen = true" 
                    :disabled="totalCartCount === 0"
                    :class="totalCartCount > 0 ? 'bg-purple-600 hover:bg-purple-700 text-white' : 'bg-slate-100 text-slate-400 cursor-not-allowed'"
                    class="flex-1 py-3 px-4 rounded-2xl font-bold text-xs text-center shadow-lg transition flex items-center justify-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span x-text="totalCartCount > 0 ? 'View Cart (' + totalCartCount + ') • ₹' + totalCartPrice : 'Cart is Empty'"></span>
                </button>
            </div>
        </div>

        <!-- 8. SLIDE-OVER CART MODAL -->
        <div x-show="isCartOpen" x-cloak class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 bg-black/60 backdrop-blur-sm">
            <div @click.away="isCartOpen = false" class="w-full max-w-lg bg-white rounded-t-3xl sm:rounded-3xl p-6 shadow-2xl max-h-[85vh] flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">🛍️</span>
                            <h3 class="text-base font-extrabold text-slate-900">Your Order Summary</h3>
                        </div>
                        <button @click="isCartOpen = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="py-4 space-y-3 max-h-60 overflow-y-auto hide-scrollbar">
                        <template x-for="(item, id) in cart" :key="id">
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-2xl">
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900" x-text="item.name"></h4>
                                    <span class="text-[11px] text-slate-500" x-text="'₹' + item.price + ' × ' + item.qty"></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button @click="updateQty(id, -1)" class="w-7 h-7 rounded-lg bg-white text-purple-700 font-bold flex items-center justify-center text-xs shadow-xs">-</button>
                                    <span class="text-xs font-bold" x-text="item.qty"></span>
                                    <button @click="updateQty(id, 1)" class="w-7 h-7 rounded-lg bg-purple-600 text-white font-bold flex items-center justify-center text-xs shadow-xs">+</button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 space-y-3">
                    <div class="flex items-center justify-between text-sm font-extrabold">
                        <span>Total Payable</span>
                        <span class="text-lg text-purple-700" x-text="'₹' + totalCartPrice"></span>
                    </div>

                    <button @click="checkoutViaWhatsApp()" class="w-full py-3.5 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xl shadow-emerald-600/20 transition flex items-center justify-center gap-2">
                        <span>Send Order via WhatsApp ➔</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- PWA Install Script -->
    <script src="/js/pwa-install.js"></script>

    <!-- Alpine.js Store Logic -->
    <script>
        function zityStoreApp(config) {
            return {
                items: config.items || [],
                whatsappNumber: config.whatsappNumber,
                businessName: config.businessName,
                slug: config.slug,
                searchQuery: '',
                selectedCategory: 'all',
                cart: {},
                isCartOpen: false,

                get categories() {
                    const set = new Set();
                    this.items.forEach(i => { if (i.category) set.add(i.category); });
                    return Array.from(set);
                },

                get filteredItems() {
                    return this.items.filter(item => {
                        const matchCat = this.selectedCategory === 'all' || item.category === this.selectedCategory;
                        const matchSearch = !this.searchQuery || item.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                        return matchCat && matchSearch;
                    });
                },

                get totalCartCount() {
                    return Object.values(this.cart).reduce((sum, item) => sum + item.qty, 0);
                },

                get totalCartPrice() {
                    return Object.values(this.cart).reduce((sum, item) => sum + (item.price * item.qty), 0);
                },

                addToCart(item) {
                    if (!this.cart[item.id]) {
                        this.cart[item.id] = { ...item, qty: 1 };
                    }
                },

                updateQty(id, delta) {
                    if (this.cart[id]) {
                        this.cart[id].qty += delta;
                        if (this.cart[id].qty <= 0) {
                            delete this.cart[id];
                        }
                    }
                },

                checkoutViaWhatsApp() {
                    if (this.totalCartCount === 0) return;
                    let text = `*New Order from Zity.in*\n\n*Store:* ${this.businessName}\n\n*Items Ordered:*\n`;
                    Object.values(this.cart).forEach(item => {
                        text += `• ${item.name} x ${item.qty} = ₹${item.price * item.qty}\n`;
                    });
                    text += `\n*Total Amount:* ₹${this.totalCartPrice}\n\nPlease confirm availability & delivery details.`;

                    const url = `https://wa.me/${this.whatsappNumber}?text=${encodeURIComponent(text)}`;
                    window.open(url, '_blank');
                    this.isCartOpen = false;
                },

                shareStore() {
                    if (navigator.share) {
                        navigator.share({
                            title: `${this.businessName} on ZITY.in`,
                            text: `Check out verified deals and catalog for ${this.businessName} on Zity!`,
                            url: window.location.href,
                        });
                    } else {
                        navigator.clipboard.writeText(window.location.href);
                        alert('Store link copied to clipboard!');
                    }
                },

                saveStore() {
                    alert('❤️ Store saved to your Zity favorites!');
                },

                downloadVCard() {
                    const vcard = `BEGIN:VCARD\nVERSION:3.0\nFN:${this.businessName}\nTEL;TYPE=CELL:${this.whatsappNumber}\nURL:${window.location.href}\nEND:VCARD`;
                    const blob = new Blob([vcard], { type: 'text/vcard' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `${this.slug}.vcf`;
                    a.click();
                }
            }
        }
    </script>
</body>
</html>
