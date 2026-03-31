@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- Judul Halaman --}}
    <h2 class="text-white font-bold text-lg mb-6 ml-2">Data Anggota</h2>

    {{-- Container Utama --}}
    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 shadow-2xl">
        
        {{-- Toolbar: Search & Tambah --}}
        <div class="flex justify-between items-center mb-6 gap-4">
            <div class="relative flex-1 max-w-2xl">
                <span class="absolute inset-y-0 left-3 flex items-center shadow-sm">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" placeholder="Cari Anggota" 
                       class="w-full bg-[#2c3038] text-gray-300 text-xs rounded-full py-2.5 pl-10 pr-4 border-none outline-none focus:ring-1 focus:ring-orange-500">
            </div>
            
            <a href="{{ route('petugas.anggota.create') }}" 
               class="bg-[#e06c1a] hover:bg-[#c95f16] text-white px-10 py-2.5 rounded-full text-xs font-bold transition shadow-lg">
                Tambah
            </a>
        </div>

        {{-- Tabel Anggota --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 border-b border-gray-800 text-[11px] uppercase tracking-wider">
                        <th class="px-4 py-4 font-semibold text-center w-32">Id Anggota</th>
                        <th class="px-4 py-4 font-semibold">Nama Anggota</th>
                        <th class="px-4 py-4 font-semibold text-center">Alamat</th>
                        <th class="px-4 py-4 font-semibold text-center">No Telphon</th>
                        <th class="px-4 py-4 font-semibold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300 text-xs">
                    @forelse($anggota as $item)
                    <tr class="border-b border-gray-800/50 hover:bg-white/5 transition">
                        <td class="px-4 py-4 text-center text-gray-500 font-mono">
                            {{-- Format ID manual atau gunakan ID asli --}}
                            10.{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}.{{ rand(100,999) }}
                        </td>
                        <td class="px-4 py-4 font-medium text-gray-200">{{ $item->name }}</td>
                        <td class="px-4 py-4 text-center text-gray-500 italic">{{ $item->alamat ?? '-' }}</td>
                        <td class="px-4 py-4 text-center text-gray-500">{{ $item->telp ?? '-' }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center justify-center gap-1">
                                {{-- Tombol Detail --}}
                                <a href="{{ route('petugas.anggota.show', $item->id) }}" 
                                   class="bg-[#b91c1c] text-[9px] text-white px-3 py-1.5 rounded font-bold uppercase hover:bg-red-700 transition">
                                    Detail
                                </a>
                                {{-- Tombol Edit --}}
                                <a href="{{ route('petugas.anggota.edit', $item->id) }}" 
                                   class="bg-[#10b981] text-[9px] text-white px-3 py-1.5 rounded font-bold uppercase hover:bg-emerald-600 transition">
                                    Edit
                                </a>
                                {{-- Tombol Delete --}}
                                <form action="{{ route('petugas.anggota.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-[#e06c1a] text-[9px] text-white px-3 py-1.5 rounded font-bold uppercase hover:bg-orange-700 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-gray-600 italic">Data anggota belum tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection