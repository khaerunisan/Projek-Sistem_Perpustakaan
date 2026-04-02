@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans text-gray-300">
    
    <div class="flex items-center mb-6 ml-2">
        <div class="w-1 h-6 bg-red-600 mr-3"></div>
        <h2 class="text-white font-bold text-lg uppercase italic tracking-wider">Detail Informasi Denda</h2>
    </div>

    <div class="bg-[#111419] rounded-xl p-8 border border-gray-800 shadow-2xl max-w-4xl mx-auto relative overflow-hidden">
        {{-- Watermark Status --}}
        <div class="absolute -right-8 -top-8 bg-red-600/10 text-red-600 px-16 py-8 rotate-12 font-black text-2xl border border-red-600/20 uppercase pointer-events-none">
            Terlambat
        </div>

        <div class="flex flex-col md:flex-row gap-8">
            
            {{-- Foto Buku --}}
            <div class="w-full md:w-1/3 text-center border-r border-gray-800 pr-8">
                <div class="bg-[#2a2e35] rounded-lg p-3 shadow-inner inline-block w-full border border-gray-700">
                    {{-- CEK DISINI: Menggunakan 'cover' sesuai screenshot database kamu --}}
                    @if($denda->buku && $denda->buku->cover)
                        @php
                            $nama_file = str_replace('buku/', '', $denda->buku->cover);
                        @endphp
                        <img src="{{ asset('assetsbackend/img/' . $nama_file) }}" 
                             class="w-full rounded shadow-md object-cover" 
                             style="max-height: 400px;"
                             onerror="this.onerror=null;this.src='{{ asset('assetsbackend/img/user.jpg') }}';">
                    @else
                        <div class="w-full h-64 bg-gray-900 flex items-center justify-center rounded border border-gray-700 italic text-gray-600 uppercase">No Image</div>
                    @endif
                </div>
                <h3 class="text-white font-bold text-lg mt-4 uppercase tracking-tighter italic">
                    {{ $denda->buku->judul ?? '-' }}
                </h3>
                <span class="text-red-500 font-mono text-[10px]">#Buku-{{ $denda->buku->id_buku ?? $denda->buku_id }}</span>
            </div>

            {{-- Form Detail Denda --}}
            <div class="w-full md:w-2/3 space-y-4">
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest block mb-1">ID Denda</label>
                        <div class="w-full bg-[#1c1f26] text-white p-2.5 rounded border border-gray-800 font-mono">
                            #DND-{{ $denda->id }}
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest block mb-1">Nama Anggota</label>
                        <div class="w-full bg-[#1c1f26] text-gray-200 p-2.5 rounded border border-gray-800 uppercase font-semibold">
                            {{ $denda->user->name ?? '-' }}
                        </div>
                    </div>
                </div>

                {{-- Bagian Tanggal --}}
                <div class="grid grid-cols-2 gap-4 border-y border-gray-800/50 py-4">
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest block mb-1">Seharusnya Kembali</label>
                        <div class="text-white text-xs">
                            {{ \Carbon\Carbon::parse($denda->tgl_kembali)->translatedFormat('d F Y') }}
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest block mb-1">Dikembalikan Pada</label>
                        <div class="text-red-500 text-xs font-bold">
                            {{ \Carbon\Carbon::parse($denda->updated_at)->translatedFormat('d F Y') }}
                        </div>
                    </div>
                </div>

                {{-- Perbaikan Hitungan Hari --}}
                <div class="bg-red-600/5 border border-red-600/20 p-4 rounded-lg">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-400 text-[10px] uppercase font-bold">Total Keterlambatan</span>
                        <span class="text-white font-bold">
                            @php
                                $deadline = \Carbon\Carbon::parse($denda->tgl_kembali)->startOfDay();
                                $realita = \Carbon\Carbon::parse($denda->updated_at)->startOfDay();
                                $hari = $deadline->diffInDays($realita, false);
                                $hasilHari = $hari > 0 ? $hari : 0;
                            @endphp
                            {{ $hasilHari }} Hari
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 text-[10px] uppercase font-bold text-[11px]">Total Tagihan Denda</span>
                        <span class="text-red-500 font-black text-xl italic">
                            Rp {{ number_format($denda->denda, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div>
                    <label class="text-gray-500 text-[10px] uppercase font-bold tracking-widest block mb-1">Metode Pembayaran</label>
                    <div class="w-full bg-[#1c1f26] text-green-500 p-2.5 rounded border border-gray-800 font-bold uppercase tracking-widest">
                        {{ $denda->metode_pembayaran ?? 'CASH / TUNAI' }}
                    </div>
                </div>

                <div class="pt-6 flex justify-end">
                    <a href="{{ route('kepala.denda') }}" class="bg-[#2a2e35] hover:bg-gray-700 text-white px-10 py-2 rounded font-bold text-xs transition uppercase tracking-widest border border-gray-700">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection