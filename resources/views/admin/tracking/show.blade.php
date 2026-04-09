@extends('layouts.admin')
@section('title', 'Tracking ' . $order->resi)
@section('page-title', 'Detail Tracking')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <a href="{{ route('admin.tracking.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-blue-600 font-bold transition-colors">
        <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg> Kembali ke Pencarian
    </a>

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

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10 pb-6 border-b border-slate-50">
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Nomor Resi</p>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">{{ $order->resi }}</h2>
            </div>
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
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
