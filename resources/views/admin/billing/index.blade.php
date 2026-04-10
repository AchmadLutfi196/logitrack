@extends('layouts.admin')
@section('title', 'Manajemen Tagihan')
@section('page-title', 'Manajemen Tagihan')

@section('content')
<div class="max-w-6xl mx-auto space-y-6" x-data="{ billingModal: false, selectedOrder: null }">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-xl font-black text-slate-800">Manajemen Tagihan</h3>
                <p class="text-sm text-slate-500">Pantau status pembayaran dan riwayat tagihan pelanggan</p>
            </div>
            <form action="{{ route('admin.billing.index') }}" method="GET" class="relative w-full md:w-72">
                <input type="text" name="search" placeholder="Cari Resi atau Nama..." value="{{ $search }}"
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 outline-none text-sm font-bold transition-all">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/30">
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Resi & Tanggal</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Pengirim / Penerima</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Total Biaya</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Metode</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Catatan</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-black text-blue-600 text-sm">{{ $order->resi }}</p>
                            <p class="text-[10px] text-slate-400 font-bold">{{ $order->created_at->format('Y-m-d') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs font-bold text-slate-700">DARI: {{ $order->sender_name }}</p>
                            <p class="text-xs font-bold text-slate-500">KE: {{ $order->receiver_name }}</p>
                        </td>
                        <td class="px-6 py-4 font-black text-slate-800 text-sm">Rp {{ number_format($order->total_shipping, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-[10px] font-black rounded uppercase tracking-wider {{ $order->payment_method === 'Cash' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' }}">{{ $order->payment_method }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-[10px] font-black rounded uppercase tracking-wider {{ $order->payment_status === 'Lunas' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">{{ $order->payment_status }}</span>
                        </td>
                        <td class="px-6 py-4 max-w-xs"><p class="text-xs text-slate-500 italic line-clamp-2">{{ $order->billing_notes ?: '-' }}</p></td>
                        <td class="px-6 py-4">
                            <button @click="selectedOrder = {{ $order->toJson() }}; billingModal = true"
                                class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Update Pembayaran">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-slate-400 font-bold">Tidak ada data tagihan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
        <div class="p-4 border-t border-slate-100">
            @include('admin.partials.pagination', ['paginator' => $orders])
        </div>
        @endif
    </div>

    {{-- Billing Update Modal --}}
    <template x-if="billingModal && selectedOrder">
        <div class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" @click.self="billingModal = false">
            <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden" @click.stop>
                <form :action="'/admin/billing/' + selectedOrder.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <div>
                            <h3 class="font-black text-slate-800">Update Status Pembayaran</h3>
                            <p class="text-xs text-blue-600 font-bold" x-text="selectedOrder.resi + ' - ' + selectedOrder.receiver_name"></p>
                        </div>
                        <button type="button" @click="billingModal = false" class="p-2 hover:bg-slate-200 rounded-full transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Pembayaran</label>
                            <div class="grid grid-cols-2 gap-4" x-data="{ payStatus: selectedOrder.payment_status }">
                                <button type="button" @click="payStatus = 'Tagihan'; $refs.payInput.value = 'Tagihan'"
                                    :class="payStatus === 'Tagihan' ? 'border-amber-500 bg-amber-50 text-amber-700' : 'border-slate-100 hover:border-slate-200 text-slate-500'"
                                    class="p-4 rounded-2xl border-2 transition-all flex flex-col items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg> <span class="text-sm font-bold">Tagihan</span>
                                </button>
                                <button type="button" @click="payStatus = 'Lunas'; $refs.payInput.value = 'Lunas'"
                                    :class="payStatus === 'Lunas' ? 'border-emerald-500 bg-emerald-50 text-emerald-700' : 'border-slate-100 hover:border-slate-200 text-slate-500'"
                                    class="p-4 rounded-2xl border-2 transition-all flex flex-col items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> <span class="text-sm font-bold">Lunas</span>
                                </button>
                                <input type="hidden" name="payment_status" x-ref="payInput" :value="payStatus">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Catatan Pembayaran</label>
                            <textarea name="billing_notes" rows="5" placeholder="Masukkan detail pembayaran..."
                                class="w-full px-4 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-medium resize-none bg-slate-50 focus:bg-white transition-all"
                                x-text="selectedOrder.billing_notes || ''"></textarea>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-2xl border border-blue-100 flex justify-between items-center">
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Total Tagihan</span>
                            <span class="text-lg font-black text-blue-700" x-text="'Rp ' + Number(selectedOrder.total_shipping).toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                    <div class="p-6 bg-slate-50 flex gap-3">
                        <button type="button" @click="billingModal = false" class="flex-1 py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-200 transition-all">Batal</button>
                        <button type="submit" class="flex-[2] py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all flex items-center justify-center gap-2"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg> Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>
@endsection
