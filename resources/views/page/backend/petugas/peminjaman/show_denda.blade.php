@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('petugas.denda') }}" class="text-gray-500 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h2 class="text-white font-bold text-lg italic uppercase tracking-wider">Detail Rincian Denda</h2>
    </div>

    <div class="bg-[#111419] rounded-xl p-8 border border-gray-800 shadow-2xl max-w-4xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Sisi Kiri: Gambar Buku & Informasi Peminjaman --}}
            <div class="space-y-6">
                {{-- Tambahan Gambar Buku --}}
                <div class="flex gap-4 items-start">
                    <div class="w-32 h-44 bg-[#1c2128] rounded-lg border border-gray-800 overflow-hidden shadow-lg flex-shrink-0">
                        {{-- FIX: Menggunakan kolom 'cover' sesuai database kamu --}}
                        @if($peminjaman->buku && $peminjaman->buku->cover)
                            <img src="{{ asset('storage/' . $peminjaman->buku->cover) }}" class="w-full h-full object-cover" alt="Cover Buku">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-700 bg-[#161b22]">
                                <svg class="w-8 h-8 mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span class="text-[10px] uppercase font-bold tracking-tighter">No Image</span>
                            </div>
                        @endif
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="text-gray-500 text-[10px] uppercase tracking-[2px] font-bold">ID Peminjaman</label>
                            <p class="text-gray-200 font-mono italic text-base">#{{ $peminjaman->id_peminjaman ?? $peminjaman->id }}</p>
                        </div>
                        <div>
                            <label class="text-gray-500 text-[10px] uppercase tracking-[2px] font-bold">Judul Buku</label>
                            <p class="text-orange-500 font-medium text-base">{{ $peminjaman->buku->judul }}</p>
                        </div>
                        <div>
                            <label class="text-gray-500 text-[10px] uppercase tracking-[2px] font-bold">Nama Anggota</label>
                            <p class="text-gray-200 text-base">{{ $peminjaman->user->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sisi Kanan: Informasi Waktu & Denda --}}
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase tracking-[2px] font-bold">Tgl Pinjam</label>
                        <p class="text-gray-300">{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase tracking-[2px] font-bold">Tgl Kembali</label>
                        <p class="text-gray-300">{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div>
                    <label class="text-gray-500 text-[10px] uppercase tracking-[2px] font-bold">Status Pengembalian</label>
                    <div>
                        <span class="bg-green-500/10 text-green-500 border border-green-500/20 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">Selesai</span>
                    </div>
                </div>
                <div class="bg-[#1c2128] p-4 rounded-lg border border-gray-800">
                    <label class="text-gray-500 text-[10px] uppercase tracking-[2px] font-bold">Total Denda</label>
                    <p class="text-[#b91c1c] text-2xl font-black">Rp. {{ number_format($peminjaman->denda, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-gray-800 flex gap-3">
            {{-- FIX: Route disesuaikan dengan petugas.denda.edit yang ada di web.php kamu --}}
            <a href="{{ route('petugas.denda.edit', $peminjaman->id) }}" class="bg-[#10b981] text-white px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 transition shadow-lg flex items-center gap-2">
                Edit Nominal
            </a>
            <a href="{{ route('petugas.denda') }}" class="bg-gray-800 text-gray-400 px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-gray-700 transition flex items-center gap-2">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection