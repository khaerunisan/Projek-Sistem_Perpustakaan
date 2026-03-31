@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- Header Judul --}}
    <div class="mb-6">
        <h2 class="text-white font-bold text-2xl tracking-tight uppercase italic">Edit Buku</h2>
    </div>

    {{-- Main Container Form --}}
    <div class="bg-[#1c2128] w-full max-w-5xl mx-auto rounded-xl shadow-2xl p-8 border border-gray-800">
        <form action="{{ route('petugas.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                
                {{-- Judul Buku --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase tracking-widest block mb-2">Judul Buku</label>
                    <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" 
                           class="w-full bg-[#0d1117] border border-gray-800 rounded-lg p-3 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Penerbit --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase tracking-widest block mb-2">Penerbit</label>
                    <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" 
                           class="w-full bg-[#0d1117] border border-gray-800 rounded-lg p-3 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Penulis (dikirim sebagai 'penulis' agar diterima controller) --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase tracking-widest block mb-2">Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis', $buku->pengarang) }}" 
                           class="w-full bg-[#0d1117] border border-gray-800 rounded-lg p-3 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Tahun Terbit --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase tracking-widest block mb-2">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->thn_terbit) }}" 
                           class="w-full bg-[#0d1117] border border-gray-800 rounded-lg p-3 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Stok (Tambahan agar lengkap) --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase tracking-widest block mb-2">Jumlah Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" 
                           class="w-full bg-[#0d1117] border border-gray-800 rounded-lg p-3 text-gray-300 outline-none focus:border-orange-500 transition">
                </div>

                {{-- Upload Sampul --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase tracking-widest block mb-2">Tambah Sampul Buku</label>
                    <div class="flex items-center gap-4">
                        <input type="file" name="cover" 
                               class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-800 file:text-gray-300 hover:file:bg-gray-700 transition">
                    </div>
                    @if($buku->cover)
                        <p class="text-[10px] text-gray-500 mt-2 italic">*Kosongkan jika tidak ingin mengganti gambar lama</p>
                    @endif
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="text-gray-500 text-[10px] uppercase tracking-widest block mb-2">Deskripsi Buku</label>
                    <textarea name="deskripsi" rows="5" 
                              class="w-full bg-[#0d1117] border border-gray-800 rounded-lg p-4 text-gray-300 text-xs outline-none focus:border-orange-500 transition">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                </div>

                {{-- Tombol Action --}}
                <div class="pt-6 border-t border-gray-800 flex justify-between items-center">
                    <a href="{{ route('petugas.buku') }}" 
                       class="bg-[#3a3a3c] hover:bg-gray-600 text-white px-8 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-widest transition shadow-lg">
                        Kembali
                    </a>
                    <button type="submit" 
                            class="bg-[#e06c1a] hover:bg-[#c95f16] text-white px-10 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-widest transition shadow-lg">
                        Update
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection