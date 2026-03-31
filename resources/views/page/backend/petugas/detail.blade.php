@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- Header Judul --}}
    <div class="mb-6">
        <h2 class="text-white font-bold text-2xl tracking-tight uppercase italic">Detail Buku</h2>
    </div>

    {{-- Main Container --}}
    <div class="bg-[#1c2128] w-full max-w-5xl mx-auto rounded-xl shadow-2xl p-8 border border-gray-800">
        <h3 class="text-white font-bold text-xl mb-8 tracking-wide">{{ $buku->judul }}</h3>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
            
            {{-- Bagian Kiri: Preview Cover --}}
            <div class="md:col-span-4 flex flex-col items-center">
                <div class="bg-[#30363d] p-4 rounded-2xl border border-gray-700 shadow-inner w-full flex justify-center">
                    @if($buku->cover)
                        {{-- Menggunakan storage/ karena di database formatnya 'buku/namafile.jpg' --}}
                        <img src="{{ asset('storage/' . $buku->cover) }}" 
                             alt="{{ $buku->judul }}" 
                             class="w-full h-auto rounded-lg shadow-2xl object-cover border border-gray-600">
                    @else
                        <div class="py-24 text-gray-500 italic">No Cover Available</div>
                    @endif
                </div>
            </div>

            {{-- Bagian Kanan: Informasi Detail --}}
            <div class="md:col-span-8 space-y-5">
                
                {{-- Penerbit --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase tracking-widest block mb-1">Penerbit</label>
                    <div class="w-full bg-[#0d1117] border border-gray-800 rounded-lg p-3 text-gray-300">
                        {{ $buku->penerbit }}
                    </div>
                </div>

                {{-- Penulis --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase tracking-widest block mb-1">Penulis</label>
                    <div class="w-full bg-[#0d1117] border border-gray-800 rounded-lg p-3 text-gray-300">
                        {{ $buku->pengarang }} {{-- Kolom di database: pengarang --}}
                    </div>
                </div>

                {{-- Tahun Terbit --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase tracking-widest block mb-1">Tahun Terbit</label>
                    <div class="w-full bg-[#0d1117] border border-gray-800 rounded-lg p-3 text-gray-300">
                        {{ $buku->thn_terbit }} {{-- Kolom di database: thn_terbit --}}
                    </div>
                </div>

                {{-- Stok --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase tracking-widest block mb-1">Stok</label>
                    <div class="inline-block bg-[#161b22] border border-gray-700 px-4 py-1.5 rounded-full text-xs font-semibold text-cyan-400">
                        {{ $buku->stok }} Tersedia
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase tracking-widest block mb-1">Deskripsi Buku</label>
                    <div class="w-full bg-[#0d1117] border border-gray-800 rounded-lg p-4 text-gray-400 text-xs leading-relaxed min-h-[120px]">
                        {{ $buku->deskripsi ?: 'Tidak ada deskripsi untuk buku ini.' }}
                    </div>
                </div>

                {{-- Tombol Kembali --}}
                <div class="pt-6 border-t border-gray-800 flex justify-start">
                    <a href="{{ route('petugas.buku') }}" 
                       class="bg-[#3a3a3c] hover:bg-gray-600 text-white px-8 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all shadow-lg">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection