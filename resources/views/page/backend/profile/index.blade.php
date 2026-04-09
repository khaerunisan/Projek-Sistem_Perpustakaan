@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    <div class="max-w-4xl mx-auto">
        {{-- Judul Halaman --}}
        <div class="flex items-center gap-4 mb-8">
            <h2 class="text-white font-bold text-2xl italic uppercase tracking-wider">Profil Saya</h2>
            <div class="h-[2px] flex-1 bg-gradient-to-r from-blue-600 to-transparent"></div>
        </div>

        <div class="bg-[#111419] rounded-xl border border-gray-800 overflow-hidden shadow-2xl">
            {{-- Bagian Atas: Avatar & Ringkasan --}}
            <div class="p-8 border-b border-gray-800 bg-[#161b22] flex flex-col md:flex-row items-center gap-6">
                {{-- Inisial Nama Otomatis --}}
                <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-black shadow-lg border-4 border-gray-800 uppercase">
                    {{ substr($user->name, 0, 1) }}
                </div>
                
                <div class="text-center md:text-left">
                    <h3 class="text-white font-black text-xl uppercase tracking-tight">{{ $user->name }}</h3>
                    <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-2">
                        <span class="bg-blue-600/20 text-blue-500 text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full border border-blue-500/30">
                            {{ $user->role }}
                        </span>
                        <span class="bg-gray-800 text-gray-400 text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full border border-gray-700">
                            ID: #{{ $user->id }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Bagian Bawah: Detail Data --}}
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Kolom Kiri --}}
                    <div class="space-y-6">
                        <div>
                            <label class="text-gray-500 text-[10px] uppercase tracking-widest font-black block mb-2">Nama Lengkap</label>
                            <div class="bg-[#000000] p-4 rounded-lg border border-gray-800 text-gray-200 font-medium">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div>
                            <label class="text-gray-500 text-[10px] uppercase tracking-widest font-black block mb-2">Alamat Email</label>
                            <div class="bg-[#000000] p-4 rounded-lg border border-gray-800 text-gray-200 font-medium">
                                {{ $user->email }}
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-6">
                        <div>
                            <label class="text-gray-500 text-[10px] uppercase tracking-widest font-black block mb-2">Nomor Telepon</label>
                            <div class="bg-[#000000] p-4 rounded-lg border border-gray-800 text-gray-200 font-medium">
                                {{ $user->no_telp ?? 'Data belum diisi' }}
                            </div>
                        </div>

                        <div>
                            <label class="text-gray-500 text-[10px] uppercase tracking-widest font-black block mb-2">Tanggal Bergabung</label>
                            <div class="bg-[#000000] p-4 rounded-lg border border-gray-800 text-gray-200 font-medium italic">
                                {{ $user->created_at->translatedFormat('d F Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Catatan Alamat --}}
                <div class="mt-8">
                    <label class="text-gray-500 text-[10px] uppercase tracking-widest font-black block mb-2">Alamat Lengkap</label>
                    <div class="bg-[#000000] p-4 rounded-lg border border-gray-800 text-gray-200 font-medium">
                        {{ $user->alamat ?? 'Data alamat belum dilengkapi' }}
                    </div>
                </div>
            </div>

            {{-- Footer Action --}}
            <div class="p-6 bg-[#0c0f13] border-t border-gray-800 flex justify-between items-center">
                <p class="text-gray-600 text-[10px] italic">*Data ini sesuai dengan informasi pendaftaran Anda.</p>
                <div class="flex gap-4">
                    {{-- PERBAIKAN: Tombol Kembali ke Dashboard --}}
                    <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition shadow-lg no-underline inline-block">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection