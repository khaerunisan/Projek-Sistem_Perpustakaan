@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- Judul Halaman --}}
    <h2 class="text-white font-bold text-lg mb-6 ml-2 uppercase italic tracking-wider">Data Petugas</h2>

    {{-- Container Utama --}}
    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 shadow-2xl">
        
        {{-- Toolbar: Search & Tambah (Optional) --}}
        <div class="flex justify-between items-center mb-6 gap-4">
            {{-- Form agar fitur Search di Controller berfungsi --}}
            <form action="{{ route('kepala.petugas') }}" method="GET" class="relative flex-1 max-w-xl">
                <span class="absolute inset-y-0 left-3 flex items-center shadow-sm">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Petugas..." 
                       class="w-full bg-[#1c1f26] text-gray-300 text-xs rounded-lg py-2.5 pl-10 pr-4 border border-gray-800 outline-none focus:ring-1 focus:ring-red-600">
                {{-- Hidden submit agar Enter berfungsi di beberapa browser --}}
                <button type="submit" class="hidden"></button>
            </form>
        </div>

        {{-- Tabel Data Petugas --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border border-gray-800">
                <thead>
                    <tr class="text-gray-400 bg-[#1c1f26] border-b border-gray-800 text-[11px] uppercase tracking-widest">
                        <th class="px-6 py-4 font-bold text-center border-r border-gray-800">Id Petugas</th>
                        <th class="px-6 py-4 font-bold border-r border-gray-800">Nama Petugas</th>
                        <th class="px-6 py-4 font-bold border-r border-gray-800">Email</th>
                        <th class="px-6 py-4 font-bold text-center border-r border-gray-800">No Telphon</th>
                        <th class="px-6 py-4 font-bold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300 text-xs">
                    @forelse($petugas as $item)
                    <tr class="border-b border-gray-800 hover:bg-white/5 transition">
                        {{-- Format ID sesuai gambar --}}
                        <td class="px-6 py-4 text-center text-gray-500 font-mono border-r border-gray-800">
                            {{ rand(10,99) }}.{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}.{{ rand(100,999) }}
                        </td>
                        
                        <td class="px-6 py-4 font-medium text-gray-200 border-r border-gray-800">
                            {{ $item->name }}
                        </td>
                        
                        <td class="px-6 py-4 text-gray-400 border-r border-gray-800">
                            {{ $item->email }}
                        </td>
                        
                        <td class="px-6 py-4 text-center border-r border-gray-800">
                            {{-- Memakai kolom 'phone' dari database --}}
                            {{ $item->phone ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            {{-- Menggunakan route kepala.petugas.show sesuai web.php --}}
                            <a href="{{ route('kepala.petugas.show', $item->id) }}" 
                               class="bg-[#b91c1c] text-[10px] text-white px-4 py-1.5 rounded font-bold uppercase hover:bg-red-700 transition shadow-lg">
                                  Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-600 italic">Data petugas belum tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Safe --}}
        @if(method_exists($petugas, 'links'))
            <div class="mt-6">
                {{-- Appends search agar saat pindah halaman pencarian tidak hilang --}}
                {{ $petugas->appends(['search' => request('search')])->links() }}
            </div>
        @endif
    </div>
</div>
@endsection