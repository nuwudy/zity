<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }} - Profile & Business Dashboard | ZITY.in</title>
    
    <!-- PWA Manifest & Meta -->
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#581c87">
    <link rel="apple-touch-icon" href="/images/icons/icon.svg">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind -->
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
</head>
<body class="bg-slate-50 text-slate-900 font-sans pb-24 md:pb-12 min-h-screen">
    <!-- Top Bar Navigation -->
    <header class="bg-white border-b border-slate-100 sticky top-0 z-30 shadow-xs">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h1 class="text-base font-bold text-slate-900">User Account</h1>
            </div>

            <div class="flex items-center gap-2">
                <span class="hidden sm:inline-flex items-center gap-1 text-xs font-semibold text-purple-700 bg-purple-50 px-2.5 py-1 rounded-full">
                    <span>🪙</span> {{ $user->coins ?? 10 }} Coins
                </span>
                <a href="{{ route('logout') }}" class="text-xs font-bold text-red-600 hover:text-red-700 px-3 py-1.5 rounded-lg hover:bg-red-50 transition">
                    Logout
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-6 space-y-6">
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-xs font-semibold flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Profile Header Box -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <!-- Avatar with Initial -->
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-600 flex items-center justify-center text-white font-extrabold text-2xl shadow-lg shadow-purple-500/20">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h2 class="text-xl font-extrabold text-slate-900">{{ $user->name }}</h2>
                            @if($user->is_verified ?? true)
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-indigo-700 bg-indigo-50 border border-indigo-200/60 px-2 py-0.5 rounded-full">
                                    <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Verified
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $user->phone ?? '+91 94952 49224' }} • {{ $user->email }}</p>
                    </div>
                </div>

                <button onclick="document.getElementById('editProfileModal').classList.remove('hidden')" class="w-10 h-10 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition" title="Edit Profile">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </button>
            </div>

            <!-- Zity Credits Banner Card (Matching Mockup Screen 1) -->
            <div class="mt-6 p-5 rounded-2xl bg-gradient-to-r from-purple-900 via-indigo-900 to-purple-800 text-white shadow-xl shadow-purple-900/20 flex items-center justify-between relative overflow-hidden">
                <!-- Background ambient shine -->
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>

                <div>
                    <span class="text-xs font-medium text-purple-200 uppercase tracking-wider block">Zity Credits</span>
                    <div class="text-3xl font-black mt-1">
                        ₹{{ number_format($user->credits ?? 250, 0) }}
                    </div>
                    <p class="text-[11px] text-purple-200/80 mt-0.5">Available for deal unlocks & bookings</p>
                </div>

                <div class="text-right">
                    <button onclick="alert('Your Zity Credits can be used across all verified stores on Zity.in!')" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white/15 hover:bg-white/25 backdrop-blur text-white text-xs font-bold transition border border-white/20">
                        <span>View Details</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <span class="block text-[10px] text-purple-300 mt-2">🪙 {{ $user->coins ?? 10 }} Coins Available</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column: CUSTOMER AREA -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 px-1">
                    <span class="text-purple-600 text-lg">🛍️</span>
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Customer Area</h3>
                </div>

                <div class="bg-white rounded-3xl p-2 shadow-sm border border-slate-100 divide-y divide-slate-100">
                    <!-- My Bookings -->
                    <a href="javascript:void(0)" onclick="alert('You have {{ $bookingsCount }} active bookings.')" class="flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition group">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-lg">
                                🎟️
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 group-hover:text-purple-700 transition">My Bookings</h4>
                                <p class="text-xs text-slate-500">View your deal bookings & history</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($bookingsCount > 0)
                                <span class="bg-purple-100 text-purple-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ $bookingsCount }}</span>
                            @endif
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-purple-600 group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>

                    <!-- Saved Deals -->
                    <a href="javascript:void(0)" onclick="document.getElementById('savedDealsModal').classList.remove('hidden')" class="flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition group">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-lg">
                                ❤️
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 group-hover:text-purple-700 transition">Saved Deals</h4>
                                <p class="text-xs text-slate-500">Deals you saved for later</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="bg-rose-50 text-rose-600 text-xs font-bold px-2 py-0.5 rounded-full">{{ $savedDeals->count() }}</span>
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-purple-600 group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>

                    <!-- Zity Credits / Wallet -->
                    <a href="javascript:void(0)" onclick="alert('Current Balance: ₹{{ $user->credits ?? 250 }} Credits & {{ $user->coins ?? 10 }} Coins')" class="flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition group">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg">
                                ⭐
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 group-hover:text-purple-700 transition">Zity Credits</h4>
                                <p class="text-xs text-slate-500">Your credits, rewards & transactions</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-purple-600 group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <!-- Refer & Earn -->
                    <a href="javascript:void(0)" onclick="document.getElementById('referralModal').classList.remove('hidden')" class="flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition group">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg">
                                🎁
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 group-hover:text-purple-700 transition">Refer & Earn</h4>
                                <p class="text-xs text-slate-500">Invite friends & earn ₹25 Credits</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-purple-600 group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <!-- Account Settings Group -->
                <div class="flex items-center gap-2 px-1 pt-2">
                    <span class="text-slate-500 text-lg">⚙️</span>
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Account</h3>
                </div>

                <div class="bg-white rounded-3xl p-2 shadow-sm border border-slate-100 divide-y divide-slate-100">
                    <button type="button" onclick="document.getElementById('editProfileModal').classList.remove('hidden')" class="w-full flex items-center justify-between p-3.5 hover:bg-slate-50 rounded-2xl transition group text-left">
                        <div class="flex items-center gap-3">
                            <span class="text-slate-400">👤</span>
                            <span class="text-xs font-bold text-slate-800 group-hover:text-purple-700">Profile Settings</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <button type="button" onclick="alert('Notification preferences saved.')" class="w-full flex items-center justify-between p-3.5 hover:bg-slate-50 rounded-2xl transition group text-left">
                        <div class="flex items-center gap-3">
                            <span class="text-slate-400">🔔</span>
                            <span class="text-xs font-bold text-slate-800 group-hover:text-purple-700">Notification Settings</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <button type="button" onclick="alert('For support, email us at support@zity.in or WhatsApp 9495249224.')" class="w-full flex items-center justify-between p-3.5 hover:bg-slate-50 rounded-2xl transition group text-left">
                        <div class="flex items-center gap-3">
                            <span class="text-slate-400">❓</span>
                            <span class="text-xs font-bold text-slate-800 group-hover:text-purple-700">Help & Support</span>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>

                <!-- Logout Button -->
                <a href="{{ route('logout') }}" class="w-full py-3.5 px-4 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs border border-rose-200/60 flex items-center justify-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Logout from Account</span>
                </a>
            </div>

            <!-- Right Column: BUSINESS AREA (Multi-Business Owner Hub) -->
            <div class="space-y-4">
                <div class="flex items-center justify-between px-1">
                    <div class="flex items-center gap-2">
                        <span class="text-purple-600 text-lg">🏪</span>
                        <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Business Area</h3>
                    </div>
                    <button onclick="document.getElementById('addBusinessModal').classList.remove('hidden')" class="inline-flex items-center gap-1 text-xs font-bold text-purple-700 hover:text-purple-800 bg-purple-100 hover:bg-purple-200 px-3 py-1 rounded-xl transition">
                        <span>+ Add New</span>
                    </button>
                </div>

                @forelse($businesses as $business)
                    <!-- Business Card (Matching Screenshot 1 Right Side) -->
                    <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 space-y-4">
                        <!-- Shop Title Bar -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl font-black">
                                    🏪
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-base font-bold text-slate-900">{{ $business->name }}</h4>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            Live
                                        </span>
                                    </div>
                                    <a href="/{{ $business->slug }}" target="_blank" class="text-xs text-purple-600 hover:underline font-medium">
                                        zity.in/{{ $business->slug }} ↗
                                    </a>
                                </div>
                            </div>

                            <a href="/admin" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/></svg>
                            </a>
                        </div>

                        <!-- Business Dashboard CTA -->
                        <a href="/admin" class="flex items-center justify-between p-3.5 bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-100 rounded-2xl group hover:border-purple-200 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-purple-600 text-white flex items-center justify-center text-sm shadow-sm">
                                    📊
                                </div>
                                <div>
                                    <h5 class="text-xs font-bold text-slate-900 group-hover:text-purple-700 transition">Business Dashboard</h5>
                                    <p class="text-[11px] text-slate-500">View analytics, bookings, deals & customer activity</p>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-purple-600 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>

                        <!-- Live Metrics Row -->
                        <div class="grid grid-cols-4 gap-2 py-2 px-1 bg-slate-50 rounded-2xl text-center border border-slate-100">
                            <div>
                                <span class="text-slate-400 text-xs">👁️</span>
                                <div class="text-xs font-black text-slate-900 mt-0.5">125</div>
                                <span class="text-[9px] text-slate-500 font-semibold uppercase">Views</span>
                            </div>
                            <div>
                                <span class="text-purple-600 text-xs">📋</span>
                                <div class="text-xs font-black text-slate-900 mt-0.5">48</div>
                                <span class="text-[9px] text-slate-500 font-semibold uppercase">Bookings</span>
                            </div>
                            <div>
                                <span class="text-amber-600 text-xs">🏷️</span>
                                <div class="text-xs font-black text-slate-900 mt-0.5">32</div>
                                <span class="text-[9px] text-slate-500 font-semibold uppercase">Deals</span>
                            </div>
                            <div>
                                <span class="text-emerald-600 text-xs">₹</span>
                                <div class="text-xs font-black text-emerald-700 mt-0.5">₹9,850</div>
                                <span class="text-[9px] text-slate-500 font-semibold uppercase">Revenue</span>
                            </div>
                        </div>

                        <!-- Management Quick Links -->
                        <div class="space-y-1 pt-1 text-xs font-semibold text-slate-700">
                            <a href="/admin/products" class="flex items-center justify-between p-2.5 hover:bg-slate-50 rounded-xl transition group">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-slate-400">🛍️</span>
                                    <span>Manage Products & Services</span>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <a href="/admin/products" class="flex items-center justify-between p-2.5 hover:bg-slate-50 rounded-xl transition group">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-slate-400">🏷️</span>
                                    <span>Manage Deals & Discounts</span>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <a href="/admin" class="flex items-center justify-between p-2.5 hover:bg-slate-50 rounded-xl transition group">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-slate-400">⚙️</span>
                                    <span>Business Settings & Details</span>
                                </div>
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- No Business Registered Yet -->
                    <div class="bg-white rounded-3xl p-8 text-center border-2 border-dashed border-purple-200 space-y-3">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-3xl">
                            🏪
                        </div>
                        <h4 class="text-base font-bold text-slate-900">Start Your Local Business</h4>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto">
                            Grow your shop, restaurant, salon or service on Zity. Reach local customers without creating a separate login.
                        </p>
                        <button onclick="document.getElementById('addBusinessModal').classList.remove('hidden')" class="mt-2 py-3 px-6 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold text-xs shadow-lg shadow-purple-500/25 hover:from-purple-700 hover:to-indigo-700 transition">
                            + Start My Business Now
                        </button>
                    </div>
                @endforelse

                <!-- Add Another Business Action -->
                @if($businesses->count() > 0)
                    <button type="button" onclick="document.getElementById('addBusinessModal').classList.remove('hidden')" class="w-full py-4 px-4 rounded-3xl border-2 border-dashed border-purple-200 hover:border-purple-400 bg-purple-50/50 hover:bg-purple-50 text-purple-700 font-bold text-xs transition flex items-center justify-center gap-2">
                        <span class="text-base">+</span>
                        <span>Add Another Business Page</span>
                    </button>
                @endif
            </div>
        </div>
    </main>

    <!-- Modal: Add Business -->
    <div id="addBusinessModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden">
        <div class="relative w-full max-w-lg bg-white rounded-3xl p-6 sm:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
            <button onclick="document.getElementById('addBusinessModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="text-center mb-6">
                <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center text-2xl mx-auto mb-2">🏪</div>
                <h3 class="text-xl font-extrabold text-slate-900">Register a New Business</h3>
                <p class="text-xs text-slate-500">This business will be connected directly to your existing account.</p>
            </div>

            <form action="{{ route('register.shop') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Business / Brand Name</label>
                    <input type="text" name="shop_name" required placeholder="e.g. Looks Salon or Tasty Bites" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-purple-600 focus:ring-2 focus:ring-purple-100 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Business Contact Phone</label>
                        <input type="tel" name="phone" required value="{{ $user->phone }}" placeholder="9495249224" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-purple-600 focus:ring-2 focus:ring-purple-100 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Service Area / City</label>
                        <input type="text" name="service_area" value="Kochi" required placeholder="Edappally, Kochi" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-purple-600 focus:ring-2 focus:ring-purple-100 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Business Type</label>
                    <select name="type" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-purple-600 focus:ring-2 focus:ring-purple-100 outline-none bg-white">
                        <option value="shop">Retail Shop / Store / Restaurant</option>
                        <option value="service">Service / Salon / Repair / Freelance</option>
                        <option value="both">Both Shop & Service</option>
                    </select>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold text-sm shadow-xl shadow-purple-500/25 hover:from-purple-700 hover:to-indigo-700 transition">
                    Create Business Page
                </button>
            </form>
        </div>
    </div>

    <!-- Modal: Edit Profile -->
    <div id="editProfileModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden">
        <div class="relative w-full max-w-md bg-white rounded-3xl p-6 sm:p-8 shadow-2xl">
            <button onclick="document.getElementById('editProfileModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <h3 class="text-lg font-bold text-slate-900 mb-4">Edit Profile Settings</h3>
            <form action="{{ route('profile.complete') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" required class="w-full px-3.5 py-2 text-sm rounded-xl border border-slate-200">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ $user->email }}" required class="w-full px-3.5 py-2 text-sm rounded-xl border border-slate-200">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ $user->phone }}" required class="w-full px-3.5 py-2 text-sm rounded-xl border border-slate-200">
                </div>
                <button type="submit" class="w-full py-3 rounded-xl bg-purple-600 text-white font-bold text-xs hover:bg-purple-700 transition">
                    Save Changes
                </button>
            </form>
        </div>
    </div>

    <!-- Modal: Saved Deals -->
    <div id="savedDealsModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden">
        <div class="relative w-full max-w-lg bg-white rounded-3xl p-6 shadow-2xl max-h-[85vh] overflow-y-auto">
            <button onclick="document.getElementById('savedDealsModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                <span>❤️</span> Saved Deals ({{ $savedDeals->count() }})
            </h3>
            <div class="space-y-3">
                @forelse($savedDeals as $item)
                    <div class="p-3 bg-slate-50 rounded-2xl flex items-center justify-between border border-slate-100">
                        <div>
                            <h4 class="text-xs font-bold text-slate-900">{{ $item->deal_title ?? ($item->product->name ?? 'Special Offer') }}</h4>
                            <p class="text-[11px] text-slate-500">{{ $item->business->name ?? 'Zity Verified Merchant' }}</p>
                        </div>
                        <a href="{{ route('home') }}" class="px-3 py-1.5 bg-purple-600 text-white text-xs font-bold rounded-xl hover:bg-purple-700 transition">
                            View Deal
                        </a>
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-400 text-xs">
                        No saved deals yet. Browse trending deals on homepage and tap the ❤️ icon!
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal: Referral Link -->
    <div id="referralModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm hidden">
        <div class="relative w-full max-w-md bg-white rounded-3xl p-6 text-center shadow-2xl">
            <button onclick="document.getElementById('referralModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="text-4xl mb-2">🎁</div>
            <h3 class="text-lg font-bold text-slate-900">Refer Friends & Earn ₹25</h3>
            <p class="text-xs text-slate-500 mt-1">Share your personal referral link with friends. When they unlock their first deal, you both earn ₹25 Zity Credit!</p>
            
            <div class="mt-4 p-3 bg-purple-50 rounded-2xl border border-purple-200 flex items-center justify-between">
                <span class="text-xs font-mono font-bold text-purple-900 truncate">https://zity.in?ref={{ $user->id }}</span>
                <button onclick="navigator.clipboard.writeText('https://zity.in?ref={{ $user->id }}'); alert('Referral link copied!');" class="px-3 py-1.5 bg-purple-600 text-white text-xs font-bold rounded-xl hover:bg-purple-700 transition shrink-0 ml-2">
                    Copy Link
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom Navigation Bar (Matching Screens) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 px-2 py-2">
        <div class="flex items-center justify-around">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-purple-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px] font-semibold">Home</span>
            </a>
            <a href="{{ route('home') }}#deals" class="flex flex-col items-center gap-1 text-slate-500 hover:text-purple-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                <span class="text-[10px] font-semibold">Deals</span>
            </a>
            <a href="javascript:void(0)" onclick="alert('You have {{ $bookingsCount }} active bookings.')" class="flex flex-col items-center gap-1 text-slate-500 hover:text-purple-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span class="text-[10px] font-semibold">Bookings</span>
            </a>
            <a href="javascript:void(0)" onclick="document.getElementById('savedDealsModal').classList.remove('hidden')" class="flex flex-col items-center gap-1 text-slate-500 hover:text-purple-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                <span class="text-[10px] font-semibold">Saved</span>
            </a>
            <a href="{{ route('profile.index') }}" class="flex flex-col items-center gap-1 text-purple-700 font-bold transition">
                <div class="w-5 h-5 rounded-full bg-purple-600 text-white flex items-center justify-center text-[10px] font-extrabold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <span class="text-[10px] font-bold">Profile</span>
            </a>
        </div>
    </nav>
</body>
</html>
