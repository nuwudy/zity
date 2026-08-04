<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congratulations! Your Shop is Live! — Zity.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .gradient-text { background: linear-gradient(135deg, #4F46E5 0%, #9333EA 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6 sm:p-12 relative overflow-hidden">
    
    <!-- Background Decor -->
    <div class="absolute top-0 left-0 w-full h-full -z-10 opacity-30">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-200 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-200 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-xl w-full glass rounded-[3rem] p-10 text-center shadow-2xl relative">
        <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center text-white mx-auto mb-8 shadow-xl shadow-green-200 animate-bounce">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>

        <h1 class="text-4xl font-bold mb-4">You’re Official! 🎉</h1>
        <p class="text-gray-500 mb-10">We've launched your digital storefront for **{{ $business->name }}**. It's time to show the world!</p>

        <div class="space-y-6 mb-12">
            <div class="p-6 bg-white rounded-3xl border-2 border-indigo-50 text-left shadow-sm hover:shadow-md transition-all">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Professional Business Link</p>
                <div class="flex items-center justify-between">
                    <span class="text-indigo-600 font-bold truncate">{{ $business->getUrl() }}</span>
                    <button onclick="copyToClipboard('{{ $business->getUrl() }}')" class="p-2 hover:bg-indigo-50 rounded-lg text-indigo-400 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                    </button>
                </div>
                <p class="mt-2 text-[10px] text-gray-400 font-medium">* This link looks premium and is your official brand URL.</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <a href="{{ $business->getUrl() }}" class="w-full py-5 bg-indigo-600 text-white rounded-[2rem] font-bold text-lg hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 flex items-center justify-center space-x-2">
                <span>Visit Shop</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
            <a href="/admin" class="w-full py-5 bg-white text-gray-600 rounded-[2rem] font-bold text-lg border-2 border-slate-100 hover:bg-slate-50 transition-all text-center">
                Dashboard
            </a>
        </div>

        <p class="mt-8 text-xs text-gray-400 font-bold uppercase tracking-widest">Share with your first customer</p>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text);
            alert('URL copied to clipboard!');
        }
    </script>
</body>
</html>
