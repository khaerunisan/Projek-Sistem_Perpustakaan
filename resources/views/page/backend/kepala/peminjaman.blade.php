@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- Judul Halaman --}}
    <h2 class="text-white font-bold text-lg mb-6 ml-2 uppercase italic tracking-wider">Peminjaman</h2>

    {{-- Container Utama --}}
    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 shadow-2xl">
        
        {{-- Search Bar --}}
        <div class="flex justify-between items-center mb-6 gap-4">
            <form action="{{ route('kepala.peminjaman') }}" method="GET" class="relative flex-1">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Anggota..." 
                       class="w-full bg-[#1c1f26] text-gray-400 text-xs rounded-full py-2 pl-10 pr-4 border border-gray-800 outline-none focus:ring-1 focus:ring-red-600 transition-all">
            </form>
        </div>

        {{-- Tabel Peminjaman --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border border-gray-800">
                <thead>
                    <tr class="text-white bg-[#000000] border-b border-gray-800 text-[11px]">
                        <th class="px-4 py-3 font-bold text-center border-r border-gray-800 w-12">No</th>
                        <th class="px-4 py-3 font-bold border-r border-gray-800">Nama</th>
                        <th class="px-4 py-3 font-bold border-r border-gray-800">Judul Buku</th>
                        <th class="px-4 py-3 font-bold border-r border-gray-800">Id Buku</th>
                        <th class="px-4 py-3 font-bold border-r border-gray-800">Tanggal Pinjam</th>
                        <th class="px-4 py-3 font-bold border-r border-gray-800">Tanggal Pengembalian</th>
                        <th class="px-4 py-3 font-bold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-400 text-xs">
                    @forelse($peminjaman as $index => $item)
                    <tr class="border-b border-gray-800 hover:bg-white/5 transition">
                        <td class="px-4 py-4 text-center border-r border-gray-800">
                            {{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-4 border-r border-gray-800 text-gray-200 uppercase">
                            {{ $item->user->name ?? '-' }}
                        </td>
                        <td class="px-4 py-4 border-r border-gray-800 italic uppercase">
                            {{ $item->buku->judul ?? '-' }}
                        </td>
                        <td class="px-4 py-4 border-r border-gray-800 font-mono text-red-500">
                            {{ $item->buku->id_buku ?? $item->buku_id ?? '-' }}
                        </td>
                        <td class="px-4 py-4 border-r border-gray-800">
                            {{ $item->tgl_pinjam ? \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') : '-' }}
                        </td>
                        <td class="px-4 py-4 border-r border-gray-800">
                            {{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y') : '-' }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            <a href="{{ route('kepala.show_peminjaman', $item->id) }}" class="bg-[#b91c1c] text-[10px] text-white px-3 py-1 rounded font-bold hover:bg-red-700 transition">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-gray-600 italic">Data peminjaman tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(method_exists($peminjaman, 'links') && $peminjaman->hasPages())
            <div class="mt-8 px-2 border-t border-gray-800 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-gray-500 text-[11px]">
                        Menampilkan {{ $peminjaman->firstItem() }} sampai {{ $peminjaman->lastItem() }} dari {{ $peminjaman->total() }} Data
                    </div>
                    <div class="pagination-custom">
                        {{ $peminjaman->links() }}
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

{{-- CSS KHUSUS PAGINATION --}}
<style>
    .pagination-custom nav div:first-child { display: none !important; }
    .pagination-custom nav div:last-child { display: flex !important; gap: 5px; box-shadow: none !important; }
    .pagination-custom nav svg { width: 14px !important; height: 14px !important; }
    .pagination-custom span, .pagination-custom a { 
        background-color: #1c1f26 !important; 
        color: #9ca3af !important; 
        border: 1px solid #374151 !important; 
        border-radius: 6px !important;
        font-size: 10px !important;
        padding: 6px 12px !important;
        text-decoration: none !important;
    }
    .pagination-custom a:hover { background-color: #2d333d !important; color: white !important; }
    .pagination-custom span[aria-current="page"] span { 
        background-color: #b91c1c !important; 
        border-color: #b91c1c !important;
        color: white !important; 
    }
</style>
@endsection