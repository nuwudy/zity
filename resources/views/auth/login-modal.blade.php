<!-- Auth Modal (Login / Register / Guest) -->
<div id="authModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden transform scale-95 transition-all duration-300" id="authModalContainer">
        <!-- Close Button -->
        <button onclick="closeAuthModal()" class="absolute top-4 right-4 z-10 w-9 h-9 flex items-center justify-center rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <!-- Header -->
        <div class="px-8 pt-8 pb-4 text-center bg-gradient-to-b from-indigo-50/70 to-transparent">
            <div class="inline-flex items-center gap-2 mb-2">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 flex items-center justify-center text-white font-black text-xl shadow-md">
                    Z
                </div>
                <div class="text-left">
                    <span class="text-2xl font-extrabold tracking-tight text-slate-900">ZITY<span class="text-purple-600">.in</span></span>
                    <p class="text-[10px] tracking-widest text-slate-500 font-semibold uppercase -mt-1">Local Deals. Real Savings.</p>
                </div>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mt-2" id="authModalTitle">Welcome to Zity</h3>
            <p class="text-xs text-slate-500 mt-0.5">Find & unlock the best local deals near you.</p>

            <!-- Mode Switcher Tabs -->
            <div class="flex p-1 mt-4 bg-slate-100 rounded-xl">
                <button type="button" onclick="switchAuthTab('login')" id="tabLoginBtn" class="flex-1 py-2 text-xs font-semibold rounded-lg transition bg-white text-purple-700 shadow-sm">
                    Sign In
                </button>
                <button type="button" onclick="switchAuthTab('register')" id="tabRegisterBtn" class="flex-1 py-2 text-xs font-semibold rounded-lg text-slate-600 hover:text-slate-900 transition">
                    Create Account <span class="ml-1 text-[10px] bg-amber-100 text-amber-800 font-bold px-1.5 py-0.5 rounded-full">+10 Coins</span>
                </button>
            </div>
        </div>

        <!-- Forms Container -->
        <div class="p-8 pt-2">
            <!-- Login Form -->
            <form id="loginForm" method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf
                <!-- Honeypot Bot Trap -->
                <input type="text" name="website_hp" class="hidden" tabindex="-1" autocomplete="off">

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email, Phone (+91) or Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </span>
                        <input type="text" name="login_id" required placeholder="e.g. 9495249224 or name@domain.com" class="w-full pl-9 pr-3 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-purple-600 focus:ring-2 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-semibold text-slate-700">Password</label>
                        <a href="javascript:void(0)" onclick="alert('Please contact support or sign up with your registered phone/email.')" class="text-[11px] font-medium text-purple-600 hover:underline">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </span>
                        <input type="password" name="password" required placeholder="••••••••" class="w-full pl-9 pr-3 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-purple-600 focus:ring-2 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" value="1" checked class="w-4 h-4 rounded text-purple-600 focus:ring-purple-500 border-slate-300">
                        <span class="text-xs text-slate-600 font-medium">Remember me</span>
                    </label>
                    <span class="inline-flex items-center gap-1 text-[11px] text-emerald-600 font-semibold bg-emerald-50 px-2 py-0.5 rounded-md">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Protected Login
                    </span>
                </div>

                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold text-sm shadow-lg shadow-purple-500/25 transition transform active:scale-[0.99] flex items-center justify-center gap-2">
                    <span>Sign In to Zity</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <!-- Register Form -->
            <form id="registerForm" method="POST" action="{{ route('register.post') }}" class="space-y-3.5 hidden">
                @csrf
                <input type="text" name="website_hp" class="hidden" tabindex="-1" autocomplete="off">

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Your Full Name</label>
                    <input type="text" name="name" required placeholder="e.g. Sait K" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-purple-600 focus:ring-2 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address</label>
                    <input type="email" name="email" required placeholder="sait@example.com" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 focus:border-purple-600 focus:ring-2 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Mobile Number (Optional)</label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-xs font-semibold text-slate-600 bg-slate-100 border border-r-0 border-slate-200 rounded-l-xl">+91</span>
                        <input type="tel" name="phone" placeholder="9495249224" class="w-full px-3 py-2.5 text-sm rounded-r-xl border border-slate-200 focus:border-purple-600 focus:ring-2 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                        <input type="password" name="password" required placeholder="Min 6 chars" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:border-purple-600 focus:ring-2 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Confirm</label>
                        <input type="password" name="password_confirmation" required placeholder="Confirm" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 focus:border-purple-600 focus:ring-2 focus:ring-purple-100 outline-none transition bg-slate-50/50">
                    </div>
                </div>

                <div class="p-2.5 bg-amber-50 rounded-xl border border-amber-200 flex items-center gap-2">
                    <span class="text-xl">🎁</span>
                    <p class="text-[11px] text-amber-900 font-medium">Get <strong>10 Instant Zity Coins</strong> on sign up to unlock hot local deals!</p>
                </div>

                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold text-sm shadow-lg shadow-purple-500/25 transition transform active:scale-[0.99] flex items-center justify-center gap-2">
                    <span>Create Account & Get 10 Coins</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-4">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
                <div class="relative flex justify-center text-xs"><span class="bg-white px-3 text-slate-400 uppercase font-semibold text-[10px] tracking-wider">or continue with</span></div>
            </div>

            <!-- Social / Quick Options -->
            <div class="grid grid-cols-3 gap-2">
                <button type="button" onclick="alert('Google Sign-In ready. Please enter email & password above.')" class="flex items-center justify-center py-2 px-3 border border-slate-200 rounded-xl hover:bg-slate-50 transition text-slate-700 font-medium text-xs gap-1.5 shadow-sm">
                    <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.7l3.1-3.1C17.3 1.8 14.8 1 12 1 7.5 1 3.7 3.6 1.9 7.3l3.7 2.9C6.5 7.3 9 5 12 5z"/><path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.6-.2-2.3H12v4.6h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.9z"/><path fill="#FBBC05" d="M5.6 14.8c-.2-.7-.4-1.5-.4-2.3 0-.8.2-1.6.4-2.3L1.9 7.3C.7 9.7 0 12.3 0 15s.7 5.3 1.9 7.7l3.7-2.9z"/><path fill="#34A853" d="M12 24c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3 0-5.5-2.3-6.4-5.2L1.9 17C3.7 20.7 7.5 23.3 12 23.3z"/></svg>
                    Google
                </button>
                <button type="button" onclick="alert('Facebook Login ready. Please enter email & password above.')" class="flex items-center justify-center py-2 px-3 border border-slate-200 rounded-xl hover:bg-slate-50 transition text-slate-700 font-medium text-xs gap-1.5 shadow-sm">
                    <svg class="w-4 h-4 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
                </button>
                <button type="button" onclick="closeAuthModal()" class="flex items-center justify-center py-2 px-3 border border-purple-200 bg-purple-50/50 hover:bg-purple-100/70 rounded-xl transition text-purple-700 font-semibold text-xs gap-1 shadow-sm">
                    👉 Guest
                </button>
            </div>

            <!-- Guest Action Button -->
            <div class="mt-4 text-center">
                <button type="button" onclick="closeAuthModal()" class="text-xs text-slate-500 hover:text-purple-700 font-medium inline-flex items-center gap-1 transition">
                    <span>Continue browsing as Guest</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            <p class="text-[10px] text-center text-slate-400 mt-3 leading-relaxed">
                By continuing, you agree to Zity's <a href="#" class="underline hover:text-slate-600">Terms & Conditions</a> and <a href="#" class="underline hover:text-slate-600">Privacy Policy</a>.
            </p>
        </div>
    </div>
</div>

<script>
function openAuthModal(mode = 'login') {
    const modal = document.getElementById('authModal');
    const container = document.getElementById('authModalContainer');
    if (!modal) return;
    
    switchAuthTab(mode);
    modal.classList.remove('opacity-0', 'pointer-events-none');
    container.classList.remove('scale-95');
    container.classList.add('scale-100');
    document.body.style.overflow = 'hidden';
}

function closeAuthModal() {
    const modal = document.getElementById('authModal');
    const container = document.getElementById('authModalContainer');
    if (!modal) return;

    modal.classList.add('opacity-0', 'pointer-events-none');
    container.classList.remove('scale-100');
    container.classList.add('scale-95');
    document.body.style.overflow = '';
}

function switchAuthTab(tab) {
    const loginForm = document.getElementById('loginForm');
    const regForm = document.getElementById('registerForm');
    const tabLoginBtn = document.getElementById('tabLoginBtn');
    const tabRegisterBtn = document.getElementById('tabRegisterBtn');
    const title = document.getElementById('authModalTitle');

    if (tab === 'login') {
        loginForm.classList.remove('hidden');
        regForm.classList.add('hidden');
        tabLoginBtn.className = "flex-1 py-2 text-xs font-semibold rounded-lg transition bg-white text-purple-700 shadow-sm";
        tabRegisterBtn.className = "flex-1 py-2 text-xs font-semibold rounded-lg text-slate-600 hover:text-slate-900 transition";
        if (title) title.innerText = "Welcome back to Zity";
    } else {
        loginForm.classList.add('hidden');
        regForm.classList.remove('hidden');
        tabRegisterBtn.className = "flex-1 py-2 text-xs font-semibold rounded-lg transition bg-white text-purple-700 shadow-sm";
        tabLoginBtn.className = "flex-1 py-2 text-xs font-semibold rounded-lg text-slate-600 hover:text-slate-900 transition";
        if (title) title.innerText = "Join Zity & Start Saving";
    }
}
</script>
