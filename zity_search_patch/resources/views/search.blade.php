<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $query ? '"' . $query . '" — Search Results' : 'Search Businesses' }} | Zity.in</title>
    <meta name="description" content="Find local businesses and service providers on Zity.in. Search plumbers, electricians, shops and more near you.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255,255,255,0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.4); }
        .result-card:hover { transform: translateY(-2px); }

        /* Highlight matched text */
        mark { background: #EEF2FF; color: #4F46E5; padding: 0 2px; border-radius: 3px; font-weight: 600; }

        /* Skeleton loader */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 12px;
        }

        /* Search bar glow */
        .search-bar:focus-within {
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen text-gray-900">

    <!-- ── Top Search Header ── -->
    <header class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center gap-3">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2 group">
                <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow group-hover:scale-105 transition-transform">Z</div>
                <span class="hidden sm:block font-bold text-gray-900 text-lg">Zity.in</span>
            </a>

            <!-- Search Form -->
            <form action="{{ route('search') }}" method="GET" class="flex-1 search-bar flex items-center bg-gray-50 border-2 border-gray-200 focus-within:border-indigo-500 rounded-2xl transition-all overflow-hidden">
                <div class="pl-4 text-gray-400 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input
                    type="text"
                    name="q"
                    id="main-search"
                    value="{{ $query }}"
                    placeholder="Search plumber, electrician, shop..."
                    class="flex-1 py-3 px-3 bg-transparent focus:outline-none font-medium text-gray-900 placeholder:text-gray-400 text-base"
                    autocomplete="off"
                    autofocus
                >
                @if($query)
                <a href="{{ route('search') }}" class="flex-shrink-0 px-3 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
                @endif
                <button type="submit" class="flex-shrink-0 m-1.5 px-5 py-2 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 active:scale-95 transition-all text-sm">
                    Search
                </button>
            </form>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-6">

        @if($query)
        <!-- ── Results Header ── -->
        <div class="mb-5">
            <p class="text-sm text-gray-500">
                About <span class="font-bold text-gray-900">{{ $total }}</span>
                {{ Str::plural('result', $total) }} for
                <span class="text-indigo-600 font-semibold">"{{ $query }}"</span>
                on Zity.in
            </p>
        </div>

        @if($results->isEmpty())
        <!-- ── No Results ── -->
        <div class="py-16 text-center">
            <div class="w-24 h-24 bg-indigo-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-3">No results for "{{ $query }}"</h2>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">We couldn't find any businesses matching your search. Try different keywords or browse all listings.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('search') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition-all">Browse All</a>
                <a href="{{ route('home') }}#register" class="px-6 py-3 border-2 border-gray-200 text-gray-700 rounded-2xl font-bold hover:border-indigo-300 transition-all">Register Your Business</a>
            </div>
        </div>

        @else
        <!-- ── Results List ── -->
        <div class="space-y-3">
            @foreach($results as $business)
            <a href="{{ $business->getUrl() }}" class="result-card block bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-200 overflow-hidden group">
                <div class="flex items-start gap-4 p-5">
                    <!-- Avatar / Logo -->
                    <div class="flex-shrink-0">
                        @if($business->logo)
                            <img src="{{ asset('storage/' . $business->logo) }}" alt="{{ $business->name }}" class="w-14 h-14 rounded-2xl object-cover border border-gray-100 shadow-sm group-hover:scale-105 transition-transform">
                        @else
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-bold text-xl shadow-sm group-hover:scale-105 transition-transform
                                {{ $business->type === 'service' ? 'bg-orange-50 text-orange-600' : 'bg-indigo-50 text-indigo-600' }}">
                                {{ strtoupper(substr($business->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <!-- URL breadcrumb (Google style) -->
                        <div class="flex items-center gap-1.5 mb-1">
                            <div class="w-4 h-4 bg-indigo-600 rounded flex items-center justify-center text-white text-[8px] font-bold flex-shrink-0">Z</div>
                            <span class="text-xs text-gray-500 truncate">zity.in/<span class="text-indigo-600">{{ $business->slug }}</span></span>
                            @if($business->is_verified)
                            <span class="flex-shrink-0 flex items-center gap-0.5 text-[10px] text-green-600 font-semibold bg-green-50 px-1.5 py-0.5 rounded-full border border-green-100">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Verified
                            </span>
                            @endif
                        </div>

                        <!-- Name -->
                        <h2 class="text-lg font-bold text-indigo-700 group-hover:text-indigo-900 transition-colors leading-tight truncate">
                            {{ $business->name }}
                        </h2>

                        <!-- Type & Category badges -->
                        <div class="flex flex-wrap items-center gap-2 mt-1 mb-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full
                                {{ $business->type === 'service' ? 'bg-orange-50 text-orange-600 border border-orange-100' : 'bg-indigo-50 text-indigo-600 border border-indigo-100' }}">
                                {{ $business->type === 'service' ? '🔧 Service Provider' : '🛍️ Shop' }}
                            </span>
                            @if($business->category)
                            <span class="text-[10px] font-semibold text-gray-500 bg-gray-50 border border-gray-100 px-2 py-0.5 rounded-full">
                                {{ $business->category->name }}
                            </span>
                            @endif
                        </div>

                        <!-- Description snippet -->
                        @if($business->about)
                        <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
                            {{ Str::limit($business->about, 160) }}
                        </p>
                        @endif

                        <!-- Location / Service Area row -->
                        <div class="flex flex-wrap items-center gap-3 mt-3 text-xs text-gray-500">
                            @if($business->address)
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $business->address }}
                            </span>
                            @endif
                            @if($business->service_area)
                            <span class="flex items-center gap-1 text-indigo-500 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                Serves: {{ $business->service_area }}
                            </span>
                            @endif
                            @if($business->phone)
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $business->phone }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <!-- Arrow -->
                    <div class="flex-shrink-0 self-center">
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- ── Register CTA ── -->
        <div class="mt-10 bg-indigo-900 rounded-3xl p-8 text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(white 0.5px, transparent 0); background-size: 20px 20px;"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold uppercase tracking-widest text-indigo-300 mb-2">Not listed yet?</p>
                <h3 class="text-2xl font-bold mb-3">Is your business on Zity.in?</h3>
                <p class="text-indigo-200 mb-6 text-sm">Get your free business page and appear in search results like these.</p>
                <a href="{{ route('home') }}#register" class="inline-block px-8 py-3.5 bg-white text-indigo-700 font-bold rounded-2xl hover:bg-indigo-50 transition-all shadow-xl shadow-indigo-900/40">
                    Register Free →
                </a>
            </div>
        </div>
        @endif

        @else
        <!-- ── Empty State / Browse All ── -->
        <div class="py-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Find any local business</h2>
            <p class="text-gray-500 mb-8">Search by profession, service, or business name — with location for best results.</p>

            <!-- Popular Searches -->
            <div class="mb-10">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Popular Searches</p>
                <div class="flex flex-wrap gap-2">
                    @foreach(['Plumber', 'Electrician', 'Mechanic', 'Grocery', 'Salon', 'Doctor', 'Carpenter', 'Tutor', 'Painter', 'Cleaning'] as $term)
                    <a href="{{ route('search', ['q' => $term]) }}"
                       class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-full text-sm font-medium hover:border-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all shadow-sm">
                        {{ $term }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Random / Recent Businesses -->
            @if($suggestions->isNotEmpty())
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Businesses on Zity.in</p>
                <div class="space-y-3">
                    @foreach($suggestions as $business)
                    <a href="{{ $business->getUrl() }}" class="result-card flex items-center gap-4 bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-md transition-all group">
                        @if($business->logo)
                            <img src="{{ asset('storage/' . $business->logo) }}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                        @else
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-lg flex-shrink-0
                                {{ $business->type === 'service' ? 'bg-orange-50 text-orange-600' : 'bg-indigo-50 text-indigo-600' }}">
                                {{ strtoupper(substr($business->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 group-hover:text-indigo-700 transition-colors truncate">{{ $business->name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $business->address ?? ($business->service_area ?? 'Zity.in') }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif

    </main>

    <!-- Autocomplete dropdown script -->
    <script>
        const input = document.getElementById('main-search');
        let debounceTimer;

        // Submit on Enter
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.target.closest('form').submit();
            }
        });
    </script>
</body>
</html>
