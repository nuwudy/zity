@if(session('new_user_welcome') || request()->has('welcome_preview'))
<!-- New User Welcome Modal (Matching Mockup Screen 4) -->
<div id="welcomeRewardModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-md transition-all duration-300">
    <div class="relative w-full max-w-sm bg-white rounded-3xl p-8 text-center shadow-2xl overflow-hidden transform scale-100 animate-in fade-in zoom-in-95 duration-300 border border-purple-100">
        <!-- Close Button -->
        <button onclick="closeWelcomeModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <!-- Confetti / Celebration Header -->
        <div class="relative mb-6">
            <div class="w-24 h-24 mx-auto relative flex items-center justify-center">
                <!-- Glowing Aura -->
                <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-amber-400 to-purple-500 blur-xl opacity-40 animate-pulse"></div>
                <!-- Gift Box Graphic -->
                <div class="relative text-6xl">
                    🎁
                </div>
                <!-- Floating Coins -->
                <span class="absolute -top-1 -right-2 text-2xl animate-bounce">🪙</span>
                <span class="absolute bottom-1 -left-2 text-2xl animate-bounce" style="animation-delay: 0.2s">🪙</span>
            </div>
            <div class="inline-flex items-center gap-1.5 text-xs font-bold text-purple-700 bg-purple-100 px-3 py-1 rounded-full mt-3">
                🎉 WELCOME TO ZITY!
            </div>
        </div>

        <h3 class="text-xl font-extrabold text-slate-900 mb-1">You earned</h3>

        <!-- Big Coins Display -->
        <div class="inline-flex items-center justify-center gap-2 py-3 px-6 my-2 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl shadow-inner">
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-amber-500 to-orange-500 flex items-center justify-center text-white font-black text-xl shadow-md">
                Z
            </div>
            <div class="text-left">
                <span class="text-3xl font-black text-amber-600 leading-none">10</span>
                <span class="block text-[11px] font-bold text-amber-800 uppercase tracking-wider -mt-0.5">Zity Coins</span>
            </div>
        </div>

        <p class="text-xs text-slate-600 font-medium mt-3 px-2">
            Complete your profile details and earn <strong class="text-purple-700 font-bold">5 more coins</strong>!
        </p>

        <!-- Actions -->
        <div class="space-y-2.5 mt-6">
            <a href="{{ route('profile.index') }}" class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold text-sm shadow-xl shadow-purple-500/25 transition transform active:scale-95 block">
                Complete Profile (+5 Coins)
            </a>
            <button onclick="closeWelcomeModal()" class="w-full py-3 px-4 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                Explore Zity Deals
            </button>
        </div>
    </div>
</div>

<script>
function closeWelcomeModal() {
    const modal = document.getElementById('welcomeRewardModal');
    if (modal) {
        modal.classList.add('opacity-0', 'pointer-events-none');
        setTimeout(() => modal.remove(), 300);
    }
}
</script>
@endif
