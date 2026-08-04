<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zity.in — Find Local Shops & Services Near You</title>
    <meta name="description" content="Discover local shops, services and businesses near you — or claim your own free business page on Zity.in">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { font-family: 'Inter', system-ui, sans-serif; box-sizing: border-box; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 99px; }

        /* ── Hero headline kerning ── */
        .hero-headline { letter-spacing: -0.04em; line-height: 1.05; }

        /* ── Search track focus glow ── */
        .search-wrap:focus-within { box-shadow: 0 0 0 3px rgba(79,70,229,0.15); }

        /* ── Category pill active ── */
        .cat-pill.active { background: #4F46E5; color: #fff; border-color: #4F46E5; }

        /* ── Availability message animate ── */
        #avail-msg { transition: opacity 0.25s, transform 0.25s; }
        #avail-msg.hidden { opacity: 0; transform: translateY(6px); pointer-events: none; }
        #avail-msg.shown  { opacity: 1; transform: translateY(0); }

        /* ── Reg form inline preview ── */
        #reg-slug-preview { transition: opacity 0.2s; }

        /* ── Step numbers ── */
        .step-num { width: 2rem; height: 2rem; background: #EEF2FF; color: #4F46E5; border-radius: 50%;
                    display: flex; align-items: center; justify-content: center;
                    font-weight: 700; font-size: 0.875rem; flex-shrink: 0; }

        /* ── Form radio card ── */
        .type-card { cursor: pointer; }
        .type-card input:checked ~ * { color: #4F46E5; }
        .type-card:has(input:checked) { border-color: #4F46E5; background: #EEF2FF; }

        /* ── Subtle divider text ── */
        .divider-text { 
            display: flex; align-items: center; gap: 1.5rem; 
            color: #4F46E5; font-size: 0.875rem; font-weight: 800; 
            letter-spacing: 0.025em; text-transform: uppercase;
        }
        .divider-text span {
            background: linear-gradient(to right, #4F46E5, #7C3AED);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            padding: 0.25rem 0.75rem;
            background-color: #EEF2FF;
            border-radius: 99px;
            border: 1px solid rgba(79, 70, 229, 0.1);
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1), 0 2px 4px -1px rgba(79, 70, 229, 0.06);
        }
        .divider-text::before, .divider-text::after { content: ''; flex: 1; height: 1px; background: linear-gradient(to right, transparent, rgba(79, 70, 229, 0.2), transparent); }

        /* ── Category row horizontal scroll on mobile ── */
        .cat-row { scrollbar-width: none; }
        .cat-row::-webkit-scrollbar { display: none; }

        /* ── Fade in animation ── */
        @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
        .fade-up { animation: fadeUp 0.5s ease both; }
        .fade-up-1 { animation-delay: 0.05s; }
        .fade-up-2 { animation-delay: 0.12s; }
        .fade-up-3 { animation-delay: 0.20s; }
        .fade-up-4 { animation-delay: 0.28s; }

        /* ── Search Suggestions ── */
        .suggestions-box {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #E5E7EB;
            border-radius: 1rem;
            margin-top: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            z-index: 50;
            overflow: hidden;
            display: none;
        }
        .suggestions-box.active { display: block; }
        .suggestion-item {
            padding: 0.75rem 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: background 0.1s;
        }
        .suggestion-item:hover, .suggestion-item.selected { background: #F3F4F6; }
        .suggestion-type {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            letter-spacing: 0.025em;
        }
        .type-category { background: #EEF2FF; color: #4F46E5; }
        .type-business { background: #ECFDF5; color: #059669; }
        .type-product  { background: #FFF7ED; color: #D97706; }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased overflow-x-hidden">

    {{-- ══════════════════════════════════════════
         NAV — minimal, sticky
    ══════════════════════════════════════════ --}}
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur border-b border-gray-100">
        <nav class="max-w-5xl mx-auto flex items-center justify-between px-5 py-3.5">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2 group">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm group-hover:bg-indigo-700 transition-colors">Z</div>
                <span class="font-bold text-lg tracking-tight text-gray-900">Zity<span class="text-indigo-600">.in</span></span>
            </a>

            {{-- Right actions --}}
            <div class="flex items-center gap-3">
                <a href="#register" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-all">
                    List Your Business
                </a>
                @auth
                <a href="/admin" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                    Dashboard
                </a>
                @else
                <a href="/admin" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 transition-colors">
                    Login
                </a>
                @endauth
            </div>
        </nav>
    </header>

    {{-- ══════════════════════════════════════════
         HERO — search first, dual track
    ══════════════════════════════════════════ --}}
    <main>
    <section class="max-w-2xl mx-auto px-5 pt-16 pb-12 text-center">

        {{-- Headline --}}
        <h1 class="hero-headline text-4xl sm:text-5xl md:text-6xl font-black text-gray-900 mb-4 fade-up fade-up-1">
            Find anything<br><span class="text-indigo-600">near you.</span>
        </h1>
        <p class="text-gray-500 text-lg mb-10 fade-up fade-up-2">
            Discover local shops, services & businesses — or claim your free business page in seconds.
        </p>

        {{-- ── Track 1: Find a business ── --}}
        <div class="mb-3 fade-up fade-up-3 relative" id="search-container">
            <form action="{{ route('search') }}" method="GET" id="search-form"
                  class="search-wrap flex items-center bg-white border-2 border-gray-200 rounded-2xl overflow-hidden transition-all hover:border-gray-300">
                <span class="pl-4 text-gray-400 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input
                    type="text" name="q" id="search-input"
                    placeholder="Search plumber, grocery, salon…"
                    class="flex-1 px-3 py-4 text-base text-gray-900 bg-transparent focus:outline-none placeholder:text-gray-400 min-w-0"
                    autocomplete="off"
                >
                <button type="submit"
                    class="flex-shrink-0 m-1.5 px-5 py-2.5 bg-indigo-600 text-white font-semibold text-sm rounded-xl hover:bg-indigo-700 active:scale-95 transition-all">
                    Search
                </button>
            </form>
            <div id="suggestions" class="suggestions-box"></div>
        </div>

        {{-- Category quick-picks --}}
        <div class="cat-row flex items-center gap-2 overflow-x-auto pb-1 mb-8 fade-up fade-up-3 justify-center flex-wrap">
            @php
                $defaultCats = ['Grocery','Plumber','Electrician','Salon','Mechanic','Restaurant','Pharmacy','Tailor'];
            @endphp
            @if($categories->count())
                @foreach($categories->take(8) as $cat)
                    <a href="{{ route('search', ['q' => $cat->name]) }}"
                       class="cat-pill flex-shrink-0 px-3.5 py-1.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-full hover:border-indigo-400 hover:text-indigo-600 transition-all whitespace-nowrap">
                        {{ $cat->name }}
                    </a>
                @endforeach
            @else
                @foreach($defaultCats as $cat)
                    <a href="{{ route('search', ['q' => $cat]) }}"
                       class="cat-pill flex-shrink-0 px-3.5 py-1.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-full hover:border-indigo-400 hover:text-indigo-600 transition-all whitespace-nowrap">
                        {{ $cat }}
                    </a>
                @endforeach
            @endif
        </div>

        {{-- Divider --}}
        <div class="divider-text mb-6 fade-up fade-up-4">
            <span>List Your shop / service free</span>
        </div>

        {{-- ── Track 2: Brand availability check ── --}}
        <div class="fade-up fade-up-4">
            <div class="search-wrap flex items-center bg-white border-2 border-gray-200 rounded-2xl overflow-hidden transition-all hover:border-gray-300 mb-3">
                <span class="pl-4 pr-1 text-gray-400 font-medium text-sm flex-shrink-0 whitespace-nowrap select-none">zity.in/</span>
                <input
                    type="text" id="brand-input"
                    placeholder="yourbrandname"
                    class="flex-1 py-4 px-1 text-base font-semibold text-gray-900 bg-transparent focus:outline-none placeholder:text-gray-300 min-w-0"
                    autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                >
                <button id="check-btn"
                    class="flex-shrink-0 m-1.5 px-5 py-2.5 bg-gray-900 text-white font-semibold text-sm rounded-xl hover:bg-gray-700 active:scale-95 transition-all">
                    Check
                </button>
            </div>

            {{-- Availability result --}}
            <div id="avail-msg" class="hidden mb-2">
                <div id="avail-inner" class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 text-left">
                    <div id="avail-icon" class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"></div>
                    <div class="flex-1 min-w-0">
                        <p id="avail-title" class="font-bold text-sm leading-tight"></p>
                        <p id="avail-sub" class="text-xs text-gray-500 mt-0.5"></p>
                    </div>
                    <button onclick="scrollToRegister()" id="claim-btn"
                        class="hidden flex-shrink-0 px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition-all">
                        Claim →
                    </button>
                </div>
            </div>
        </div>

    </section>

    {{-- ══════════════════════════════════════════
         STATS STRIP
    ══════════════════════════════════════════ --}}
    <div class="border-y border-gray-100 bg-gray-50">
        <div class="max-w-3xl mx-auto px-5 py-5 flex flex-wrap justify-center gap-8">
            <div class="text-center">
                <p class="text-2xl font-black text-gray-900">Free</p>
                <p class="text-xs text-gray-500 font-medium mt-0.5">Always & forever</p>
            </div>
            <div class="hidden sm:block w-px bg-gray-200"></div>
            <div class="text-center">
                <p class="text-2xl font-black text-gray-900">60s</p>
                <p class="text-xs text-gray-500 font-medium mt-0.5">To go live</p>
            </div>
            <div class="hidden sm:block w-px bg-gray-200"></div>
            <div class="text-center">
                <p class="text-2xl font-black text-gray-900">0%</p>
                <p class="text-xs text-gray-500 font-medium mt-0.5">Commission</p>
            </div>
            <div class="hidden sm:block w-px bg-gray-200"></div>
            <div class="text-center">
                <p class="text-2xl font-black text-gray-900">India</p>
                <p class="text-xs text-gray-500 font-medium mt-0.5">Local & global</p>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         HOW IT WORKS — 3 clean steps
    ══════════════════════════════════════════ --}}
    <section class="max-w-3xl mx-auto px-5 py-16">
        <div class="text-center mb-10">
            <p class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-2">For Business Owners</p>
            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Your shop online in 3 steps</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Step 1 --}}
            <div class="flex flex-col items-start gap-4 p-6 rounded-2xl border border-gray-100 bg-white hover:border-indigo-200 hover:shadow-md transition-all group">
                <div class="step-num group-hover:bg-indigo-600 group-hover:text-white transition-colors">1</div>
                <div>
                    <h3 class="font-bold text-gray-900 mb-1">Check your brand name</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Type the name you want. See instantly if <span class="font-mono text-indigo-600">zity.in/yourname</span> is free.</p>
                </div>
            </div>

            {{-- Step 2 --}}
            <div class="flex flex-col items-start gap-4 p-6 rounded-2xl border border-gray-100 bg-white hover:border-indigo-200 hover:shadow-md transition-all group">
                <div class="step-num group-hover:bg-indigo-600 group-hover:text-white transition-colors">2</div>
                <div>
                    <h3 class="font-bold text-gray-900 mb-1">Fill in the basics</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Your shop name, phone number and what you do. That's it — no forms, no documents.</p>
                </div>
            </div>

            {{-- Step 3 --}}
            <div class="flex flex-col items-start gap-4 p-6 rounded-2xl border border-gray-100 bg-white hover:border-indigo-200 hover:shadow-md transition-all group">
                <div class="step-num group-hover:bg-indigo-600 group-hover:text-white transition-colors">3</div>
                <div>
                    <h3 class="font-bold text-gray-900 mb-1">Share & get customers</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Your page is live. Share your link on WhatsApp, Instagram, anywhere — orders come to you directly.</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="#register"
               class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 active:scale-95 transition-all shadow-lg shadow-indigo-100 text-sm">
                Create Your Free Page
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         REGISTER SECTION — 2-col desktop, stacked mobile
    ══════════════════════════════════════════ --}}
    <section id="register" class="bg-gray-50 border-t border-gray-100 py-16 px-5">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">

                {{-- LEFT: pitch --}}
                <div class="md:sticky md:top-24 pt-2">
                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-widest mb-3">Free Registration</p>
                    <h2 class="text-4xl font-black text-gray-900 tracking-tight leading-tight mb-4">
                        Claim your<br>business page.
                    </h2>
                    <p class="text-gray-500 text-base leading-relaxed mb-8">
                        Shops, restaurants, salons, electricians, mechanics — everyone welcome. No fees, no commissions, ever.
                    </p>
                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 bg-indigo-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-800">Live in 60 seconds</p>
                                <p class="text-xs text-gray-500 mt-0.5">Fill in your name and number. Your page is online instantly.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-800">100% free — no commissions</p>
                                <p class="text-xs text-gray-500 mt-0.5">Your page, your customers, your money. We take nothing.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.685 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-800">WhatsApp orders directly</p>
                                <p class="text-xs text-gray-500 mt-0.5">Customers tap to order. Orders land straight on your WhatsApp.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-800">Your own shareable link</p>
                                <p class="text-xs text-gray-500 mt-0.5">Share <span class="font-mono text-indigo-600">zity.in/yourname</span> on WhatsApp, Instagram, anywhere.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: form --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                    <form action="{{ route('register.shop') }}" method="POST" class="space-y-5">
                        @csrf

                        @if ($errors->any() && !$errors->has('shop_name'))
                            <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm">
                                <ul class="list-disc list-inside space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Type --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label class="type-card flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all">
                                <input type="radio" name="type" value="shop" class="text-indigo-600 focus:ring-indigo-500 flex-shrink-0" checked onchange="toggleServiceArea(this.value)">
                                <div>
                                    <p class="font-semibold text-sm text-gray-800">🛍️ Products</p>
                                </div>
                            </label>
                            <label class="type-card flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all">
                                <input type="radio" name="type" value="service" class="text-indigo-600 focus:ring-indigo-500 flex-shrink-0" onchange="toggleServiceArea(this.value)">
                                <div>
                                    <p class="font-semibold text-sm text-gray-800">🔧 Services</p>
                                </div>
                            </label>
                            <label class="type-card flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all">
                                <input type="radio" name="type" value="both" class="text-indigo-600 focus:ring-indigo-500 flex-shrink-0" onchange="toggleServiceArea(this.value)">
                                <div>
                                    <p class="font-semibold text-sm text-gray-800">🛍️🔧 Both</p>
                                </div>
                            </label>
                        </div>

                        {{-- Business Name --}}
                        <div class="space-y-1.5">
                            <label for="reg-shop-name" class="block text-sm font-semibold text-gray-700">
                                Business Name <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="text" name="shop_name" id="reg-shop-name"
                                placeholder="e.g. Green Grocery"
                                value="{{ old('shop_name') }}"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('shop_name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 focus:outline-none transition-all text-sm placeholder:text-gray-400"
                                required
                            >
                            @error('shop_name')
                                <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                            @enderror
                            <div id="reg-slug-preview" class="hidden items-center gap-1.5">
                                <span class="text-xs text-gray-400">zity.in/<span class="font-mono font-semibold text-gray-600" id="reg-slug-text"></span></span>
                                <span id="reg-slug-badge" class="text-xs font-semibold px-2 py-0.5 rounded-full"></span>
                            </div>
                        </div>

                        {{-- WhatsApp --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-gray-700">
                                WhatsApp Number <span class="text-red-400">*</span>
                            </label>
                            <input
                                type="text" name="phone"
                                placeholder="+91 98765 43210"
                                value="{{ old('phone') }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 focus:outline-none transition-all text-sm placeholder:text-gray-400"
                                required
                            >
                        </div>

                        {{-- Email --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-gray-700">
                                Email <span class="text-gray-400 font-normal">(optional)</span>
                            </label>
                            <input
                                type="email" name="email"
                                placeholder="you@example.com"
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 focus:outline-none transition-all text-sm placeholder:text-gray-400"
                            >
                        </div>

                        {{-- Password --}}
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-gray-700">
                                Password <span class="text-red-400">*</span>
                            </label>
                            <div class="relative">
                                <input
                                    type="password" name="password" id="reg-password"
                                    placeholder="Create a password"
                                    class="w-full px-4 py-3 pr-11 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 focus:outline-none transition-all text-sm placeholder:text-gray-400"
                                    required
                                >
                                <button type="button" onclick="togglePwd()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-indigo-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path id="eye-open"       stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path id="eye-open-outer" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        <path id="eye-closed" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.04m5.733-4.441A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.059 10.059 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Service area --}}
                        <div id="service-area-field" class="hidden space-y-1.5">
                            <label class="block text-sm font-semibold text-gray-700">
                                Service Area <span class="text-gray-400 font-normal">(optional)</span>
                            </label>
                            <input
                                type="text" name="service_area" id="service-area-input"
                                placeholder="e.g. Kozhikode City, 10km radius"
                                value="{{ old('service_area') }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 focus:outline-none transition-all text-sm placeholder:text-gray-400"
                            >
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="w-full py-3.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 active:scale-[0.99] transition-all text-sm flex items-center justify-center gap-2 mt-2">
                            Create My Free Business Page
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>

                        <p class="text-xs text-center text-gray-400 pt-1">
                            By registering you agree to our <a href="#" class="underline hover:text-gray-600">Terms of Service</a>. No credit card required.
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </section>

    </main>

    {{-- ══════════════════════════════════════════
         FOOTER — ultra minimal
    ══════════════════════════════════════════ --}}
    <footer class="border-t border-gray-100 bg-white">
        <div class="max-w-5xl mx-auto px-5 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-indigo-600 rounded-md flex items-center justify-center text-white font-bold text-xs">Z</div>
                <span class="font-bold text-sm text-gray-900">Zity<span class="text-indigo-600">.in</span></span>
            </div>
            <p class="text-xs text-gray-400 text-center">
                Building the digital city for local businesses &mdash; &copy; {{ date('Y') }} Zity.in
            </p>
            <div class="flex items-center gap-4 text-xs text-gray-400">
                <a href="#" class="hover:text-gray-700 transition-colors">Privacy</a>
                <a href="#" class="hover:text-gray-700 transition-colors">Terms</a>
                @auth
                <a href="/admin" class="hover:text-gray-700 transition-colors">Dashboard</a>
                @else
                <a href="/admin" class="hover:text-gray-700 transition-colors">Login</a>
                @endauth
            </div>
        </div>
    </footer>

    {{-- ══════════════════════════════════════════
         JAVASCRIPT
    ══════════════════════════════════════════ --}}
    <script>
    /* ── Utility: client-side slugify (mirrors Laravel's Str::slug) ── */
    function slugify(str) {
        return str.toLowerCase().trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    /* ════════════════════════════════════
       TRACK 2: Hero brand availability check
    ════════════════════════════════════ */
    const brandInput  = document.getElementById('brand-input');
    const checkBtn    = document.getElementById('check-btn');
    const availMsg    = document.getElementById('avail-msg');
    const availInner  = document.getElementById('avail-inner');
    const availIcon   = document.getElementById('avail-icon');
    const availTitle  = document.getElementById('avail-title');
    const availSub    = document.getElementById('avail-sub');
    const claimBtn    = document.getElementById('claim-btn');
    const regShopName = document.getElementById('reg-shop-name');

    async function checkAvailability(rawName) {
        const name = rawName.trim();
        if (!name) { hideAvail(); return; }

        availMsg.classList.remove('hidden', 'shown');
        availMsg.classList.add('shown');

        try {
            const res  = await fetch(`/check-availability?name=${encodeURIComponent(name)}`);
            const data = await res.json();

            if (data.available) {
                availInner.className = 'flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-green-200 bg-green-50 text-left';
                availIcon.className  = 'w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-green-500 text-white';
                availIcon.innerHTML  = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>';
                availTitle.textContent = 'Available!';
                availTitle.className   = 'font-bold text-sm text-green-800';
                availSub.textContent   = `zity.in/${data.slug} is yours to claim.`;
                claimBtn.classList.remove('hidden');
                // Pre-fill the registration form name
                regShopName.value = name;
                triggerRegSlugCheck(name);
            } else {
                availInner.className = 'flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-red-200 bg-red-50 text-left';
                availIcon.className  = 'w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-red-500 text-white';
                availIcon.innerHTML  = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>';
                availTitle.textContent = 'Already taken';
                availTitle.className   = 'font-bold text-sm text-red-800';
                availSub.textContent   = 'Try adding your city or a unique twist.';
                claimBtn.classList.add('hidden');
            }
        } catch (e) {
            console.error('Brand check error:', e);
        }
    }

    function hideAvail() {
        availMsg.classList.add('hidden');
        availMsg.classList.remove('shown');
    }

    function scrollToRegister() {
        document.getElementById('register').scrollIntoView({ behavior: 'smooth' });
        setTimeout(() => {
            regShopName.focus();
            regShopName.classList.add('ring-2', 'ring-indigo-300', 'border-indigo-500');
            setTimeout(() => regShopName.classList.remove('ring-2', 'ring-indigo-300'), 2000);
        }, 600);
    }

    let heroDebounce = null;
    brandInput.addEventListener('input', e => {
        clearTimeout(heroDebounce);
        if (!e.target.value.trim()) { hideAvail(); return; }
        heroDebounce = setTimeout(() => checkAvailability(e.target.value), 500);
    });
    checkBtn.addEventListener('click', () => checkAvailability(brandInput.value));
    brandInput.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); checkAvailability(brandInput.value); } });

    /* ════════════════════════════════════
       Registration form: inline slug preview
    ════════════════════════════════════ */
    const regSlugPreview = document.getElementById('reg-slug-preview');
    const regSlugText    = document.getElementById('reg-slug-text');
    const regSlugBadge   = document.getElementById('reg-slug-badge');

    function showRegSlug(slug, state) {
        // state: 'loading' | 'available' | 'taken'
        regSlugText.textContent = slug;
        regSlugPreview.classList.remove('hidden');
        regSlugPreview.classList.add('flex');

        if (state === 'loading') {
            regSlugBadge.textContent = '…';
            regSlugBadge.className   = 'text-xs font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-500';
            regShopName.classList.remove('border-green-400', 'border-red-300');
        } else if (state === 'available') {
            regSlugBadge.textContent = '✓ Available';
            regSlugBadge.className   = 'text-xs font-bold px-2 py-0.5 rounded-full bg-green-100 text-green-700';
            regShopName.classList.add('border-green-400');
            regShopName.classList.remove('border-red-300', 'border-gray-200');
        } else {
            regSlugBadge.textContent = '✗ Taken';
            regSlugBadge.className   = 'text-xs font-bold px-2 py-0.5 rounded-full bg-red-100 text-red-600';
            regShopName.classList.add('border-red-300');
            regShopName.classList.remove('border-green-400', 'border-gray-200');
        }
    }

    async function triggerRegSlugCheck(rawName) {
        const slug = slugify(rawName);
        if (!slug) {
            regSlugPreview.classList.add('hidden');
            regSlugPreview.classList.remove('flex');
            return;
        }
        showRegSlug(slug, 'loading');
        try {
            const res  = await fetch(`/check-availability?name=${encodeURIComponent(rawName)}`);
            const data = await res.json();
            showRegSlug(data.slug || slug, data.available ? 'available' : 'taken');
        } catch (e) {
            console.error('Reg slug check error:', e);
        }
    }

    let regDebounce = null;
    regShopName.addEventListener('input', e => {
        clearTimeout(regDebounce);
        regDebounce = setTimeout(() => triggerRegSlugCheck(e.target.value), 500);
    });

    // If old('shop_name') is pre-filled (e.g. after a validation failure), run check on load
    if (regShopName.value) {
        triggerRegSlugCheck(regShopName.value);
    }

    /* ════════════════════════════════════
       Password toggle
    ════════════════════════════════════ */
    function togglePwd() {
        const inp = document.getElementById('reg-password');
        const isText = inp.type === 'text';
        inp.type = isText ? 'password' : 'text';
        document.getElementById('eye-open').classList.toggle('hidden', !isText);
        document.getElementById('eye-open-outer').classList.toggle('hidden', !isText);
        document.getElementById('eye-closed').classList.toggle('hidden', isText);
    }

    /* ════════════════════════════════════
       Service area field toggle
    ════════════════════════════════════ */
    function toggleServiceArea(value) {
        const field = document.getElementById('service-area-field');
        field.classList.toggle('hidden', value !== 'service' && value !== 'both');
        document.getElementById('service-area-input').removeAttribute('required');
    }

    /* ════════════════════════════════════
       SEARCH AUTOCOMPLETE
    ════════════════════════════════════ */
    const searchInput = document.getElementById('search-input');
    const suggestionsBox = document.getElementById('suggestions');
    let selectedIndex = -1;

    async function fetchSuggestions(query) {
        if (query.length < 2) {
            hideSuggestions();
            return;
        }

        try {
            const res = await fetch(`/api/suggestions?q=${encodeURIComponent(query)}`);
            const data = await res.json();
            renderSuggestions(data);
        } catch (e) {
            console.error('Suggestions error:', e);
        }
    }

    function renderSuggestions(data) {
        if (data.length === 0) {
            hideSuggestions();
            return;
        }

        suggestionsBox.innerHTML = data.map((item, index) => `
            <div class="suggestion-item" data-index="${index}" onclick="location.href='${item.url}'">
                <span class="suggestion-type type-${item.type}">${item.type}</span>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-sm text-gray-800 truncate">${item.text}</p>
                    ${item.business ? `<p class="text-xs text-gray-500 truncate">${item.business}</p>` : ''}
                </div>
            </div>
        `).join('');

        suggestionsBox.classList.add('active');
        selectedIndex = -1;
    }

    function hideSuggestions() {
        suggestionsBox.classList.remove('active');
        selectedIndex = -1;
    }

    let searchDebounce = null;
    searchInput.addEventListener('input', e => {
        clearTimeout(searchDebounce);
        searchDebounce = setTimeout(() => fetchSuggestions(e.target.value), 300);
    });

    searchInput.addEventListener('keydown', e => {
        const items = suggestionsBox.querySelectorAll('.suggestion-item');
        if (!suggestionsBox.classList.contains('active')) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedIndex = Math.min(selectedIndex + 1, items.length - 1);
            updateSelection(items);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedIndex = Math.max(selectedIndex - 1, -1);
            updateSelection(items);
        } else if (e.key === 'Enter' && selectedIndex > -1) {
            e.preventDefault();
            items[selectedIndex].click();
        } else if (e.key === 'Escape') {
            hideSuggestions();
        }
    });

    function updateSelection(items) {
        items.forEach((item, index) => {
            item.classList.toggle('selected', index === selectedIndex);
        });
        if (selectedIndex > -1) {
            // Optional: update input value to selected item text
            // searchInput.value = items[selectedIndex].querySelector('p').textContent;
        }
    }

    document.addEventListener('click', e => {
        if (!document.getElementById('search-container').contains(e.target)) {
            hideSuggestions();
        }
    });
    </script>

</body>
</html>
