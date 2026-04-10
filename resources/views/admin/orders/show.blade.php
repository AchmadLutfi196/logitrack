@extends('layouts.admin')
@section('title', 'Resi ' . $order->resi)
@section('page-title', 'Detail Order & Cetak Resi')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- Back Button --}}
    <a href="{{ route('admin.courier.index') }}" class="inline-flex items-center gap-2 px-4 py-2 mb-6 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Kembali ke Manajemen Pengiriman
    </a>

    @php
        $statusColors = [
            'Pending' => 'bg-slate-400', 'Picked Up' => 'bg-blue-500', 'At Drop Point' => 'bg-indigo-500',
            'In Transit' => 'bg-amber-500', 'Arrived at Gateway' => 'bg-purple-500',
            'Out for Delivery' => 'bg-orange-500', 'Delivered' => 'bg-emerald-500', 'Failed' => 'bg-red-500',
        ];
        $statusBg = [
            'Pending' => 'bg-slate-50 border-slate-200', 'Picked Up' => 'bg-blue-50 border-blue-200', 'At Drop Point' => 'bg-indigo-50 border-indigo-200',
            'In Transit' => 'bg-amber-50 border-amber-200', 'Arrived at Gateway' => 'bg-purple-50 border-purple-200',
            'Out for Delivery' => 'bg-orange-50 border-orange-200', 'Delivered' => 'bg-emerald-50 border-emerald-200', 'Failed' => 'bg-red-50 border-red-200',
        ];
        $statusIcons = [
            'Pending' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            'Picked Up' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>',
            'At Drop Point' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>',
            'In Transit' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.079-.504 1.079-1.125V7.5c0-.621-.504-1.125-1.125-1.125H14.25M8.25 18.75V6.375c0-.621.504-1.125 1.125-1.125h4.875"/></svg>',
            'Arrived at Gateway' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21"/></svg>',
            'Out for Delivery' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>',
            'Delivered' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            'Failed' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        ];
    @endphp

    {{-- ===== ROW 1: RESI HEADER ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Nomor Resi</p>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight font-mono">{{ $order->resi }}</h2>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-400 font-medium">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</span>
                <div class="px-5 py-2 rounded-xl text-white text-xs font-black shadow-lg uppercase tracking-wider {{ $statusColors[$order->current_status] ?? 'bg-slate-400' }}">
                    {{ $order->current_status }}
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

        {{-- ===== LEFT: INFO & TRACKING (3 cols) ===== --}}
        <div class="xl:col-span-3 space-y-6">

            {{-- Pengirim & Penerima --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Pengirim --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-5 py-3 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                        <h3 class="text-xs font-black text-slate-700 uppercase tracking-wider">Pengirim</h3>
                    </div>
                    <div class="p-5">
                        <p class="text-sm font-bold text-slate-900">{{ $order->sender_name }}</p>
                        <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            {{ $order->sender_phone }}
                        </p>
                        <hr class="my-3 border-slate-100">
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $order->sender_address }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $order->sender_village }}, {{ $order->sender_district }}</p>
                        <p class="text-xs text-slate-500">{{ $order->sender_city }}, {{ $order->sender_province }}</p>
                        <span class="inline-block mt-2 px-2 py-0.5 bg-slate-100 rounded-md text-[10px] font-bold text-slate-600">{{ $order->sender_postal_code }}</span>
                    </div>
                </div>

                {{-- Penerima --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-5 py-3 border-b border-slate-100 bg-gradient-to-r from-red-50 to-white flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-red-500 text-white flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        </span>
                        <h3 class="text-xs font-black text-slate-700 uppercase tracking-wider">Penerima</h3>
                    </div>
                    <div class="p-5">
                        <p class="text-sm font-bold text-slate-900">{{ $order->receiver_name }}</p>
                        <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                            {{ $order->receiver_phone }}
                        </p>
                        <hr class="my-3 border-slate-100">
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $order->receiver_address }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $order->receiver_village }}, {{ $order->receiver_district }}</p>
                        <p class="text-xs text-slate-500">{{ $order->receiver_city }}, {{ $order->receiver_province }}</p>
                        <span class="inline-block mt-2 px-2 py-0.5 bg-slate-100 rounded-md text-[10px] font-bold text-slate-600">{{ $order->receiver_postal_code }}</span>
                    </div>
                </div>
            </div>

            {{-- Detail Paket & Biaya --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-5 py-3 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-white flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-amber-500 text-white flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </span>
                    <h3 class="text-xs font-black text-slate-700 uppercase tracking-wider">Detail Paket</h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="bg-slate-50 rounded-xl p-3 text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Berat</p>
                            <p class="text-lg font-black text-slate-800 mt-1">{{ number_format($order->weight, 1) }}</p>
                            <p class="text-[10px] text-slate-400">KG</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3 text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Koli</p>
                            <p class="text-lg font-black text-slate-800 mt-1">{{ $order->koli }}</p>
                            <p class="text-[10px] text-slate-400">Paket</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3 text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Dimensi</p>
                            <p class="text-lg font-black text-slate-800 mt-1">
                                @if($order->length && $order->width && $order->height)
                                    <span class="text-sm">{{ $order->length }}×{{ $order->width }}×{{ $order->height }}</span>
                                @else
                                    <span class="text-slate-300">—</span>
                                @endif
                            </p>
                            <p class="text-[10px] text-slate-400">CM</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3 text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Harga/KG</p>
                            <p class="text-lg font-black text-slate-800 mt-1">{{ number_format($order->price_per_kg / 1000, 0) }}K</p>
                            <p class="text-[10px] text-slate-400">Rupiah</p>
                        </div>
                    </div>
                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl px-5 py-4 text-white shadow-lg shadow-blue-200">
                        <div class="flex items-center gap-6">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-blue-200">Pembayaran</p>
                                <p class="text-sm font-black">{{ $order->payment_method }} — {{ $order->payment_status }}</p>
                            </div>
                            @if($order->reff_no)
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-blue-200">No. Reff</p>
                                <p class="text-sm font-bold">{{ $order->reff_no }}</p>
                            </div>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-blue-200">Total Ongkir</p>
                            <p class="text-2xl font-black">Rp {{ number_format($order->total_shipping, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tracking Timeline --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-5 py-3 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-white flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-500 text-white flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <h3 class="text-xs font-black text-slate-700 uppercase tracking-wider">Riwayat Tracking</h3>
                    <span class="ml-auto text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">{{ $order->trackingLogs->count() }} log</span>
                </div>
                <div class="p-5">
                    <div class="relative">
                        {{-- Timeline line --}}
                        <div class="absolute left-[15px] top-2 bottom-2 w-0.5 bg-slate-100"></div>

                        <div class="space-y-0">
                            @foreach($order->trackingLogs->sortByDesc('logged_at')->values() as $i => $log)
                            <div class="relative flex gap-4 pb-6 last:pb-0">
                                {{-- Timeline dot --}}
                                <div class="relative z-10 shrink-0 w-[31px] flex justify-center">
                                    <div class="w-[31px] h-[31px] rounded-full flex items-center justify-center {{ $i === 0 ? ($statusColors[$log->status] ?? 'bg-slate-400') . ' text-white shadow-md' : 'bg-white border-2 border-slate-200 text-slate-400' }}">
                                        {!! $statusIcons[$log->status] ?? '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/></svg>' !!}
                                    </div>
                                </div>
                                {{-- Content --}}
                                <div class="flex-1 min-w-0 pt-1">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <p class="text-sm font-bold {{ $i === 0 ? 'text-slate-900' : 'text-slate-600' }}">{{ $log->description }}</p>
                                            <p class="text-[10px] text-slate-400 font-medium mt-0.5">{{ $log->location }} • {{ $log->updated_by }}</p>
                                        </div>
                                        <span class="text-[10px] text-slate-400 font-medium whitespace-nowrap shrink-0">{{ $log->logged_at->translatedFormat('d M, H:i') }}</span>
                                    </div>
                                    @if($log->image)
                                    <div class="mt-2 rounded-lg overflow-hidden border border-slate-100 max-w-[200px]">
                                        <img src="{{ asset('storage/' . $log->image) }}" alt="Bukti" class="w-full h-auto">
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- POD Section --}}
            @if($order->current_status === 'Delivered')
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl overflow-hidden">
                <div class="px-5 py-3 border-b border-emerald-200 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-500 text-white flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <h3 class="text-xs font-black text-emerald-800 uppercase tracking-wider">Bukti Penerimaan (POD)</h3>
                </div>
                <div class="p-5">
                    <div class="aspect-video bg-white rounded-xl border border-emerald-200 flex items-center justify-center overflow-hidden max-w-sm">
                        @if($order->pod_photo)
                            <img src="{{ asset('storage/' . $order->pod_photo) }}" alt="POD" class="w-full h-full object-cover">
                        @else
                            <div class="text-emerald-300 text-center p-4"><p class="text-xs">Foto belum tersedia</p></div>
                        @endif
                    </div>
                    @if($order->pod_receiver_name)
                    <p class="mt-3 text-xs text-emerald-700 font-medium">Diterima oleh: <span class="font-bold">{{ $order->pod_receiver_name }}</span></p>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- ===== RIGHT: LABEL RESI (2 cols) ===== --}}
        <div class="xl:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-slate-800 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                    Label Resi
                </h3>
                <button onclick="printLabel()" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-900 transition-all active:scale-95 shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6z"/></svg>
                    Cetak
                </button>
            </div>

            {{-- AWB Label --}}
            <div class="bg-white border-2 border-slate-900 mx-auto relative overflow-hidden rounded-lg" id="awb-label">
                {{-- Header --}}
                <div class="flex justify-between items-center px-5 py-3 border-b-2 border-slate-900">
                    <div>
                        <h2 class="text-xl font-black text-slate-900 tracking-tighter italic">LOGITRACK</h2>
                        <p class="text-[8px] text-slate-500 uppercase font-bold tracking-[0.2em]">Express Delivery</p>
                    </div>
                    <div class="text-right border-l-2 border-slate-900 pl-4">
                        <p class="text-[8px] font-bold text-slate-500 uppercase tracking-wider">Pembayaran</p>
                        <p class="text-sm font-black text-slate-900">{{ strtoupper($order->payment_method) }}</p>
                    </div>
                </div>

                {{-- QR Code + Resi --}}
                <div class="flex items-center gap-4 px-5 py-4 border-b-2 border-slate-900 bg-slate-50">
                    <div id="qrcode" class="shrink-0 bg-white p-1.5 border border-slate-300 rounded"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[8px] text-slate-500 font-bold uppercase tracking-wider">No. AWB</p>
                        <p class="font-mono font-black text-lg tracking-wider text-slate-900 leading-tight break-all">{{ $order->resi }}</p>
                        <p class="text-[8px] text-slate-400 mt-1">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                {{-- Pengirim --}}
                <div class="px-5 py-3 border-b border-slate-300">
                    <p class="text-[8px] font-black text-slate-900 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                        <span class="inline-block w-1.5 h-1.5 bg-blue-600 rounded-full"></span> PENGIRIM
                    </p>
                    <p class="text-[11px] font-bold text-slate-800 leading-relaxed">{{ $order->sender_name }} — {{ $order->sender_phone }}</p>
                    <p class="text-[10px] text-slate-600 leading-relaxed mt-0.5">{{ $order->sender_address }}, {{ $order->sender_village }}, {{ $order->sender_district }}</p>
                    <p class="text-[10px] text-slate-600">{{ $order->sender_city }}, {{ $order->sender_province }} {{ $order->sender_postal_code }}</p>
                </div>

                {{-- Penerima --}}
                <div class="px-5 py-3 border-b-2 border-slate-900 bg-amber-50/50">
                    <p class="text-[8px] font-black text-slate-900 uppercase tracking-wider mb-1.5 flex items-center gap-1">
                        <span class="inline-block w-1.5 h-1.5 bg-red-500 rounded-full"></span> PENERIMA
                    </p>
                    <p class="text-[12px] font-black text-slate-900 leading-relaxed">{{ $order->receiver_name }} — {{ $order->receiver_phone }}</p>
                    <p class="text-[10px] text-slate-700 leading-relaxed font-medium mt-0.5">{{ $order->receiver_address }}, {{ $order->receiver_village }}, {{ $order->receiver_district }}</p>
                    <p class="text-[10px] text-slate-700 font-medium">{{ $order->receiver_city }}, {{ $order->receiver_province }} {{ $order->receiver_postal_code }}</p>
                </div>

                {{-- Detail Kiriman --}}
                <table class="w-full text-[10px] border-collapse">
                    <tr class="border-b border-slate-300">
                        <td class="px-4 py-2 font-bold text-slate-500 uppercase tracking-wider border-r border-slate-300 w-1/2">Berat</td>
                        <td class="px-4 py-2 font-bold text-slate-500 uppercase tracking-wider w-1/2">Koli</td>
                    </tr>
                    <tr class="border-b border-slate-300">
                        <td class="px-4 py-2 font-black text-slate-900 text-sm border-r border-slate-300">{{ number_format($order->weight, 2) }} KG</td>
                        <td class="px-4 py-2 font-black text-slate-900 text-sm">{{ $order->koli }}</td>
                    </tr>
                    <tr class="border-b border-slate-300">
                        <td class="px-4 py-2 font-bold text-slate-500 uppercase tracking-wider border-r border-slate-300">Harga / KG</td>
                        <td class="px-4 py-2 font-bold text-slate-500 uppercase tracking-wider">No. Reff</td>
                    </tr>
                    <tr class="border-b-2 border-slate-900">
                        <td class="px-4 py-2 font-black text-slate-900 text-sm border-r border-slate-300">Rp {{ number_format($order->price_per_kg, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 font-bold text-slate-700 text-sm">{{ $order->reff_no ?: '-' }}</td>
                    </tr>
                </table>

                {{-- Total Biaya --}}
                <div class="px-5 py-3 bg-slate-900 text-white flex justify-between items-center">
                    <span class="text-[9px] font-bold uppercase tracking-widest">Total Ongkos Kirim</span>
                    <span class="text-base font-black">Rp {{ number_format($order->total_shipping, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var qr = qrcode(0, 'H');
        qr.addData('{{ $order->resi }}');
        qr.make();
        document.getElementById('qrcode').innerHTML = qr.createSvgTag(3);
    });

    function printLabel() {
        var qrEl = document.getElementById('qrcode');
        var qrHtml = qrEl ? qrEl.innerHTML : '';

        var old = document.getElementById('print-iframe');
        if (old) old.remove();

        var iframe = document.createElement('iframe');
        iframe.id = 'print-iframe';
        iframe.style.cssText = 'position:fixed;width:0;height:0;border:none;left:-9999px;top:-9999px;';
        document.body.appendChild(iframe);

        var doc = iframe.contentDocument || iframe.contentWindow.document;
        doc.open();
        doc.write(`<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Label {{ $order->resi }}</title>
<style>
@page { size: 105mm 148mm; margin: 3mm; }
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: Arial, Helvetica, sans-serif; }
.label { width:99mm; border:2px solid #111; overflow:hidden; }
.header { display:flex; justify-content:space-between; align-items:center; padding:8px 12px; border-bottom:2px solid #111; }
.logo { font-size:16px; font-weight:900; font-style:italic; letter-spacing:-1px; color:#111; }
.logo-sub { font-size:7px; font-weight:700; text-transform:uppercase; letter-spacing:2px; color:#666; }
.pay-box { text-align:right; border-left:2px solid #111; padding-left:12px; }
.pay-lbl { font-size:7px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#666; }
.pay-val { font-size:13px; font-weight:900; color:#111; }
.qr-row { display:flex; align-items:center; gap:10px; padding:10px 12px; border-bottom:2px solid #111; background:#f8f8f8; }
.qr-box { flex-shrink:0; background:#fff; padding:3px; border:1px solid #ccc; }
.qr-box svg { display:block; }
.awb-lbl { font-size:7px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#666; }
.awb-num { font-family:monospace; font-size:16px; font-weight:900; letter-spacing:2px; color:#111; }
.awb-date { font-size:7px; color:#999; margin-top:2px; }
.sec { padding:8px 12px; border-bottom:1px solid #ccc; }
.sec-rcv { padding:8px 12px; border-bottom:2px solid #111; background:#fffdf5; }
.sec-title { font-size:7px; font-weight:900; text-transform:uppercase; letter-spacing:1px; color:#111; margin-bottom:3px; display:flex; align-items:center; gap:4px; }
.dot-b { width:5px; height:5px; border-radius:50%; background:#2563eb; display:inline-block; }
.dot-r { width:5px; height:5px; border-radius:50%; background:#ef4444; display:inline-block; }
.nm { font-size:10px; font-weight:800; color:#111; }
.nm-big { font-size:11px; font-weight:900; color:#111; }
.ad { font-size:8px; color:#444; line-height:1.4; }
.ad-b { font-size:8px; color:#333; font-weight:500; line-height:1.4; }
table.det { width:100%; border-collapse:collapse; }
table.det td { padding:5px 8px; font-size:8px; }
.tl { font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#666; border-bottom:1px solid #ddd; }
.tv { font-weight:900; font-size:11px; color:#111; border-bottom:1px solid #ddd; }
.tbr { border-right:1px solid #ccc; }
.ft { padding:8px 12px; background:#111; color:#fff; display:flex; justify-content:space-between; align-items:center; }
.ft-lbl { font-size:8px; font-weight:700; text-transform:uppercase; letter-spacing:2px; }
.ft-val { font-size:15px; font-weight:900; }
</style>
</head>
<body>
<div class="label">
    <div class="header">
        <div><div class="logo">LOGITRACK</div><div class="logo-sub">Express Delivery</div></div>
        <div class="pay-box"><div class="pay-lbl">Pembayaran</div><div class="pay-val">{{ strtoupper($order->payment_method) }}</div></div>
    </div>
    <div class="qr-row">
        <div class="qr-box">` + qrHtml + `</div>
        <div><div class="awb-lbl">No. AWB</div><div class="awb-num">{{ $order->resi }}</div><div class="awb-date">{{ $order->created_at->format('d/m/Y H:i') }}</div></div>
    </div>
    <div class="sec">
        <div class="sec-title"><span class="dot-b"></span> PENGIRIM</div>
        <div class="nm">{{ $order->sender_name }} — {{ $order->sender_phone }}</div>
        <div class="ad">{{ $order->sender_address }}, {{ $order->sender_village }}, {{ $order->sender_district }}</div>
        <div class="ad">{{ $order->sender_city }}, {{ $order->sender_province }} {{ $order->sender_postal_code }}</div>
    </div>
    <div class="sec-rcv">
        <div class="sec-title"><span class="dot-r"></span> PENERIMA</div>
        <div class="nm-big">{{ $order->receiver_name }} — {{ $order->receiver_phone }}</div>
        <div class="ad-b">{{ $order->receiver_address }}, {{ $order->receiver_village }}, {{ $order->receiver_district }}</div>
        <div class="ad-b">{{ $order->receiver_city }}, {{ $order->receiver_province }} {{ $order->receiver_postal_code }}</div>
    </div>
    <table class="det">
        <tr><td class="tl tbr" style="width:50%">Berat</td><td class="tl">Koli</td></tr>
        <tr><td class="tv tbr">{{ number_format($order->weight, 2) }} KG</td><td class="tv">{{ $order->koli }}</td></tr>
        <tr><td class="tl tbr">Harga / KG</td><td class="tl">No. Reff</td></tr>
        <tr><td class="tv tbr">Rp {{ number_format($order->price_per_kg, 0, ',', '.') }}</td><td class="tv" style="font-size:10px">{{ $order->reff_no ?: '-' }}</td></tr>
    </table>
    <div class="ft">
        <span class="ft-lbl">Total Ongkos Kirim</span>
        <span class="ft-val">Rp {{ number_format($order->total_shipping, 0, ',', '.') }}</span>
    </div>
</div>
</body>
</html>`);
        doc.close();

        iframe.onload = function() {
            setTimeout(function() {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
            }, 100);
        };
    }
</script>
@endsection
