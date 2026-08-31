<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $business->name }} — Zity Card</title>

    <!-- Open Graph / Meta -->
    <meta property="og:title" content="{{ $business->name }} — Digital Card">
    <meta property="og:description" content="{{ $business->tagline ?: ($business->description ? Str::limit($business->description, 120) : 'Digital card on Zity.in') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    @if($business->logo)
        <meta property="og:image" content="{{ asset('storage/' . $business->logo) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CDN + Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Outfit', 'sans-serif'],
                        display: ['Outfit', '"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        
        body {
            font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
            background: #0f172a;
            -webkit-tap-highlight-color: transparent;
        }

        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Cute Glass & Bento Styles */
        .cute-card-shell {
            background: linear-gradient(180deg, #FFFFFF 0%, #FAF8F5 100%);
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.35);
        }

        .cute-action-btn {
            transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .cute-action-btn:hover {
            transform: translateY(-3px);
        }
        .cute-action-btn:active {
            transform: scale(0.93);
        }

        .cute-pill {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        /* Pulse glow for checkout */
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.5); }
            50% { box-shadow: 0 0 0 10px rgba(37, 211, 102, 0); }
        }
        .animate-pulse-glow {
            animation: pulse-glow 2s infinite;
        }

        /* Smooth bounce for badges */
        @keyframes gentle-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        .animate-float {
            animation: gentle-float 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="text-slate-800 antialiased min-h-screen flex justify-center py-0 md:py-6 px-0 md:px-4">

    <!-- Card App Container -->
    <div 
        x-data="zityCardApp({
            items: {{ Js::from($catalogItems) }},
            whatsappNumber: '{{ $cleanWhatsapp }}',
            businessName: '{{ addslashes($business->name) }}'
        })"
        class="w-full max-w-[430px] min-h-screen md:min-h-[92vh] md:rounded-[36px] cute-card-shell relative flex flex-col justify-between overflow-hidden border border-slate-100/80 shadow-2xl"
    >
        <!-- Main Scrollable Content -->
        <main class="flex-grow pb-32">

            <!-- 1. Header & Cute Cover Image -->
            <div class="relative">
                <!-- Cover Banner -->
                <div class="h-44 w-full bg-gradient-to-br from-violet-500 via-purple-500 to-pink-400 relative overflow-hidden">
                    @if($business->cover_image)
                        <img 
                            src="{{ asset('storage/' . $business->cover_image) }}" 
                            alt="{{ $business->name }}" 
                            class="w-full h-full object-cover"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-black/20"></div>
                    @else
                        <!-- Cute geometric decorative pattern -->
                        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#fff_2px,transparent_2px)] [background-size:16px_16px]"></div>
                        <div class="absolute -right-10 -bottom-10 w-44 h-44 rounded-full bg-white/10 blur-2xl"></div>
                        <div class="absolute -left-10 -top-10 w-44 h-44 rounded-full bg-pink-300/20 blur-2xl"></div>
                    @endif

                    <!-- Top Bar Tools (Zity Card Badge + Actions) -->
                    <div class="absolute top-3.5 left-4 right-4 flex items-center justify-between z-10">
                        <span class="px-3 py-1 rounded-full bg-black/35 backdrop-blur-md text-[10px] font-extrabold text-white tracking-wider border border-white/20 uppercase flex items-center gap-1.5 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Zity Card
                        </span>

                        <div class="flex items-center gap-2">
                            @if(auth()->check() && (auth()->id() == $business->user_id || auth()->user()->isMasterAdmin()))
                                <a href="/admin" class="px-3 py-1 bg-white/30 hover:bg-white/40 backdrop-blur-md rounded-full text-[11px] font-bold text-white border border-white/30 transition-all flex items-center gap-1 shadow-sm active:scale-95">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </a>
                            @endif
                            <button 
                                @click="shareCard()" 
                                class="w-8 h-8 rounded-full bg-black/35 hover:bg-black/50 backdrop-blur-md text-white flex items-center justify-center border border-white/20 active:scale-90 transition-all shadow-sm"
                                title="Share Card"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Avatar Profile Section -->
                <div class="px-5 relative -mt-12 flex items-end justify-between">
                    <div class="relative group">
                        <div class="w-24 h-24 rounded-[26px] bg-white p-1.5 shadow-xl border border-slate-100 overflow-hidden ring-4 ring-white/90">
                            @if($business->logo)
                                <img src="{{ asset('storage/' . $business->logo) }}" alt="{{ $business->name }}" class="w-full h-full object-cover rounded-[20px]">
                            @else
                                <div class="w-full h-full bg-gradient-to-tr from-violet-500 to-indigo-600 rounded-[20px] flex items-center justify-center text-white font-black text-3xl shadow-inner">
                                    {{ strtoupper(substr($business->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        @if($business->is_verified)
                            <div class="absolute -bottom-1 -right-1 bg-gradient-to-r from-violet-600 to-indigo-600 text-white rounded-full p-1 shadow-md border-2 border-white flex items-center justify-center" title="Verified Card">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                        @endif
                    </div>

                    <!-- Cute Business Type Pill -->
                    <div class="mb-1 text-right">
                        @if($business->type === 'service')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-violet-100/90 text-violet-800 border border-violet-200/80 shadow-xs">
                                <span>🔧</span> Service Provider
                            </span>
                        @elseif($business->type === 'shop')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100/90 text-emerald-800 border border-emerald-200/80 shadow-xs">
                                <span>🛍️</span> Product Store
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-purple-100/90 text-purple-800 border border-purple-200/80 shadow-xs">
                                <span>✨</span> Official Card
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Business Identity Details -->
                <div class="px-5 pt-3">
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-1.5">
                        <span>{{ $business->name }}</span>
                    </h1>
                    
                    @if($business->tagline)
                        <p class="text-sm font-semibold text-violet-600 mt-0.5 leading-snug">{{ $business->tagline }}</p>
                    @endif

                    <!-- Location / Address Chip -->
                    @if($business->city || $business->address)
                        <div class="inline-flex items-center gap-1.5 text-xs text-slate-500 mt-2 font-medium bg-slate-100/80 px-2.5 py-1 rounded-full border border-slate-200/60">
                            <span class="text-rose-500">📍</span>
                            <span>{{ $business->city ? $business->city . ($business->state ? ', ' . $business->state : '') : $business->address }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 2. Cute Quick-Action Buttons (Horizontal Grid of 4 Compact Tiles) -->
            <div class="px-5 mt-4">
                <div class="grid grid-cols-4 gap-2.5">
                    <!-- Call Tile -->
                    @if($cleanPhone)
                        <a href="tel:{{ $cleanPhone }}" class="cute-action-btn flex flex-col items-center justify-center py-3 px-1 rounded-2xl bg-violet-50/90 hover:bg-violet-100/90 border border-violet-200/70 text-violet-700 shadow-xs group">
                            <div class="w-9 h-9 rounded-xl bg-white text-violet-600 flex items-center justify-center mb-1.5 shadow-sm group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <span class="text-[11px] font-extrabold tracking-tight">Call</span>
                        </a>
                    @endif

                    <!-- WhatsApp Tile -->
                    @if($cleanWhatsapp)
                        <a href="https://wa.me/{{ $cleanWhatsapp }}?text={{ urlencode('Hi ' . $business->name . ', I saw your Zity Card.') }}" target="_blank" class="cute-action-btn flex flex-col items-center justify-center py-3 px-1 rounded-2xl bg-emerald-50/90 hover:bg-emerald-100/90 border border-emerald-200/70 text-emerald-800 shadow-xs group">
                            <div class="w-9 h-9 rounded-xl bg-white text-emerald-600 flex items-center justify-center mb-1.5 shadow-sm group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            </div>
                            <span class="text-[11px] font-extrabold tracking-tight">WhatsApp</span>
                        </a>
                    @endif

                    <!-- Save Contact (vCard) Tile -->
                    <button @click="downloadVCard()" class="cute-action-btn flex flex-col items-center justify-center py-3 px-1 rounded-2xl bg-rose-50/90 hover:bg-rose-100/90 border border-rose-200/70 text-rose-700 shadow-xs group">
                        <div class="w-9 h-9 rounded-xl bg-white text-rose-500 flex items-center justify-center mb-1.5 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="text-[11px] font-extrabold tracking-tight">Save</span>
                    </button>

                    <!-- Directions Tile -->
                    <a 
                        href="{{ $business->google_url ?: 'https://www.google.com/maps/search/?api=1&query=' . urlencode($business->name . ' ' . $business->city . ' ' . $business->address) }}" 
                        target="_blank" 
                        class="cute-action-btn flex flex-col items-center justify-center py-3 px-1 rounded-2xl bg-sky-50/90 hover:bg-sky-100/90 border border-sky-200/70 text-sky-700 shadow-xs group"
                    >
                        <div class="w-9 h-9 rounded-xl bg-white text-sky-500 flex items-center justify-center mb-1.5 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        </div>
                        <span class="text-[11px] font-extrabold tracking-tight">Direction</span>
                    </a>
                </div>
            </div>

            <!-- 3. Cute Bento About / Bio Section -->
            @if($business->description)
                <div class="px-5 mt-4">
                    <div class="p-4 rounded-3xl bg-white border border-slate-200/70 shadow-xs" x-data="{ expanded: false }">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-1.5">
                                <span class="text-sm">🌿</span>
                                <h2 class="text-xs font-black text-slate-800 uppercase tracking-wider">About Us</h2>
                            </div>
                            @if($business->experience_years)
                                <span class="text-[10px] font-bold text-violet-700 bg-violet-100/80 px-2.5 py-0.5 rounded-full">
                                    {{ $business->experience_years }}+ Yrs Exp
                                </span>
                            @endif
                        </div>
                        <p 
                            class="text-xs leading-relaxed text-slate-600 transition-all font-normal"
                            :class="expanded ? '' : 'line-clamp-3'"
                        >
                            {{ $business->description }}
                        </p>
                        @if(strlen($business->description) > 140)
                            <button 
                                @click="expanded = !expanded" 
                                class="text-[11px] font-bold text-violet-600 mt-1.5 hover:underline focus:outline-none flex items-center gap-1"
                            >
                                <span x-text="expanded ? 'Show Less' : 'Read More'"></span>
                                <span x-text="expanded ? '▲' : '▼'"></span>
                            </button>
                        @endif
                    </div>
                </div>
            @endif

            <!-- 4. Cute Store Badges / Highlights -->
            @if(!empty($business->badges) && is_array($business->badges))
                <div class="px-5 mt-3.5">
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($business->badges as $badge)
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-amber-50/80 border border-amber-200/70 text-amber-900 shadow-2xs inline-flex items-center gap-1">
                                <span>✨</span> {{ $badge }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 5. Catalog / Items Section -->
            <div class="px-5 mt-6">
                <!-- Section Header -->
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-base font-black text-slate-900 flex items-center gap-1.5">
                            <span>🛍️</span>
                            <span>{{ $business->type === 'service' ? 'Services' : 'Catalog & Products' }}</span>
                        </h2>
                        <p class="text-[11px] text-slate-400 font-medium mt-0.5">Tap + to add items to your WhatsApp order</p>
                    </div>
                </div>

                <!-- Category Filtering Pills -->
                <template x-if="categories.length > 1">
                    <div class="flex items-center gap-1.5 overflow-x-auto hide-scrollbar pb-2 mb-3">
                        <template x-for="cat in categories" :key="cat">
                            <button 
                                @click="selectedCategory = cat"
                                :class="selectedCategory === cat ? 'bg-violet-600 text-white shadow-sm ring-2 ring-violet-200' : 'bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50'"
                                class="px-3.5 py-1.5 rounded-full text-xs font-bold whitespace-nowrap transition-all active:scale-95"
                                x-text="cat"
                            ></button>
                        </template>
                    </div>
                </template>

                <!-- Items Grid -->
                <div class="space-y-3">
                    <template x-for="item in filteredItems" :key="item.id">
                        <div class="p-3 bg-white rounded-3xl border border-slate-200/70 shadow-xs flex items-center justify-between gap-3 hover:border-violet-300 hover:shadow-md transition-all duration-200">
                            
                            <!-- Thumbnail Image -->
                            <template x-if="item.image">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden shrink-0 bg-slate-50 border border-slate-100 p-0.5">
                                    <img :src="item.image" :alt="item.name" class="w-full h-full object-cover rounded-[14px]">
                                </div>
                            </template>

                            <!-- Item Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-1.5">
                                    <h3 class="text-xs md:text-sm font-bold text-slate-900 truncate" x-text="item.name"></h3>
                                </div>
                                <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5 font-normal" x-text="item.description" x-show="item.description"></p>
                                
                                <div class="mt-1 flex items-center gap-2">
                                    <template x-if="item.price > 0">
                                        <span class="inline-flex items-center text-xs font-extrabold text-slate-900 bg-slate-100 px-2 py-0.5 rounded-md" x-text="'₹' + item.price.toLocaleString('en-IN')"></span>
                                    </template>
                                    <template x-if="item.price <= 0">
                                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">Free Quote / Inquiry</span>
                                    </template>
                                </div>
                            </div>

                            <!-- Cute Quantity Controller (+ / -) -->
                            <div class="shrink-0">
                                <template x-if="!getQty(item.id)">
                                    <button 
                                        @click="addToCart(item)"
                                        class="px-3.5 py-1.5 rounded-full bg-violet-50 hover:bg-violet-600 text-violet-700 hover:text-white text-xs font-extrabold transition-all active:scale-90 border border-violet-200/80 hover:border-transparent flex items-center gap-1 shadow-2xs"
                                    >
                                        <span class="text-sm font-bold leading-none">+</span>
                                        <span>Add</span>
                                    </button>
                                </template>

                                <template x-if="getQty(item.id) > 0">
                                    <div class="flex items-center gap-1 bg-gradient-to-r from-violet-600 to-indigo-600 text-white rounded-full p-1 shadow-sm">
                                        <button 
                                            @click="decrement(item.id)" 
                                            class="w-6 h-6 rounded-full bg-white/25 hover:bg-white/40 flex items-center justify-center font-black text-xs active:scale-90 transition-transform"
                                        >–</button>
                                        <span class="w-5 text-center text-xs font-black" x-text="getQty(item.id)"></span>
                                        <button 
                                            @click="increment(item.id)" 
                                            class="w-6 h-6 rounded-full bg-white/25 hover:bg-white/40 flex items-center justify-center font-black text-xs active:scale-90 transition-transform"
                                        >+</button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    <!-- Empty State -->
                    <template x-if="filteredItems.length === 0">
                        <div class="text-center py-10 bg-white rounded-3xl border border-dashed border-slate-200">
                            <p class="text-xs text-slate-400 font-medium">No items available in this category.</p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- 6. Social Links Row -->
            @php
                $socials = array_filter([
                    ['name' => 'Instagram', 'url' => $business->instagram_url, 'emoji' => '📸'],
                    ['name' => 'Facebook', 'url' => $business->facebook_url, 'emoji' => '📘'],
                    ['name' => 'YouTube', 'url' => $business->youtube_url, 'emoji' => '▶️'],
                    ['name' => 'X / Twitter', 'url' => $business->twitter_url, 'emoji' => '🐦'],
                    ['name' => 'Website', 'url' => $business->website_url, 'emoji' => '🌐'],
                ], fn($s) => !empty($s['url']));
            @endphp

            @if(count($socials) > 0)
                <div class="px-5 mt-6">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-2.5">Find us online</h3>
                    <div class="flex items-center gap-2 overflow-x-auto hide-scrollbar pb-1">
                        @foreach($socials as $soc)
                            <a 
                                href="{{ $soc['url'] }}" 
                                target="_blank" 
                                class="px-3.5 py-2 rounded-2xl bg-white border border-slate-200/80 text-slate-700 text-xs font-bold shadow-2xs hover:text-violet-600 hover:border-violet-300 flex items-center gap-1.5 shrink-0 active:scale-95 transition-all"
                            >
                                <span>{{ $soc['emoji'] }}</span>
                                <span>{{ $soc['name'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 7. Footer Branding -->
            <div class="px-5 mt-8 mb-4 text-center">
                <a href="/" class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-400 hover:text-violet-600 transition-colors">
                    <span>Powered by</span>
                    <span class="text-violet-600 font-extrabold">Zity.in</span>
                    <span>✨</span>
                </a>
            </div>
        </main>

        <!-- ========================================== -->
        <!-- 8. Cute Floating Capsule Bottom Bar        -->
        <!-- ========================================== -->
        <div 
            x-show="cartTotalCount > 0" 
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-y-full opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-full opacity-0"
            class="fixed bottom-3 left-0 right-0 z-40 max-w-[420px] mx-auto px-4"
            x-cloak
        >
            <div class="bg-slate-900/95 text-white rounded-full p-2.5 pl-3.5 shadow-2xl border border-slate-700/60 flex items-center justify-between gap-2 backdrop-blur-xl">
                <!-- Cart Preview Trigger -->
                <button 
                    @click="showCartDrawer = true" 
                    class="flex items-center gap-2.5 text-left active:scale-95 transition-transform"
                >
                    <div class="relative w-9 h-9 rounded-full bg-violet-600 flex items-center justify-center text-white shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span 
                            class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-emerald-400 text-slate-900 font-black text-[9px] flex items-center justify-center ring-2 ring-slate-900" 
                            x-text="cartTotalCount"
                        ></span>
                    </div>

                    <div>
                        <div class="text-[9px] font-extrabold text-slate-300 uppercase tracking-wider">
                            <span x-text="cartTotalCount"></span> <span x-text="cartTotalCount === 1 ? 'item' : 'items'"></span>
                        </div>
                        <div class="text-sm font-black text-white leading-tight" x-text="'₹' + cartTotalPrice.toLocaleString('en-IN')"></div>
                    </div>
                </button>

                <!-- Cute WhatsApp Checkout CTA -->
                <button 
                    @click="checkoutWhatsApp()" 
                    class="px-4 py-2.5 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 active:scale-95 text-white font-extrabold text-xs uppercase tracking-wide flex items-center gap-1.5 shadow-lg shadow-emerald-500/30 transition-all animate-pulse-glow"
                >
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    <span>Order on WhatsApp</span>
                </button>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 9. Cute Cart Slide-Up Drawer               -->
        <!-- ========================================== -->
        <div 
            x-show="showCartDrawer" 
            class="fixed inset-0 z-50 flex items-end justify-center bg-black/60 backdrop-blur-xs max-w-[430px] mx-auto"
            x-cloak
            @click.self="showCartDrawer = false"
        >
            <div 
                x-show="showCartDrawer"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="translate-y-full"
                x-transition:enter-end="translate-y-0"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="translate-y-0"
                x-transition:leave-end="translate-y-full"
                class="w-full bg-white rounded-t-[32px] p-5 shadow-2xl max-h-[85vh] flex flex-col border-t border-slate-100"
            >
                <!-- Drawer Header -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                        <h3 class="text-base font-black text-slate-900">Your Cart Items</h3>
                    </div>
                    <button 
                        @click="showCartDrawer = false" 
                        class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center font-bold text-xs active:scale-90 transition-transform"
                    >✕</button>
                </div>

                <!-- Items list -->
                <div class="flex-grow overflow-y-auto py-3 space-y-2.5 max-h-64 hide-scrollbar">
                    <template x-for="item in cartItemList" :key="item.id">
                        <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="flex-1 min-w-0 pr-2">
                                <div class="text-xs font-bold text-slate-900 truncate" x-text="item.name"></div>
                                <div class="text-[10px] text-slate-400 font-semibold" x-text="item.price > 0 ? '₹' + item.price + ' each' : 'Free Inquiry'"></div>
                            </div>

                            <div class="flex items-center gap-2">
                                <div class="flex items-center gap-1 bg-white border border-slate-200 rounded-full p-0.5 shadow-2xs">
                                    <button 
                                        @click="decrement(item.id)" 
                                        class="w-5 h-5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs font-bold"
                                    >–</button>
                                    <span class="w-4 text-center text-xs font-black text-slate-800" x-text="item.qty"></span>
                                    <button 
                                        @click="increment(item.id)" 
                                        class="w-5 h-5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center text-xs font-bold"
                                    >+</button>
                                </div>
                                <div class="w-14 text-right text-xs font-black text-slate-900" x-text="'₹' + (item.price * item.qty).toLocaleString('en-IN')"></div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Total & Checkout Action -->
                <div class="pt-3 border-t border-slate-100 space-y-3">
                    <div class="flex items-center justify-between px-1">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Amount</span>
                        <span class="text-lg font-black text-slate-900" x-text="'₹' + cartTotalPrice.toLocaleString('en-IN')"></span>
                    </div>

                    <button 
                        @click="checkoutWhatsApp()" 
                        class="w-full py-3.5 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 active:scale-95 text-white font-black text-xs uppercase tracking-wider flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/25 transition-all"
                    >
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Send Order via WhatsApp</span>
                    </button>

                    <button 
                        @click="clearCart()" 
                        class="w-full text-center text-xs font-bold text-slate-400 hover:text-rose-500 py-1 transition-colors"
                    >
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- Alpine.js Application Logic                -->
    <!-- ========================================== -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('zityCardApp', (config) => ({
                items: config.items || [],
                whatsappNumber: config.whatsappNumber || '',
                businessName: config.businessName || '',
                selectedCategory: 'All',
                cart: {},
                showCartDrawer: false,

                get categories() {
                    const set = new Set(['All']);
                    this.items.forEach(i => {
                        if (i.category) set.add(i.category);
                    });
                    return Array.from(set);
                },

                get filteredItems() {
                    if (this.selectedCategory === 'All') return this.items;
                    return this.items.filter(i => i.category === this.selectedCategory);
                },

                getQty(itemId) {
                    return this.cart[itemId] || 0;
                },

                addToCart(item) {
                    this.cart[item.id] = 1;
                },

                increment(itemId) {
                    this.cart[itemId] = (this.cart[itemId] || 0) + 1;
                },

                decrement(itemId) {
                    if (!this.cart[itemId]) return;
                    if (this.cart[itemId] <= 1) {
                        delete this.cart[itemId];
                    } else {
                        this.cart[itemId]--;
                    }
                },

                clearCart() {
                    this.cart = {};
                    this.showCartDrawer = false;
                },

                get cartItemList() {
                    return Object.keys(this.cart).map(id => {
                        const item = this.items.find(i => i.id === id);
                        return {
                            ...item,
                            qty: this.cart[id]
                        };
                    }).filter(Boolean);
                },

                get cartTotalCount() {
                    return Object.values(this.cart).reduce((sum, q) => sum + q, 0);
                },

                get cartTotalPrice() {
                    return this.cartItemList.reduce((sum, item) => sum + (item.price * item.qty), 0);
                },

                checkoutWhatsApp() {
                    if (this.cartTotalCount === 0) return;
                    if (!this.whatsappNumber) {
                        alert('WhatsApp contact number is not configured for this card.');
                        return;
                    }

                    let message = `*Order / Booking from Zity Card*\n`;
                    message += `👤 *Store:* ${this.businessName}\n`;
                    message += `-------------------------\n`;

                    this.cartItemList.forEach(item => {
                        const itemTotal = item.price > 0 ? `₹${(item.price * item.qty).toLocaleString('en-IN')}` : 'Inquiry';
                        message += `• ${item.name} x ${item.qty} = ${itemTotal}\n`;
                    });

                    message += `-------------------------\n`;
                    message += `*Total: ₹${this.cartTotalPrice.toLocaleString('en-IN')}*\n\n`;
                    message += `Please confirm my order/booking. Thank you!`;

                    const encoded = encodeURIComponent(message);
                    window.open(`https://wa.me/${this.whatsappNumber}?text=${encoded}`, '_blank');
                },

                shareCard() {
                    if (navigator.share) {
                        navigator.share({
                            title: `${this.businessName} — Zity Card`,
                            url: window.location.href
                        }).catch(() => {});
                    } else {
                        navigator.clipboard.writeText(window.location.href);
                        alert('Card link copied to clipboard!');
                    }
                },

                downloadVCard() {
                    const name = '{{ addslashes($business->name) }}';
                    const phone = '{{ $cleanPhone }}';
                    const email = '{{ $business->email }}';
                    const url = window.location.href;
                    const address = '{{ addslashes($business->address) }}';

                    let vcard = "BEGIN:VCARD\nVERSION:3.0\n";
                    vcard += `FN:${name}\n`;
                    vcard += `ORG:${name}\n`;
                    if (phone) vcard += `TEL;TYPE=CELL:${phone}\n`;
                    if (email) vcard += `EMAIL:${email}\n`;
                    if (address) vcard += `ADR;TYPE=WORK:;;${address};;;;\n`;
                    vcard += `URL:${url}\n`;
                    vcard += "END:VCARD";

                    const blob = new Blob([vcard], { type: "text/vcard" });
                    const link = document.createElement("a");
                    link.href = URL.createObjectURL(blob);
                    link.download = `${name.replace(/[^a-z0-9]/gi, '_').toLowerCase()}_contact.vcf`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            }));
        });
    </script>
</body>
</html>
