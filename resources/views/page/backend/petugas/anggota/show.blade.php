@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-8 text-sm">
    {{-- Header Halaman --}}
    <div class="mb-6 ml-2 text-uppercase italic">
        <h1 class="text-white font-bold text-xl uppercase">Detail Profil Anggota</h1>
    </div>

    {{-- Kartu Detail --}}
    <div class="bg-[#1c1f26] rounded-xl shadow-2xl p-10 max-w-5xl border border-gray-800 mx-auto">
        <div class="flex flex-col md:flex-row gap-12">
            
            {{-- Sisi Kiri: Foto & Tombol Kembali --}}
            <div class="w-full md:w-1/3 flex flex-col items-center border-r border-gray-800 pr-10">
                <div class="relative">
                    <div class="bg-[#2c3038] rounded-full p-1 shadow-lg w-44 h-44 overflow-hidden border-4 border-blue-600">
                        <img src="{{ asset('assetsbackend/img/user.jpg') }}" class="w-full h-full object-cover rounded-full">
                    </div>
                </div>
                
                <div class="mt-6 text-center uppercase italic">
                    <h2 class="text-white font-bold text-lg tracking-tight">{{ $anggota->name }}</h2>
                    <p class="text-gray-500 text-[10px] mt-1 tracking-widest">ID: 10.{{ str_pad($anggota->id, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
                
                <a href="{{ route('petugas.anggota') }}" class="mt-10 bg-[#2c3038] hover:bg-gray-700 text-white text-center py-2.5 px-6 rounded-full transition-all text-[10px] w-full font-bold uppercase tracking-widest border border-gray-700 shadow-lg">
                    <i class="fas fa-arrow-left me-2"></i> Kembali 
                </a>
            </div>

            {{-- Sisi Kanan: Data Profil (Read Only) --}}
            <div class="w-full md:w-2/3 space-y-7 uppercase italic">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-gray-600 text-[9px] block mb-2 font-black tracking-widest">Nama Lengkap Anggota</label>
                        <div class="bg-[#000000] border border-gray-800 rounded-lg px-4 py-3 text-gray-200 font-bold shadow-inner">
                            {{ $anggota->name }}
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-600 text-[9px] block mb-2 font-black tracking-widest">Program Studi / Jurusan</label>
                        <div class="bg-[#000000] border border-gray-800 rounded-lg px-4 py-3 text-gray-200 font-bold shadow-inner">
                            {{ $anggota->prodi ?? 'BELUM DIISI' }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-gray-600 text-[9px] block mb-2 font-black tracking-widest">Alamat Email</label>
                        <div class="bg-[#000000] border border-gray-800 rounded-lg px-4 py-3 text-gray-400">
                            {{ $anggota->email }}
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-600 text-[9px] block mb-2 font-black tracking-widest">No. Telepon / WhatsApp</label>
                        <div class="bg-[#000000] border border-gray-800 rounded-lg px-4 py-3 text-emerald-500 font-bold shadow-inner">
                            {{-- Menggunakan kolom 'phone' sesuai database --}}
                            {{ $anggota->phone ?? '-' }}
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-gray-600 text-[9px] block mb-2 font-black tracking-widest">Alamat Domisili Lengkap</label>
                    <div class="bg-[#000000] border border-gray-800 rounded-lg px-4 py-3 text-gray-400 italic">
                        {{ $anggota->alamat ?? 'INFORMASI ALAMAT BELUM DILENGKAPI' }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-gray-600 text-[9px] block mb-2 font-black tracking-widest">Status Keanggotaan</label>
                        <div class="bg-blue-900/10 border border-blue-800/30 rounded-lg px-4 py-3 text-blue-500 font-bold">
                            {{ strtoupper($anggota->role) }} TETAP
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-600 text-[9px] block mb-2 font-black tracking-widest">Tanggal Registrasi</label>
                        <div class="bg-[#000000] border border-gray-800 rounded-lg px-4 py-3 text-gray-400 font-bold">
                            {{ $anggota->created_at->translatedFormat('d F Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection