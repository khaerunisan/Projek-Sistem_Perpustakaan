@extends('layouts.backend.app')

@section('content')

<div class="min-h-screen bg-[#000000] text-white p-6">
    <h2 class="text-2xl font-bold mb-6 text-white">Detail Buku</h2>

    <div class="bg-[#161b22] rounded-xl p-8 max-w-5xl shadow-2xl border border-[#30363d]">
        <h3 class="text-3xl font-bold mb-8 tracking-tight">{{ $buku->judul }}</h3>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
           <div class="md:col-span-4 bg-[#30363d] rounded-2xl p-4 flex items-center justify-center">
                @if($buku->cover)
                    {{-- PERBAIKAN: Menggunakan storage karena di database sudah ada tulisan 'buku/' --}}
                    <img src="{{ asset('storage/' . $buku->cover) }}" 
                        alt="Cover Buku" 
                        class="w-full rounded-lg shadow-lg object-cover">
                @else
                    {{-- Default jika gambar tidak ada --}}
                    <div class="flex flex-col items-center text-gray-500 italic text-xs">
                        <i class="fas fa-book fa-3x mb-2"></i>
                        No Cover
                    </div>
                @endif
            </div>

            <div class="md:col-span-8 space-y-5">
                <div>
                    <label class="text-gray-400 text-sm mb-1 block">Penerbit</label>
                    <div class="bg-[#000000] border border-[#30363d] p-3 rounded-lg w-full text-gray-300">
                        {{ $buku->penerbit }}
                    </div>
                </div>

                <div>
                    <label class="text-gray-400 text-sm mb-1 block">Penulis</label>
                    <div class="bg-[#000000] border border-[#30363d] p-3 rounded-lg w-full text-gray-300">
                        {{ $buku->pengarang }}
                    </div>
                </div>

                <div>
                    <label class="text-gray-400 text-sm mb-1 block">Tahun Terbit</label>
                    <div class="bg-[#000000] border border-[#30363d] p-3 rounded-lg w-full text-gray-300">
                        {{ $buku->thn_terbit }}
                    </div>
                </div>

                <div>
                    <label class="text-gray-400 text-sm mb-1 block">Stok</label>
                    <span class="bg-[#000000] border border-[#30363d] px-4 py-1.5 rounded-full text-xs font-semibold text-gray-300 inline-block">
                        {{ $buku->stok }} Tersedia
                    </span>
                </div>

                <div>
                    <label class="text-gray-400 text-sm mb-1 block">Deskripsi Buku</label>
                    <div class="bg-[#000000] border border-[#30363d] p-4 rounded-lg w-full text-gray-400 text-sm leading-relaxed min-h-[120px]">
                        {{ $buku->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex gap-4">
            <a href="{{ route('anggota.daftarbuku') }}" 
               class="bg-[#3b5998] hover:bg-[#2d4373] text-white px-8 py-2.5 rounded-md transition duration-300 inline-block font-medium">
                Kembali
            </a>
            
            <a href="{{ route('buku.pinjam', $buku->id) }}" 
                class="bg-red-600 hover:bg-red-700 text-white px-8 py-2.5 rounded-md transition duration-300 inline-block font-medium text-center">
                Pinjam Buku
            </a>
        </div>
    </div>
</div>

@endsection