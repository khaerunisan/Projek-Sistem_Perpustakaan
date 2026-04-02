@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-white font-bold text-2xl tracking-tight uppercase italic">Edit Anggota</h2>
    </div>

    {{-- Container Form --}}
    <div class="bg-[#1c2128] w-full max-w-5xl mx-auto rounded shadow-2xl p-10 border border-gray-800">
        {{-- PERBAIKAN: Menggunakan $petugas agar sinkron dengan Controller --}}
        <form action="{{ route('petugas.anggota.update', $petugas->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                
                {{-- Id Anggota --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">Id Anggota</label>
                    <input type="text" name="id_anggota" value="{{ old('id_anggota', '10.' . str_pad($petugas->id, 3, '0', STR_PAD_LEFT)) }}" readonly
                           class="w-full bg-[#0b0e11] border border-gray-800 rounded-md p-2 text-gray-500 outline-none cursor-not-allowed">
                </div>

                {{-- Nama Lengkap --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $petugas->name) }}" required
                           class="w-full bg-[#000000] border border-gray-800 rounded-md p-2 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Program Studi --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">Program Studi</label>
                    <input type="text" name="prodi" value="{{ old('prodi', $petugas->prodi) }}"
                           class="w-full bg-[#000000] border border-gray-800 rounded-md p-2 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Alamat --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $petugas->alamat) }}"
                           class="w-full bg-[#000000] border border-gray-800 rounded-md p-2 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- No Telphon --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">No Telphon</label>
                    {{-- PERBAIKAN: name="phone" dan value memanggil $petugas->phone agar muncul datanya --}}
                    <input type="text" name="phone" value="{{ old('phone', $petugas->phone) }}"
                           class="w-full bg-[#000000] border border-gray-800 rounded-md p-2 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Email --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $petugas->email) }}" required
                           class="w-full bg-[#000000] border border-gray-800 rounded-md p-2 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Password (Opsional) --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">Password (Kosongkan jika tidak diganti)</label>
                    <input type="password" name="password"
                           class="w-full bg-[#000000] border border-gray-800 rounded-md p-2 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Tombol Action --}}
                <div class="pt-10 flex justify-end items-center gap-4">
                    <a href="{{ route('petugas.anggota') }}" 
                       class="bg-[#5a6268] hover:bg-gray-600 text-white px-6 py-2 rounded text-[11px] font-bold transition shadow-lg">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="bg-[#e06c1a] hover:bg-[#c95f16] text-white px-8 py-2 rounded text-[11px] font-bold transition shadow-lg">
                        Update Data
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection