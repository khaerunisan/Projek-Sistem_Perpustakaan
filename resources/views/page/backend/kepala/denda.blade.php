@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    <h2 class="text-white font-bold text-lg mb-6 ml-2 uppercase italic tracking-wider">Denda</h2>
    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 shadow-2xl">
        
        {{-- Search Section --}}
        <div class="mb-6">
            <form action="{{ route('kepala.denda') }}" method="GET" class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-500 text-xs"></i>
                </span>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari Anggota atau Judul Buku..." 
                       class="w-full bg-[#1c1f26] text-gray-400 text-xs rounded-full py-2.5 pl-10 border border-gray-800 outline-none focus:ring-1 focus:ring-red-600 transition"
                       onchange="this.form.submit()">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border border-gray-800">
                <thead>
                    <tr class="text-white bg-[#000000] border-b border-gray-800 text-[11px]">
                        <th class="px-4 py-3 border-r border-gray-800">Id Denda</th>
                        <th class="px-4 py-3 border-r border-gray-800">Judul Buku</th>
                        <th class="px-4 py-3 border-r border-gray-800">Nama Anggota</th>
                        <th class="px-4 py-3 border-r border-gray-800 text-center">Terlambat</th>
                        <th class="px-4 py-3 border-r border-gray-800">Jumlah Denda</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-400 text-xs">
                    @forelse($denda as $item)
                    <tr class="border-b border-gray-800 hover:bg-white/5 transition">
                        <td class="px-4 py-4 border-r border-gray-800">#DND{{ $item->id }}</td>
                        <td class="px-4 py-4 border-r border-gray-800">{{ $item->buku->judul ?? 'Buku Tidak Ditemukan' }}</td>
                        <td class="px-4 py-4 border-r border-gray-800">{{ $item->user->name ?? 'User Tidak Ditemukan' }}</td>
                        <td class="px-4 py-4 border-r border-gray-800 text-center">
                            @php
                                $to = \Carbon\Carbon::parse($item->tgl_kembali);
                                $from = \Carbon\Carbon::parse($item->tgl_pinjam);
                                $days = $to->diffInDays($from);
                            @endphp
                            {{ $days }} Hari
                        </td>
                        <td class="px-4 py-4 border-r border-gray-800 text-red-500 font-bold">
                            Rp. {{ number_format($item->denda, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4 text-center">
                           <a href="{{ route('kepala.show_denda', $item->id) }}" class="bg-red-600 text-white px-3 py-1 rounded text-[10px] font-bold uppercase hover:opacity-80 transition">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-gray-500 italic uppercase tracking-widest text-[10px]">
                            Data denda tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(method_exists($denda, 'links') && $denda->hasPages())
            <div class="mt-8 px-2 border-t border-gray-800 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-gray-500 text-[11px]">
                        Menampilkan {{ $denda->firstItem() }} sampai {{ $denda->lastItem() }} dari {{ $denda->total() }} Data Denda
                    </div>
                    <div class="pagination-custom">
                        {{ $denda->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- CSS KHUSUS PAGINATION --}}
<style>
    /* Sembunyikan informasi default Laravel agar tidak double */
    .pagination-custom nav div:first-child { display: none !important; }
    
    /* Container Tombol Navigasi */
    .pagination-custom nav div:last-child { 
        display: flex !important; 
        gap: 5px; 
        box-shadow: none !important; 
    }
    
    /* Ukuran Icon Navigasi Panah */
    .pagination-custom nav svg { width: 14px !important; height: 14px !important; }
    
    /* Styling Tombol Anggota */
    .pagination-custom span, .pagination-custom a { 
        background-color: #1c1f26 !important; 
        color: #9ca3af !important; 
        border: 1px solid #374151 !important; 
        border-radius: 6px !important;
        font-size: 10px !important;
        padding: 6px 12px !important;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    
    /* Hover state */
    .pagination-custom a:hover { 
        background-color: #2d333d !important; 
        color: white !important; 
    }
    
    /* Active state (Halaman Sekarang) */
    .pagination-custom span[aria-current="page"] span { 
        background-color: #dc2626 !important; 
        border-color: #dc2626 !important;
        color: white !important; 
    }
</style>
@endsection