<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LogiTrack — Lacak Kiriman Anda</title>
    <meta name="description" content="Lacak pengiriman paket Anda secara real-time dengan LogiTrack.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans" x-data="{ previewImage: null }">

    {{-- Header --}}
    <header class="bg-white border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div class="leading-none">
                    <h1 class="text-2xl font-black text-blue-600 tracking-tighter italic">LOGITRACK</h1>
                    <p class="text-[10px] text-slate-500 font-bold tracking-widest uppercase">Sistem Logistik Terpadu</p>
                </div>
            </div>
        </div>
    </header>

    {{-- Hero / Search --}}
    @if(!isset($order) || !$order)
    <section class="py-20 bg-slate-50 border-b border-slate-100">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h2 class="text-4xl font-black text-slate-900 mb-4 tracking-tight">Lacak Kiriman Anda</h2>
            <p class="text-slate-500 mb-10 text-lg">Masukkan nomor resi untuk mengetahui status pengiriman paket secara real-time.</p>

            <form action="{{ route('public.track') }}" method="POST" class="relative">
                @csrf
                <input type="text" name="resi" placeholder="Masukkan Nomor Resi (Contoh: JP1234567890)"
                    class="w-full pl-14 pr-36 py-6 rounded-2xl bg-white border-2 border-slate-200 focus:border-blue-600 outline-none shadow-2xl shadow-blue-900/5 text-xl font-bold transition-all"
                    value="{{ $resi ?? '' }}">
                <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-xl font-black transition-all">CEK RESI</button>
            </form>
        </div>
    </section>
    @endif

    {{-- Tracking Result (Light Theme) --}}
    @if(isset($order) && $order)
    <section class="bg-white py-12 min-h-[calc(100vh-80px)]">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <a href="{{ route('public.landing') }}" class="text-slate-500 hover:text-blue-600 flex items-center gap-2 font-bold transition-colors">
                    <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg> Kembali ke Pencarian
                </a>
            </div>

            {{-- Pengiriman Header --}}
            <div class="bg-blue-600 px-4 py-2 text-white font-bold text-sm mb-0 rounded-t-lg">Pengiriman</div>

            {{-- Main Info --}}
            <div class="overflow-x-auto mb-6 border border-slate-200 border-t-0 rounded-b-lg">
                <table class="w-full border-collapse text-slate-700 text-xs">
                    <thead><tr class="bg-slate-50 text-slate-500">
                        <th class="border-b border-t border-slate-200 p-3 text-left font-bold uppercase tracking-wider">No. AWB</th>
                        <th class="border-b border-t border-slate-200 p-3 text-left font-bold uppercase tracking-wider">No. Reff</th>
                        <th class="border-b border-t border-slate-200 p-3 text-left font-bold uppercase tracking-wider">Tanggal Pengiriman</th>
                        <th class="border-b border-t border-slate-200 p-3 text-left font-bold uppercase tracking-wider">Asal</th>
                        <th class="border-b border-t border-slate-200 p-3 text-left font-bold uppercase tracking-wider">Tujuan</th>
                    </tr></thead>
                    <tbody><tr>
                        <td class="border-slate-200 p-3 font-bold text-slate-800">{{ $order->resi }}</td>
                        <td class="border-slate-200 p-3 font-medium">{{ $order->reff_no ?: '-' }}</td>
                        <td class="border-slate-200 p-3 font-medium">{{ $order->created_at->format('Y-m-d') }}</td>
                        <td class="border-slate-200 p-3 font-medium uppercase">{{ $order->sender_city }} ({{ $order->sender_postal_code }})</td>
                        <td class="border-slate-200 p-3 font-medium uppercase">{{ $order->receiver_city }} ({{ $order->receiver_postal_code }})</td>
                    </tr></tbody>
                </table>
            </div>

            {{-- Service Info --}}
            <div class="overflow-x-auto mb-6 border border-slate-200 rounded-lg">
                <table class="w-full border-collapse text-slate-700 text-xs">
                    <thead><tr class="bg-slate-50 text-slate-500">
                        <th class="border-b border-slate-200 p-3 text-left font-bold uppercase tracking-wider">Servis</th>
                        <th class="border-b border-slate-200 p-3 text-left font-bold uppercase tracking-wider">Tipe</th>
                        <th class="border-b border-slate-200 p-3 text-left font-bold uppercase tracking-wider">Koli</th>
                        <th class="border-b border-slate-200 p-3 text-left font-bold uppercase tracking-wider">Berat</th>
                        <th class="border-b border-slate-200 p-3 text-left font-bold uppercase tracking-wider">Harga</th>
                    </tr></thead>
                    <tbody><tr>
                        <td class="border-slate-200 p-3 font-bold">LTL</td>
                        <td class="border-slate-200 p-3 font-medium">PAKET</td>
                        <td class="border-slate-200 p-3 font-medium">{{ $order->koli }}</td>
                        <td class="border-slate-200 p-3 font-medium">{{ number_format($order->weight, 2) }} KG</td>
                        <td class="border-slate-200 p-3 font-bold text-blue-600">Rp {{ number_format($order->total_shipping, 0, ',', '.') }}</td>
                    </tr></tbody>
                </table>
            </div>

            {{-- Sender/Receiver --}}
            @php
                $maskName = function($name) {
                    if (strlen($name) <= 2) return $name;
                    return $name[0] . str_repeat('*', strlen($name) - 2) . $name[strlen($name) - 1];
                };
            @endphp
            <div class="overflow-x-auto mb-10 border border-slate-200 rounded-lg">
                <table class="w-full border-collapse text-slate-700 text-xs">
                    <thead><tr class="bg-slate-50 text-slate-500">
                        <th class="border-b border-slate-200 p-3 text-left font-bold uppercase tracking-wider w-1/2">Pengirim</th>
                        <th class="border-b border-slate-200 p-3 text-left font-bold uppercase tracking-wider w-1/2">Penerima</th>
                    </tr></thead>
                    <tbody><tr>
                        <td class="border-slate-200 p-3 font-bold">{{ $maskName($order->sender_name) }}</td>
                        <td class="border-slate-200 p-3 font-bold">{{ $maskName($order->receiver_name) }}</td>
                    </tr></tbody>
                </table>
            </div>

            {{-- Status Penerima --}}
            <div class="bg-blue-600 px-4 py-2 text-white font-bold text-sm mb-0 rounded-t-lg">Status Penerima</div>
            @php $lastLog = $order->trackingLogs->last(); @endphp
            <div class="overflow-x-auto mb-12 border border-slate-200 border-t-0 rounded-b-lg">
                <table class="w-full border-collapse text-slate-700 text-xs">
                    <thead><tr class="bg-slate-50 text-slate-500">
                        <th class="border-b border-slate-200 p-3 text-left font-bold uppercase tracking-wider">Status Pengiriman</th>
                        <th class="border-b border-slate-200 p-3 text-left font-bold uppercase tracking-wider">Nama Penerima</th>
                        <th class="border-b border-slate-200 p-3 text-left font-bold uppercase tracking-wider">Tanggal Diterima</th>
                        <th class="border-b border-slate-200 p-3 text-left font-bold uppercase tracking-wider">Waktu Diterima</th>
                        <th class="border-b border-slate-200 p-3 text-left font-bold uppercase tracking-wider">Perantara Penerima</th>
                    </tr></thead>
                    <tbody><tr>
                        <td class="border-slate-200 p-3 font-bold text-emerald-600">{{ $order->current_status === 'Delivered' ? 'TERKIRIM' : strtoupper($order->current_status) }}</td>
                        <td class="border-slate-200 p-3 font-medium">{{ $order->pod_receiver_name ?: '-' }}</td>
                        <td class="border-slate-200 p-3 font-medium">{{ $order->current_status === 'Delivered' && $lastLog ? $lastLog->logged_at->format('Y-m-d') : '-' }}</td>
                        <td class="border-slate-200 p-3 font-medium">{{ $order->current_status === 'Delivered' && $lastLog ? $lastLog->logged_at->format('H:i:s') : '-' }}</td>
                        <td class="border-slate-200 p-3 font-medium uppercase">{{ $order->current_status === 'Delivered' ? 'KARYAWAN' : '-' }}</td>
                    </tr></tbody>
                </table>
            </div>

            {{-- Riwayat Pengiriman --}}
            <div class="text-center mb-10">
                <h3 class="text-slate-900 text-xl font-bold">Riwayat Pengiriman</h3>
            </div>

            {{-- Progress Stepper --}}
            @php
                $steps = [
                    ['label' => 'DITERIMA CABANG', 'statuses' => ['Picked Up', 'At Drop Point']],
                    ['label' => 'SEDANG PROSES', 'statuses' => ['In Transit']],
                    ['label' => 'PROSES PENGIRIMAN', 'statuses' => ['Arrived at Gateway', 'Out for Delivery']],
                    ['label' => 'SAMPAI DITUJUAN', 'statuses' => ['Delivered']],
                ];
                $logStatuses = $order->trackingLogs->pluck('status')->toArray();
                $lastCompletedIndex = -1;
                foreach ($steps as $i => $step) {
                    if (count(array_intersect($step['statuses'], $logStatuses)) > 0) {
                        $lastCompletedIndex = $i;
                    }
                }
            @endphp
            <div class="relative flex w-full mb-20 px-4">
                @foreach($steps as $i => $step)
                    @php $isCompleted = count(array_intersect($step['statuses'], $logStatuses)) > 0; @endphp
                    <div class="flex-1 relative">
                        <div class="h-2 w-full transition-colors duration-500 {{ $isCompleted ? 'bg-emerald-500' : 'bg-slate-200' }} {{ $i === 0 ? 'rounded-l-full' : '' }} {{ $i === count($steps)-1 ? 'rounded-r-full' : '' }}"></div>
                        <div class="absolute top-4 left-1/2 -translate-x-1/2 text-center w-full">
                            <p class="text-[10px] font-black tracking-widest {{ $isCompleted ? 'text-emerald-600' : 'text-slate-400' }}">{{ $step['label'] }}</p>
                        </div>
                        @if($i === $lastCompletedIndex)
                            <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-4 h-4 bg-white border-2 border-emerald-500 rounded-full shadow-lg shadow-emerald-500/50 animate-pulse"></div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Detailed Logs --}}
            <div class="max-w-3xl mx-auto space-y-4">
                @foreach($order->trackingLogs->sortByDesc('logged_at')->values() as $i => $log)
                <div class="flex gap-4 items-start">
                    <div class="w-24 text-right pt-1">
                        <p class="text-[10px] font-bold text-slate-500">{{ $log->logged_at->format('Y-m-d') }}</p>
                        <p class="text-[10px] font-bold text-slate-400">{{ $log->logged_at->format('H:i:s') }}</p>
                    </div>
                    <div class="relative pb-6">
                        <div class="absolute left-0 top-2 bottom-0 w-px bg-slate-200"></div>
                        <div class="absolute -left-1.5 top-1.5 w-3 h-3 rounded-full border-2 border-white {{ $i === 0 ? 'bg-emerald-500 shadow-md shadow-emerald-500/40' : 'bg-slate-300' }}"></div>
                    </div>
                    <div class="flex-1 pb-6">
                        <p class="text-sm font-bold {{ $i === 0 ? 'text-slate-900' : 'text-slate-500' }}">{{ $log->description }}</p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider mt-1">{{ $log->location }}</p>
                        @if($log->image)
                            <div class="mt-3 rounded-xl overflow-hidden border border-slate-200 max-w-xs shadow-sm shadow-slate-200">
                                <button type="button" @click="previewImage = @js(asset('storage/' . $log->image))" class="block group w-full" title="Klik untuk melihat gambar">
                                    <img src="{{ asset('storage/' . $log->image) }}" alt="Bukti Log" class="w-full h-auto object-cover transition-opacity duration-200 group-hover:opacity-90 cursor-zoom-in">
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Footer --}}
    <footer class="bg-slate-900 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="space-y-6">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h1 class="text-2xl font-black tracking-tighter italic leading-none">LOGITRACK</h1>
                </div>
                <p class="text-slate-400 text-sm leading-relaxed">Solusi logistik terpercaya untuk pengiriman domestik dan internasional dengan jangkauan terluas di Indonesia.</p>
            </div>
            <div>
                <h4 class="font-bold mb-6 uppercase tracking-widest text-xs text-blue-500">Layanan</h4>
                <ul class="space-y-4 text-sm text-slate-400 font-medium">
                    <li class="hover:text-white cursor-pointer">Express Delivery</li>
                    <li class="hover:text-white cursor-pointer">Cargo Service</li>
                    <li class="hover:text-white cursor-pointer">Warehouse Solutions</li>
                    <li class="hover:text-white cursor-pointer">Supply Chain</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6 uppercase tracking-widest text-xs text-blue-500">Perusahaan</h4>
                <ul class="space-y-4 text-sm text-slate-400 font-medium">
                    <li class="hover:text-white cursor-pointer">Tentang Kami</li>
                    <li class="hover:text-white cursor-pointer">Karir</li>
                    <li class="hover:text-white cursor-pointer">Berita</li>
                    <li class="hover:text-white cursor-pointer">Kontak</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6 uppercase tracking-widest text-xs text-blue-500">Hubungi Kami</h4>
                <ul class="space-y-4 text-sm text-slate-400 font-medium">
                    <li class="flex items-center gap-3">📞 1500-123</li>
                    <li class="flex items-center gap-3">✉️ info@logitrack.com</li>
                    <li class="flex items-center gap-3">🌐 www.logitrack.com</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 mt-20 pt-8 border-t border-slate-800 text-center text-slate-500 text-xs font-bold uppercase tracking-widest">
            © 2026 LOGITRACK. ALL RIGHTS RESERVED.
        </div>
    </footer>

    <div x-show="previewImage" x-transition.opacity class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-sm p-4 flex items-center justify-center" @click.self="previewImage = null" @keydown.escape.window="previewImage = null">
        <div class="relative w-full max-w-4xl bg-white rounded-2xl p-3 sm:p-4 shadow-2xl border border-slate-200">
            <button type="button" @click="previewImage = null" class="absolute -top-3 -right-3 w-9 h-9 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-50 shadow-sm flex items-center justify-center" aria-label="Tutup preview gambar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <img :src="previewImage" alt="Preview Foto" class="w-full max-h-[80vh] object-contain rounded-xl bg-slate-50">
        </div>
    </div>

    {{-- Admin Login --}}
    <a href="{{ route('admin.orders.create') }}" class="fixed bottom-4 left-4 z-[100] bg-white/10 hover:bg-white/20 text-white/20 hover:text-white/50 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all backdrop-blur-sm border border-white/5">Admin Login</a>
</body>
</html>
