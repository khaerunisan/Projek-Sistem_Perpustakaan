@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-8 text-sm font-sans text-gray-300">
    
    <h2 class="text-white font-bold text-xl mb-6 italic uppercase tracking-wider">Detail Peminjaman</h2>

    <div class="bg-[#111419] rounded-xl p-8 border border-gray-800 shadow-2xl max-w-5xl">
        
        {{-- Judul Buku di Atas --}}
        <h3 class="text-white font-bold text-2xl mb-8 ml-2 italic uppercase tracking-tight">
            {{ $peminjaman->buku->judul }}
        </h3>

        <div class="flex flex-col md:flex-row gap-12">
            
            {{-- Sisi Kiri: Cover Buku --}}
            <div class="w-full md:w-1/3 bg-[#1c2128] p-5 rounded-2xl border border-gray-800 shadow-inner flex justify-center items-center">
                @if($peminjaman->buku->cover)
                    <img src="{{ asset('storage/' . $peminjaman->buku->cover) }}" 
                         alt="Cover Buku" 
                         class="w-full h-auto rounded-lg shadow-2xl border border-gray-700 object-cover transform hover:scale-[1.02] transition duration-300">
                @else
                    <div class="w-full aspect-[3/4] bg-gray-900 rounded-lg flex items-center justify-center text-gray-600 italic">
                        No Cover
                    </div>
                @endif
            </div>

            {{-- Sisi Kanan: Detail Informasi (Input Style Hitam) --}}
            <div class="flex-1 space-y-7">
                
                {{-- Id Buku / Id Peminjaman --}}
                <div class="group">
                    <label class="text-gray-500 text-[10px] mb-2 block uppercase tracking-[0.2em] font-bold group-hover:text-orange-500 transition">Id Buku</label>
                    <div class="w-full bg-black text-gray-400 py-3.5 px-5 rounded-lg border border-gray-800 font-mono italic shadow-inner">
                        {{ $peminjaman->id_peminjaman }}
                    </div>
                </div>

                {{-- Nama Anggota --}}
                <div class="group">
                    <label class="text-gray-500 text-[10px] mb-2 block uppercase tracking-[0.2em] font-bold group-hover:text-orange-500 transition">Nama Anggota</label>
                    <div class="w-full bg-black text-gray-300 py-3.5 px-5 rounded-lg border border-gray-800 font-medium">
                        {{ $peminjaman->user->name }}
                    </div>
                </div>

                {{-- Tanggal Pinjam --}}
                <div class="group">
                    <label class="text-gray-500 text-[10px] mb-2 block uppercase tracking-[0.2em] font-bold group-hover:text-orange-500 transition">Tanggal Pinjam</label>
                    <div class="w-full bg-black text-gray-400 py-3.5 px-5 rounded-lg border border-gray-800">
                        {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d F Y') }}
                    </div>
                </div>

                {{-- Tanggal Pengembalian --}}
                <div class="group">
                    <label class="text-gray-500 text-[10px] mb-2 block uppercase tracking-[0.2em] font-bold group-hover:text-orange-500 transition">Tanggal Pengembalian</label>
                    <div class="w-full bg-black text-gray-500 py-3.5 px-5 rounded-lg border border-gray-800 italic shadow-inner">
                        {{ $peminjaman->tgl_kembali ?? '-' }}
                    </div>
                </div>

                {{-- Tombol Kembali --}}
                <div class="pt-6">
                    <a href="{{ route('petugas.peminjaman') }}" 
                       class="bg-[#3b5998] hover:bg-[#2d4373] text-white px-12 py-3.5 rounded-lg text-[11px] font-black transition shadow-lg inline-block uppercase tracking-[0.2em]">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection