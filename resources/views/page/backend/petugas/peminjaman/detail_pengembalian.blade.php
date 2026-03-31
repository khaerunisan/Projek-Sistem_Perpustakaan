@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-8 text-sm font-sans text-gray-300">
    <h2 class="text-white font-bold text-xl mb-6 italic uppercase tracking-wider">Detail Pengembalian</h2>

    <div class="bg-[#111419] rounded-xl p-8 border border-gray-800 shadow-2xl max-w-5xl">
        {{-- Judul Buku --}}
        <h3 class="text-white font-bold text-2xl mb-8 ml-2 italic uppercase tracking-tight">
            {{ $peminjaman->buku->judul }}
        </h3>

        <div class="flex flex-col md:flex-row gap-12">
            {{-- Sisi Kiri: Cover Buku --}}
            <div class="w-full md:w-1/3 bg-[#1c2128] p-5 rounded-2xl border border-gray-800 shadow-inner flex justify-center items-center">
                <img src="{{ asset('storage/' . $peminjaman->buku->cover) }}" 
                     alt="Cover Buku" 
                     class="w-full h-auto rounded-lg shadow-2xl border border-gray-700 object-cover">
            </div>

            {{-- Sisi Kanan: Detail Informasi --}}
            <div class="flex-1 space-y-6">
                <div>
                    <label class="text-gray-500 text-[10px] mb-2 block uppercase font-bold tracking-widest">Id Buku</label>
                    <div class="w-full bg-black text-gray-400 py-3 px-5 rounded-lg border border-gray-800 font-mono italic shadow-inner">
                        {{ $peminjaman->id_peminjaman }}
                    </div>
                </div>

                <div>
                    <label class="text-gray-500 text-[10px] mb-2 block uppercase font-bold tracking-widest">Nama Anggota</label>
                    <div class="w-full bg-black text-gray-300 py-3 px-5 rounded-lg border border-gray-800">
                        {{ $peminjaman->user->name }}
                    </div>
                </div>

                <div>
                    <label class="text-gray-500 text-[10px] mb-2 block uppercase font-bold tracking-widest">Tanggal Pinjam</label>
                    <div class="w-full bg-black text-gray-400 py-3 px-5 rounded-lg border border-gray-800">
                        {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d F Y') }}
                    </div>
                </div>

                <div>
                    <label class="text-gray-500 text-[10px] mb-2 block uppercase font-bold tracking-widest">Tanggal Pengembalian</label>
                    <div class="w-full bg-black text-gray-300 py-3 px-5 rounded-lg border border-gray-800">
                        {{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d F Y') }}
                    </div>
                </div>

                {{-- Kolom Metode Pembayaran & Denda (Sesuai Screenshot) --}}
                <div>
                    <label class="text-gray-500 text-[10px] mb-2 block uppercase font-bold tracking-widest">Metode Pembayaran</label>
                    <div class="flex gap-4">
                        <div class="bg-black text-gray-300 py-3 px-8 rounded-lg border border-gray-800 flex-1 text-center font-bold italic shadow-inner">
                            {{ $peminjaman->metode_pembayaran ?? 'Dana' }}
                        </div>
                        <div class="bg-black text-gray-300 py-3 px-8 rounded-lg border border-gray-800 flex-1 text-center font-bold shadow-inner">
                            {{ number_format($peminjaman->denda, 2, '.', ',') }}
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <a href="{{ route('petugas.pengembalian') }}" 
                       class="bg-[#3b5998] hover:bg-[#2d4373] text-white px-12 py-3.5 rounded-lg text-[11px] font-black uppercase tracking-widest transition shadow-lg inline-block">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection