<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LogiTrack Admin')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900" x-data>

    {{-- Sidebar --}}
    <aside class="fixed left-0 top-0 bottom-0 w-20 md:w-64 bg-white border-r border-slate-200 z-50 flex flex-col">
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <span class="hidden md:block font-black text-xl tracking-tighter italic text-blue-600">LOGITRACK</span>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-2">
            @php
                $navItems = [
                    ['route' => 'admin.orders.create', 'icon' => 'plus', 'label' => 'Buat Order'],
                    ['route' => 'admin.senders.index', 'icon' => 'users', 'label' => 'Data Pengirim'],
                    ['route' => 'admin.receivers.index', 'icon' => 'user-check', 'label' => 'Data Penerima'],
                    ['route' => 'admin.billing.index', 'icon' => 'credit-card', 'label' => 'Data Tagihan'],
                    ['route' => 'admin.courier.index', 'icon' => 'truck', 'label' => 'Kurir App'],
                    ['route' => 'admin.users.index', 'icon' => 'shield', 'label' => 'Master User'],
                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all group
                    {{ request()->routeIs($item['route'].'*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-800' }}">
                    @include('components.icons.' . $item['icon'])
                    <span class="hidden md:block">{{ $item['label'] }}</span>
                </a>
            @endforeach

            <a href="{{ route('public.landing') }}"
               class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition-all group">
                @include('components.icons.globe')
                <span class="hidden md:block">Landing Page</span>
            </a>
        </nav>

        <div class="p-4 border-t border-slate-100 space-y-2">
            <div class="hidden md:flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                <div class="w-8 h-8 rounded-full flex items-center justify-center font-black text-xs bg-blue-100 text-blue-700">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-xs font-bold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hidden md:flex w-full items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-red-500 hover:bg-red-50 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="ml-20 md:ml-64 p-4 md:p-8">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">@yield('page-title')</h1>
                <p class="text-slate-500 text-sm">Sistem Logistik Terpadu LogiTrack</p>
            </div>
            <div class="flex items-center gap-4">
                <button class="p-2 rounded-full bg-white border border-slate-200 text-slate-400 hover:text-blue-600 transition-colors relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </button>
            </div>
        </header>

        {{-- SweetAlert Flash Messages --}}
        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'colored-toast'
                    },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            });
        </script>
        @endif
        @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error')),
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'colored-toast'
                    },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            });
        </script>
        @endif

        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
