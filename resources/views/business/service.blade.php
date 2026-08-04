<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $business->name }} — Zity.in</title>

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="{{ $business->name }} — Zity.in">
    <meta property="og:description" content="{{ $business->description ?? 'Professional service provider on Zity.in.' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    @if($business->logo)
    <meta property="og:image" content="{{ asset('storage/' . $business->logo) }}">
    <meta name="twitter:image" content="{{ asset('storage/' . $business->logo) }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $business->name }} — Zity.in">
    <meta name="twitter:description" content="{{ $business->description ?? 'Professional service provider on Zity.in.' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; -webkit-tap-highlight-color: transparent; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        .safe-bottom { padding-bottom: calc(env(safe-area-inset-bottom) + 120px); }

        /* Mobile Tab System */
        .tab-content { display: none; animation: slideUp 0.3s ease-out forwards; }
        .tab-content.active { display: block; }

        @media (min-width: 768px) {
            .tab-content { display: block !important; opacity: 1 !important; transform: none !important; }
            .safe-bottom { padding-bottom: 80px; }
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .nav-item.active { color: #7C3AED; }
        .nav-item.active .nav-icon { background: #EDE9FE; transform: scale(1.1); }

        ::-webkit-scrollbar { display: none; }
        body { -ms-overflow-style: none; scrollbar-width: none; }

        /* Service card hover */
        .service-card:hover { transform: translateY(-4px); }

        @keyframes pulse-ring {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(109, 40, 217, 0.4); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(109, 40, 217, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(109, 40, 217, 0); }
        }
        .animate-pulse-ring { animation: pulse-ring 2s infinite; }
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(-5%); }
            50% { transform: translateY(0); }
        }
        .animate-bounce-slow { animation: bounce-slow 3s infinite; }
    </style>
</head>
<body class="bg-gray-100 md:bg-white text-gray-900">
    @if(auth()->check() && (auth()->id() == $business->user_id || auth()->user()->isMasterAdmin()))
    <!-- Owner Dashboard Link -->
    <div class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] animate-bounce-slow hidden md:block">
        <a href="/admin" class="glass bg-white/70 text-violet-600 px-5 py-2 rounded-full flex items-center space-x-2 shadow-2xl border border-white/50 hover:scale-105 active:scale-95 transition-all text-sm font-bold backdrop-blur-xl">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.370 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.370a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span>Dashboard</span>
        </a>
    </div>
    @endif

    <div class="app-container shadow-2xl md:shadow-none relative md:block border-x border-gray-100/50">
        <div class="flex flex-col min-h-screen">
        
        <div class="flex-grow md:hidden">
            <!-- Mobile Header/Cover Section (Hidden on Desktop) -->
            <div class="relative bg-white pb-6 rounded-b-[2.5rem] shadow-sm tracking-wide border-b border-gray-100">
                <div class="h-32 bg-gradient-to-br from-violet-500 to-purple-600 relative overflow-hidden rounded-b-[2rem]">
                    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#fff 0.5px, transparent 0.5px); background-size: 10px 10px;"></div>
                    <!-- Top controls -->
                    <div class="absolute top-4 left-4 right-4 flex justify-between items-start z-10">
                        <div class="flex flex-col items-center">
                            <button onclick="shareApp()" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/30 transition-transform active:scale-95">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                            </button>
                            <span class="text-[7px] font-bold text-white mt-1.5 tracking-tighter opacity-90 text-center leading-none">share my<br>zityCard</span>
                        </div>

                        @if(auth()->check() && (auth()->id() == $business->user_id || auth()->user()->isMasterAdmin()))
                        <div class="flex-1 flex justify-center -mt-1">
                            <a href="/admin" class="glass bg-white/20 text-white px-4 py-1.5 rounded-full flex items-center space-x-1.5 shadow-lg border border-white/30 hover:bg-white/30 transition-all text-[9px] font-bold backdrop-blur-md">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.370 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.370a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>Dashboard</span>
                            </a>
                        </div>
                        @endif

                        <div class="flex items-start">
                            @if(auth()->check())
                            <div class="flex flex-col items-center">
                                <a href="/logout" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/30 transition-transform active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </a>
                                <span class="text-[7px] font-bold text-white mt-1.5 tracking-tighter opacity-90">home</span>
                            </div>
                            @else
                            <div class="flex flex-col items-center">
                                <a href="/admin/login" class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/30 transition-transform active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </a>
                                <span class="text-[7px] font-bold text-white mt-1.5 tracking-tighter opacity-90 text-center leading-none">login</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Mobile Profile Info (Avatar, Name, Actions) -->
                <div class="flex justify-center -mt-16 relative z-10 px-6">
                    <div class="relative">
                        @if($business->logo)
                            <img src="{{ asset('storage/' . $business->logo) }}" class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-xl bg-white">
                        @else
                            <div class="w-28 h-28 bg-white border-4 border-white text-violet-600 rounded-full flex items-center justify-center font-bold text-4xl shadow-xl">{{ substr($business->name, 0, 1) }}</div>
                        @endif
                        <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center shadow-lg">
                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-6 px-6 flex flex-col items-center">
                    <h1 class="text-xl font-bold text-gray-900 leading-tight break-words whitespace-normal text-center w-full max-w-[90vw] -mt-2">{{ $business->name }}</h1>
                    <p class="text-[10px] font-bold text-violet-500 uppercase tracking-widest mt-1 mb-2 bg-violet-50 px-3 py-1 rounded-full w-fit">Verified Pro</p>
                    @if($business->description)
                    <p class="text-gray-500 text-sm line-clamp-2 px-4">{{ Str::limit($business->description, 80) }}</p>
                    @endif
                    
                    <div class="flex flex-wrap justify-center gap-2 mt-3">
                        @if($business->experience_years)
                        <div class="bg-gray-50 text-gray-600 px-3 py-1 rounded-full text-xs font-bold border border-gray-100 flex items-center space-x-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> <span>{{ $business->experience_years }}y Exp.</span></div>
                        @endif
                        @if($business->service_area)
                        <div class="bg-gray-50 text-gray-600 px-3 py-1 rounded-full text-xs font-bold border border-gray-100 flex items-center space-x-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg> <span>{{ $business->service_area }}</span></div>
                        @endif
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="flex justify-center items-center space-x-6 mt-6 w-full">
                        <a href="tel:{{ $business->phone }}" class="flex flex-col items-center">
                            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-gray-700 border border-gray-100 shadow-sm active:scale-95 transition-transform"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg></div>
                            <span class="text-[10px] font-bold text-gray-500 mt-2">Call</span>
                        </a>
                        <a href="https://wa.me/{{ $business->whatsapp }}" target="_blank" class="flex flex-col items-center">
                            <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-green-600 border border-green-100 shadow-sm active:scale-95 transition-transform"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.685 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></div>
                            <span class="text-[10px] font-bold text-gray-500 mt-2">Chat</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Desktop Header (Always Visible on PC) -->
        <header class="hidden md:block sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="{{ $business->getUrl() }}" class="flex items-center space-x-4 group">
                    @if($business->logo)
                        <img src="{{ asset('storage/' . $business->logo) }}" class="w-12 h-12 rounded-2xl object-cover shadow-sm group-hover:scale-105 transition-transform">
                    @else
                        <div class="w-12 h-12 bg-violet-100 text-violet-600 rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm group-hover:scale-105 transition-transform">{{ substr($business->name, 0, 1) }}</div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <h1 class="text-xl font-bold text-gray-900 group-hover:text-violet-600 transition-colors break-words whitespace-normal max-w-md leading-none">{{ $business->name }}</h1>
                        <p class="text-sm text-violet-600 font-semibold tracking-wide uppercase">Verified Service Provider</p>
                    </div>
                </a>
                <nav class="flex items-center space-x-8 font-bold text-gray-500">
                    <a href="#tab-services" class="hover:text-violet-600 transition-colors">Services</a>
                    <a href="#tab-about" class="hover:text-violet-600 transition-colors">About</a>
                    <a href="#tab-contact" class="hover:text-violet-600 transition-colors">Contact</a>
                    <div class="h-6 w-px bg-gray-100 mx-2"></div>
                    <a href="{{ auth()->check() ? '/admin' : '/admin/login' }}" class="text-violet-600 hover:text-violet-700 transition-colors">
                        {{ auth()->check() ? 'Dashboard' : 'Login' }}
                    </a>
                    @if(auth()->check())
                        <a href="/logout" class="text-red-500 hover:text-red-600 transition-colors">Logout</a>
                    @endif
                    <button onclick="bookViaWhatsApp()" class="px-6 py-2.5 bg-violet-600 text-white rounded-xl hover:bg-violet-700 transition-all shadow-lg shadow-violet-100">Book Now</button>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="safe-bottom flex-1 md:bg-gray-50/50">
            <div class="max-w-7xl mx-auto">

                <!-- Desktop Hero Banner (Hidden on Mobile) -->
                <div class="hidden md:block hero-gradient relative overflow-hidden shadow-sm rounded-b-[2rem]">
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 0.5px, transparent 0.5px); background-size: 20px 20px;"></div>
                    <div class="relative z-10 p-8 md:p-16 flex flex-col md:flex-row items-center gap-8">
                        <!-- Avatar -->
                        <div class="relative flex-shrink-0">
                            @if($business->logo)
                                <img src="{{ asset('storage/' . $business->logo) }}" class="w-28 h-28 md:w-36 md:h-36 rounded-3xl object-cover border-4 border-white/30 shadow-2xl animate-pulse-ring">
                            @else
                                <div class="w-28 h-28 md:w-36 md:h-36 bg-white/20 text-white rounded-3xl flex items-center justify-center font-bold text-5xl shadow-2xl animate-pulse-ring border-4 border-white/30">{{ substr($business->name, 0, 1) }}</div>
                            @endif
                            <div class="absolute -bottom-2 -right-2 bg-green-400 text-white text-[10px] font-bold px-3 py-1 rounded-full border-2 border-white shadow-lg uppercase tracking-wider">Available</div>
                        </div>

                        <!-- Info -->
                        <div class="text-white text-center md:text-left flex-1">
                            <h2 class="text-3xl md:text-5xl font-bold mb-2 break-words">{{ $business->name }}</h2>
                            @if($business->category)
                            <p class="text-violet-200 font-semibold text-lg mb-4">{{ $business->category->name }}</p>
                            @endif

                            <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                                @if($business->experience_years)
                                <div class="bg-white/15 backdrop-blur-md px-4 py-2 rounded-2xl text-sm font-bold border border-white/20 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                    <span>{{ $business->experience_years }}+ Years Exp.</span>
                                </div>
                                @endif
                                @if($business->service_area)
                                <div class="bg-white/15 backdrop-blur-md px-4 py-2 rounded-2xl text-sm font-bold border border-white/20 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>{{ $business->service_area }}</span>
                                </div>
                                @endif
                                @if($business->availability)
                                <div class="bg-white/15 backdrop-blur-md px-4 py-2 rounded-2xl text-sm font-bold border border-white/20 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>{{ $business->availability }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Desktop CTA -->
                        <div class="hidden md:flex flex-col gap-3 flex-shrink-0">
                            <button onclick="bookViaWhatsApp()" class="px-8 py-4 bg-white text-violet-700 rounded-2xl font-bold text-lg shadow-2xl hover:scale-105 active:scale-95 transition-all flex items-center space-x-3">
                                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.685 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                <span>Book via WhatsApp</span>
                            </button>
                            <a href="tel:{{ $business->phone }}" class="px-8 py-4 bg-white/10 text-white border border-white/20 rounded-2xl font-bold text-lg backdrop-blur-md hover:bg-white/20 transition-all text-center">
                                📞 Call Now
                            </a>
                        </div>
                    </div>
                </div>



                <!-- === SERVICES TAB === -->
                <div id="tab-services" class="tab-content active p-6 md:mb-0">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl md:text-4xl font-bold">Services Offered</h2>
                            <p class="text-gray-500 mt-1">Tap a service to book it directly on WhatsApp.</p>
                        </div>
                    </div>

                    @php $services = $business->services ?? []; @endphp

                    @if(empty($services))
                        <div class="py-20 text-center bg-white md:bg-gray-50 rounded-[2.5rem] border-2 border-dashed border-gray-100">
                            <div class="w-20 h-20 bg-violet-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-violet-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
                            </div>
                            <p class="text-gray-400 font-bold text-xl">Services coming soon</p>
                            <p class="text-gray-400 mt-2 text-sm">Contact us directly to discuss your needs.</p>
                            <button onclick="bookViaWhatsApp()" class="mt-6 px-8 py-3 bg-violet-600 text-white rounded-2xl font-bold hover:bg-violet-700 active:scale-95 transition-all inline-flex items-center space-x-2 shadow-lg shadow-violet-100">
                                <span>Message Us</span>
                            </button>
                        </div>
                    @else
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($services as $service)
                                @php $name = is_array($service) ? ($service['name'] ?? '') : $service; @endphp
                                @if($name)
                                <button onclick="bookService('{{ addslashes($name) }}')" class="service-card bg-white border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 text-left group flex flex-col space-y-4">
                                    <div class="w-12 h-12 bg-violet-50 text-violet-600 rounded-2xl flex items-center justify-center group-hover:bg-violet-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900 text-sm md:text-base leading-tight group-hover:text-violet-600 transition-colors">{{ $name }}</h3>
                                    </div>
                                    <div class="flex items-center text-xs font-bold text-violet-500 group-hover:text-violet-700 transition-colors space-x-1">
                                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.685 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                        <span>Book Now</span>
                                    </div>
                                </button>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Desktop: About + Contact in 2-col grid -->
                <div class="hidden md:grid grid-cols-2 gap-12 px-6 py-12">
                    <div id="desktop-tab-about" class="bg-violet-700 rounded-[3rem] p-12 text-white shadow-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
                        <h2 class="text-3xl font-bold mb-6 relative z-10">About Us</h2>
                        <p class="text-xl leading-relaxed text-violet-100 mb-10 relative z-10">"{{ $business->description ?? 'We are dedicated to providing professional, high-quality services to all our customers.' }}"</p>
                        <div class="grid grid-cols-2 gap-4 relative z-10">
                            @if($business->experience_years)
                            <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-md">
                                <p class="text-xs font-bold uppercase tracking-wider mb-1">Experience</p>
                                <p class="text-lg font-bold">{{ $business->experience_years }}+ Years</p>
                            </div>
                            @endif
                            @if($business->service_area)
                            <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-md">
                                <p class="text-xs font-bold uppercase tracking-wider mb-1">Serves</p>
                                <p class="text-lg font-bold">{{ $business->service_area }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div id="desktop-tab-contact" class="bg-white rounded-[3rem] p-12 shadow-sm border border-gray-100">
                        <h2 class="text-3xl font-bold mb-8 text-gray-900">Contact</h2>
                        <div class="space-y-6">
                            @if($business->address)
                            <div class="flex items-center space-x-4 p-5 rounded-2xl bg-gray-50">
                                <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-violet-600 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Location</p>
                                    <p class="font-bold text-gray-900">{{ $business->address }}</p>
                                </div>
                            </div>
                            @endif
                            @if($business->availability)
                            <div class="flex items-center space-x-4 p-5 rounded-2xl bg-gray-50">
                                <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-violet-600 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Availability</p>
                                    <p class="font-bold text-gray-900">{{ $business->availability }}</p>
                                </div>
                            </div>
                            @endif
                            <div class="flex items-center space-x-4">
                                <a href="tel:{{ $business->phone }}" class="flex-1 flex items-center space-x-3 p-5 rounded-2xl bg-blue-50 text-blue-600 hover:scale-105 transition-all font-bold">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span>Call</span>
                                </a>
                                <a href="https://wa.me/{{ $business->whatsapp }}" target="_blank" class="flex-1 flex items-center space-x-3 p-5 rounded-2xl bg-green-50 text-green-600 hover:scale-105 transition-all font-bold">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.685 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    <span>WhatsApp</span>
                                </a>
                            </div>
                            @if($business->email)
                            <a href="mailto:{{ $business->email }}" class="flex items-center space-x-4 p-5 rounded-2xl bg-violet-50 text-violet-600 hover:scale-105 transition-all font-bold">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>{{ $business->email }}</span>
                            </a>
                            @endif

                            @if($business->facebook_url || $business->instagram_url || $business->youtube_url || $business->twitter_url || $business->google_url || $business->website_url)
                            <div class="pt-4">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Connect with us</p>
                                <div class="flex flex-wrap gap-4">
                                    @if($business->facebook_url)
                                    <a href="{{ $business->facebook_url }}" target="_blank" class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </a>
                                    @endif
                                    @if($business->instagram_url)
                                    <a href="{{ $business->instagram_url }}" target="_blank" class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 hover:bg-pink-600 hover:text-white transition-all shadow-sm">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    </a>
                                    @endif
                                    @if($business->youtube_url)
                                    <a href="{{ $business->youtube_url }}" target="_blank" class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                    </a>
                                    @endif
                                    @if($business->twitter_url)
                                    <a href="{{ $business->twitter_url }}" target="_blank" class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 hover:bg-black hover:text-white transition-all shadow-sm">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    </a>
                                    @endif
                                    @if($business->google_url)
                                    <a href="{{ $business->google_url }}" target="_blank" class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M21.35 11.1h-9.17v2.73h5.14c-.22 1.1-.88 2.03-1.85 2.68v2.23h3c1.74-1.6 2.74-3.97 2.74-6.81 0-.64-.06-1.26-.14-1.83z"/><path d="M12.18 21c2.43 0 4.47-.8 5.96-2.18l-2.91-2.26c-.83.56-1.89.88-3.05.88-2.34 0-4.33-1.58-5.03-3.7h-3v2.33C5.64 19.16 8.68 21 12.18 21z"/><path d="M7.15 13.74a5.275 5.275 0 0 1 0-3.48V7.93h-3v2.34a8.913 8.913 0 0 0 0 7.42l3-2.33c-.15-.46-.15-1.12 0-1.62z"/><path d="M12.18 6.44c1.33 0 2.52.46 3.45 1.36l2.58-2.58C16.65 3.73 14.61 3 12.18 3c-3.5 0-6.54 1.84-8.03 4.93l3 2.34c.7-2.12 2.69-3.7 5.03-3.7z"/></svg>
                                    </a>
                                    @endif
                                    @if($business->website_url)
                                    <a href="{{ $business->website_url }}" target="_blank" class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400 hover:bg-violet-600 hover:text-white transition-all shadow-sm">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Mobile: About & Contact Tabs -->
                <div class="md:hidden">
                    <div id="tab-about" class="tab-content p-6">
                        <h2 class="text-2xl font-bold mb-6">About Us</h2>
                        <div class="bg-violet-50 p-6 rounded-[2rem] mb-6">
                            <p class="text-violet-900 leading-relaxed italic">"{{ $business->description ?? 'We are dedicated to providing professional, high-quality services.' }}"</p>
                        </div>
                        @if($business->experience_years || $business->service_area)
                        <div class="grid grid-cols-2 gap-4">
                            @if($business->experience_years)
                            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm text-center">
                                <p class="text-2xl font-bold text-violet-600">{{ $business->experience_years }}+</p>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Years Exp.</p>
                            </div>
                            @endif
                            @if($business->service_area)
                            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm text-center">
                                <p class="text-base font-bold text-violet-600 leading-tight">{{ $business->service_area }}</p>
                                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mt-1">Service Area</p>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>

                    <div id="tab-contact" class="tab-content p-6 text-center">
                        <h2 class="text-2xl font-bold mb-8">Get in Touch</h2>
                        @if($business->address)
                        <div class="bg-gray-50 rounded-[2.5rem] p-6 mb-6 text-left flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm text-violet-600 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-700">{{ $business->address }}</p>
                        </div>
                        @endif
                        @if($business->availability)
                        <div class="bg-violet-50 rounded-[2.5rem] p-4 mb-6 text-left flex items-center space-x-4">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm text-violet-600 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-violet-900">{{ $business->availability }}</p>
                        </div>
                        @endif
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <a href="tel:{{ $business->phone }}" class="bg-white border border-gray-100 p-5 rounded-3xl shadow-sm font-bold text-sm text-blue-600 flex flex-col items-center space-y-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>Call</span>
                            </a>
                            <a href="https://wa.me/{{ $business->whatsapp }}" target="_blank" class="bg-white border border-gray-100 p-5 rounded-3xl shadow-sm font-bold text-sm text-green-600 flex flex-col items-center space-y-2">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.653a11.888 11.888 0 005.685 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                <span>WhatsApp</span>
                            </a>
                        </div>
                        @if($business->email)
                        <a href="mailto:{{ $business->email }}" class="block w-full bg-violet-50 p-5 rounded-3xl font-bold text-sm text-violet-700 border border-violet-100 flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>{{ $business->email }}</span>
                        </a>
                        @endif

                        @if($business->facebook_url || $business->instagram_url || $business->youtube_url || $business->twitter_url || $business->google_url || $business->website_url)
                        <div class="pt-8">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Follow us on Social Media</p>
                            <div class="flex flex-wrap justify-center gap-4">
                                @if($business->facebook_url)
                                <a href="{{ $business->facebook_url }}" target="_blank" class="w-12 h-12 bg-white border border-gray-100 rounded-2xl flex items-center justify-center text-gray-400 active:scale-95 transition-all shadow-sm">
                                    <svg class="w-6 h-6 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                                @endif
                                @if($business->instagram_url)
                                <a href="{{ $business->instagram_url }}" target="_blank" class="w-12 h-12 bg-white border border-gray-100 rounded-2xl flex items-center justify-center text-gray-400 active:scale-95 transition-all shadow-sm">
                                    <svg class="w-6 h-6 text-[#E4405F]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                                @endif
                                @if($business->youtube_url)
                                <a href="{{ $business->youtube_url }}" target="_blank" class="w-12 h-12 bg-white border border-gray-100 rounded-2xl flex items-center justify-center text-gray-400 active:scale-95 transition-all shadow-sm">
                                    <svg class="w-6 h-6 text-[#FF0000]" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                </a>
                                @endif
                                @if($business->twitter_url)
                                <a href="{{ $business->twitter_url }}" target="_blank" class="w-12 h-12 bg-white border border-gray-100 rounded-2xl flex items-center justify-center text-gray-400 active:scale-95 transition-all shadow-sm">
                                    <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                                @endif
                                @if($business->google_url)
                                <a href="{{ $business->google_url }}" target="_blank" class="w-12 h-12 bg-white border border-gray-100 rounded-2xl flex items-center justify-center text-gray-400 active:scale-95 transition-all shadow-sm">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M21.35 11.1h-9.17v2.73h5.14c-.22 1.1-.88 2.03-1.85 2.68v2.23h3c1.74-1.6 2.74-3.97 2.74-6.81 0-.64-.06-1.26-.14-1.83z" fill="#4285F4"/><path d="M12.18 21c2.43 0 4.47-.8 5.96-2.18l-2.91-2.26c-.83.56-1.89.88-3.05.88-2.34 0-4.33-1.58-5.03-3.7h-3v2.33C5.64 19.16 8.68 21 12.18 21z" fill="#34A853"/><path d="M7.15 13.74a5.275 5.275 0 0 1 0-3.48V7.93h-3v2.34a8.913 8.913 0 0 0 0 7.42l3-2.33c-.15-.46-.15-1.12 0-1.62z" fill="#FBBC05"/><path d="M12.18 6.44c1.33 0 2.52.46 3.45 1.36l2.58-2.58C16.65 3.73 14.61 3 12.18 3c-3.5 0-6.54 1.84-8.03 4.93l3 2.34c.7-2.12 2.69-3.7 5.03-3.7z" fill="#EA4335"/></svg>
                                </a>
                                @endif
                                @if($business->website_url)
                                <a href="{{ $business->website_url }}" target="_blank" class="w-12 h-12 bg-white border border-gray-100 rounded-2xl flex items-center justify-center text-gray-400 active:scale-95 transition-all shadow-sm">
                                    <svg class="w-6 h-6 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </main>

        <!-- Bottom Tab Navigation (Mobile Only) -->
        <nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 flex justify-center pb-6 pointer-events-none">
            <div class="max-w-[500px] w-full px-4 pointer-events-auto">
                <div class="glass border border-white/20 rounded-[2.5rem] px-4 py-3 shadow-2xl flex items-center justify-between">
                    <button onclick="switchTab('services', event)" class="nav-item active flex flex-col items-center flex-1 space-y-1">
                        <div class="nav-icon w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Services</span>
                    </button>
                    <button onclick="switchTab('about', event)" class="nav-item flex flex-col items-center flex-1 space-y-1">
                        <div class="nav-icon w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-widest">About</span>
                    </button>
                    <button onclick="switchTab('contact', event)" class="nav-item flex flex-col items-center flex-1 space-y-1">
                        <div class="nav-icon w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Contact</span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Desktop Footer -->
        <footer class="hidden md:block bg-white border-t border-gray-100 py-12">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-gray-400 font-medium">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 mb-4 md:mb-0 group">
                    <div class="w-8 h-8 bg-violet-600 rounded-lg flex items-center justify-center text-white font-bold text-sm group-hover:rotate-12 transition-transform">Z</div>
                    <span class="font-bold text-gray-900">Zity.in</span>
                </a>
                <p class="text-sm">&copy; 2026 {{ $business->name }}. Verified Service Provider on Zity.in</p>
            </div>
        </footer>
    </div>
</div>

    <!-- Toast -->
    <div id="js-toast" class="hidden fixed top-10 left-1/2 -translate-x-1/2 z-[100] w-[90%] max-w-[400px]">
        <div class="bg-violet-700 text-white p-4 rounded-3xl shadow-2xl flex items-center justify-between border-4 border-white/20 backdrop-blur-xl">
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p id="js-toast-title" class="text-[10px] font-bold uppercase tracking-widest opacity-80"></p>
                    <p id="js-toast-message" class="text-sm font-bold"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabId, event) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.getElementById('tab-' + tabId).classList.add('active');
            document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
            if (event) event.currentTarget.classList.add('active');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function bookViaWhatsApp(serviceName = null) {
            const businessName = "{{ $business->name }}";
            const waNumber = "{{ $business->whatsapp }}";
            let message;
            if (serviceName) {
                message = `Hi! I found your profile on Zity.in and I need *${serviceName}* service from *${businessName}*. Are you available?`;
            } else {
                message = `Hi! I found your profile on Zity.in and I'd like to book a service from *${businessName}*. Are you available?`;
            }
            window.open(`https://wa.me/${waNumber}?text=${encodeURIComponent(message)}`, '_blank');
        }

        function bookService(name) {
            bookViaWhatsApp(name);
        }

        function showToast(title, message) {
            const toast = document.getElementById('js-toast');
            document.getElementById('js-toast-title').innerText = title;
            document.getElementById('js-toast-message').innerText = message;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3000);
        }

        async function shareApp() {
            const currentUrl = window.location.href.split('#')[0];
            const shareData = { title: '{{ $business->name }}', text: 'Check out this service provider on Zity.in!', url: currentUrl };
            if (navigator.share && navigator.canShare && navigator.canShare(shareData)) {
                try { await navigator.share(shareData); } catch (err) { if (err.name !== 'AbortError') copyToClipboard(currentUrl); }
            } else { copyToClipboard(currentUrl); }
        }

        function copyToClipboard(text) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => showToast('Link Copied', 'Profile URL copied to clipboard.'));
            } else {
                const ta = document.createElement("textarea");
                ta.value = text; ta.style.position = "fixed"; ta.style.left = "-9999px";
                document.body.appendChild(ta); ta.focus(); ta.select();
                try { document.execCommand('copy'); showToast('Link Copied', 'Profile URL copied to clipboard.'); }
                catch (err) { showToast('Error', 'Unable to copy link.'); }
                document.body.removeChild(ta);
            }
        }
    </script>
</body>
</html>
