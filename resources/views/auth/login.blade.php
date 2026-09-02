<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In / Register - ZITY.in</title>
    
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
<body class="bg-slate-50 text-slate-900 font-sans min-h-screen flex flex-col justify-between">
    <!-- Top Bar -->
    <div class="px-6 py-4 flex items-center justify-between max-w-lg mx-auto w-full">
        <a href="{{ route('home') }}" class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-slate-700 hover:text-purple-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <span class="text-xs font-semibold text-slate-500">Fast & Free Access</span>
    </div>

    <!-- Main Container -->
    <div class="w-full max-w-md mx-auto px-6 py-4">
        <!-- Logo & Header -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center gap-2 mb-2">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-600 flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-purple-500/30">
                    Z
                </div>
                <div class="text-left">
                    <span class="text-3xl font-extrabold tracking-tight text-slate-900">ZITY<span class="text-purple-600">.in</span></span>
                    <p class="text-[10px] tracking-widest text-slate-500 font-bold uppercase -mt-1">Local Deals. Real Savings.</p>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 mt-3">Welcome to Zity</h1>
            <p class="text-sm text-slate-500 mt-1">Find the best deals, discounts & services near you.</p>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3.5 bg-red-50 border border-red-200 rounded-2xl text-red-700 text-xs flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Card Box -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-slate-100">
            <!-- Tabs -->
            <div class="flex p-1 mb-6 bg-slate-100 rounded-2xl">
                <button type="button" onclick="showTab('login')" id="tabLogin" class="flex-1 py-2.5 text-xs font-bold rounded-xl transition bg-white text-purple-700 shadow-sm">
                    Sign In
                </button>
                <button type="button" onclick="showTab('register')" id="tabRegister" class="flex-1 py-2.5 text-xs font-bold rounded-xl text-slate-600 hover:text-slate-900 transition">
                    Create Account <span class="ml-1 text-[10px] bg-amber-100 text-amber-800 font-extrabold px-1.5 py-0.5 rounded-full">+10 Coins</span>
                </button>
            </div>

            <!-- Login Form -->
            <form id="loginBox" method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf
                <input type="text" name="website_hp" class="hidden" tabindex="-1">

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Email, Phone (+91) or Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </span>
                        <input type="text" name="login_id" required value="{{ old('login_id') }}" placeholder="9495249224 or name@domain.com" class="w-full pl-10 pr-3.5 py-3 text-sm rounded-2xl border border-slate-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700">Password</label>
                        <a href="javascript:void(0)" onclick="alert('Password reset instructions will be sent to your email/phone.')" class="text-[11px] font-semibold text-purple-600 hover:underline">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <input type="password" id="pageLoginPassword" name="password" required placeholder="••••••••" class="w-full pl-10 pr-10 py-3 text-sm rounded-2xl border border-slate-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                        <button type="button" onclick="togglePasswordVisibility('pageLoginPassword', this)" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-purple-600 transition" title="Show/Hide Password">
                            <svg class="w-4 h-4 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="w-4 h-4 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between py-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" value="1" checked class="w-4 h-4 rounded text-purple-600 focus:ring-purple-500 border-slate-300">
                        <span class="text-xs text-slate-600 font-medium">Keep me signed in</span>
                    </label>
                    <span class="inline-flex items-center gap-1 text-[11px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-lg">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Secure Login
                    </span>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold text-sm shadow-xl shadow-purple-500/30 transition transform active:scale-[0.98] flex items-center justify-center gap-2">
                    <span>Continue to Zity</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <!-- Register Form -->
            <form id="registerBox" method="POST" action="{{ route('register.post') }}" class="space-y-4 hidden">
                @csrf
                <input type="text" name="website_hp" class="hidden" tabindex="-1">

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Full Name</label>
                    <input type="text" name="name" required placeholder="e.g. Sait K" class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Address</label>
                    <input type="email" name="email" required placeholder="sait@example.com" class="w-full px-4 py-3 text-sm rounded-2xl border border-slate-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Mobile Number</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3.5 text-xs font-bold text-slate-600 bg-slate-100 border border-r-0 border-slate-200 rounded-l-2xl">+91</span>
                        <input type="tel" name="phone" placeholder="9495249224" class="w-full px-4 py-3 text-sm rounded-r-2xl border border-slate-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Password</label>
                        <div class="relative">
                            <input type="password" id="pageRegPassword" name="password" required placeholder="••••••••" class="w-full pl-3.5 pr-8 py-2.5 text-sm rounded-2xl border border-slate-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                            <button type="button" onclick="togglePasswordVisibility('pageRegPassword', this)" class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-slate-400 hover:text-purple-600 transition">
                                <svg class="w-3.5 h-3.5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="w-3.5 h-3.5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Confirm</label>
                        <div class="relative">
                            <input type="password" id="pageRegConfirm" name="password_confirmation" required placeholder="••••••••" class="w-full pl-3.5 pr-8 py-2.5 text-sm rounded-2xl border border-slate-200 focus:border-purple-600 focus:ring-4 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                            <button type="button" onclick="togglePasswordVisibility('pageRegConfirm', this)" class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-slate-400 hover:text-purple-600 transition">
                                <svg class="w-3.5 h-3.5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="w-3.5 h-3.5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Reward Highlight -->
                <div class="p-3 bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl border border-amber-200 flex items-center gap-3">
                    <span class="text-2xl">🎁</span>
                    <div>
                        <p class="text-xs font-bold text-amber-900">Instant 10 Zity Coins Bonus!</p>
                        <p class="text-[11px] text-amber-700">Unlock your first restaurant or spa deal instantly.</p>
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold text-sm shadow-xl shadow-purple-500/30 transition transform active:scale-[0.98] flex items-center justify-center gap-2">
                    <span>Create Account & Claim Coins</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <!-- Continue As Guest -->
            <div class="mt-6 pt-4 border-t border-slate-100 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-purple-700 transition py-1 px-3 rounded-lg hover:bg-slate-50">
                    <span>👉 Explore deals first (Continue as Guest)</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Trust Features (Matching Bottom of Screenshot 3) -->
        <div class="grid grid-cols-2 gap-3 mt-6">
            <div class="bg-white/80 backdrop-blur rounded-2xl p-3 border border-slate-100 flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-sm font-bold shrink-0">
                    🛡️
                </div>
                <div>
                    <h4 class="text-[11px] font-bold text-slate-900">100% Safe</h4>
                    <p class="text-[10px] text-slate-500">Your data is secured</p>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur rounded-2xl p-3 border border-slate-100 flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm font-bold shrink-0">
                    ⚡
                </div>
                <div>
                    <h4 class="text-[11px] font-bold text-slate-900">Instant Access</h4>
                    <p class="text-[10px] text-slate-500">Sign in & start saving</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="py-4 text-center text-xs text-slate-400">
        © {{ date('Y') }} ZITY.in • Local Deals. Real Savings.
    </div>

    <script>
        function showTab(tab) {
            const loginBox = document.getElementById('loginBox');
            const regBox = document.getElementById('registerBox');
            const tabLogin = document.getElementById('tabLogin');
            const tabReg = document.getElementById('tabRegister');

            if (tab === 'login') {
                loginBox.classList.remove('hidden');
                regBox.classList.add('hidden');
                tabLogin.className = "flex-1 py-2.5 text-xs font-bold rounded-xl transition bg-white text-purple-700 shadow-sm";
                tabReg.className = "flex-1 py-2.5 text-xs font-bold rounded-xl text-slate-600 hover:text-slate-900 transition";
            } else {
                loginBox.classList.add('hidden');
                regBox.classList.remove('hidden');
                tabReg.className = "flex-1 py-2.5 text-xs font-bold rounded-xl transition bg-white text-purple-700 shadow-sm";
                tabLogin.className = "flex-1 py-2.5 text-xs font-bold rounded-xl text-slate-600 hover:text-slate-900 transition";
            }
        }

        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            const openIcon = btn.querySelector('.eye-open');
            const closedIcon = btn.querySelector('.eye-closed');
            if (openIcon && closedIcon) {
                openIcon.classList.toggle('hidden', isPassword);
                closedIcon.classList.toggle('hidden', !isPassword);
            }
        }
    </script>
</body>
</html>
