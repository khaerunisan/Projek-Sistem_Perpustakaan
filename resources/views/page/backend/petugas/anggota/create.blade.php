@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-white font-bold text-2xl tracking-tight uppercase italic">Tambah Anggota</h2>
    </div>

    {{-- Container Form --}}
    <div class="bg-[#1c2128] w-full max-w-5xl mx-auto rounded shadow-2xl p-10 border border-gray-800">
        <form action="{{ route('petugas.anggota.store') }}" method="POST">
            @csrf

            <div class="space-y-5">
                
                {{-- Id Anggota (Biasanya otomatis, tapi ini input sesuai screenshot) --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">Id Anggota</label>
                    <input type="text" name="id_anggota" placeholder="Masukkan ID Anggota"
                           class="w-full bg-[#000000] border border-gray-800 rounded-md p-2 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Nama Lengkap --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">Nama Lengkap</label>
                    <input type="text" name="name" required
                           class="w-full bg-[#000000] border border-gray-800 rounded-md p-2 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Program Studi --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">Program Studi</label>
                    <input type="text" name="prodi"
                           class="w-full bg-[#000000] border border-gray-800 rounded-md p-2 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Alamat --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">Alamat</label>
                    <input type="text" name="alamat"
                           class="w-full bg-[#000000] border border-gray-800 rounded-md p-2 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- No Telphon --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">No Telphon</label>
                    <input type="text" name="telp"
                           class="w-full bg-[#000000] border border-gray-800 rounded-md p-2 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Email --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">Email</label>
                    <input type="email" name="email" required
                           class="w-full bg-[#000000] border border-gray-800 rounded-md p-2 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Password --}}
                <div>
                    <label class="text-gray-500 text-[11px] block mb-2">Password</label>
                    <input type="password" name="password" required
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
                        Submit
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection