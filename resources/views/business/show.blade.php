<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $business->name }} — Zity.in</title>
    
    <!-- Open Graph / Social Media Meta Tags -->
    @if(isset($ogProduct) && $ogProduct)
        <meta property="og:title" content="{{ $ogProduct->name }} at {{ $business->name }} — Zity.in">
        <meta property="og:description" content="{{ $ogProduct->description ?? 'Check out ' . $ogProduct->name . ' at our store.' }}">
        <meta property="og:type" content="product">
        <meta property="og:url" content="{{ request()->url() }}?product={{ $ogProduct->id }}">
        @if($ogProduct->image)
            <meta property="og:image" content="{{ asset('storage/' . $ogProduct->image) }}">
            <meta name="twitter:image" content="{{ asset('storage/' . $ogProduct->image) }}">
        @elseif($business->logo)
            <meta property="og:image" content="{{ asset('storage/' . $business->logo) }}">
            <meta name="twitter:image" content="{{ asset('storage/' . $business->logo) }}">
        @endif
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $ogProduct->name }} at {{ $business->name }} — Zity.in">
        <meta name="twitter:description" content="{{ $ogProduct->description ?? 'Check out ' . $ogProduct->name . ' at our store.' }}">
    @else
        <meta property="og:title" content="{{ $business->name }} — Zity.in">
        <meta property="og:description" content="{{ $business->description ?? 'Discover our organic and natural products online at our official store.' }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ request()->url() }}">
        @if($business->logo)
            <meta property="og:image" content="{{ asset('storage/' . $business->logo) }}">
            <meta name="twitter:image" content="{{ asset('storage/' . $business->logo) }}">
        @endif
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $business->name }} — Zity.in">
        <meta name="twitter:description" content="{{ $business->description ?? 'Discover our organic and natural products online at our official store.' }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-cream: #FAF7F2;
            --header-sage: #A3D8BD;
            --header-sage-dark: #8ECDAA;
            --brand-dark: #1E3A2F;
            --pill-tan: #DFCAAB;
            --pill-tan-text: #4E3629;
            --btn-green: #25D366;
            --btn-green-hover: #20BA56;
            --accent-green: #2D6A4F;
        }

        body {
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-cream);
            color: #2D3748;
            -webkit-tap-highlight-color: transparent;
            min-height: 100vh;
        }

        /* Smooth scroll & hide default scrollbar */
        html {
            scroll-behavior: smooth;
        }
        ::-webkit-scrollbar {
            display: none;
        }
        body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .sage-banner {
            background-color: var(--header-sage);
        }

        /* Cart Sidebar & Overlay */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            max-width: 440px;
            height: 100%;
            background: #FFFFFF;
            z-index: 120;
            transition: right 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: -12px 0 35px rgba(30, 58, 47, 0.15);
        }
        .cart-sidebar.open {
            right: 0;
        }
        .cart-overlay {
            position: fixed;
            inset: 0;
            background: rgba(30, 58, 47, 0.45);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 110;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .cart-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        /* Active Tab indicator */
        .cat-tab.active {
            color: var(--accent-green);
            font-weight: 700;
            border-bottom: 2.5px solid var(--accent-green);
        }

        .product-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -8px rgba(30, 58, 47, 0.12);
        }

        .safe-bottom {
            padding-bottom: 100px;
        }

        @media (min-width: 768px) {
            .safe-bottom {
                padding-bottom: 40px;
            }
        }
    </style>
</head>
<body class="bg-[#FAF7F2] text-[#2D3748] antialiased">

    <!-- Top Admin Quick Access (if owner/admin) -->
    @if(auth()->check() && (auth()->id() == $business->user_id || (method_exists(auth()->user(), 'isMasterAdmin') && auth()->user()->isMasterAdmin())))
    <div class="bg-[#1E3A2F] text-white py-1.5 px-4 text-xs font-semibold flex justify-between items-center z-50 relative">
        <div class="flex items-center space-x-2">
            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
            <span>Store Owner Mode</span>
        </div>
        <div class="flex items-center space-x-3">
            <a href="/admin/products/create" class="bg-[#25D366] hover:bg-[#20BA56] text-white px-2.5 py-0.5 rounded-full flex items-center gap-1 font-bold shadow-xs transition-transform active:scale-95">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                <span>+ Add Product</span>
            </a>
            <a href="/admin" class="hover:underline flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.370 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.370a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('logout') }}" class="hover:text-red-300">Logout</a>
        </div>
    </div>
    @endif

    <!-- Main Container -->
    <div class="min-h-screen flex flex-col justify-between">
        <div>
            <!-- Header Section (Sage Green Header) -->
            <header class="w-full bg-[#A3D8BD] px-4 py-4 md:px-8 md:py-5 transition-all">
                <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
                    
                    <!-- Brand / Store Logo & Name -->
                    <div class="flex items-center justify-center md:justify-start space-x-2">
                        @if($business->logo)
                            <img src="{{ asset('storage/' . $business->logo) }}" alt="{{ $business->name }}" class="h-10 md:h-12 w-auto object-contain rounded-xl shadow-xs">
                        @else
                            <!-- Styled Organic Botanical Brand Name & Icon -->
                            <div class="flex items-center space-x-2 cursor-pointer" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                                <svg class="w-7 h-7 md:w-8 md:h-8 text-[#1E3A2F]" viewBox="0 0 36 36" fill="currentColor">
                                    <path d="M18 2C18 2 12 8 12 16C12 21 16 25 18 26C20 25 24 21 24 16C24 8 18 2 18 2Z" fill-opacity="0.8"/>
                                    <path d="M18 26V34M18 34H14M18 34H22" stroke="#1E3A2F" stroke-width="2.5" stroke-linecap="round"/>
                                    <path d="M8 12C8 12 10 18 16 19C16 14 13 10 8 12Z" fill="#1E3A2F"/>
                                    <path d="M28 12C28 12 26 18 20 19C20 14 23 10 28 12Z" fill="#1E3A2F"/>
                                </svg>
                                <div class="flex flex-col">
                                    <span class="text-2xl md:text-3xl font-extrabold tracking-tight text-[#1E3A2F]">{{ $business->name }}</span>
                                    @if($business->tagline)
                                        <span class="text-[11px] md:text-xs text-[#2D5A27] font-semibold -mt-1 tracking-wide">{{ $business->tagline }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Contact Action Pill Buttons (WhatsApp, Call, Email) -->
                    <div class="flex items-center justify-center gap-2.5 flex-wrap">
                        <!-- WhatsApp Button -->
                        <a href="https://wa.me/{{ $business->whatsapp ?? $business->phone }}" target="_blank" class="inline-flex items-center gap-1.5 bg-[#25D366] hover:bg-[#20BA56] text-white px-4 py-1.5 md:py-2 rounded-full font-bold text-xs md:text-sm shadow-xs transition-transform active:scale-95">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.685 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            <span>WhatsApp</span>
                        </a>

                        <!-- Call Button -->
                        <a href="tel:{{ $business->phone }}" class="inline-flex items-center gap-1.5 bg-[#1E3A2F] hover:bg-[#152921] text-white px-4 py-1.5 md:py-2 rounded-full font-bold text-xs md:text-sm shadow-xs transition-transform active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>Call</span>
                        </a>

                        <!-- Email Button -->
                        @if($business->email)
                        <a href="mailto:{{ $business->email }}" class="inline-flex items-center gap-1.5 bg-[#DFCAAB] hover:bg-[#D4B996] text-[#4E3629] px-4 py-1.5 md:py-2 rounded-full font-bold text-xs md:text-sm shadow-xs transition-transform active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>Email</span>
                        </a>
                        @else
                        <button onclick="shareApp()" class="inline-flex items-center gap-1.5 bg-[#DFCAAB] hover:bg-[#D4B996] text-[#4E3629] px-4 py-1.5 md:py-2 rounded-full font-bold text-xs md:text-sm shadow-xs transition-transform active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            <span>Share</span>
                        </button>
                        @endif

                        <!-- Cart Button (Desktop quick trigger) -->
                        <button type="button" onclick="zityCart.toggle()" class="hidden md:inline-flex items-center gap-1.5 bg-white/90 hover:bg-white text-[#1E3A2F] px-4 py-1.5 md:py-2 rounded-full font-bold text-xs md:text-sm shadow-xs transition-transform active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <span>Cart (<span id="header-cart-count">0</span>)</span>
                        </button>
                    </div>

                </div>
            </header>

            <!-- Badges Bar (Custom or Default) -->
            @php
                $badges = !empty($business->badges) ? $business->badges : ['100% Herbal', 'Natural', 'Eco-friendly'];
            @endphp
            <div class="max-w-6xl mx-auto px-4 pt-5 pb-2">
                <div class="flex items-center justify-center gap-2 md:gap-3 flex-wrap">
                    @foreach($badges as $badge)
                    <span class="inline-flex items-center gap-1.5 bg-white/80 border border-[#D9D3C7] text-[#2D5A27] text-xs md:text-sm font-semibold px-3 py-1 md:px-4 md:py-1.5 rounded-full shadow-2xs">
                        <svg class="w-4 h-4 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        {{ $badge }}
                    </span>
                    @endforeach
                </div>
            </div>

            <!-- Category Navigation Tabs -->
            <div class="max-w-6xl mx-auto px-4 pt-3 pb-4">
                <nav class="flex items-center justify-center overflow-x-auto space-x-6 md:space-x-10 text-sm md:text-base border-b border-[#E5DFD3] pb-1">
                    <button type="button" onclick="filterCategory('all', event)" class="cat-tab active py-2 px-1 whitespace-nowrap text-[#1E3A2F] transition-all">
                        All
                    </button>
                    @if(isset($productCategories) && $productCategories->count() > 0)
                        @foreach($productCategories as $cat)
                            <button type="button" onclick="filterCategory('{{ strtolower($cat) }}', event)" class="cat-tab py-2 px-1 whitespace-nowrap text-[#5C6B5E] hover:text-[#1E3A2F] font-medium transition-all">
                                {{ $cat }}
                            </button>
                        @endforeach
                    @else
                        <button type="button" onclick="filterCategory('hair', event)" class="cat-tab py-2 px-1 whitespace-nowrap text-[#5C6B5E] hover:text-[#1E3A2F] font-medium transition-all">
                            Hair
                        </button>
                        <button type="button" onclick="filterCategory('women', event)" class="cat-tab py-2 px-1 whitespace-nowrap text-[#5C6B5E] hover:text-[#1E3A2F] font-medium transition-all">
                            Women
                        </button>
                        <button type="button" onclick="filterCategory('men', event)" class="cat-tab py-2 px-1 whitespace-nowrap text-[#5C6B5E] hover:text-[#1E3A2F] font-medium transition-all">
                            Men
                        </button>
                        <button type="button" onclick="filterCategory('herbal', event)" class="cat-tab py-2 px-1 whitespace-nowrap text-[#5C6B5E] hover:text-[#1E3A2F] font-medium transition-all">
                            Herbal
                        </button>
                    @endif
                </nav>
            </div>

            <!-- Products Showcase Section -->
            <main class="max-w-6xl mx-auto px-4 py-4">
                @if($products->isEmpty())
                    <div class="py-16 text-center bg-white rounded-3xl border border-[#EBE6DC] shadow-xs max-w-md mx-auto my-6">
                        <div class="w-16 h-16 bg-[#EAF3EC] rounded-2xl flex items-center justify-center mx-auto mb-4 text-[#2D6A4F]">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#1E3A2F]">Catalog Arriving Soon</h3>
                        <p class="text-xs md:text-sm text-[#718096] mt-1 px-6">Our handcrafted organic products will be featured here shortly.</p>
                        <a href="https://wa.me/{{ $business->whatsapp ?? $business->phone }}" target="_blank" class="mt-5 inline-flex items-center gap-2 bg-[#25D366] text-white px-5 py-2 rounded-full font-bold text-xs shadow-xs hover:bg-[#20BA56] transition">
                            Inquire via WhatsApp
                        </a>
                    </div>
                @else
                    <!-- 4 columns on Desktop, 2 columns on Mobile -->
                    <div id="product-grid" class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6">
                        @foreach($products as $product)
                            @php
                                $categoryTag = strtolower($product->category ?? 'herbal');
                                $imgSrc = $product->image 
                                    ? asset('storage/' . $product->image) 
                                    : 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80';
                            @endphp
                            <div class="product-card bg-white rounded-2xl md:rounded-3xl border border-[#EAE4D9] shadow-xs flex flex-col justify-between overflow-hidden relative group" data-category="{{ $categoryTag }}">
                                
                                <!-- Product Image -->
                                <div class="relative w-full aspect-square bg-[#EBF4EE] overflow-hidden flex items-center justify-center">
                                    <img src="{{ $imgSrc }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                    
                                    <!-- Quick Cart (+) Floating Badge -->
                                    <button onclick="zityCart.addItem({id: '{{ $product->id }}', name: '{{ addslashes($product->name) }}', price: {{ $product->price ?? 0 }}, image: '{{ $product->image ? asset('storage/' . $product->image) : '' }}'})" title="Add to Cart" class="absolute top-2.5 right-2.5 w-7 h-7 md:w-8 md:h-8 bg-white/90 hover:bg-white text-[#1E3A2F] rounded-full shadow-md flex items-center justify-center transition-all hover:scale-110 active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                    </button>
                                </div>

                                <!-- Product Info & Cart / Order Actions -->
                                <div class="p-3 md:p-4 flex flex-col flex-1 justify-between">
                                    <div>
                                        <h3 class="font-bold text-[#1E3A2F] text-xs md:text-sm leading-snug line-clamp-2">{{ $product->name }}</h3>
                                        
                                        <div class="mt-1 font-extrabold text-[#2D6A4F] text-xs md:text-sm">
                                            @if($product->price)
                                                ₹{{ number_format($product->price) }}
                                            @else
                                                <span class="text-xs text-gray-500 font-normal">Contact for price</span>
                                            @endif
                                        </div>

                                        @if($product->description)
                                            <p class="text-[10px] md:text-xs text-[#718096] line-clamp-1 mt-1">{{ $product->description }}</p>
                                        @endif
                                    </div>

                                    <!-- Action: Add to Cart (Multi-Product Select) & Quick WhatsApp -->
                                    <div class="mt-3 space-y-1.5">
                                        <!-- Primary Add to Cart / Qty Stepper Button -->
                                        <div class="card-cart-action" data-id="{{ $product->id }}" data-name="{{ addslashes($product->name) }}" data-price="{{ $product->price ?? 0 }}" data-image="{{ $imgSrc }}">
                                            <button onclick="zityCart.addItem({id: '{{ $product->id }}', name: '{{ addslashes($product->name) }}', price: {{ $product->price ?? 0 }}, image: '{{ $imgSrc }}'})" class="w-full bg-[#1E3A2F] hover:bg-[#152921] active:scale-95 text-white font-bold text-xs py-2 px-2.5 rounded-xl md:rounded-2xl transition shadow-xs flex items-center justify-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                <span>Add to Cart</span>
                                            </button>
                                        </div>

                                        <!-- Quick Direct 1-Item Order Button -->
                                        <button onclick="directWhatsAppOrder('{{ addslashes($product->name) }}', '{{ $product->price ? number_format($product->price) : '' }}')" class="w-full bg-[#EBF4EE] hover:bg-[#D8EADB] text-[#1E3A2F] font-bold text-[10px] md:text-[11px] py-1.5 px-2 rounded-lg md:rounded-xl transition-all flex items-center justify-center gap-1">
                                            <svg class="w-3 h-3 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.685 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            <span>Quick Order</span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif
            </main>

            <!-- "Why Choose Us" Section -->
            <section class="max-w-6xl mx-auto px-4 pt-10 pb-6">
                <h2 class="text-xl md:text-2xl font-extrabold text-[#1E3A2F] mb-4 md:mb-6">Why Choose Us</h2>
                
                @php
                    $features = !empty($business->why_choose_us) ? $business->why_choose_us : [
                        ['title' => 'Organic Ingredients', 'description' => 'Organic ingredients and natural sustainable products crafted with purity.'],
                        ['title' => 'Vegan & Cruelty-Free', 'description' => 'Vegan certified formulations adhering to high ethical and eco standards.'],
                        ['title' => 'Handmade With Care', 'description' => 'Handmade artisan care guaranteeing fresh, nourishing potency for your health.']
                    ];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-6">
                    @foreach($features as $idx => $feat)
                    <div class="bg-white rounded-2xl md:rounded-3xl p-4 md:p-6 border border-[#EAE4D9] shadow-xs flex flex-col items-start space-y-2">
                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-[#EAF5ED] text-[#2D6A4F] flex items-center justify-center">
                            @if($idx % 3 === 0)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            @elseif($idx % 3 === 1)
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            @endif
                        </div>
                        <h3 class="font-bold text-[#1E3A2F] text-sm md:text-base">{{ $feat['title'] ?? '' }}</h3>
                        <p class="text-xs md:text-sm text-[#718096] leading-relaxed">{{ $feat['description'] ?? '' }}</p>
                    </div>
                    @endforeach
                </div>
            </section>

            <!-- "About Us" Section -->
            <section class="max-w-6xl mx-auto px-4 pt-4 pb-12 safe-bottom">
                <h2 class="text-xl md:text-2xl font-extrabold text-[#1E3A2F] mb-3">About Us</h2>
                <div class="bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 border border-[#EAE4D9] shadow-xs">
                    <p class="text-xs md:text-sm text-[#4A5568] leading-relaxed">
                        {{ $business->description ?? ($business->name . ' is dedicated to natural living and sustainable herbal products crafted to support your healthy lifestyle and wellness community.') }}
                    </p>

                    @if($business->address)
                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-2 text-xs md:text-sm text-[#718096]">
                        <svg class="w-4 h-4 text-[#2D6A4F] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        <span>{{ $business->address }}, {{ $business->city }} {{ $business->state }}</span>
                    </div>
                    @endif

                    @if($business->facebook_url || $business->instagram_url || $business->youtube_url || $business->website_url)
                    <div class="mt-4 flex items-center gap-3">
                        <span class="text-xs font-bold text-gray-400 uppercase">Connect:</span>
                        @if($business->instagram_url)
                        <a href="{{ $business->instagram_url }}" target="_blank" class="w-7 h-7 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:text-pink-600 transition">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        @endif
                        @if($business->facebook_url)
                        <a href="{{ $business->facebook_url }}" target="_blank" class="w-7 h-7 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 hover:text-blue-600 transition">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
            </section>
        </div>

        <!-- Mobile Bottom Dock (Mobile Screens Only) -->
        <div class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-t border-[#EAE4D9] shadow-lg">
            <div class="max-w-6xl mx-auto px-6 py-2.5 flex items-center justify-between">
                
                <!-- Account / Home -->
                @if(auth()->check())
                <a href="/admin" class="flex flex-col items-center text-[#5C6B5E] hover:text-[#1E3A2F] transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="text-[10px] font-semibold mt-0.5">My Account</span>
                </a>
                @else
                <a href="{{ route('home') }}" class="flex flex-col items-center text-[#5C6B5E] hover:text-[#1E3A2F] transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="text-[10px] font-semibold mt-0.5">Home</span>
                </a>
                @endif

                <!-- Center: WhatsApp Order Circle Button -->
                <div class="flex flex-col items-center -mt-6">
                    <a href="https://wa.me/{{ $business->whatsapp ?? $business->phone }}?text={{ urlencode('Hi! I am browsing ' . $business->name . ' on Zity.in and would like to place an order.') }}" target="_blank" class="w-12 h-12 bg-[#25D366] hover:bg-[#20BA56] text-white rounded-full shadow-lg flex items-center justify-center hover:scale-105 active:scale-95 transition-all border-4 border-[#FAF7F2]">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.685 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                    <span class="text-[10px] font-bold text-[#1E3A2F] mt-1">WhatsApp Order</span>
                </div>

                <!-- Cart Trigger -->
                <button type="button" onclick="zityCart.toggle()" class="flex flex-col items-center text-[#5C6B5E] hover:text-[#1E3A2F] transition relative">
                    <div class="relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span id="nav-cart-count" class="absolute -top-1.5 -right-2 bg-[#2D6A4F] text-white text-[9px] font-extrabold w-4 h-4 rounded-full flex items-center justify-center border border-white hidden">0</span>
                    </div>
                    <span class="text-[10px] font-semibold mt-0.5">Cart</span>
                </button>

            </div>
        </div>

        <!-- Desktop Footer (Matches PC Desktop Mockup) -->
        <footer class="hidden md:block bg-white border-t border-[#EAE4D9] py-8 mt-12">
            <div class="max-w-6xl mx-auto px-6 flex items-center justify-between">
                <!-- Left Links -->
                <div class="flex items-center space-x-6 text-xs text-[#718096]">
                    <span>&copy; {{ date('Y') }} {{ $business->name }}. Official Store verified by <a href="{{ route('home') }}" class="font-bold text-[#1E3A2F] hover:underline">Zity.in</a></span>
                    <a href="#" class="hover:text-[#1E3A2F]">Terms of Service</a>
                    <a href="#" class="hover:text-[#1E3A2F]">Privacy Policy</a>
                </div>

                <!-- Center WhatsApp Order Button -->
                <div class="flex items-center">
                    <a href="https://wa.me/{{ $business->whatsapp ?? $business->phone }}?text={{ urlencode('Hi! I am browsing ' . $business->name . ' on Zity.in and would like to place an order.') }}" target="_blank" class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#20BA56] text-white px-5 py-2 rounded-full font-bold text-xs shadow-xs transition-transform active:scale-95">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.685 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        <span>WhatsApp Order</span>
                    </a>
                </div>

                <!-- Right Actions (Cart & Account) -->
                <div class="flex items-center space-x-6">
                    <button type="button" onclick="zityCart.toggle()" class="flex items-center space-x-1.5 text-xs font-bold text-[#1E3A2F] hover:text-[#2D6A4F] transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span>Cart (<span id="desktop-cart-count">0</span>)</span>
                    </button>
                    @if(auth()->check())
                    <a href="/admin" class="text-xs font-bold text-[#5C6B5E] hover:text-[#1E3A2F] transition flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Account</span>
                    </a>
                    @else
                    <a href="{{ route('home') }}" class="text-xs font-bold text-[#5C6B5E] hover:text-[#1E3A2F] transition flex items-center space-x-1">
                        <span>Home</span>
                    </a>
                    @endif
                </div>
            </div>
        </footer>

    </div>

    <!-- Cart Overlay & Sidebar Drawer -->
    <div id="cart-overlay" onclick="zityCart.toggle()" class="cart-overlay"></div>
    <aside id="cart-sidebar" class="cart-sidebar flex flex-col">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-white sticky top-0 z-10">
            <div>
                <h2 class="text-lg md:text-xl font-bold text-[#1E3A2F]">Shopping Cart</h2>
                <p class="text-xs text-[#718096] font-medium">{{ $business->name }}</p>
            </div>
            <button onclick="zityCart.toggle()" class="p-2 hover:bg-gray-100 rounded-full transition-colors text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div id="cart-items" class="flex-1 overflow-y-auto p-5 space-y-4">
            <!-- Injected via JavaScript -->
        </div>

        <div class="p-5 bg-[#FAF7F2] border-t border-[#EAE4D9] space-y-3">
            <div class="flex items-center justify-between font-bold text-base md:text-lg">
                <span class="text-[#1E3A2F]">Total Amount</span>
                <span id="cart-total" class="text-[#2D6A4F]">₹0</span>
            </div>
            <button id="cart-checkout" onclick="zityCart.checkout()" class="w-full py-3.5 bg-[#25D366] hover:bg-[#20BA56] text-white rounded-2xl font-bold text-sm md:text-base shadow-sm transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.685 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                <span>Checkout via WhatsApp</span>
            </button>
        </div>
    </aside>

    <!-- Floating Bottom Multi-Product WhatsApp Checkout Bar -->
    <div id="floating-cart-bar" class="hidden fixed bottom-18 md:bottom-6 left-1/2 -translate-x-1/2 z-[80] w-[92%] max-w-lg shadow-2xl transition-all duration-300">
        <div class="bg-[#1E3A2F] text-white p-3.5 md:p-4 rounded-2xl md:rounded-3xl shadow-2xl flex items-center justify-between border-2 border-white/20 backdrop-blur-xl">
            <div class="flex items-center space-x-3 cursor-pointer" onclick="zityCart.toggle()">
                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center text-[#25D366]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div>
                    <p class="text-xs md:text-sm font-bold text-white"><span id="floating-cart-count">0</span> items in cart</p>
                    <p class="text-[11px] md:text-xs text-[#A3D8BD] font-semibold">Total: <span id="floating-cart-total">₹0</span></p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="zityCart.toggle()" class="bg-white/20 hover:bg-white/30 text-white px-3 py-2 rounded-xl text-xs font-bold transition">
                    View
                </button>
                <button onclick="zityCart.checkout()" class="bg-[#25D366] hover:bg-[#20BA56] active:scale-95 text-white px-4 py-2 rounded-xl text-xs md:text-sm font-bold flex items-center gap-1.5 shadow-md transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.685 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    <span>Order on WhatsApp</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast-notify" class="hidden fixed top-6 left-1/2 -translate-x-1/2 z-[150] w-[90%] max-w-sm">
        <div class="bg-[#1E3A2F] text-white p-3.5 rounded-2xl shadow-xl flex items-center justify-between border border-white/20">
            <div class="flex items-center space-x-2.5">
                <span class="w-2 h-2 rounded-full bg-[#25D366]"></span>
                <p id="toast-msg" class="text-xs md:text-sm font-semibold">Item added to cart</p>
            </div>
        </div>
    </div>

    <!-- JavaScript Interactions -->
    <script>
        // Category Filter Logic
        function filterCategory(category, event) {
            document.querySelectorAll('.cat-tab').forEach(tab => tab.classList.remove('active'));
            if (event && event.currentTarget) {
                event.currentTarget.classList.add('active');
            }

            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                const cardCat = (card.getAttribute('data-category') || '').toLowerCase();
                if (category === 'all' || cardCat.includes(category) || category === cardCat) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Direct Single Item WhatsApp Order
        function directWhatsAppOrder(productName, price) {
            let message = `Hi! I would like to order *${productName}*`;
            if (price) {
                message += ` (₹${price})`;
            }
            message += ` from your store *{{ addslashes($business->name) }}* on Zity.in. Please confirm availability.`;
            const phone = "{{ $business->whatsapp ?? $business->phone }}";
            window.open(`https://wa.me/${phone}?text=${encodeURIComponent(message)}`, '_blank');
        }

        // Shopping Cart Implementation
        const zityCart = {
            items: JSON.parse(localStorage.getItem('cart_{{ $business->slug }}')) || [],

            toggle() {
                document.getElementById('cart-sidebar').classList.toggle('open');
                document.getElementById('cart-overlay').classList.toggle('show');
            },

            addItem(product) {
                const existing = this.items.find(item => item.id === product.id);
                if (existing) {
                    existing.quantity++;
                } else {
                    this.items.push({ ...product, quantity: 1 });
                }
                this.save();
                this.render();
                if (product.name) {
                    showToast(`Added ${product.name} to cart`);
                }
            },

            removeItem(id) {
                const index = this.items.findIndex(item => item.id === id);
                if (index > -1) {
                    if (this.items[index].quantity > 1) {
                        this.items[index].quantity--;
                    } else {
                        this.items.splice(index, 1);
                    }
                }
                this.save();
                this.render();
            },

            deleteItem(id) {
                this.items = this.items.filter(item => item.id !== id);
                this.save();
                this.render();
            },

            save() {
                localStorage.setItem('cart_{{ $business->slug }}', JSON.stringify(this.items));
            },

            render() {
                const container = document.getElementById('cart-items');
                const totalDisplay = document.getElementById('cart-total');
                const checkoutBtn = document.getElementById('cart-checkout');
                const floatingBar = document.getElementById('floating-cart-bar');
                const floatingCount = document.getElementById('floating-cart-count');
                const floatingTotal = document.getElementById('floating-cart-total');

                const updateCountBadges = (val) => {
                    const nav = document.getElementById('nav-cart-count');
                    const desktop = document.getElementById('desktop-cart-count');
                    const header = document.getElementById('header-cart-count');
                    if (nav) {
                        nav.innerText = val;
                        if (val > 0) nav.classList.remove('hidden');
                        else nav.classList.add('hidden');
                    }
                    if (desktop) desktop.innerText = val;
                    if (header) header.innerText = val;
                };

                // Update dynamic button/stepper on each product card
                document.querySelectorAll('.card-cart-action').forEach(el => {
                    const pId = el.getAttribute('data-id');
                    const pName = el.getAttribute('data-name');
                    const pPrice = parseFloat(el.getAttribute('data-price') || 0);
                    const pImage = el.getAttribute('data-image');
                    const cartItem = this.items.find(item => item.id === pId);

                    if (cartItem && cartItem.quantity > 0) {
                        el.innerHTML = `
                            <div class="flex items-center justify-between bg-[#EAF5ED] border border-[#A8D5BA] rounded-xl p-1 shadow-2xs">
                                <button type="button" onclick="zityCart.removeItem('${pId}')" class="w-7 h-7 bg-white rounded-lg font-bold text-sm text-[#1E3A2F] shadow-xs flex items-center justify-center hover:bg-gray-100 active:scale-90 transition">-</button>
                                <span class="font-extrabold text-xs text-[#1E3A2F] px-1">${cartItem.quantity} in cart</span>
                                <button type="button" onclick="zityCart.addItem({id: '${pId}'})" class="w-7 h-7 bg-[#25D366] text-white rounded-lg font-bold text-sm shadow-xs flex items-center justify-center hover:bg-[#20BA56] active:scale-90 transition">+</button>
                            </div>
                        `;
                    } else {
                        el.innerHTML = `
                            <button type="button" onclick="zityCart.addItem({id: '${pId}', name: '${pName}', price: ${pPrice}, image: '${pImage}'})" class="w-full bg-[#1E3A2F] hover:bg-[#152921] active:scale-95 text-white font-bold text-xs py-2 px-2.5 rounded-xl md:rounded-2xl transition shadow-xs flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                <span>Add to Cart</span>
                            </button>
                        `;
                    }
                });

                if (this.items.length === 0) {
                    container.innerHTML = `
                        <div class="flex flex-col items-center justify-center h-48 text-center space-y-2 opacity-50">
                            <svg class="w-12 h-12 text-[#1E3A2F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <p class="text-sm font-bold text-[#1E3A2F]">Your cart is empty</p>
                        </div>`;
                    updateCountBadges(0);
                    totalDisplay.innerText = '₹0';
                    checkoutBtn.disabled = true;
                    if (floatingBar) floatingBar.classList.add('hidden');
                    return;
                }

                let html = '';
                let total = 0;
                let count = 0;

                this.items.forEach(item => {
                    const lineTotal = (item.price || 0) * item.quantity;
                    total += lineTotal;
                    count += item.quantity;
                    html += `
                        <div class="flex items-center space-x-3 bg-[#FAF7F2] p-3 rounded-2xl border border-[#EAE4D9]">
                            <div class="w-14 h-14 rounded-xl overflow-hidden bg-white flex-shrink-0 flex items-center justify-center">
                                <img src="${item.image || 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?ixlib=rb-1.2.1&auto=format&fit=crop&w=400&q=80'}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-[#1E3A2F] text-xs truncate leading-tight">${item.name}</h4>
                                <p class="text-[#2D6A4F] font-bold text-xs mt-0.5">₹${(item.price || 0).toLocaleString()}</p>
                                <div class="flex items-center space-x-2 mt-1.5">
                                    <button onclick="zityCart.removeItem('${item.id}')" class="w-5 h-5 rounded-md bg-white border border-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 hover:bg-gray-50">-</button>
                                    <span class="text-xs font-bold w-4 text-center">${item.quantity}</span>
                                    <button onclick="zityCart.addItem({id: '${item.id}'})" class="w-5 h-5 rounded-md bg-white border border-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 hover:bg-gray-50">+</button>
                                </div>
                            </div>
                            <button onclick="zityCart.deleteItem('${item.id}')" class="p-1.5 text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>`;
                });

                container.innerHTML = html;
                updateCountBadges(count);
                totalDisplay.innerText = '₹' + total.toLocaleString();
                checkoutBtn.disabled = false;

                if (floatingBar) {
                    floatingBar.classList.remove('hidden');
                    if (floatingCount) floatingCount.innerText = count;
                    if (floatingTotal) floatingTotal.innerText = '₹' + total.toLocaleString();
                }
            },

            checkout() {
                if (this.items.length === 0) return;

                let message = `🛍️ *Order from {{ addslashes($business->name) }}*\n`;
                message += `---------------------------------\n`;
                message += `*Items Ordered:*\n`;
                
                let total = 0;
                this.items.forEach((item, index) => {
                    const lineTotal = (item.price || 0) * item.quantity;
                    total += lineTotal;
                    message += `${index + 1}. *${item.name}* (x${item.quantity}) — ₹${lineTotal.toLocaleString()}\n`;
                });

                message += `---------------------------------\n`;
                message += `💰 *TOTAL AMOUNT: ₹${total.toLocaleString()}*\n\n`;
                message += `_Please confirm my order and share delivery details!_`;

                const phone = "{{ $business->whatsapp ?? $business->phone }}";
                const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
                window.open(url, '_blank');
            }
        };

        // Initialize Cart State
        zityCart.render();

        function showToast(msg) {
            const toast = document.getElementById('toast-notify');
            const text = document.getElementById('toast-msg');
            text.innerText = msg;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 2500);
        }

        async function shareApp() {
            const currentUrl = window.location.href.split('#')[0].split('?')[0];
            const shareData = { title: '{{ addslashes($business->name) }}', text: 'Check out {{ addslashes($business->name) }} on Zity.in!', url: currentUrl };
            if (navigator.share && navigator.canShare && navigator.canShare(shareData)) {
                try { await navigator.share(shareData); } catch (err) {}
            } else if (navigator.clipboard) {
                navigator.clipboard.writeText(currentUrl);
                showToast('Store link copied to clipboard!');
            }
        }
    </script>
</body>
</html>
