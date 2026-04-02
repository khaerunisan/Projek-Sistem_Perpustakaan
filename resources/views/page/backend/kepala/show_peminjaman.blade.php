@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    <h2 class="text-white font-bold text-lg mb-6 ml-2 uppercase italic tracking-wider">Detail Peminjaman</h2>

    {{-- Card Utama --}}
    <div class="bg-[#111419] rounded-xl p-8 border border-gray-800 shadow-2xl max-w-4xl mx-auto">
        
        <div class="flex flex-col md:flex-row gap-8">
            
            {{-- Bagian Kiri: Poster Buku --}}
            <div class="w-full md:w-1/3">
                <div class="bg-[#2a2e35] rounded-lg p-3 shadow-inner">
                    @if($peminjaman->buku && $peminjaman->buku->cover)
                        <img src="{{ asset('storage/' . $peminjaman->buku->cover) }}" alt="Cover Buku" class="w-full rounded shadow-md object-cover">
                    @else
                        {{-- Placeholder jika tidak ada gambar --}}
                        <div class="w-full h-64 bg-gray-800 flex items-center justify-center rounded text-gray-500 italic">
                            No Cover Available
                        </div>
                    @endif
                </div>
                <h3 class="text-white font-bold text-xl mt-4 text-center uppercase">{{ $peminjaman->buku->judul ?? '-' }}</h3>
            </div>

            {{-- Bagian Kanan: Form Detail --}}
            <div class="w-full md:w-2/3 space-y-4">
                
                {{-- Id Buku --}}
                <div>
                    <label class="text-gray-500 text-xs block mb-1">Id Buku</label>
                    <div class="w-full bg-[#000000] text-gray-300 p-2 rounded border border-gray-800 font-mono">
                        {{ $peminjaman->buku->id_buku ?? $peminjaman->buku_id ?? '-' }}
                    </div>
                </div>

                {{-- Nama Anggota --}}
                <div>
                    <label class="text-gray-500 text-xs block mb-1">Nama Anggota</label>
                    <div class="w-full bg-[#000000] text-gray-300 p-2 rounded border border-gray-800">
                        {{ $peminjaman->user->name ?? '-' }}
                    </div>
                </div>

                {{-- Tanggal Pinjam --}}
                <div>
                    <label class="text-gray-500 text-xs block mb-1">Tanggal Pinjam</label>
                    <div class="w-full bg-[#000000] text-gray-300 p-2 rounded border border-gray-800">
                        {{ $peminjaman->tgl_pinjam ? \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d F Y') : '-' }}
                    </div>
                </div>

                {{-- Tanggal Pengembalian --}}
                <div>
                    <label class="text-gray-500 text-xs block mb-1">Tanggal Pengembalian</label>
                    <div class="w-full bg-[#000000] text-gray-300 p-2 rounded border border-gray-800">
                        {{ $peminjaman->tgl_kembali ? \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d F Y') : '-' }}
                    </div>
                </div>

                {{-- Tombol Kembali --}}
                <div class="pt-4">
                    <a href="{{ route('kepala.peminjaman') }}" class="bg-[#3b82f6] hover:bg-blue-700 text-white px-6 py-2 rounded text-xs font-bold transition shadow-lg inline-block">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection