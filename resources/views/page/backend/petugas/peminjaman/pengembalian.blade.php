@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    <h2 class="text-white font-bold text-lg mb-6 ml-2 italic uppercase tracking-wider">Riwayat Pengembalian</h2>

    {{-- Notifikasi Sukses/Error --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-500/20 border border-green-500 text-green-500 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 shadow-2xl">
        
        {{-- Search Melebar Penuh --}}
        <div class="mb-6 w-full">
            <form action="{{ route('petugas.pengembalian') }}" method="GET" class="w-full">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-3 flex items-center">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    {{-- Input Search dengan submit otomatis --}}
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari Nama Anggota atau Judul Buku..." 
                           class="w-full bg-[#1c2128] text-gray-300 text-xs rounded-full py-2.5 pl-10 pr-4 border border-gray-800 outline-none focus:border-orange-500 transition"
                           onchange="this.form.submit()">
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 border-b border-gray-800 text-[11px] uppercase tracking-wider bg-[#1c2128]/50">
                        <th class="px-4 py-4 text-center w-16">No</th>
                        <th class="px-4 py-4">Nama</th>
                        <th class="px-4 py-4">Judul Buku</th>
                        <th class="px-4 py-4">Id Buku</th>
                        <th class="px-4 py-4 text-center">Tanggal Pinjam</th>
                        <th class="px-4 py-4 text-center">Tanggal Pengembalian</th>
                        <th class="px-4 py-4 text-center">Denda</th>
                        <th class="px-4 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300 text-xs">
                    @forelse($pengembalian as $index => $item)
                    <tr class="border-b border-gray-800/50 hover:bg-white/5 transition">
                        {{-- Nomor urut sinkron dengan pagination --}}
                        <td class="px-4 py-5 text-center text-gray-500">
                            {{ $pengembalian->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-5 text-gray-400 font-medium">{{ $item->user->name ?? 'User Tidak Ditemukan' }}</td>
                        <td class="px-4 py-5 text-gray-500">{{ $item->buku->judul ?? 'Buku Tidak Ditemukan' }}</td>
                        <td class="px-4 py-5 text-gray-500 font-mono italic">#BK-{{ $item->buku_id }}</td>
                        
                        <td class="px-4 py-5 text-center text-gray-500">
                            {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') }}
                        </td>
                        
                        <td class="px-4 py-5 text-center text-gray-500 italic">
                            {{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y') }}
                        </td>

                        <td class="px-4 py-5 text-center {{ $item->denda > 0 ? 'text-red-500' : 'text-green-500' }} font-bold">
                            {{ $item->denda > 0 ? 'Rp. ' . number_format($item->denda, 0, ',', '.') : 'Selesai' }}
                        </td>

                        <td class="px-4 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('petugas.pengembalian.detail', $item->id) }}" class="bg-[#b91c1c] text-[10px] text-white px-3 py-1.5 rounded-sm font-bold uppercase hover:opacity-80 transition">
                                    Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-10 text-center text-gray-500 italic">Belum ada data pengembalian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- BAGIAN PAGINATION DENGAN INFO DATA --}}
        @if($pengembalian->hasPages())
            <div class="mt-8 flex flex-col md:flex-row justify-between items-center gap-4 px-2 border-t border-gray-800 pt-6">
                <div class="text-gray-500 text-[11px]">
                    Menampilkan {{ $pengembalian->firstItem() }} sampai {{ $pengembalian->lastItem() }} dari {{ $pengembalian->total() }} Riwayat
                </div>
                <div class="pagination-wrapper">
                    {{ $pengembalian->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Styling Pagination Agar Sesuai Tema Gelap Dashboard --}}
<style>
    .pagination-wrapper nav div:first-child { display: none !important; }
    .pagination-wrapper nav div:last-child { display: flex !important; gap: 5px !important; }
    
    .pagination-wrapper span, .pagination-wrapper a { 
        background-color: #1c2128 !important; 
        color: #9ca3af !important; 
        border: 1px solid #374151 !important;
        border-radius: 4px !important;
        padding: 6px 12px !important;
        font-size: 11px !important;
        text-decoration: none !important;
    }
    
    .pagination-wrapper .active span, 
    .pagination-wrapper [aria-current="page"] span { 
        background-color: #e06c1a !important; 
        color: white !important; 
        border-color: #e06c1a !important;
    }
    
    .pagination-wrapper a:hover { 
        background-color: #2d333b !important; 
        color: white !important; 
    }
    
    .pagination-wrapper svg { width: 16px !important; height: 16px !important; }
</style>
@endsection