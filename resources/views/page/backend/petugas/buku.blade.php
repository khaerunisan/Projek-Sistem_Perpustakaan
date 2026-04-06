@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-4 text-sm font-sans">
    
    {{-- Header --}}
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-white font-bold text-xl tracking-wide uppercase italic">Data Buku</h2>
        <a href="{{ route('petugas.buku.create') }}" class="bg-[#e06c1a] text-white px-6 py-2 rounded-full font-bold text-xs hover:bg-[#c95f16] transition shadow-lg uppercase">
            + Tambah
        </a>
    </div>

    {{-- TAMBAHAN: Alert Sukses (Agar tahu kalau data berhasil masuk/dihapus) --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-500/20 border border-green-500 rounded-lg text-green-500 text-xs font-bold uppercase tracking-wider">
            {{ session('success') }}
        </div>
    @endif

    {{-- Grid Layout --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @forelse($buku as $item)
        <div class="bg-[#2c3038] rounded-xl p-3 flex flex-col border border-gray-700 shadow-xl">
            
            {{-- Foto: Jarak mb-2 agar sangat dekat dengan judul --}}
            <div class="w-full aspect-[3/4] overflow-hidden rounded-lg mb-2 shadow-md border border-gray-800 bg-[#111111] relative">
                @if($item->cover)
                    <img src="{{ asset('storage/' . $item->cover) }}" 
                         class="absolute inset-0 w-full h-full object-cover"
                         alt="Cover">
                @else
                    <div class="flex items-center justify-center h-full text-gray-700 text-[10px] italic">
                        No Cover
                    </div>
                @endif
            </div>

            {{-- Info Buku --}}
            <div class="text-center w-full mb-3">
                <h3 class="text-white font-bold text-[11px] leading-tight uppercase line-clamp-1" title="{{ $item->judul }}">
                    {{ $item->judul }}
                </h3>
                <p class="text-gray-400 text-[9px] truncate italic">{{ $item->pengarang }}</p>
            </div>

            {{-- Action Buttons: SEJAJAR 3 KOLOM --}}
            <div class="w-full mt-auto">
                <div class="grid grid-cols-3 gap-1">
                    {{-- Detail --}}
                    <a href="{{ route('petugas.buku.show', $item->id) }}" class="bg-[#1e3a8a] text-white py-2 rounded text-[8px] font-bold text-center uppercase hover:bg-blue-800 transition flex items-center justify-center">
                        Detail
                    </a>

                    {{-- Edit --}}
                    <a href="{{ route('petugas.buku.edit', $item->id) }}" class="bg-[#d97706] text-white py-2 rounded text-[8px] font-bold text-center uppercase hover:bg-amber-700 transition flex items-center justify-center">
                        Edit
                    </a>

                    {{-- Delete (Hapus) --}}
                    <form action="{{ route('petugas.buku.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus?')" class="w-full">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full bg-[#b91c1c] text-white py-2 rounded text-[8px] font-bold text-center uppercase hover:bg-red-800 transition flex items-center justify-center">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

        </div>
        @empty
            <div class="col-span-full text-center py-20">
                <p class="text-gray-600 italic">Data buku belum tersedia.</p>
            </div>
        @endforelse
    </div>

    {{-- BAGIAN PAGINATION --}}
    <div class="mt-8 px-2">
        {{-- Menampilkan navigasi halaman --}}
        {{ $buku->appends(request()->query())->links() }}
    </div>
</div>
@endsection