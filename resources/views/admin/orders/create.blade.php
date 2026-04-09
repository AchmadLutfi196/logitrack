@extends('layouts.admin')
@section('title', 'Buat Pengiriman Baru')
@section('page-title', 'Buat Pengiriman Baru')

@section('content')
<div class="max-w-7xl mx-auto" x-data="orderForm()">
    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf

        {{-- ===== SECTION 1: DATA PENGIRIM & PENERIMA ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

            {{-- PENGIRIM --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-white">
                    <h3 class="font-black text-slate-800 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                        Data Pengirim
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Nama Pengirim</label>
                            <input required name="sender_name" placeholder="Masukkan nama" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium" value="{{ old('sender_name') }}">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">No. HP</label>
                            <input required name="sender_phone" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium" value="{{ old('sender_phone') }}">
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Alamat Lengkap</label>
                        <input required name="sender_address" placeholder="Jalan, No. Rumah, RT/RW" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium" value="{{ old('sender_address') }}">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Provinsi</label>
                            <select required name="sender_province_select" x-model="senderProvince" @change="fetchCities('sender')" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium appearance-none">
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinces as $p)
                                    <option value="{{ $p->id }}" data-name="{{ $p->name }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Kab / Kota</label>
                            <select required name="sender_city_select" x-model="senderCity" @change="fetchDistricts('sender')" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium disabled:opacity-50 appearance-none" :disabled="!senderProvince">
                                <option value="">Pilih Kab/Kota</option>
                                <template x-for="c in senderCities" :key="c.id"><option :value="c.id" x-text="c.name" :data-name="c.name"></option></template>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Kecamatan</label>
                            <select required name="sender_district_select" x-model="senderDistrict" @change="fetchVillages('sender')" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium disabled:opacity-50 appearance-none" :disabled="!senderCity">
                                <option value="">Pilih Kecamatan</option>
                                <template x-for="d in senderDistricts" :key="d.id"><option :value="d.id" x-text="d.name" :data-name="d.name"></option></template>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Kelurahan</label>
                            <select required name="sender_village" x-model="senderVillage" @change="senderPostalCode = (senderVillages.find(v => v.name === senderVillage) || {}).postal_code || ''" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium disabled:opacity-50 appearance-none" :disabled="!senderDistrict">
                                <option value="">Pilih Kelurahan</option>
                                <template x-for="v in senderVillages" :key="v.id"><option :value="v.name" x-text="v.name"></option></template>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Kode Pos</label>
                        <input required list="sender_postalcodes" name="sender_postal_code" x-model="senderPostalCode" placeholder="Pilih dropdown atau ketik Kode Pos" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium">
                        <datalist id="sender_postalcodes">
                            <template x-for="p in senderPostalCodes"><option :value="p"></option></template>
                        </datalist>
                    </div>
                    <input type="hidden" name="sender_province" :value="senderProvinceName">
                    <input type="hidden" name="sender_city" :value="senderCityName">
                    <input type="hidden" name="sender_district" :value="senderDistrictName">
                </div>
            </div>

            {{-- PENERIMA --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-red-50 to-white">
                    <h3 class="font-black text-slate-800 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-red-500 text-white flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </span>
                        Data Penerima
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Nama Penerima</label>
                            <input required name="receiver_name" placeholder="Masukkan nama" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium" value="{{ old('receiver_name') }}">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">No. HP</label>
                            <input required name="receiver_phone" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium" value="{{ old('receiver_phone') }}">
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Alamat Lengkap</label>
                        <input required name="receiver_address" placeholder="Jalan, No. Rumah, RT/RW" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium" value="{{ old('receiver_address') }}">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Provinsi</label>
                            <select required name="receiver_province_select" x-model="receiverProvince" @change="fetchCities('receiver')" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium appearance-none">
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinces as $p)
                                    <option value="{{ $p->id }}" data-name="{{ $p->name }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Kab / Kota</label>
                            <select required name="receiver_city_select" x-model="receiverCity" @change="fetchDistricts('receiver')" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium disabled:opacity-50 appearance-none" :disabled="!receiverProvince">
                                <option value="">Pilih Kab/Kota</option>
                                <template x-for="c in receiverCities" :key="c.id"><option :value="c.id" x-text="c.name" :data-name="c.name"></option></template>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Kecamatan</label>
                            <select required name="receiver_district_select" x-model="receiverDistrict" @change="fetchVillages('receiver')" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium disabled:opacity-50 appearance-none" :disabled="!receiverCity">
                                <option value="">Pilih Kecamatan</option>
                                <template x-for="d in receiverDistricts" :key="d.id"><option :value="d.id" x-text="d.name" :data-name="d.name"></option></template>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Kelurahan</label>
                            <select required name="receiver_village" x-model="receiverVillage" @change="receiverPostalCode = (receiverVillages.find(v => v.name === receiverVillage) || {}).postal_code || ''" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium disabled:opacity-50 appearance-none" :disabled="!receiverDistrict">
                                <option value="">Pilih Kelurahan</option>
                                <template x-for="v in receiverVillages" :key="v.id"><option :value="v.name" x-text="v.name"></option></template>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Kode Pos</label>
                        <input required list="receiver_postalcodes" name="receiver_postal_code" x-model="receiverPostalCode" placeholder="Pilih dropdown atau ketik Kode Pos" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium">
                        <datalist id="receiver_postalcodes">
                            <template x-for="p in receiverPostalCodes"><option :value="p"></option></template>
                        </datalist>
                    </div>
                    <input type="hidden" name="receiver_province" :value="receiverProvinceName">
                    <input type="hidden" name="receiver_city" :value="receiverCityName">
                    <input type="hidden" name="receiver_district" :value="receiverDistrictName">
                </div>
            </div>
        </div>

        {{-- ===== SECTION 2: DETAIL PAKET & RINGKASAN ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- DETAIL PAKET --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-white">
                    <h3 class="font-black text-slate-800 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </span>
                        Detail Paket
                    </h3>
                </div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">No. Reff (Opsional)</label>
                            <input name="reff_no" placeholder="REFF-00000" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Koli (Jumlah Paket)</label>
                            <input type="number" name="koli" min="1" x-model.number="koli" placeholder="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Total Berat Aktual (kg)</label>
                            <input type="number" name="weight" min="0.1" step="0.1" x-model.number="weight" placeholder="0.0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 flex items-center justify-between">
                                <span>Dimensi per Koli (cm)</span>
                                <span class="text-blue-500 font-black" x-text="'Vol: ' + volumeWeight.toFixed(1) + ' kg'"></span>
                            </label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="length" min="1" x-model.number="length" placeholder="P (cm)" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium text-center">
                                <span class="text-slate-300 text-sm font-black shrink-0">×</span>
                                <input type="number" name="width" min="1" x-model.number="width" placeholder="L (cm)" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium text-center">
                                <span class="text-slate-300 text-sm font-black shrink-0">×</span>
                                <input type="number" name="height" min="1" x-model.number="height" placeholder="T (cm)" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium text-center">
                            </div>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Harga / kg (Rp)</label>
                            <input type="number" name="price_per_kg" min="0" x-model.number="pricePerKg" placeholder="10000" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-200 focus:border-blue-400 outline-none transition-all text-sm font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Metode Pembayaran</label>
                        <div class="flex gap-4">
                            <label class="flex-1 cursor-pointer group">
                                <input type="radio" name="payment_method" value="Cash" checked class="peer hidden">
                                <div class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                    <span class="text-lg">💵</span>
                                    <span class="text-sm font-bold text-slate-700 peer-checked:text-blue-700">Cash</span>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer group">
                                <input type="radio" name="payment_method" value="Tagihan" class="peer hidden">
                                <div class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 border-slate-200 bg-slate-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
                                    <span class="text-sm font-bold text-slate-700 peer-checked:text-blue-700">Tagihan</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RINGKASAN BIAYA --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-white">
                        <h3 class="font-black text-slate-800 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                            </span>
                            Ringkasan Biaya
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Berat Aktual</span>
                            <span class="font-bold text-slate-700" x-text="Number(weight).toFixed(1) + ' kg'"></span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Berat Volume</span>
                            <span class="font-bold text-slate-700" x-text="volumeWeight.toFixed(1) + ' kg'"></span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Jumlah Koli</span>
                            <span class="font-bold text-slate-700" x-text="koli"></span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Harga / kg</span>
                            <span class="font-bold text-slate-700" x-text="'Rp ' + Number(pricePerKg).toLocaleString('id-ID')"></span>
                        </div>
                        <hr class="border-slate-100">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Berat Ditagihkan</span>
                            <span class="text-sm font-black text-slate-800" x-text="chargeableWeight.toFixed(1) + ' kg'"></span>
                        </div>
                        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl p-5 text-center shadow-lg shadow-blue-200">
                            <p class="text-blue-200 text-[10px] font-bold uppercase tracking-widest mb-1">Total Ongkos Kirim</p>
                            <p class="text-3xl font-black text-white" x-text="'Rp ' + (chargeableWeight * pricePerKg).toLocaleString('id-ID')"></p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-2xl shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-3 active:scale-[0.98] text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Buat Pesanan & Generate Resi
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function orderForm() {
    return {
        weight: null, pricePerKg: null, koli: null,
        length: null, width: null, height: null,
        senderProvince: '', senderCity: '', senderDistrict: '', senderVillage: '', senderPostalCode: '',
        senderCities: [], senderDistricts: [], senderVillages: [],
        senderProvinceName: '', senderCityName: '', senderDistrictName: '',
        receiverProvince: '', receiverCity: '', receiverDistrict: '', receiverVillage: '', receiverPostalCode: '',
        receiverCities: [], receiverDistricts: [], receiverVillages: [],
        receiverProvinceName: '', receiverCityName: '', receiverDistrictName: '',

        get senderPostalCodes() {
            const codes = new Set();
            this.senderVillages.forEach(v => { if (v.postal_code) codes.add(v.postal_code); });
            return Array.from(codes).sort();
        },
        get receiverPostalCodes() {
            const codes = new Set();
            this.receiverVillages.forEach(v => { if (v.postal_code) codes.add(v.postal_code); });
            return Array.from(codes).sort();
        },

        get volumeWeight() {
            const divisor = 4000;
            return ((this.length * this.width * this.height) / divisor) * this.koli;
        },
        get chargeableWeight() {
            return Math.max(Number(this.weight) || 0, this.volumeWeight);
        },

        async fetchCities(type) {
            const id = type === 'sender' ? this.senderProvince : this.receiverProvince;
            if (!id) return;
            const el = document.querySelector(`select[name="${type}_province_select"] option[value="${id}"]`);
            if (type === 'sender') {
                this.senderProvinceName = el?.dataset.name || '';
                this.senderCity = ''; this.senderDistrict = ''; this.senderVillage = '';
                this.senderDistricts = []; this.senderVillages = [];
            } else {
                this.receiverProvinceName = el?.dataset.name || '';
                this.receiverCity = ''; this.receiverDistrict = ''; this.receiverVillage = '';
                this.receiverDistricts = []; this.receiverVillages = [];
            }
            const res = await fetch(`/api/locations/cities/${id}`);
            const data = await res.json();
            if (type === 'sender') this.senderCities = data;
            else this.receiverCities = data;
        },
        async fetchDistricts(type) {
            const id = type === 'sender' ? this.senderCity : this.receiverCity;
            if (!id) return;
            if (type === 'sender') {
                const el = this.$el.querySelector(`select[x-model="senderCity"] option[value="${id}"]`);
                this.senderCityName = el?.dataset?.name || el?.textContent || '';
                this.senderDistrict = ''; this.senderVillage = ''; this.senderVillages = [];
            } else {
                const el = this.$el.querySelector(`select[x-model="receiverCity"] option[value="${id}"]`);
                this.receiverCityName = el?.dataset?.name || el?.textContent || '';
                this.receiverDistrict = ''; this.receiverVillage = ''; this.receiverVillages = [];
            }
            const res = await fetch(`/api/locations/districts/${id}`);
            const data = await res.json();
            if (type === 'sender') this.senderDistricts = data;
            else this.receiverDistricts = data;
        },
        async fetchVillages(type) {
            const id = type === 'sender' ? this.senderDistrict : this.receiverDistrict;
            if (!id) return;
            if (type === 'sender') {
                const el = this.$el.querySelector(`select[x-model="senderDistrict"] option[value="${id}"]`);
                this.senderDistrictName = el?.dataset?.name || el?.textContent || '';
                this.senderVillage = '';
            } else {
                const el = this.$el.querySelector(`select[x-model="receiverDistrict"] option[value="${id}"]`);
                this.receiverDistrictName = el?.dataset?.name || el?.textContent || '';
                this.receiverVillage = '';
            }
            const res = await fetch(`/api/locations/villages/${id}`);
            const data = await res.json();
            if (type === 'sender') this.senderVillages = data;
            else this.receiverVillages = data;
        },
    }
}
</script>
@endsection
