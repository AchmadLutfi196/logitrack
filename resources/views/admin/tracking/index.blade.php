@extends('layouts.admin')
@section('title', 'Lacak Pengiriman')
@section('page-title', 'Lacak Pengiriman')

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('admin.tracking.search') }}" method="POST" class="relative mb-12">
        @csrf
        <input type="text" name="resi" placeholder="Masukkan Nomor Resi (Contoh: JP1234567890)"
            class="w-full pl-14 pr-32 py-5 rounded-2xl bg-white border-2 border-slate-200 focus:border-blue-500 outline-none shadow-xl shadow-slate-200/50 text-lg font-bold transition-all"
            value="{{ old('resi') }}">
        <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all">Lacak</button>
    </form>

    <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-200">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800">Belum ada data pelacakan</h3>
        <p class="text-slate-500 max-w-xs mx-auto mt-2">Silakan masukkan nomor resi Anda untuk melihat status pengiriman terkini.</p>
    </div>
</div>
@endsection
