@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans text-gray-400">
    
    <div class="mb-6">
        <h2 class="text-white font-bold text-2xl tracking-tight uppercase italic">Tambah Buku</h2>
    </div>

    <div class="bg-[#1c1c1e] p-8 rounded-2xl shadow-2xl border border-gray-800 max-w-5xl mx-auto">
        
        {{-- Menampilkan Error agar kamu tahu kalau ada yang kurang --}}
        @if ($errors->any())
            <div class="mb-5 p-4 bg-red-900/20 border border-red-900/50 rounded-lg">
                <ul class="list-disc list-inside text-red-500 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('petugas.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                
                <div>
                    <label class="block mb-1.5 text-xs text-gray-500 font-medium uppercase tracking-wider">Judul Buku</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Contoh: Diary of Canva" 
                           class="w-full bg-[#111111] border border-gray-800 rounded-lg p-3 text-white placeholder-gray-700 focus:ring-1 focus:ring-cyan-500 outline-none transition" required>
                </div>

                {{-- PERBAIKAN: name diganti jadi 'penulis' agar sesuai Controller --}}
                <div>
                    <label class="block mb-1.5 text-xs text-gray-500 font-medium uppercase tracking-wider">Penulis</label>
                    <input type="text" name="penulis" value="{{ old('penulis') }}" placeholder="Nama penulis..." 
                           class="w-full bg-[#111111] border border-gray-800 rounded-lg p-3 text-white placeholder-gray-700 focus:ring-1 focus:ring-cyan-500 outline-none transition" required>
                </div>

                <div>
                    <label class="block mb-1.5 text-xs text-gray-500 font-medium uppercase tracking-wider">Penerbit</label>
                    <input type="text" name="penerbit" value="{{ old('penerbit') }}" placeholder="Nama penerbit..." 
                           class="w-full bg-[#111111] border border-gray-800 rounded-lg p-3 text-white placeholder-gray-700 focus:ring-1 focus:ring-cyan-500 outline-none transition" required>
                </div>

                {{-- PERBAIKAN: name diganti jadi 'tahun_terbit' agar sesuai Controller --}}
                <div>
                    <label class="block mb-1.5 text-xs text-gray-500 font-medium uppercase tracking-wider">Tahun Terbit</label>
                    <select name="tahun_terbit" class="w-full bg-[#111111] border border-gray-800 rounded-lg p-3 text-white focus:ring-1 focus:ring-cyan-500 outline-none transition appearance-none">
                        @for($year = date('Y'); $year >= 1990; $year--)
                            <option value="{{ $year }}" {{ old('tahun_terbit') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label class="block mb-1.5 text-xs text-gray-500 font-medium uppercase tracking-wider">Jumlah Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', 1) }}" 
                           class="w-full bg-[#111111] border border-gray-800 rounded-lg p-3 text-white focus:ring-1 focus:ring-cyan-500 outline-none transition" required>
                </div>

                <div>
                    <label class="block mb-1.5 text-xs text-gray-500 font-medium uppercase tracking-wider">Upload Sampul</label>
                    <div class="flex items-center gap-4 bg-[#111111] border border-gray-800 rounded-lg p-2.5">
                        <label class="cursor-pointer bg-[#3a3a3c] text-white px-4 py-1.5 rounded text-[10px] font-bold uppercase hover:bg-gray-600 transition">
                            Pilih File
                            <input type="file" name="cover" id="cover" class="hidden" accept="image/*" required>
                        </label>
                        <span id="file-name" class="text-gray-600 text-[10px] truncate">Belum ada file...</span>
                    </div>
                </div>

            </div>

            <div class="mt-5">
                <label class="block mb-1.5 text-xs text-gray-500 font-medium uppercase tracking-wider">Deskripsi Buku</label>
                <textarea name="deskripsi" rows="4" placeholder="Masukkan sinopsis buku..." 
                          class="w-full bg-[#111111] border border-gray-800 rounded-lg p-3 text-white placeholder-gray-700 focus:ring-1 focus:ring-cyan-500 outline-none transition resize-none">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-800">
                <a href="{{ route('petugas.buku') }}" class="px-6 py-2 rounded-lg bg-[#3a3a3c] text-white text-[10px] font-bold uppercase tracking-wider hover:bg-gray-600 transition">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-2 rounded-lg bg-[#19e3cd] text-black text-[10px] font-bold uppercase tracking-wider hover:bg-[#15bfaa] transition shadow-lg shadow-[#19e3cd]/20">
                    Simpan Buku
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    document.getElementById('cover').addEventListener('change', function(e){
        var fileName = e.target.files[0] ? e.target.files[0].name : "Belum ada file...";
        document.getElementById('file-name').textContent = fileName;
        document.getElementById('file-name').classList.replace('text-gray-600', 'text-cyan-400');
    });
</script>
@endsection