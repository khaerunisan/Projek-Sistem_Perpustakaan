@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('petugas.denda') }}" class="text-gray-500 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h2 class="text-white font-bold text-lg italic uppercase tracking-wider">Update Nominal Denda</h2>
    </div>

    <div class="bg-[#111419] rounded-xl p-8 border border-gray-800 shadow-2xl max-w-2xl">
        <form action="{{ route('petugas.denda.update', $peminjaman->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                {{-- Info Anggota (Read Only) --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase tracking-[2px] font-bold mb-2 block">Nama Anggota</label>
                        <input type="text" value="{{ $peminjaman->user->name }}" class="w-full bg-[#1c2128]/50 text-gray-500 text-xs rounded-lg py-3 px-4 border border-gray-800 outline-none" readonly>
                    </div>
                    <div>
                        <label class="text-gray-500 text-[10px] uppercase tracking-[2px] font-bold mb-2 block">Judul Buku</label>
                        <input type="text" value="{{ $peminjaman->buku->judul }}" class="w-full bg-[#1c2128]/50 text-gray-500 text-xs rounded-lg py-3 px-4 border border-gray-800 outline-none" readonly>
                    </div>
                </div>

                {{-- Input Denda --}}
                <div>
                    <label for="denda" class="text-gray-300 text-[10px] uppercase tracking-[2px] font-bold mb-2 block">Nominal Denda Baru (Rp)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-4 flex items-center text-gray-500 font-bold">Rp</span>
                        <input type="number" name="denda" id="denda" 
                               value="{{ old('denda', $peminjaman->denda) }}"
                               class="w-full bg-[#1c2128] text-white text-lg font-bold rounded-lg py-4 pl-12 pr-4 border border-gray-800 outline-none focus:ring-1 focus:ring-red-500 transition @error('denda') border-red-500 @enderror"
                               placeholder="0">
                    </div>
                    @error('denda')
                        <p class="text-red-500 text-[10px] mt-2 italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-800 flex items-center justify-between">
                <p class="text-gray-600 text-[10px] italic">*Pastikan nominal sudah sesuai dengan kebijakan perpustakaan.</p>
                <div class="flex gap-3">
                    <button type="submit" class="bg-[#b91c1c] text-white px-8 py-3 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition shadow-lg">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection