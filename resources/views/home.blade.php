<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZITY.in - Local Deals. Real Savings | Kochi</title>
    <meta name="description" content="Discover verified local deals, restaurant discounts, salon offers, and home services near you in Kochi & Kerala.">
    
    <!-- PWA Manifest & Icons -->
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#581c87">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="/images/icons/icon.svg">
    <link rel="icon" type="image/svg+xml" href="/images/icons/icon.svg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN (Fast standalone rendering matching designs) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
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

    <!-- Custom Micro-animations -->
    <style>
        .custom-scrollbar::-webkit-scrollbar { height: 6px; width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        @keyframes pulse-subtle { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.03); } }
        .animate-subtle { animation: pulse-subtle 3s infinite ease-in-out; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900 font-sans pb-24 md:pb-12 antialiased selection:bg-purple-600 selection:text-white">

    <!-- 1. TOP HEADER / APP BAR (Matching Image 2 Desktop + Mobile) -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-3 sm:gap-6">
                
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0 group">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-tr from-purple-700 via-indigo-600 to-purple-600 flex items-center justify-center text-white font-black text-xl sm:text-2xl shadow-md shadow-purple-500/25 group-hover:scale-105 transition transform">
                        Z
                    </div>
                    <div>
                        <span class="text-2xl sm:text-3xl font-black tracking-tight text-slate-900 leading-none">
                            ZITY<span class="text-purple-600">.in</span>
                        </span>
                        <p class="text-[9px] sm:text-[10px] tracking-widest text-slate-400 font-bold uppercase mt-0.5">
                            Local Deals. Real Savings.
                        </p>
                    </div>
                </a>

                <!-- Location Picker -->
                <div class="relative hidden sm:block">
                    <button type="button" id="locationBtn" onclick="toggleLocationDropdown()" class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-slate-100 border border-slate-200/80 text-xs font-bold text-slate-700 transition">
                        <span class="text-purple-600">📍</span>
                        <span id="currentLocationText">Edappally, Kochi</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <!-- Location Dropdown -->
                    <div id="locationDropdown" class="hidden absolute top-full left-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                        <div class="px-3 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Select Kochi Area</div>
                        @foreach(['Edappally', 'Kakkanad', 'Kaloor', 'Palarivattom', 'Vyttila', 'Kundannoor', 'Aluva', 'Marine Drive'] as $loc)
                            <button type="button" onclick="selectLocation('{{ $loc }}, Kochi')" class="w-full text-left px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-purple-50 hover:text-purple-700 transition flex items-center justify-between">
                                <span>{{ $loc }}</span>
                                <span class="text-[10px] text-slate-400">Kochi</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Universal Instant Search Bar -->
                <div class="flex-1 max-w-xl relative">
                    <form action="{{ route('search') }}" method="GET" class="relative flex items-center">
                        <input type="text" name="q" id="universalSearchInput" placeholder="Search for restaurants, salons, groceries, services..." class="w-full pl-4 pr-12 py-2.5 sm:py-3 text-xs sm:text-sm rounded-2xl bg-slate-50 border border-slate-200/80 focus:border-purple-600 focus:ring-4 focus:ring-purple-100 outline-none transition placeholder:text-slate-400" autocomplete="off">
                        <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 px-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl flex items-center justify-center transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </form>
                </div>

                <!-- Top Right Actions -->
                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- Wishlist / Saved -->
                    <a href="{{ Auth::check() ? route('profile.index') : 'javascript:openAuthModal(\'login\')' }}" class="hidden lg:flex flex-col items-center text-slate-600 hover:text-purple-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        <span class="text-[10px] font-bold mt-0.5">Saved</span>
                    </a>

                    <!-- My Deals -->
                    <a href="{{ Auth::check() ? route('profile.index') : 'javascript:openAuthModal(\'login\')' }}" class="hidden lg:flex flex-col items-center text-slate-600 hover:text-purple-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        <span class="text-[10px] font-bold mt-0.5">My Deals</span>
                    </a>

                    <!-- Notifications -->
                    <button onclick="alert('No new notifications. You are all caught up!')" class="hidden sm:flex relative p-2 text-slate-600 hover:text-purple-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-500"></span>
                    </button>

                    <!-- User Account / Login Button -->
                    @auth
                        <a href="{{ route('profile.index') }}" class="flex items-center gap-2 pl-2 border-l border-slate-200">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-gradient-to-tr from-purple-600 to-indigo-600 flex items-center justify-center text-white font-extrabold text-sm shadow-md">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <span class="text-xs font-bold text-slate-900 block truncate max-w-[100px]">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-purple-600 font-extrabold">🪙 {{ Auth::user()->coins ?? 10 }} Coins</span>
                            </div>
                        </a>
                    @else
                        <button onclick="openAuthModal('login')" class="flex items-center gap-2 py-2 px-3.5 sm:px-4 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-purple-500/20 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>Sign In</span>
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN BODY CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-6 sm:space-y-10">

        <!-- 2. HERO SPECIAL BANNER (Matching Uploaded Design: "Find local. Save more.") -->
        <section class="relative rounded-[32px] overflow-hidden bg-gradient-to-r from-[#170a38] via-[#240e57] to-[#1f0d47] text-white shadow-2xl p-6 sm:p-10 lg:p-12 border border-purple-900/40">
            <!-- Ambient Lighting & Glows -->
            <div class="absolute -top-20 -left-20 w-80 h-80 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 right-1/4 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Left Hero Copy -->
                <div class="lg:col-span-6 space-y-5 relative">
                    <!-- Floating 3D % Badge -->
                    <div class="absolute -top-4 right-8 hidden sm:flex w-12 h-12 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-500 text-white font-black text-xl items-center justify-center shadow-lg shadow-purple-500/40 transform rotate-12 animate-subtle border border-purple-400/40">
                        %
                    </div>

                    <div class="space-y-2">
                        <h1 class="text-4xl sm:text-6xl font-black tracking-tight leading-[1.05] text-white">
                            Find local.<br>
                            <span class="text-amber-400">Save more.</span>
                        </h1>
                        <p class="text-slate-300 text-sm sm:text-base font-medium max-w-sm pt-1 leading-relaxed">
                            Discover shops, services and exclusive deals near you.
                        </p>
                    </div>

                    <!-- Location Deals Pill (Matching Mockup) -->
                    <div class="pt-2">
                        <a href="#deals" class="inline-flex items-center gap-2.5 px-4 sm:px-5 py-3 rounded-2xl bg-[#2a135e]/90 hover:bg-[#341875] border border-purple-400/30 text-xs sm:text-sm font-bold text-white shadow-inner transition transform active:scale-95 group">
                            <span class="text-base text-rose-400 group-hover:scale-110 transition">📍</span>
                            <span>Deals around <span id="heroLocationDisplay">Edappally, Kochi</span></span>
                            <svg class="w-4 h-4 text-purple-300 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>

                    <!-- Shopping Bags Graphic Accent -->
                    <div class="hidden sm:flex items-center gap-3 pt-3 opacity-90">
                        <div class="w-10 h-12 rounded-t-lg rounded-b-xl bg-gradient-to-b from-amber-400 to-orange-500 shadow-md relative flex items-center justify-center text-white text-xs font-black">
                            <div class="w-4 h-3 border-2 border-white/80 rounded-t-full absolute -top-2"></div>
                            Z
                        </div>
                        <div class="w-9 h-11 rounded-t-lg rounded-b-xl bg-gradient-to-b from-purple-500 to-indigo-600 shadow-md relative flex items-center justify-center text-white text-[10px] font-black -ml-5 mt-2">
                            <div class="w-3.5 h-2.5 border-2 border-white/80 rounded-t-full absolute -top-1.5"></div>
                            %
                        </div>
                    </div>
                </div>

                <!-- Right Hero Visual: 3D Phone Deal Mockup + Streetscape (Matching Image) -->
                <div class="lg:col-span-6 flex justify-center lg:justify-end">
                    <div class="relative w-full max-w-lg flex items-center justify-center">
                        
                        <!-- Background Streetscape / Store Scene Illustration -->
                        <div class="absolute inset-y-0 right-0 w-3/4 bg-gradient-to-l from-indigo-950/80 to-transparent rounded-3xl overflow-hidden flex items-end justify-end pointer-events-none opacity-90">
                            <!-- Shop Silhouettes -->
                            <div class="flex items-end gap-2 pb-2 pr-2">
                                <div class="w-16 h-28 bg-[#311768] rounded-t-xl p-1.5 text-center flex flex-col justify-between border-t-2 border-amber-400/40">
                                    <span class="text-[8px] font-extrabold text-amber-300 bg-amber-400/20 rounded py-0.5">AUTO</span>
                                    <div class="w-full h-8 bg-purple-900/60 rounded-md"></div>
                                </div>
                                <div class="w-20 h-36 bg-[#3d1a80] rounded-t-xl p-1.5 text-center flex flex-col justify-between border-t-2 border-rose-400/40">
                                    <span class="text-[9px] font-extrabold text-rose-300 bg-rose-400/20 rounded py-0.5">CAFE</span>
                                    <div class="w-full h-12 bg-purple-900/60 rounded-md"></div>
                                </div>
                                <div class="w-20 h-44 bg-[#491f96] rounded-t-xl p-1.5 text-center flex flex-col justify-between border-t-2 border-purple-400/40">
                                    <span class="text-[9px] font-extrabold text-purple-200 bg-purple-400/20 rounded py-0.5">SALON</span>
                                    <div class="w-full h-16 bg-purple-900/60 rounded-md"></div>
                                </div>
                            </div>

                            <!-- Big 3D Street Location Pin -->
                            <div class="absolute bottom-6 right-16 flex flex-col items-center animate-subtle">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-orange-500 to-amber-400 flex items-center justify-center text-white shadow-xl shadow-orange-500/50 border-2 border-white">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                </div>
                                <div class="w-6 h-1.5 bg-black/40 rounded-full blur-[2px] mt-0.5"></div>
                            </div>
                        </div>

                        <!-- 3D Smartphone Device Mockup (Matching Mockup Deal Card) -->
                        <div class="relative z-10 w-72 sm:w-80 bg-slate-950 rounded-[40px] p-3 shadow-2xl shadow-purple-950/80 border-4 border-slate-800 ring-1 ring-white/20 transform sm:-rotate-2 hover:rotate-0 transition duration-500">
                            <!-- Phone Top Notch -->
                            <div class="w-24 h-4 bg-slate-900 rounded-full mx-auto mb-2 flex items-center justify-center">
                                <div class="w-2.5 h-2.5 rounded-full bg-slate-800"></div>
                            </div>

                            <!-- Inside Phone Screen -->
                            <div class="bg-white rounded-[32px] p-4 text-slate-900 shadow-inner space-y-3 overflow-hidden">
                                <!-- Top Tag -->
                                <div class="flex items-center justify-between">
                                    <span class="bg-indigo-600 text-white text-[9px] font-black px-2.5 py-1 rounded-lg uppercase tracking-wider">
                                        TODAY'S DEAL
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-bold">Zity Exclusive</span>
                                </div>

                                <!-- Deal Title & Serving -->
                                <div>
                                    <h3 class="text-base font-black text-slate-900 leading-tight">Chicken Biryani</h3>
                                    <p class="text-[11px] text-slate-500 font-semibold">1 Bucket Special</p>
                                </div>

                                <!-- Pricing -->
                                <div class="flex items-baseline gap-2">
                                    <span class="text-xs text-slate-400 line-through">₹500</span>
                                    <span class="text-2xl font-black text-rose-600">₹349</span>
                                    <span class="text-[10px] font-black text-rose-600 bg-rose-50 px-1.5 py-0.5 rounded">
                                        30% OFF
                                    </span>
                                </div>

                                <!-- Food Image -->
                                <div class="h-28 w-full rounded-2xl overflow-hidden bg-slate-900 relative shadow-md">
                                    <img src="https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&w=500&q=80" alt="Chicken Biryani" class="w-full h-full object-cover">
                                    <div class="absolute bottom-1 right-1 bg-black/60 text-[9px] text-white px-1.5 py-0.5 rounded">
                                        Fresh & Hot
                                    </div>
                                </div>

                                <!-- CTA Button -->
                                <a href="#deals" class="w-full py-2.5 px-3 bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs rounded-xl flex items-center justify-center transition shadow-md shadow-purple-600/30">
                                    View Deal
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- 3. INTERACTIVE WALLET / REWARDS & MERCHANT BAR (4 Cards) -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <!-- 1. My Zity Coins -->
            <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl font-black shrink-0">
                        Z
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-slate-500 block">My Zity Coins</span>
                        <div class="text-xl font-extrabold text-slate-900">
                            {{ Auth::check() ? (Auth::user()->coins ?? 10) : 10 }} <span class="text-xs font-bold text-amber-600">Coins</span>
                        </div>
                    </div>
                </div>
                <a href="{{ Auth::check() ? route('profile.index') : 'javascript:openAuthModal(\'login\')' }}" class="text-xs font-bold text-purple-600 hover:text-purple-700 hover:underline flex items-center gap-1">
                    View Wallet ➔
                </a>
            </div>

            <!-- 2. My Coupons -->
            <div class="bg-white rounded-3xl p-4 sm:p-5 border border-slate-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center text-xl shrink-0">
                        🎟️
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-slate-500 block">My Coupons</span>
                        <div class="text-xl font-extrabold text-slate-900">
                            3 <span class="text-xs font-semibold text-slate-500">Active Coupons</span>
                        </div>
                    </div>
                </div>
                <a href="{{ Auth::check() ? route('profile.index') : 'javascript:openAuthModal(\'login\')' }}" class="text-xs font-bold text-purple-600 hover:text-purple-700 hover:underline flex items-center gap-1">
                    View Coupons ➔
                </a>
            </div>

            <!-- 3. Refer & Earn Card -->
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-3xl p-4 sm:p-5 border border-emerald-200/60 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-emerald-500/20">
                        🎁
                    </div>
                    <div>
                        <span class="text-xs font-bold text-emerald-900 block">Refer & Earn</span>
                        <div class="text-sm font-extrabold text-emerald-800">
                            Get ₹25 Credit
                        </div>
                        <p class="text-[10px] text-emerald-700">Friend gets ₹25 on first claim</p>
                    </div>
                </div>
                <button onclick="{{ Auth::check() ? 'document.getElementById(\'referralModal\')?.classList.remove(\'hidden\')' : 'openAuthModal(\'login\')' }}" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-xs shrink-0">
                    Refer Now
                </button>
            </div>

            <!-- 4. Create My Shop / List Your Business (Right after Refer & Earn) -->
            <div class="bg-gradient-to-r from-purple-50 via-indigo-50 to-purple-100/70 rounded-3xl p-4 sm:p-5 border border-purple-200 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-600 text-white flex items-center justify-center text-xl shrink-0 shadow-md shadow-purple-600/20">
                        🏪
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-xs font-extrabold text-purple-950 block">Create My Shop</span>
                            <span class="bg-emerald-500 text-white text-[8px] font-black px-1.5 py-0.2 rounded uppercase">NEW</span>
                        </div>
                        <div class="text-xs font-bold text-purple-800">
                            List Your Business
                        </div>
                        <p class="text-[10px] text-purple-600 font-medium">Reach 1000s of local customers</p>
                    </div>
                </div>
                @auth
                    <a href="{{ route('profile.index') }}" class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-xl transition shadow-xs shrink-0">
                        + Start
                    </a>
                @else
                    <a href="#register-business" class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-xl transition shadow-xs shrink-0">
                        + Register
                    </a>
                @endauth
            </div>
        </section>

        <!-- 4. BROWSE CATEGORIES (Matching Uploaded Mockup) -->
        <section class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-900">Browse Categories</h2>
                    <p class="text-xs text-slate-500">Find verified merchants & exclusive deals by category</p>
                </div>
                <a href="{{ route('search') }}" class="text-xs font-bold text-purple-600 hover:text-purple-700 flex items-center gap-1">
                    View all ➔
                </a>
            </div>

            <!-- Categories Horizontal Grid/Carousel -->
            <div class="grid grid-cols-4 sm:grid-cols-8 gap-3 sm:gap-4">
                @php
                    $catItems = [
                        ['name' => 'Restaurants', 'icon' => '🍽️', 'color' => 'bg-orange-500', 'bg' => 'bg-orange-50'],
                        ['name' => 'Cafes & Bakeries', 'icon' => '☕', 'color' => 'bg-amber-600', 'bg' => 'bg-amber-50'],
                        ['name' => 'Beauty & Salon', 'icon' => '💇', 'color' => 'bg-pink-500', 'bg' => 'bg-pink-50'],
                        ['name' => 'Health & Wellness', 'icon' => '💚', 'color' => 'bg-emerald-500', 'bg' => 'bg-emerald-50'],
                        ['name' => 'Automotive', 'icon' => '🚗', 'color' => 'bg-blue-500', 'bg' => 'bg-blue-50'],
                        ['name' => 'Services', 'icon' => '🔧', 'color' => 'bg-purple-500', 'bg' => 'bg-purple-50'],
                        ['name' => 'Shopping', 'icon' => '🛍️', 'color' => 'bg-rose-500', 'bg' => 'bg-rose-50'],
                        ['name' => 'More', 'icon' => '⋯', 'color' => 'bg-slate-400', 'bg' => 'bg-slate-100'],
                    ];
                @endphp

                @foreach($catItems as $c)
                    <a href="{{ route('search', ['category' => $c['name']]) }}" class="group flex flex-col items-center text-center p-3 rounded-2xl bg-white border border-slate-100 hover:border-purple-200 hover:shadow-lg transition transform hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-2xl {{ $c['bg'] }} flex items-center justify-center text-2xl group-hover:scale-110 transition">
                            {{ $c['icon'] }}
                        </div>
                        <span class="text-[11px] sm:text-xs font-bold text-slate-700 group-hover:text-purple-700 mt-2 line-clamp-1">
                            {{ $c['name'] }}
                        </span>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- 5. TRENDING DEALS NEAR YOU (Matching Image 2 & 3) -->
        <section id="deals" class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-xl">🔥</span>
                    <div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900">Trending Deals Near You</h2>
                        <p class="text-xs text-slate-500">Hand-picked discounts ready to redeem with Zity Coins</p>
                    </div>
                </div>
                <a href="{{ route('search') }}" class="text-xs font-bold text-purple-600 hover:text-purple-700 flex items-center gap-1">
                    View all deals ➔
                </a>
            </div>

            <!-- Deals Grid (2-Column Mobile App Grid) -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                @php
                    $mockDeals = [
                        [
                            'id' => 1,
                            'title' => 'Chicken Biriyani Special',
                            'shop' => 'Khaja Makkani',
                            'slug' => 'khaja-makkani',
                            'discount' => '30% OFF',
                            'original' => 220,
                            'price' => 149,
                            'coins' => 10,
                            'location' => 'Edappally',
                            'dist' => '1.8 KM',
                            'rating' => '4.6',
                            'reviews' => 120,
                            'image' => 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?auto=format&fit=crop&w=500&q=80',
                        ],
                        [
                            'id' => 2,
                            'title' => 'Hair Spa + Stylish Haircut',
                            'shop' => 'Looks Salon',
                            'slug' => 'looks-salon',
                            'discount' => '20% OFF',
                            'original' => 999,
                            'price' => 799,
                            'coins' => 15,
                            'location' => 'Edappally',
                            'dist' => '1.8 KM',
                            'rating' => '4.3',
                            'reviews' => 86,
                            'image' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=500&q=80',
                        ],
                        [
                            'id' => 3,
                            'title' => 'Any Large Cheese Pizza',
                            'shop' => 'Pizza Town',
                            'slug' => 'pizza-town',
                            'discount' => '15% OFF',
                            'original' => 600,
                            'price' => 510,
                            'coins' => 20,
                            'location' => 'Edappally',
                            'dist' => '1.8 KM',
                            'rating' => '4.5',
                            'reviews' => 58,
                            'image' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?auto=format&fit=crop&w=500&q=80',
                        ],
                        [
                            'id' => 4,
                            'title' => 'Fresh Grocery Basket',
                            'shop' => 'Fresh Supermarket',
                            'slug' => 'fresh-supermarket',
                            'discount' => '₹100 OFF',
                            'original' => 799,
                            'price' => 699,
                            'coins' => 25,
                            'location' => 'Edappally',
                            'dist' => '1.8 KM',
                            'rating' => '4.2',
                            'reviews' => 40,
                            'image' => 'https://images.unsplash.com/photo-1610348725531-843dff563e2c?auto=format&fit=crop&w=500&q=80',
                        ]
                    ];
                @endphp

                @foreach($mockDeals as $deal)
                    <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                        <!-- Image & Badges -->
                        <div class="relative h-32 sm:h-44 overflow-hidden bg-slate-100">
                            <img src="{{ $deal['image'] }}" alt="{{ $deal['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            
                            <!-- Discount Badge -->
                            <div class="absolute top-2 left-2 bg-red-600 text-white text-[9px] sm:text-[11px] font-extrabold px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-lg sm:rounded-xl shadow-md">
                                {{ $deal['discount'] }}
                            </div>

                            <!-- Heart Wishlist Action -->
                            <button onclick="saveDealAction({{ $deal['id'] }}, '{{ $deal['title'] }}')" class="absolute top-2 right-2 w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white/90 backdrop-blur text-slate-600 hover:text-red-500 hover:bg-white flex items-center justify-center transition shadow-md">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            </button>
                        </div>

                        <!-- Card Content -->
                        <div class="p-3 sm:p-5 flex-1 flex flex-col justify-between space-y-2 sm:space-y-3">
                            <div>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900 line-clamp-1 group-hover:text-purple-600 transition">
                                    {{ $deal['title'] }}
                                </h3>
                                <p class="text-[10px] sm:text-xs font-semibold text-slate-500 mt-0.5 truncate">{{ $deal['shop'] }}</p>

                                <!-- Pricing -->
                                <div class="flex items-baseline gap-1.5 sm:gap-2 mt-1.5 sm:mt-2 flex-wrap">
                                    <span class="text-sm sm:text-lg font-black text-slate-900">₹{{ $deal['price'] }}</span>
                                    <span class="text-[10px] sm:text-xs text-slate-400 line-through">₹{{ $deal['original'] }}</span>
                                    <span class="text-[9px] sm:text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1 py-0.5 rounded">
                                        Save ₹{{ $deal['original'] - $deal['price'] }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-1.5 sm:space-y-2 pt-2 border-t border-slate-100">
                                <!-- Unlock with Coins Button -->
                                <button onclick="unlockDealAction({{ $deal['coins'] }}, '{{ $deal['title'] }}')" class="w-full py-1.5 sm:py-2 px-2 sm:px-3 bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-900 rounded-xl text-[10px] sm:text-xs font-bold flex items-center justify-center gap-1 transition">
                                    <span>🔓 Unlock</span>
                                    <span class="inline-flex items-center text-amber-600 font-extrabold">🪙 {{ $deal['coins'] }}</span>
                                </button>

                                <!-- View Deal CTA -->
                                <a href="/{{ $deal['slug'] }}" class="w-full py-2 sm:py-2.5 px-2 sm:px-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-[11px] sm:text-xs font-bold flex items-center justify-center transition shadow-sm">
                                    View Deal
                                </a>

                                <!-- Distance & Rating Footer -->
                                <div class="flex items-center justify-between text-[9px] sm:text-[11px] text-slate-400 font-medium pt-0.5">
                                    <span class="truncate">📍 {{ $deal['location'] }}</span>
                                    <span class="text-amber-600 font-bold shrink-0">⭐ {{ $deal['rating'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- 6. GAMIFICATION: EARN MORE ZITY COINS (Matching Image 2 & 3) -->
        <section class="bg-gradient-to-r from-purple-50 via-indigo-50 to-amber-50 rounded-3xl p-6 sm:p-8 border border-purple-100 shadow-sm space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-400 to-orange-500 text-white flex items-center justify-center text-2xl shadow-md">
                        🎁
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-extrabold text-slate-900">Earn More Zity Coins</h2>
                        <p class="text-xs text-slate-600">Spin, refer & complete fun local activities to earn exciting rewards!</p>
                    </div>
                </div>

                <button onclick="openSpinWheel()" class="px-5 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold text-xs rounded-xl shadow-md shadow-purple-500/20 hover:from-purple-700 hover:to-indigo-700 transition">
                    Earn Now ➔
                </button>
            </div>

            <!-- 4 Activity Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div onclick="openSpinWheel()" class="cursor-pointer bg-white rounded-2xl p-4 text-center border border-slate-100 hover:border-purple-300 hover:shadow-md transition">
                    <div class="text-3xl mb-1">🎡</div>
                    <h4 class="text-xs font-bold text-slate-900">Daily Spin</h4>
                    <span class="text-[10px] text-purple-600 font-semibold">Spin & Win Coins</span>
                </div>

                <div onclick="{{ Auth::check() ? 'document.getElementById(\'referralModal\')?.classList.remove(\'hidden\')' : 'openAuthModal(\'login\')' }}" class="cursor-pointer bg-white rounded-2xl p-4 text-center border border-slate-100 hover:border-purple-300 hover:shadow-md transition">
                    <div class="text-3xl mb-1">👥</div>
                    <h4 class="text-xs font-bold text-slate-900">Refer Friend</h4>
                    <span class="text-[10px] text-emerald-600 font-bold">Get 25 Coins</span>
                </div>

                <div onclick="alert('Write a review for any store you visited to earn +5 Zity Coins!')" class="cursor-pointer bg-white rounded-2xl p-4 text-center border border-slate-100 hover:border-purple-300 hover:shadow-md transition">
                    <div class="text-3xl mb-1">⭐</div>
                    <h4 class="text-xs font-bold text-slate-900">Store Review</h4>
                    <span class="text-[10px] text-amber-600 font-bold">Get 5 Coins</span>
                </div>

                <div onclick="alert('Scan QR code at any Zity partner store in Kochi to earn +2 instant coins!')" class="cursor-pointer bg-white rounded-2xl p-4 text-center border border-slate-100 hover:border-purple-300 hover:shadow-md transition">
                    <div class="text-3xl mb-1">📱</div>
                    <h4 class="text-xs font-bold text-slate-900">Visit QR Check-in</h4>
                    <span class="text-[10px] text-blue-600 font-bold">Get 2 Coins</span>
                </div>
            </div>
        </section>

        <!-- 7. HOW ZITY WORKS? (Matching Image 2 - 5 Steps) -->
        <section class="space-y-4">
            <div class="text-center max-w-xl mx-auto">
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">How Zity Works?</h2>
                <p class="text-xs text-slate-500 mt-1">Unlock genuine discounts in 5 easy steps without pre-payment hassles.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 sm:gap-4">
                <div class="bg-white rounded-3xl p-4 text-center border border-slate-100 shadow-sm flex flex-col items-center">
                    <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-700 text-xs font-black flex items-center justify-center mb-2">1</span>
                    <div class="text-3xl mb-2">🔍</div>
                    <h3 class="text-xs font-bold text-slate-900">Discover</h3>
                    <p class="text-[10px] text-slate-500 mt-1 leading-tight">Explore amazing local deals near you.</p>
                </div>

                <div class="bg-white rounded-3xl p-4 text-center border border-slate-100 shadow-sm flex flex-col items-center">
                    <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-700 text-xs font-black flex items-center justify-center mb-2">2</span>
                    <div class="text-3xl mb-2">🪙</div>
                    <h3 class="text-xs font-bold text-slate-900">Unlock Deal</h3>
                    <p class="text-[10px] text-slate-500 mt-1 leading-tight">Use Zity Coins & get your coupon.</p>
                </div>

                <div class="bg-white rounded-3xl p-4 text-center border border-slate-100 shadow-sm flex flex-col items-center">
                    <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-700 text-xs font-black flex items-center justify-center mb-2">3</span>
                    <div class="text-3xl mb-2">🏪</div>
                    <h3 class="text-xs font-bold text-slate-900">Visit & Redeem</h3>
                    <p class="text-[10px] text-slate-500 mt-1 leading-tight">Visit the store, show QR & redeem.</p>
                </div>

                <div class="bg-white rounded-3xl p-4 text-center border border-slate-100 shadow-sm flex flex-col items-center">
                    <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-700 text-xs font-black flex items-center justify-center mb-2">4</span>
                    <div class="text-3xl mb-2">🎁</div>
                    <h3 class="text-xs font-bold text-slate-900">Save & Earn</h3>
                    <p class="text-[10px] text-slate-500 mt-1 leading-tight">Save money & earn coins as rewards.</p>
                </div>

                <div class="col-span-2 sm:col-span-1 bg-gradient-to-b from-purple-50 to-indigo-50 rounded-3xl p-4 text-center border border-purple-200 shadow-sm flex flex-col items-center">
                    <span class="w-6 h-6 rounded-full bg-purple-600 text-white text-xs font-black flex items-center justify-center mb-2">5</span>
                    <div class="text-3xl mb-2">🏬</div>
                    <div class="flex items-center gap-1">
                        <h3 class="text-xs font-bold text-slate-900">List Your Shop</h3>
                        <span class="bg-emerald-500 text-white text-[8px] font-black px-1 rounded">NEW</span>
                    </div>
                    <p class="text-[10px] text-slate-500 mt-1 leading-tight">Create your shop page & grow sales.</p>
                </div>
            </div>
        </section>

        <!-- 8. MERCHANT CTA: GROW YOUR BUSINESS WITH ZITY (Matching Image 2) -->
        <section id="register-business" class="rounded-3xl bg-gradient-to-r from-slate-950 via-purple-950 to-slate-900 text-white p-6 sm:p-10 shadow-xl border border-purple-900/40 relative overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <!-- Left Details -->
                <div class="lg:col-span-7 space-y-4">
                    <span class="text-xs font-bold text-purple-300 uppercase tracking-widest block">For Local Merchants & Services</span>
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-white">Grow Your Business with Zity</h2>
                    
                    <ul class="space-y-2 text-xs sm:text-sm text-slate-300 font-medium">
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-400 font-bold">✓</span> Reach thousands of active local customers in your neighborhood
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-400 font-bold">✓</span> Pay only for verified results & redemptions
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-400 font-bold">✓</span> Easy offer & flash discount management
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-400 font-bold">✓</span> Detailed performance & revenue dashboard
                        </li>
                    </ul>

                    <div class="pt-2">
                        @auth
                            <a href="{{ route('profile.index') }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm rounded-2xl shadow-xl shadow-amber-400/20 transition transform active:scale-95">
                                <span>+ Register / Manage Your Business</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @else
                            <button onclick="openAuthModal('register')" class="inline-flex items-center gap-2 px-6 py-3.5 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm rounded-2xl shadow-xl shadow-amber-400/20 transition transform active:scale-95">
                                <span>Register Your Business</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        @endauth
                    </div>
                </div>

                <!-- Right Mockup Analytics Card (Matching Image 2) -->
                <div class="lg:col-span-5">
                    <div class="bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/15 space-y-4">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-300">
                            <span>This Month's Performance</span>
                            <span class="text-emerald-400 font-bold">● Active</span>
                        </div>

                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div class="bg-white/5 p-2.5 rounded-xl border border-white/5">
                                <span class="text-[10px] text-slate-400">Views</span>
                                <div class="text-base font-black text-white">5,230</div>
                            </div>
                            <div class="bg-white/5 p-2.5 rounded-xl border border-white/5">
                                <span class="text-[10px] text-slate-400">Claims</span>
                                <div class="text-base font-black text-white">620</div>
                            </div>
                            <div class="bg-white/5 p-2.5 rounded-xl border border-white/5">
                                <span class="text-[10px] text-slate-400">Redeemed</span>
                                <div class="text-base font-black text-emerald-400">312</div>
                            </div>
                        </div>

                        <div class="p-3 bg-white/5 rounded-2xl border border-white/5 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-slate-400 block">Revenue Generated</span>
                                <span class="text-xl font-black text-emerald-400">₹1,45,600</span>
                            </div>
                            <span class="text-2xl">📈</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 9. POPULAR LOCATIONS (Matching Image 2) -->
        <section class="space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-extrabold text-slate-900">Popular Locations in Kochi</h3>
                <a href="{{ route('search') }}" class="text-xs font-bold text-purple-600 hover:underline">View all ➔</a>
            </div>

            <div class="flex flex-wrap gap-2">
                @foreach(['Edappally', 'Kakkanad', 'Kaloor', 'Palarivattom', 'Vyttila', 'Kundannoor', 'Aluva', 'Panampilly Nagar', 'Fort Kochi', 'Marine Drive'] as $loc)
                    <a href="{{ route('search', ['location' => $loc]) }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-purple-50 hover:text-purple-700 hover:border-purple-200 transition">
                        {{ $loc }}
                    </a>
                @endforeach
            </div>
        </section>

        <!-- 10. APP DOWNLOAD / PWA INSTALL BANNER (Matching Image 2) -->
        <section class="rounded-3xl bg-gradient-to-r from-purple-900 via-indigo-900 to-purple-800 text-white p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-xl relative overflow-hidden">
            <div class="space-y-2 text-center sm:text-left">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur text-purple-200 text-[11px] font-bold">
                    📱 Progressive Web App
                </div>
                <h3 class="text-xl sm:text-2xl font-black">Get Better Experience - Download Zity App!</h3>
                <div class="flex flex-wrap gap-4 text-xs text-purple-200 justify-center sm:justify-start">
                    <span>⚡ Exclusive App Deals</span>
                    <span>🚀 Faster Access</span>
                    <span>🎟️ Instant QR Offline</span>
                </div>
            </div>

            <!-- Install / App Buttons -->
            <div class="flex items-center gap-3 shrink-0">
                <button onclick="window.installZityApp()" class="px-5 py-3 rounded-2xl bg-white hover:bg-purple-50 text-purple-900 font-extrabold text-xs shadow-lg transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Install Zity App</span>
                </button>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-100 mt-12 py-8 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 space-y-2">
            <div class="flex justify-center items-center gap-2 font-black text-lg text-slate-900">
                <span>ZITY<span class="text-purple-600">.in</span></span>
            </div>
            <p class="text-slate-400 text-xs">Local Deals. Real Savings. • Kochi, Kerala</p>
            <p class="text-[11px] text-slate-400">© {{ date('Y') }} Zity.in. All rights reserved.</p>
        </div>
    </footer>

    <!-- MOBILE STICKY BOTTOM NAVIGATION (Matching Image 1, 2, 3) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 px-2 py-2 shadow-2xl">
        <div class="flex items-center justify-around">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 text-purple-700 font-bold transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px] font-bold">Home</span>
            </a>
            <a href="#deals" class="flex flex-col items-center gap-1 text-slate-500 hover:text-purple-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                <span class="text-[10px] font-semibold">Deals</span>
            </a>
            <a href="{{ Auth::check() ? route('profile.index') : 'javascript:openAuthModal(\'login\')' }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-purple-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span class="text-[10px] font-semibold">Bookings</span>
            </a>
            <a href="{{ Auth::check() ? route('profile.index') : 'javascript:openAuthModal(\'login\')' }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-purple-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                <span class="text-[10px] font-semibold">Saved</span>
            </a>
            <a href="{{ Auth::check() ? route('profile.index') : 'javascript:openAuthModal(\'login\')' }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-purple-600 transition">
                <div class="w-5 h-5 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center text-[10px] font-bold">
                    @auth {{ strtoupper(substr(Auth::user()->name, 0, 1)) }} @else 👤 @endauth
                </div>
                <span class="text-[10px] font-semibold">Profile</span>
            </a>
        </div>
    </nav>

    <!-- Interactive Spin & Win Modal -->
    <div id="spinWheelModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden">
        <div class="relative w-full max-w-sm bg-white rounded-3xl p-6 text-center shadow-2xl">
            <button onclick="document.getElementById('spinWheelModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="text-4xl mb-2">🎡</div>
            <h3 class="text-lg font-black text-slate-900">Daily Spin & Win!</h3>
            <p class="text-xs text-slate-500 mt-1">Spin the wheel to win up to 50 free Zity Coins every day.</p>
            
            <div class="my-6 py-6 bg-slate-50 rounded-2xl border border-dashed border-purple-200">
                <span class="text-5xl animate-spin inline-block" id="spinWheelGraphic">🎯</span>
            </div>

            <button onclick="performSpin()" id="spinBtn" class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold text-xs shadow-xl shadow-purple-500/25 hover:from-purple-700 hover:to-indigo-700 transition">
                SPIN NOW
            </button>
        </div>
    </div>

    <!-- Deal Unlock Success Modal -->
    <div id="dealUnlockedModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden">
        <div class="relative w-full max-w-sm bg-white rounded-3xl p-6 text-center shadow-2xl">
            <button onclick="document.getElementById('dealUnlockedModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="text-5xl mb-2">🎉</div>
            <h3 class="text-lg font-black text-slate-900">Deal Unlocked!</h3>
            <p class="text-xs text-slate-500 mt-1" id="unlockedDealTitle">Chicken Biriyani Special</p>

            <div class="my-4 p-4 bg-purple-50 rounded-2xl border border-purple-200">
                <span class="text-[10px] text-purple-700 font-bold uppercase tracking-wider block">Your Coupon Code</span>
                <span class="text-xl font-mono font-black text-purple-900 mt-1 block" id="couponCodeDisplay">ZITY9495</span>
                <span class="text-[10px] text-slate-500 mt-1 block">Show this code or QR at the store to claim discount.</span>
            </div>

            <button onclick="document.getElementById('dealUnlockedModal').classList.add('hidden')" class="w-full py-3 px-4 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs transition">
                Got It, Thanks!
            </button>
        </div>
    </div>

    <!-- Include Auth Modal & Welcome Reward Modal -->
    @include('auth.login-modal')
    @include('components.welcome-modal')

    <!-- PWA Install Script -->
    <script src="/js/pwa-install.js"></script>

    <!-- Client-side Logic Scripts -->
    <script>
        function toggleLocationDropdown() {
            const dropdown = document.getElementById('locationDropdown');
            dropdown.classList.toggle('hidden');
        }

        function selectLocation(loc) {
            document.getElementById('currentLocationText').innerText = loc;
            const heroLoc = document.getElementById('heroLocationDisplay');
            if (heroLoc) heroLoc.innerText = loc;
            document.getElementById('locationDropdown').classList.add('hidden');
        }

        function openSpinWheel() {
            @auth
                document.getElementById('spinWheelModal').classList.remove('hidden');
            @else
                openAuthModal('login');
            @endauth
        }

        function performSpin() {
            const btn = document.getElementById('spinBtn');
            btn.disabled = true;
            btn.innerText = 'Spinning...';
            setTimeout(() => {
                alert('🎉 Congratulations! You won 15 Bonus Zity Coins!');
                document.getElementById('spinWheelModal').classList.add('hidden');
                btn.disabled = false;
                btn.innerText = 'SPIN NOW';
            }, 1200);
        }

        function saveDealAction(id, title) {
            @auth
                fetch('{{ route("deal.save") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ product_id: id, deal_title: title })
                })
                .then(r => r.json())
                .then(data => {
                    alert(data.message || 'Deal saved to your profile!');
                })
                .catch(() => alert('Saved to your wishlist!'));
            @else
                openAuthModal('login');
            @endauth
        }

        function unlockDealAction(coins, title) {
            @auth
                fetch('{{ route("deal.unlock") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ coins: coins, deal_title: title })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('unlockedDealTitle').innerText = title;
                        document.getElementById('couponCodeDisplay').innerText = data.coupon_code || 'ZITY' + Math.floor(1000 + Math.random() * 9000);
                        document.getElementById('dealUnlockedModal').classList.remove('hidden');
                    } else {
                        alert(data.message || 'Could not unlock deal.');
                    }
                })
                .catch(() => {
                    document.getElementById('unlockedDealTitle').innerText = title;
                    document.getElementById('dealUnlockedModal').classList.remove('hidden');
                });
            @else
                openAuthModal('login');
            @endauth
        }
    </script>
</body>
</html>
