@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    <h2 class="text-white font-bold text-lg mb-6 ml-2 uppercase italic tracking-wider">Form Pengembalian Buku</h2>

    {{-- max-w-full digunakan agar box mengikuti lebar konten dashboard --}}
    <div class="max-w-full"> 
        <div class="bg-[#111419] rounded-xl border border-gray-800 shadow-2xl overflow-hidden w-full">
            <form action="{{ route('petugas.pengembalian.update', $peminjaman->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="p-8 space-y-6">
                    {{-- Nama Peminjam --}}
                    <div class="w-full">
                        <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2">Peminjam</label>
                        <input type="text" value="{{ $peminjaman->user->name }}" class="w-full bg-[#1c1f26] text-gray-500 text-xs rounded-lg py-3 px-4 border border-gray-800 outline-none" readonly>
                    </div>

                    {{-- Judul Buku --}}
                    <div class="w-full">
                        <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2">Judul Buku</label>
                        <input type="text" value="{{ $peminjaman->buku->judul }}" class="w-full bg-[#1c1f26] text-gray-500 text-xs rounded-lg py-3 px-4 border border-gray-800 outline-none" readonly>
                    </div>

                    {{-- Tanggal Kembali --}}
                    <div class="w-full">
                        <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2 text-red-500">Tanggal Pengembalian</label>
                        <input type="date" name="tanggal_kembali" 
                               value="{{ $peminjaman->tanggal_kembali ?? date('Y-m-d') }}" 
                               class="w-full bg-[#1c1f26] text-gray-200 text-xs rounded-lg py-3 px-4 border border-gray-800 outline-none focus:ring-1 focus:ring-red-600">
                    </div>

                    {{-- Status --}}
                    <div class="w-full">
                        <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2">Status</label>
                        <select name="status" class="w-full bg-[#1c1f26] text-gray-200 text-xs rounded-lg py-3 px-4 border border-gray-800 outline-none focus:ring-1 focus:ring-red-600">
                            <option value="dikembalikan" {{ $peminjaman->status == 'dikembalikan' ? 'selected' : '' }}>DIKEMBALIKAN</option>
                            <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>DIPINJAM</option>
                        </select>
                    </div>
                </div>

                {{-- Bagian tombol yang juga dibuat lebar --}}
                <div class="bg-[#0d0f13] px-8 py-5 border-t border-gray-800 flex justify-end gap-3">
                    <a href="{{ route('petugas.pengembalian') }}" class="px-8 py-2.5 text-gray-400 text-[10px] font-bold uppercase hover:text-white transition">Batal</a>
                    <button type="submit" class="bg-[#b91c1c] text-white px-10 py-2.5 rounded text-[10px] font-bold uppercase hover:bg-red-700 transition shadow-lg">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection