@extends('layouts.admin')
@section('title', 'Database Pengirim')
@section('page-title', 'Database Pengirim')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-xl font-black text-slate-800">Database Pengirim</h3>
            <p class="text-sm text-slate-500">Daftar pelanggan yang pernah melakukan pengiriman</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Nama</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">No. HP</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Alamat Terakhir</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Kota</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($senders as $sender)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $sender->sender_name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 flex items-center gap-2">
                            <span class="text-blue-500"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg></span> {{ $sender->sender_phone }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $sender->sender_address }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded uppercase">{{ $sender->sender_city }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-slate-400 font-bold">Belum ada data pengirim</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
