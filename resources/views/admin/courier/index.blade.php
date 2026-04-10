@extends('layouts.admin')
@section('title', 'Tugas Kurir')
@section('page-title', 'Tugas Kurir')

@section('content')
@php
    $oldOrderId = old('order_id');
    $oldOrder = $oldOrderId ? $orders->firstWhere('id', (int) $oldOrderId) : null;
@endphp
<div class="max-w-4xl mx-auto space-y-6" x-data="{ logModal: @js($errors->any()), selectedOrder: @js($oldOrder ? ['id' => $oldOrder->id, 'resi' => $oldOrder->resi] : null) }">
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h3 class="text-xl font-black text-slate-800">Manajemen Pengiriman</h3>
                <p class="text-sm text-slate-500">Update status dan log perjalanan paket</p>
            </div>
            <form action="{{ route('admin.courier.index') }}" method="GET" class="relative w-full md:w-72">
                <input type="text" name="search" placeholder="Cari Nomor Resi..." value="{{ $search }}"
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 outline-none text-sm font-bold transition-all">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            </form>
        </div>

        <div class="space-y-4">
            @forelse($orders as $order)
            @php
                $iconColors = [
                    'Pending' => 'bg-slate-400', 'Picked Up' => 'bg-blue-500', 'At Drop Point' => 'bg-indigo-500',
                    'In Transit' => 'bg-amber-500', 'Arrived at Gateway' => 'bg-purple-500',
                    'Out for Delivery' => 'bg-orange-500', 'Delivered' => 'bg-emerald-500', 'Failed' => 'bg-red-500',
                ];
                $textColors = [
                    'Pending' => 'text-slate-500', 'Picked Up' => 'text-blue-600', 'At Drop Point' => 'text-indigo-600',
                    'In Transit' => 'text-amber-600', 'Arrived at Gateway' => 'text-purple-600',
                    'Out for Delivery' => 'text-orange-600', 'Delivered' => 'text-emerald-600', 'Failed' => 'text-red-600',
                ];
            @endphp
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 hover:border-blue-200 transition-all">
                <div class="flex gap-4 items-start">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-lg {{ $iconColors[$order->current_status] ?? 'bg-slate-400' }}">
                        @if($order->current_status === 'Delivered')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif($order->current_status === 'Failed')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif($order->current_status === 'In Transit')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.079-.504 1.079-1.125V7.5c0-.621-.504-1.125-1.125-1.125H14.25M8.25 18.75V6.375c0-.621.504-1.125 1.125-1.125h4.875"/></svg>
                        @elseif($order->current_status === 'Out for Delivery')
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        @endif
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <p class="text-xs font-bold text-blue-600">{{ $order->resi }}</p>
                        </div>
                        <p class="font-black text-slate-800 text-lg">{{ $order->receiver_name }}</p>
                        <p class="text-xs text-slate-500 flex items-center gap-1"><svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg> {{ $order->receiver_address }}, {{ $order->receiver_city }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden md:block mr-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Terakhir</p>
                        <p class="text-sm font-bold {{ $textColors[$order->current_status] ?? 'text-slate-700' }}">{{ $order->current_status }}</p>
                    </div>
                    <a href="{{ route('admin.orders.show', $order) }}"
                        class="flex-1 md:flex-none px-5 py-3 bg-white border-2 border-blue-500 text-blue-600 text-sm font-black rounded-xl hover:bg-blue-50 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18.25 6.875V3.375"/></svg>
                        Detail & Cetak Resi
                    </a>
                    <button @click='selectedOrder = @json(["id" => $order->id, "resi" => $order->resi]); logModal = true'
                        class="flex-1 md:flex-none px-5 py-3 bg-slate-900 text-white text-sm font-black rounded-xl hover:bg-slate-800 shadow-lg shadow-slate-200 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                        Update Log
                    </button>
                </div>
            </div>
            @empty
            <div class="bg-slate-50 p-12 rounded-3xl border-2 border-dashed border-slate-200 text-center">
                <svg class="w-12 h-12 text-slate-200 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <p class="text-slate-400 font-bold">Tidak ada pesanan yang ditemukan</p>
            </div>
            @endforelse

            @if($orders->hasPages())
            <div class="pt-4 border-t border-slate-100">
                @include('admin.partials.pagination', ['paginator' => $orders])
            </div>
            @endif
        </div>
    </div>

    {{-- Log Update Modal --}}
    <template x-if="logModal && selectedOrder">
        <div class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" @click.self="logModal = false">
            <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden" @click.stop>
                <form :action="'/admin/courier/' + selectedOrder.id + '/log'" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <div>
                            <h3 class="font-black text-slate-800">Update Status Pengiriman</h3>
                            <p class="text-xs text-blue-600 font-bold" x-text="selectedOrder.resi"></p>
                        </div>
                        <button type="button" @click="logModal = false" class="p-2 hover:bg-slate-200 rounded-full transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>

                    <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto" x-data="{ selectedStatus: @js(old('status', '')), fileName: '', fileError: '' }">
                        <input type="hidden" name="order_id" :value="selectedOrder ? selectedOrder.id : ''">
                        @if($errors->any())
                            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm font-bold border border-red-100">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="grid grid-cols-2 gap-3">
                            @php
                                $statuses = [
                                    ['status' => 'Picked Up', 'label' => 'Pick Up', 'color' => 'text-blue-600'],
                                    ['status' => 'At Drop Point', 'label' => 'Tiba di Drop Point', 'color' => 'text-indigo-600'],
                                    ['status' => 'In Transit', 'label' => 'Dalam Transit', 'color' => 'text-amber-600'],
                                    ['status' => 'Arrived at Gateway', 'label' => 'Tiba di Gateway', 'color' => 'text-purple-600'],
                                    ['status' => 'Out for Delivery', 'label' => 'Kurir Menuju Alamat', 'color' => 'text-orange-600'],
                                    ['status' => 'Delivered', 'label' => 'Diterima', 'color' => 'text-emerald-600'],
                                    ['status' => 'Failed', 'label' => 'Gagal Kirim', 'color' => 'text-red-600'],
                                ];
                            @endphp
                            @foreach($statuses as $opt)
                            <button type="button" @click="selectedStatus = '{{ $opt['status'] }}'; $refs.statusInput.value = '{{ $opt['status'] }}'"
                                :class="selectedStatus === '{{ $opt['status'] }}' ? 'border-blue-500 bg-blue-50' : 'border-slate-100 hover:border-slate-200'"
                                class="p-3 rounded-2xl border-2 text-left transition-all flex items-center gap-3">
                                <span class="{{ $opt['color'] }} text-sm font-bold">{{ $opt['label'] }}</span>
                            </button>
                            @endforeach
                            <input type="hidden" name="status" x-ref="statusInput" :value="selectedStatus">
                        </div>

                        <div class="space-y-4 pt-4 border-t border-slate-100">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Lokasi Saat Ini</label>
                                <input type="text" name="location" required placeholder="Contoh: DC Jakarta, Drop Point Bandung"
                                    value="{{ old('location') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-medium">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Keterangan Log</label>
                                <textarea name="description" required rows="3" placeholder="Masukkan detail proses pengiriman..."
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none text-sm font-medium resize-none">{{ old('description') }}</textarea>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Foto Bukti (Opsional)</label>
                                <label class="flex flex-col items-center justify-center gap-2 p-6 border-2 border-dashed border-slate-200 rounded-2xl hover:border-blue-400 hover:bg-blue-50 transition-all cursor-pointer">
                                    <span class="text-xs font-bold text-slate-500 flex items-center gap-1 text-center" x-text="fileName ? fileName : 'Ambil Foto / Upload'"></span>
                                    <input type="file" name="image" accept="image/*" class="hidden" @change="
                                        const file = $event.target.files[0];
                                        fileName = file ? file.name : '';
                                        fileError = '';
                                        if (file && file.size > 2048 * 1024) {
                                            fileError = 'Ukuran gambar maksimal 2 MB. Silakan pilih gambar lain.';
                                            $event.target.value = '';
                                            fileName = '';
                                        }
                                    ">
                                </label>
                                @error('image')
                                    <p class="text-xs font-bold text-red-600">{{ $message }}</p>
                                @enderror
                                <p x-show="fileError" x-text="fileError" class="text-xs font-bold text-red-600"></p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50 flex gap-3">
                        <button type="button" @click="logModal = false" class="flex-1 py-3 rounded-xl font-bold text-slate-500 hover:bg-slate-200 transition-all">Batal</button>
                        <button type="submit" :disabled="fileError !== '' || !selectedStatus" class="flex-[2] py-3 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition-all disabled:bg-slate-300 disabled:shadow-none disabled:cursor-not-allowed">Simpan Update</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>
@endsection
