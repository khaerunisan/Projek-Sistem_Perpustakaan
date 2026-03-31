@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-8 text-sm">
    {{-- Header --}}
    <h1 class="text-white font-bold text-xl mb-6 ml-4">Detail Buku</h1>

    {{-- Container Card Utama --}}
    <div class="bg-[#1c1f26] rounded-md shadow-2xl p-10 max-w-6xl mx-auto border border-gray-800">
        
        <div class="flex flex-col md:flex-row gap-12">
            
            {{-- Sisi Kiri: Cover Buku & Tombol --}}
            <div class="w-full md:w-1/3 flex flex-col gap-6">
                <div class="bg-[#4a5568] rounded-lg p-5 shadow-lg">
                    {{-- DIUBAH: Menggunakan variabel 'cover' sesuai database --}}
                    @if($buku->cover)
                        <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}" class="w-full rounded shadow-md object-cover aspect-[3/4]">
                    @else
                        <div class="w-full aspect-[3/4] bg-gray-700 rounded flex items-center justify-center">
                            <i class="fas fa-book fa-4x text-gray-500"></i>
                        </div>
                    @endif
                </div>
                
                {{-- Tombol Kembali --}}
                <a href="{{ route('kepala.data-buku') }}" class="bg-[#3b5998] hover:bg-[#2d4373] text-white text-center py-2 px-8 rounded shadow-md transition-all text-xs w-[120px]">
                    Kembali
                </a>
            </div>

            {{-- Sisi Kanan: Judul & Input Fields --}}
            <div class="w-full md:w-2/3">
                <h2 class="text-white font-bold text-2xl mb-8 tracking-wide">{{ $buku->judul }}</h2>

                <div class="space-y-5">
                    {{-- Penerbit --}}
                    <div>
                        <label class="text-[#718096] text-[12px] block mb-2">Penerbit</label>
                        <div class="bg-[#000000] border border-gray-900 rounded-md px-4 py-2.5 text-gray-400">
                            {{ $buku->penerbit }}
                        </div>
                    </div>

                    {{-- Penulis --}}
                    <div>
                        <label class="text-[#718096] text-[12px] block mb-2">Penulis</label>
                        <div class="bg-[#000000] border border-gray-900 rounded-md px-4 py-2.5 text-gray-400">
                            {{-- DIUBAH: Menggunakan variabel 'pengarang' sesuai database --}}
                            {{ $buku->pengarang }}
                        </div>
                    </div>

                    {{-- Tahun Terbit --}}
                    <div>
                        <label class="text-[#718096] text-[12px] block mb-2">Tahun Terbit</label>
                        <div class="bg-[#000000] border border-gray-900 rounded-md px-4 py-2.5 text-gray-400">
                            {{-- DIUBAH: Menggunakan variabel 'thn_terbit' sesuai database --}}
                            {{ $buku->thn_terbit }}
                        </div>
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label class="text-[#718096] text-[12px] block mb-2">Stok</label>
                        <div class="inline-block bg-[#000000] border border-gray-900 rounded-full px-4 py-1 text-gray-400 text-xs">
                            <span class="font-bold">{{ $buku->stok }}</span> Tersedia
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="text-[#718096] text-[12px] block mb-2">Deskripsi Buku</label>
                        <div class="bg-[#000000] border border-gray-900 rounded-md p-4 text-gray-500 leading-relaxed min-h-[120px] text-[13px]">
                            {{ $buku->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.' }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection