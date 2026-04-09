<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — LogiTrack</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-4 font-sans border-t-4 border-blue-600">

    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-10 flex flex-col items-center">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-600/20 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h1 class="text-3xl font-black text-blue-600 tracking-tighter italic leading-none">LOGITRACK</h1>
            <p class="text-[10px] text-slate-500 font-bold tracking-widest uppercase mt-1">Sistem Logistik Terpadu</p>
        </div>

        {{-- Login Card --}}
        <div class="bg-white border border-slate-200 rounded-3xl p-8 sm:p-10 shadow-2xl shadow-slate-200/50">
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Login Admin</h2>
                <p class="text-sm text-slate-500 mt-2 font-medium">Masuk untuk mengelola sistem logistik</p>
            </div>

            @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-3">
                <div class="bg-red-100 p-1.5 rounded-lg shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                {{ $errors->first('email') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5 text-left">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-900 text-sm font-bold placeholder-slate-400 focus:bg-white focus:ring-0 focus:border-blue-600 outline-none transition-all"
                            placeholder="admin@apm.com">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                        </div>
                        <input type="password" name="password" required
                            class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-900 text-sm font-bold placeholder-slate-400 focus:bg-white focus:ring-0 focus:border-blue-600 outline-none transition-all"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="remember" class="w-5 h-5 rounded border-2 border-slate-300 text-blue-600 focus:ring-blue-600 transition-all cursor-pointer">
                        </div>
                        <span class="text-sm text-slate-600 font-medium group-hover:text-slate-900 transition-colors">Ingat saya</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full py-4 mt-4 bg-blue-600 text-white rounded-xl font-black text-sm tracking-widest shadow-lg shadow-blue-600/30 hover:bg-blue-700 hover:shadow-blue-600/40 transition-all active:scale-[0.98] flex items-center justify-center gap-2 uppercase">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                    Masuk Sekarang
                </button>
            </form>
        </div>

        <div class="text-center mt-10 text-slate-500">
            <a href="{{ route('public.landing') }}" class="inline-flex items-center justify-center gap-2 text-xs font-bold hover:text-blue-600 transition-colors uppercase tracking-widest group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali ke Beranda
            </a>
        </div>
        
        <p class="text-center text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-8">
            &copy; {{ date('Y') }} LOGITRACK. ALL RIGHTS RESERVED.
        </p>
    </div>
    
</body>
</html>
