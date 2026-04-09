@extends('layouts.admin')
@section('title', 'Resi ' . $order->resi)
@section('page-title', 'Detail Order & Cetak Resi')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Back Button --}}
    <a href="{{ route('admin.courier.index') }}" class="inline-flex items-center gap-2 px-4 py-2 mb-6 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-blue-600 transition-all active:scale-95 shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
        Kembali ke Manajemen Pengiriman
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        {{-- Tracking Timeline --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10 pb-6 border-b border-slate-50">
                <div>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Nomor Resi</p>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">{{ $order->resi }}</h2>
                </div>
                @php
                    $statusColors = [
                        'Pending' => 'bg-slate-400', 'Picked Up' => 'bg-blue-500', 'At Drop Point' => 'bg-indigo-500',
                        'In Transit' => 'bg-amber-500', 'Arrived at Gateway' => 'bg-purple-500',
                        'Out for Delivery' => 'bg-orange-500', 'Delivered' => 'bg-emerald-500', 'Failed' => 'bg-red-500',
                    ];
                    $statusIcons = [
                        'Pending' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>',
                        'Picked Up' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>',
                        'At Drop Point' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>',
                        'In Transit' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.079-.504 1.079-1.125V7.5c0-.621-.504-1.125-1.125-1.125H14.25M8.25 18.75V6.375c0-.621.504-1.125 1.125-1.125h4.875"/></svg>',
                        'Arrived at Gateway' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21"/></svg>',
                        'Out for Delivery' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>',
                        'Delivered' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                        'Failed' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    ];
                @endphp
                <div class="px-6 py-2 rounded-xl text-white text-sm font-black shadow-lg uppercase tracking-wider {{ $statusColors[$order->current_status] ?? 'bg-slate-400' }}">
                    {{ $order->current_status }}
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-slate-100">
                            <th class="pb-4 text-xs font-black text-slate-400 uppercase tracking-widest w-32">Waktu</th>
                            <th class="pb-4 text-xs font-black text-slate-400 uppercase tracking-widest">Keterangan Log</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($order->trackingLogs->sortByDesc('logged_at')->values() as $i => $log)
                        <tr>
                            <td class="py-5 pr-4 align-top">
                                <p class="text-sm font-bold text-slate-700 whitespace-nowrap">{{ $log->logged_at->translatedFormat('d M, H:i') }}</p>
                            </td>
                            <td class="py-5 align-top">
                                <div class="flex items-start gap-3">
                                    <span class="text-slate-500 shrink-0">{!! $statusIcons[$log->status] ?? '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>' !!}</span>
                                    <div>
                                        <p class="text-sm font-bold leading-relaxed {{ $i === 0 ? 'text-slate-900' : 'text-slate-600' }}">{{ $log->description }}</p>
                                        <p class="text-[10px] text-slate-400 font-medium mt-1 uppercase tracking-wider">{{ $log->location }} • Update by {{ $log->updated_by }}</p>
                                        @if($log->image)
                                            <div class="mt-3 rounded-xl overflow-hidden border border-slate-100 max-w-xs">
                                                <img src="{{ asset('storage/' . $log->image) }}" alt="Bukti Log" class="w-full h-auto object-cover">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- POD Section --}}
        @if($order->current_status === 'Delivered')
        <div class="mt-6 bg-emerald-50 border border-emerald-100 p-6 rounded-xl">
            <h3 class="text-emerald-900 font-bold flex items-center gap-2 mb-4"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Bukti Penerimaan (POD)</h3>
            <div class="aspect-video bg-white rounded-lg border border-emerald-200 flex items-center justify-center overflow-hidden max-w-md">
                @if($order->pod_photo)
                    <img src="{{ asset('storage/' . $order->pod_photo) }}" alt="POD" class="w-full h-full object-cover">
                @else
                    <div class="text-emerald-300 text-center p-4"><p class="text-xs">Foto belum tersedia</p></div>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- AWB Label Sidebar --}}
    <div class="lg:col-span-1 sticky top-8 space-y-6">
        <h3 class="font-bold text-slate-800 flex items-center gap-2 print:hidden">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg> Resi Terbit
        </h3>

        {{-- AWB Label --}}
        <div class="bg-white border-2 border-slate-900 max-w-md mx-auto relative overflow-hidden" id="awb-label">
            {{-- Header --}}
            <div class="flex justify-between items-center px-5 py-3 border-b-2 border-slate-900">
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tighter italic">LOGITRACK</h2>
                    <p class="text-[9px] text-slate-500 uppercase font-bold tracking-[0.2em]">Express Delivery</p>
                </div>
                <div class="text-right border-l-2 border-slate-900 pl-4">
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-wider">Pembayaran</p>
                    <p class="text-base font-black text-slate-900">{{ strtoupper($order->payment_method) }}</p>
                </div>
            </div>

            {{-- QR Code + Resi --}}
            <div class="flex items-center gap-4 px-5 py-4 border-b-2 border-slate-900 bg-slate-50">
                <div id="qrcode" class="shrink-0 bg-white p-1.5 border border-slate-300"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-wider">No. AWB</p>
                    <p class="font-mono font-black text-xl tracking-wider text-slate-900 leading-tight">{{ $order->resi }}</p>
                    <p class="text-[9px] text-slate-400 mt-1">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            {{-- Pengirim --}}
            <div class="px-5 py-3 border-b border-slate-300">
                <p class="text-[9px] font-black text-slate-900 uppercase tracking-wider mb-1 flex items-center gap-1">
                    <span class="inline-block w-1.5 h-1.5 bg-blue-600 rounded-full"></span> PENGIRIM
                </p>
                <p class="text-xs font-bold text-slate-800">{{ $order->sender_name }} — {{ $order->sender_phone }}</p>
                <p class="text-[10px] text-slate-600 leading-relaxed">{{ $order->sender_address }}, {{ $order->sender_village }}, {{ $order->sender_district }}</p>
                <p class="text-[10px] text-slate-600">{{ $order->sender_city }}, {{ $order->sender_province }} {{ $order->sender_postal_code }}</p>
            </div>

            {{-- Penerima --}}
            <div class="px-5 py-3 border-b-2 border-slate-900 bg-amber-50/50">
                <p class="text-[9px] font-black text-slate-900 uppercase tracking-wider mb-1 flex items-center gap-1">
                    <span class="inline-block w-1.5 h-1.5 bg-red-500 rounded-full"></span> PENERIMA
                </p>
                <p class="text-sm font-black text-slate-900">{{ $order->receiver_name }} — {{ $order->receiver_phone }}</p>
                <p class="text-[10px] text-slate-700 leading-relaxed font-medium">{{ $order->receiver_address }}, {{ $order->receiver_village }}, {{ $order->receiver_district }}</p>
                <p class="text-[10px] text-slate-700 font-medium">{{ $order->receiver_city }}, {{ $order->receiver_province }} {{ $order->receiver_postal_code }}</p>
            </div>

            {{-- Detail Kiriman --}}
            <table class="w-full text-[10px] border-collapse">
                <tr class="border-b border-slate-300">
                    <td class="px-3 py-2 font-bold text-slate-500 uppercase tracking-wider border-r border-slate-300 w-1/2">Berat</td>
                    <td class="px-3 py-2 font-bold text-slate-500 uppercase tracking-wider w-1/2">Koli</td>
                </tr>
                <tr class="border-b border-slate-300">
                    <td class="px-3 py-2 font-black text-slate-900 text-sm border-r border-slate-300">{{ number_format($order->weight, 2) }} KG</td>
                    <td class="px-3 py-2 font-black text-slate-900 text-sm">{{ $order->koli }}</td>
                </tr>
                <tr class="border-b border-slate-300">
                    <td class="px-3 py-2 font-bold text-slate-500 uppercase tracking-wider border-r border-slate-300">Harga / KG</td>
                    <td class="px-3 py-2 font-bold text-slate-500 uppercase tracking-wider">No. Reff</td>
                </tr>
                <tr class="border-b-2 border-slate-900">
                    <td class="px-3 py-2 font-black text-slate-900 text-sm border-r border-slate-300">Rp {{ number_format($order->price_per_kg, 0, ',', '.') }}</td>
                    <td class="px-3 py-2 font-bold text-slate-700 text-sm">{{ $order->reff_no ?: '-' }}</td>
                </tr>
            </table>

            {{-- Total Biaya --}}
            <div class="px-5 py-3 bg-slate-900 text-white flex justify-between items-center">
                <span class="text-[10px] font-bold uppercase tracking-widest">Total Ongkos Kirim</span>
                <span class="text-lg font-black">Rp {{ number_format($order->total_shipping, 0, ',', '.') }}</span>
            </div>
        </div>

        <button onclick="printLabel()" class="w-full py-3 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-900 transition-all flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v8H6z"/></svg>
            Cetak Label
        </button>
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

        // Remove existing print iframe if any
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
        <div class="qr-box">${qrHtml}</div>
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
