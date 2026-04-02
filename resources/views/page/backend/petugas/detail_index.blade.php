@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- Judul Halaman --}}
    <h2 class="text-white font-bold text-lg mb-6 ml-2 uppercase italic tracking-wider">Detail Informasi Petugas</h2>

    <div class="max-w-4xl">
        {{-- Card Container --}}
        <div class="bg-[#111419] rounded-xl border border-gray-800 shadow-2xl overflow-hidden">
            
            {{-- Header Profil --}}
            <div class="bg-[#1c1f26] p-8 border-b border-gray-800 flex items-center gap-6">
                <div class="w-20 h-20 bg-red-900/20 border border-red-600/30 rounded-full flex items-center justify-center shadow-inner">
                    <span class="text-red-600 text-3xl font-bold uppercase">{{ substr($petugas->name, 0, 1) }}</span>
                </div>
                <div>
                    <h1 class="text-white text-2xl font-bold tracking-tight">{{ $petugas->name }}</h1>
                    <p class="text-gray-500 text-[10px] mt-1 uppercase tracking-[0.2em] font-bold">Role: <span class="text-red-500">Petugas Perpustakaan</span></p>
                </div>
            </div>

            {{-- Grid Informasi --}}
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                
                {{-- Sisi Kiri: Akun --}}
                <div class="space-y-6">
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2">Alamat Email</label>
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-4 bg-red-600"></div>
                            <p class="text-gray-200 font-medium">{{ $petugas->email }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2">ID Identitas</label>
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-4 bg-gray-700"></div>
                            <p class="text-gray-200 font-mono text-sm tracking-tighter">
                                {{ rand(10,99) }}.{{ str_pad($petugas->id, 3, '0', STR_PAD_LEFT) }}.{{ rand(100,999) }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Sisi Kanan: Kontak --}}
                <div class="space-y-6">
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2">Nomor Telepon</label>
                        <div class="flex items-center gap-3">
                            <div class="w-1 h-4 bg-red-600"></div>
                            <p class="text-gray-200 font-medium">{{ $petugas->phone ?? '-' }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2">Alamat Domisili</label>
                        <div class="flex items-start gap-3">
                            <div class="w-1 h-4 bg-gray-700 mt-1"></div>
                            <p class="text-gray-200 leading-relaxed">{{ $petugas->alamat ?? 'Belum diisi.' }}</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer Tombol --}}
            <div class="bg-[#0d0f13] px-8 py-5 border-t border-gray-800 flex justify-end gap-3">
                <a href="{{ route('kepala.petugas') }}" 
                   class="px-5 py-2 rounded text-gray-400 text-[10px] font-bold uppercase hover:text-white transition border border-transparent hover:border-gray-700">
                    Kembali
                </a>
                <a href="{{ route('petugas.anggota.edit', $petugas->id) }}" 
                   class="px-5 py-2 rounded bg-red-600 text-white text-[10px] font-bold uppercase hover:bg-red-700 transition shadow-lg tracking-wider">
                    Ubah Data
                </a>
            </div>
        </div>
    </div>
</div>
@endsection