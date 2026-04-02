@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans text-gray-300">
    
    <h2 class="text-white font-bold text-lg mb-6 ml-2 uppercase italic tracking-wider">Detail Pengembalian</h2>

    <div class="bg-[#111419] rounded-xl p-8 border border-gray-800 shadow-2xl max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row gap-8">
            
            {{-- Foto Buku --}}
            <div class="w-full md:w-1/3 text-center border-r border-gray-800 pr-8">
                <div class="bg-[#2a2e35] rounded-lg p-3 shadow-inner inline-block w-full">
                    @if($peminjaman->buku && $peminjaman->buku->foto)
                        {{-- Logika Fallback Gambar: Cek folder root storage, lalu folder buku --}}
                        <img src="{{ asset('storage/' . $peminjaman->buku->foto) }}" 
                             class="w-full rounded shadow-md object-cover" 
                             style="max-height: 400px;"
                             onerror="this.onerror=null;this.src='{{ asset('storage/buku/' . $peminjaman->buku->foto) }}';">
                    @else
                        <div class="w-full h-64 bg-gray-900 flex items-center justify-center rounded border border-gray-700 italic text-gray-600">No Image</div>
                    @endif
                </div>
                <h3 class="text-white font-bold text-lg mt-4 uppercase tracking-tighter italic">
                    {{ $peminjaman->buku->judul ?? '-' }}
                </h3>
                {{-- Tambahan: Kategori Buku --}}
                <p class="text-gray-500 text-[10px] mt-1 uppercase tracking-widest">
                    Kategori: {{ $peminjaman->buku->kategori->nama ?? 'Umum' }}
                </p>
            </div>

            {{-- Form Detail --}}
            <div class="w-full md:w-2/3 space-y-4">
                
                {{-- Id Buku --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest block mb-1">Id Buku</label>
                    <div class="w-full bg-[#1c1f26] text-red-500 p-2.5 rounded border border-gray-800 font-mono">
                        {{ $peminjaman->buku->id_buku ?? $peminjaman->buku_id ?? '-' }}
                    </div>
                </div>

                {{-- Nama Anggota --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest block mb-1">Nama Anggota</label>
                    <div class="w-full bg-[#1c1f26] text-gray-200 p-2.5 rounded border border-gray-800 uppercase text-xs">
                        {{ $peminjaman->user->name ?? '-' }}
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    {{-- Tanggal Pinjam --}}
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest block mb-1">Tanggal Pinjam</label>
                        <div class="w-full bg-[#1c1f26] text-gray-200 p-2.5 rounded border border-gray-800">
                            {{ $peminjaman->tgl_pinjam ? \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d F Y') : '-' }}
                        </div>
                    </div>
                    {{-- Tanggal Kembali --}}
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest block mb-1">Tanggal Kembali</label>
                        <div class="w-full bg-[#1c1f26] text-gray-200 p-2.5 rounded border border-gray-800">
                            {{ $peminjaman->tgl_kembali ? \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d F Y') : '-' }}
                        </div>
                    </div>
                </div>

                {{-- Status Ketepatan Waktu --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest block mb-1">Status Pengembalian</label>
                    <div class="w-full bg-[#1c1f26] p-2.5 rounded border border-gray-800 italic">
                        @if($peminjaman->denda > 0)
                            <span class="text-red-500 font-bold uppercase">Terlambat</span>
                        @else
                            <span class="text-green-500 font-bold uppercase">Tepat Waktu</span>
                        @endif
                    </div>
                </div>

                {{-- Denda --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest block mb-1">Denda</label>
                    <div class="w-full bg-[#1c1f26] {{ $peminjaman->denda > 0 ? 'text-red-500' : 'text-green-500' }} p-2.5 rounded border border-gray-800 font-bold">
                        {{ $peminjaman->denda > 0 ? 'Rp ' . number_format($peminjaman->denda, 0, ',', '.') : 'Tidak Ada Denda' }}
                    </div>
                </div>

                {{-- Metode Pembayaran --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest block mb-1">Metode Pembayaran</label>
                    <div class="w-full bg-[#1c1f26] text-gray-200 p-2.5 rounded border border-gray-800 font-bold uppercase text-[11px]">
                        {{ $peminjaman->metode_pembayaran ?? ($peminjaman->denda > 0 ? 'Cash' : '-') }}
                    </div>
                </div>

                <div class="pt-6 flex justify-end">
                    <a href="{{ route('kepala.pengembalian') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-2 rounded font-bold text-xs transition uppercase tracking-widest shadow-lg">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection