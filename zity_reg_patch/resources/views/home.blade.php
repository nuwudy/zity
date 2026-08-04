<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZITY.IN — The Smart Local Business Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .gradient-text { background: linear-gradient(135deg, #4F46E5 0%, #9333EA 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .bg-pattern { background-image: radial-gradient(#4F46E5 0.5px, transparent 0.5px); background-size: 24px 24px; opacity: 0.1; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 leading-relaxed overflow-x-hidden">
    <div class="fixed inset-0 -z-10 bg-pattern"></div>

    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 px-6 py-4">
        <nav class="max-w-7xl mx-auto flex items-center justify-between glass rounded-2xl px-6 py-3 shadow-sm border border-white/40">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-200">Z</div>
                <span class="text-2xl font-bold tracking-tight text-gray-900">Zity.in</span>
            </div>
            <!-- Mobile Login Button (visible only on small screens) -->
            <a href="/admin" class="md:hidden px-4 py-2 bg-gray-900 text-white rounded-xl font-semibold text-sm hover:bg-gray-800 transition-all shadow-md">Login</a>

            <!-- Desktop Nav Links -->
            <div class="hidden md:flex items-center space-x-8 font-medium text-gray-600">
                <a href="#features" class="hover:text-indigo-600 transition-colors">Features</a>
                <a href="#register" class="hover:text-indigo-600 transition-colors">Register</a>
                <a href="/admin" class="px-5 py-2.5 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition-all shadow-md">Login</a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 px-6 overflow-hidden">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-12">
            <div class="flex-1 text-center md:text-left">
                <div class="inline-flex items-center space-x-2 px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm font-semibold mb-6 animate-fade-in">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span>Empowering Local Shops</span>
                </div>
                <h1 class="text-5xl md:text-7xl font-bold leading-[1.1] mb-6">
                    Launch Your <span class="gradient-text">Shop Online</span> in 60 Seconds.
                </h1>
                <p class="text-xl text-gray-600 mb-10 max-w-2xl">
                    Every local business deserves an online identity. Claim your unique store URL today — completely free.
                </p>
                
                <!-- ── Business Search Bar ── -->
                <div class="mb-5">
                    <form action="{{ route('search') }}" method="GET" class="flex items-center bg-white rounded-3xl shadow-2xl shadow-indigo-100 border-2 border-transparent focus-within:border-indigo-500 focus-within:ring-4 focus-within:ring-indigo-50 transition-all overflow-hidden p-2">
                        <div class="pl-3 pr-1 text-gray-400 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="q" placeholder="Search plumber, electrician, grocery..." class="flex-1 py-3 px-2 text-base font-medium text-gray-900 focus:outline-none placeholder:text-gray-400 bg-transparent min-w-0">
                        <button type="submit" class="flex-shrink-0 px-5 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 active:scale-95 transition-all shadow-lg shadow-indigo-200 text-sm">Find</button>
                    </form>
                    <p class="text-xs text-gray-400 mt-2 pl-1">Try: <a href="{{ route('search', ['q' => 'plumber']) }}" class="text-indigo-500 hover:underline">plumber</a>, <a href="{{ route('search', ['q' => 'electrician']) }}" class="text-indigo-500 hover:underline">electrician</a>, <a href="{{ route('search', ['q' => 'grocery']) }}" class="text-indigo-500 hover:underline">grocery shop</a></p>
                </div>

                <!-- ── Brand Availability (Divider) ── -->
                <div class="flex items-center gap-3 mb-5">
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Or check your brand</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                <div class="max-w-md bg-white p-2 rounded-3xl shadow-2xl shadow-indigo-100 flex items-center border-2 border-transparent focus-within:border-indigo-500 focus-within:ring-4 focus-within:ring-indigo-50 transition-all mb-8 group">
                    <div class="flex-shrink-0 pl-4 pr-1 text-gray-400 font-medium group-focus-within:text-indigo-600 transition-colors lowercase whitespace-nowrap">zity.in/</div>
                    <input type="text" id="brand-search" placeholder="yourbrandname" class="flex-1 w-full min-w-0 py-3 px-1 text-lg font-bold text-gray-900 focus:outline-none placeholder:text-gray-300 bg-transparent">
                    <button id="check-btn" class="flex-shrink-0 px-6 py-3 ml-1 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 active:scale-95 transition-all shadow-lg shadow-indigo-200">Check</button>
                </div>

                <div id="availability-message" class="hidden mb-10 transform transition-all duration-500 scale-95 opacity-0">
                    <div class="flex items-center space-x-3 p-4 rounded-3xl border-2 shadow-xl transition-all">
                        <div id="status-icon" class="w-10 h-10 rounded-2xl flex items-center justify-center text-white shadow-lg"></div>
                        <div class="flex-1">
                            <p id="status-text" class="font-bold text-lg leading-tight"></p>
                            <p id="status-subtext" class="text-xs text-gray-500 font-medium"></p>
                        </div>
                        <button onclick="scrollToRegister()" id="claim-btn" class="hidden px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold text-sm hover:bg-indigo-700 active:scale-95 transition-all shadow-lg shadow-indigo-100">Claim Now</button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4">
                    <a href="#features" class="w-full sm:w-auto px-8 py-4 glass text-gray-900 rounded-2xl font-bold text-lg hover:bg-white/90 transition-all text-center">See How It Works</a>
                </div>
            </div>
            
            <div class="flex-1 relative">
                <div class="absolute -top-12 -left-12 w-64 h-64 bg-indigo-200 opacity-20 blur-3xl rounded-full"></div>
                <div class="absolute -bottom-12 -right-12 w-64 h-64 bg-purple-200 opacity-20 blur-3xl rounded-full"></div>
                <div class="relative glass rounded-[2.5rem] p-4 shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-500">
                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Shop Page Mockup" class="rounded-[2rem] w-full h-[500px] object-cover">
                    <div class="absolute bottom-10 -left-8 glass p-6 rounded-2xl shadow-xl animate-bounce-slow">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.685 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">New Order</p>
                                <p class="text-sm font-bold">Fresh Order Received</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration Section -->
    <section id="register" class="py-20 px-6 bg-indigo-900 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-pattern opacity-10"></div>
        <div class="max-w-4xl mx-auto relative z-10 text-center text-white">

            <!-- ── Audience Callout ── -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 border border-white/20 rounded-full text-indigo-200 text-sm font-semibold mb-6 backdrop-blur-sm">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                Free to list — No commissions
            </div>

            <h2 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                Are You a <span class="text-yellow-300">Shop Owner</span> or<br class="hidden md:block">
                <span class="text-green-300">Service Provider?</span>
            </h2>
            <p class="text-indigo-200 text-lg mb-8 max-w-2xl mx-auto">
                Thousands of customers search for local businesses on Zity.in every day.
                <strong class="text-white">Get found. Get customers. Grow your business.</strong>
            </p>

            <!-- Benefit Pills -->
            <div class="flex flex-wrap justify-center gap-3 mb-10">
                <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-full text-sm font-medium border border-white/10 backdrop-blur-sm">
                    <span class="text-green-300">✓</span> Free business page
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-full text-sm font-medium border border-white/10 backdrop-blur-sm">
                    <span class="text-green-300">✓</span> Appear in search results
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-full text-sm font-medium border border-white/10 backdrop-blur-sm">
                    <span class="text-green-300">✓</span> WhatsApp orders
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-full text-sm font-medium border border-white/10 backdrop-blur-sm">
                    <span class="text-green-300">✓</span> Ready in 60 seconds
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white/10 rounded-full text-sm font-medium border border-white/10 backdrop-blur-sm">
                    <span class="text-green-300">✓</span> No technical skills needed
                </div>
            </div>


            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-2xl text-gray-900 border-b-8 border-indigo-200">
                <form action="{{ route('register.shop') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                    @csrf
                    @if ($errors->any())
                        <div class="col-span-full bg-red-50 border-2 border-red-100 text-red-600 p-4 rounded-2xl text-sm font-bold">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 ml-1">Shop Name</label>
                        <input type="text" name="shop_name" placeholder="e.g. Green Grocery" class="w-full px-5 py-4 rounded-xl border-2 border-gray-100 bg-gray-50 focus:border-indigo-500 focus:outline-none transition-all placeholder:text-gray-400" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 ml-1">WhatsApp Number</label>
                        <input type="text" name="phone" placeholder="+91 99999 00000" class="w-full px-5 py-4 rounded-xl border-2 border-gray-100 bg-gray-50 focus:border-indigo-500 focus:outline-none transition-all placeholder:text-gray-400" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 ml-1">Email (Optional)</label>
                        <input type="email" name="email" placeholder="you@example.com" class="w-full px-5 py-4 rounded-xl border-2 border-gray-100 bg-gray-50 focus:border-indigo-500 focus:outline-none transition-all placeholder:text-gray-400">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 ml-1">Set Password</label>
                        <div class="relative group">
                            <input type="password" id="reg-password" name="password" placeholder="••••••••" class="w-full px-5 py-4 rounded-xl border-2 border-gray-100 bg-gray-50 focus:border-indigo-500 focus:outline-none transition-all placeholder:text-gray-400 pr-12" required>
                            <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 p-1 text-gray-400 hover:text-indigo-600 transition-colors">
                                <svg id="eye-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path id="eye-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path id="eye-open-outer" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    <path id="eye-closed" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.04m5.733-4.441A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.059 10.059 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-sm font-bold text-gray-700 ml-1">What do you do?</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center space-x-3 p-4 rounded-xl border-2 border-gray-100 bg-gray-50 cursor-pointer hover:border-indigo-300 transition-all has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="type" value="shop" class="text-indigo-600" checked onchange="toggleServiceArea(this.value)">
                                <div>
                                    <p class="font-bold text-sm text-gray-800">🛍️ I sell products</p>
                                    <p class="text-xs text-gray-500">Groceries, clothing, etc.</p>
                                </div>
                            </label>
                            <label class="flex items-center space-x-3 p-4 rounded-xl border-2 border-gray-100 bg-gray-50 cursor-pointer hover:border-indigo-300 transition-all has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                                <input type="radio" name="type" value="service" class="text-indigo-600" onchange="toggleServiceArea(this.value)">
                                <div>
                                    <p class="font-bold text-sm text-gray-800">🔧 I offer services</p>
                                    <p class="text-xs text-gray-500">Electrician, mechanic, etc.</p>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div id="service-area-field" class="md:col-span-2 space-y-2 hidden">
                        <label class="text-sm font-bold text-gray-700 ml-1">Service Area <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="text" id="service-area-input" name="service_area" placeholder="e.g. Kozhikode City, 10km radius" class="w-full px-5 py-4 rounded-xl border-2 border-gray-100 bg-gray-50 focus:border-indigo-500 focus:outline-none transition-all placeholder:text-gray-400">
                    </div>
                    <div class="md:col-span-2 mt-4">
                        <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-bold text-xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 flex items-center justify-center space-x-3 group">
                            <span>Create Your Free Web Page</span>
                            <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </button>
                    </div>
                </form>
                <p class="mt-6 text-sm text-gray-500 font-medium">By clicking this, you agree to our <a href="#" class="text-indigo-600 underline">Terms & Service</a></p>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="py-24 px-6 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold mb-4">Everything You Need to Sell Online</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Zity is designed to be simple for shop owners and amazing for customers.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-10 rounded-3xl bg-white shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold mb-4">Smart URL</h3>
                <p class="text-gray-600">Get a professional brand link like <strong>zity.in/johns</strong> that you can share on WhatsApp and Instagram.</p>
            </div>
            
            <div class="p-10 rounded-3xl bg-white shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                <div class="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-green-600 group-hover:text-white transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <h3 class="text-2xl font-bold mb-4">Product Listing</h3>
                <p class="text-gray-600">Easily add products with images and prices. Your shop page updates instantly.</p>
            </div>
            
            <div class="p-10 rounded-3xl bg-white shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-orange-600 group-hover:text-white transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold mb-4">Direct Orders</h3>
                <p class="text-gray-600">Customers send pre-filled WhatsApp messages to order. No middlemen or commissions.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-20 px-6 border-t border-gray-800">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start gap-12">
            <div class="max-w-md">
                <div class="flex items-center space-x-2 mb-6">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center font-bold">Z</div>
                    <span class="text-xl font-bold tracking-tight">Zity.in</span>
                </div>
                <p class="text-gray-400 mb-8">Building the digital city of local businesses. Empowering Every Shop Owner in India.</p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-indigo-600 transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-indigo-600 transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                </div>
            </div>
            
            <div class="flex-1 grid grid-cols-2 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="font-bold mb-6">Company</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Success Stories</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6">Support</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">WhatsApp Support</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6">Legal</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-20 pt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
            <p>&copy; 2026 Zity.in Media. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const brandSearch = document.getElementById('brand-search');
        const checkBtn = document.getElementById('check-btn');
        const availabilityMessage = document.getElementById('availability-message');
        const statusIcon = document.getElementById('status-icon');
        const statusText = document.getElementById('status-text');
        const statusSubtext = document.getElementById('status-subtext');
        const claimBtn = document.getElementById('claim-btn');
        const shopNameInput = document.querySelector('input[name="shop_name"]');
        const regPasswordInput = document.getElementById('reg-password');

        function togglePassword() {
            const type = regPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            regPasswordInput.setAttribute('type', type);
            
            const eyeOpen = document.getElementById('eye-open');
            const eyeOpenOuter = document.getElementById('eye-open-outer');
            const eyeClosed = document.getElementById('eye-closed');
            
            if (type === 'text') {
                eyeOpen.classList.add('hidden');
                eyeOpenOuter.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                eyeOpen.classList.remove('hidden');
                eyeOpenOuter.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        let timeout = null;

        const checkAvailability = async (name) => {
            if (!name) {
                availabilityMessage.classList.add('hidden', 'scale-95', 'opacity-0');
                availabilityMessage.classList.remove('scale-100', 'opacity-100');
                return;
            }

            try {
                const response = await fetch(`/check-availability?name=${encodeURIComponent(name)}`);
                const data = await response.json();

                availabilityMessage.classList.remove('hidden');
                setTimeout(() => {
                    availabilityMessage.classList.add('scale-100', 'opacity-100');
                    availabilityMessage.classList.remove('scale-95', 'opacity-0');
                }, 10);

                const container = availabilityMessage.querySelector('div');

                if (data.available) {
                    container.className = 'flex items-center space-x-3 p-4 rounded-[2rem] border-2 border-green-100 bg-white shadow-xl shadow-green-50 transition-all';
                    statusIcon.className = 'w-10 h-10 rounded-2xl flex items-center justify-center bg-green-500 text-white shadow-lg shadow-green-200';
                    statusIcon.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                    statusText.innerText = 'Good news!';
                    statusText.className = 'font-bold text-green-900';
                    statusSubtext.innerText = `zity.in/${data.slug} is available for you.`;
                    claimBtn.classList.remove('hidden');
                    
                    // Pre-fill shop name
                    shopNameInput.value = name;
                } else {
                    container.className = 'flex items-center space-x-3 p-4 rounded-[2rem] border-2 border-red-100 bg-white shadow-xl shadow-red-50 transition-all';
                    statusIcon.className = 'w-10 h-10 rounded-2xl flex items-center justify-center bg-red-500 text-white shadow-lg shadow-red-200';
                    statusIcon.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                    statusText.innerText = 'Already taken';
                    statusText.className = 'font-bold text-red-900';
                    statusSubtext.innerText = 'Try a different name or add your city.';
                    claimBtn.classList.add('hidden');
                }
            } catch (error) {
                console.error('Error checking availability:', error);
            }
        };

        function scrollToRegister() {
            document.getElementById('register').scrollIntoView({ behavior: 'smooth' });
            // Highlight the shop name input
            setTimeout(() => {
                shopNameInput.focus();
                shopNameInput.classList.add('ring-4', 'ring-indigo-100', 'border-indigo-500');
            }, 800);
        }

        brandSearch.addEventListener('input', (e) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                checkAvailability(e.target.value);
            }, 500);
        });

        checkBtn.addEventListener('click', () => {
            checkAvailability(brandSearch.value);
        });

        function toggleServiceArea(value) {
            const field = document.getElementById('service-area-field');
            const input = document.getElementById('service-area-input');
            if (value === 'service') {
                field.classList.remove('hidden');
            } else {
                field.classList.add('hidden');
            }
            // Always ensure the field is never required
            input.removeAttribute('required');
        }
    </script>
    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.8s ease-out forwards; }
        .animate-bounce-slow { animation: bounce 3s infinite; }
        @keyframes bounce {
            0%, 100% { transform: translateY(-5%); animation-timing-function: cubic-bezier(0.8, 0, 1, 1); }
            50% { transform: translateY(0); animation-timing-function: cubic-bezier(0, 0, 0.2, 1); }
        }
    </style>
</body>
</html>
