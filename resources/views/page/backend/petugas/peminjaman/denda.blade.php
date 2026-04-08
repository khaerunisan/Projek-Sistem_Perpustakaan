@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    <h2 class="text-white font-bold text-lg mb-6 ml-2 italic uppercase tracking-wider">Denda</h2>

    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 shadow-2xl">
        
        <div class="flex justify-between items-center mb-6 gap-4">
            {{-- Search Bar - Ditambahkan fungsionalitas filter --}}
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari Anggota atau Judul Buku..." class="w-full bg-[#1c2128] text-gray-300 text-xs rounded-full py-2.5 pl-10 pr-4 border border-gray-800 outline-none focus:ring-1 focus:ring-orange-500 transition">
            </div>

            {{-- Tombol Tambah Data - Diubah ke Link Halaman Baru --}}
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border border-gray-800" id="dendaTable">
                <thead>
                    <tr class="text-gray-300 border-b border-gray-800 text-[11px] uppercase tracking-wider bg-[#1c2128]/50">
                        <th class="px-4 py-4 border-r border-gray-800 text-center w-32">Id Denda</th>
                        <th class="px-4 py-4 border-r border-gray-800">Judul Buku</th>
                        <th class="px-4 py-4 border-r border-gray-800">Nama Anggota</th>
                        <th class="px-4 py-4 border-r border-gray-800 text-center">Terlambat</th>
                        <th class="px-4 py-4 border-r border-gray-800">Jumlah Denda</th>
                        <th class="px-4 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-400 text-xs" id="dendaBody">
                    @forelse($denda as $item)
                    <tr class="border-b border-gray-800/50 hover:bg-white/5 transition">
                        <td class="px-4 py-5 border-r border-gray-800 text-center font-mono italic">{{ $item->id_peminjaman ?? $item->id }}</td>
                        <td class="px-4 py-5 border-r border-gray-800 font-medium text-gray-300">{{ $item->buku->judul }}</td>
                        <td class="px-4 py-5 border-r border-gray-800">{{ $item->user->name }}</td>
                        <td class="px-4 py-5 border-r border-gray-800 text-center italic">
                            @php
                                $to = \Carbon\Carbon::parse($item->tgl_kembali);
                                $from = \Carbon\Carbon::parse($item->tgl_pinjam)->addDays(7); 
                                $days = $to > $from ? $to->diffInDays($from) : 0;
                            @endphp
                            {{ $days }} Hari
                        </td>
                        <td class="px-4 py-5 border-r border-gray-800 font-bold text-gray-200">Rp. {{ number_format($item->denda, 0, ',', '.') }}</td>
                        <td class="px-4 py-5">
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- Detail - Diarahkan ke route denda.show --}}
                                <a href="{{ route('petugas.denda.show', $item->id) }}" class="bg-[#b91c1c] text-[9px] text-white px-2.5 py-1.5 rounded-sm font-bold uppercase hover:opacity-80 transition">Detail</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="noDataRow">
                        <td colspan="6" class="px-4 py-10 text-center text-gray-600 italic">Tidak ada data denda saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- BAGIAN PAGINATION --}}
        @if($denda->hasPages())
            <div class="mt-8 flex flex-col md:flex-row justify-between items-center gap-4 px-2 border-t border-gray-800 pt-6">
                <div class="text-gray-500 text-[11px]">
                    Menampilkan {{ $denda->firstItem() }} sampai {{ $denda->lastItem() }} dari {{ $denda->total() }} Data Denda
                </div>
                <div class="pagination-wrapper">
                    {{ $denda->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Styling Pagination Agar Sesuai Tema --}}
<style>
    /* Sembunyikan informasi teks bawaan Laravel agar tidak double */
    .pagination-wrapper nav div:first-child { display: none !important; }
    .pagination-wrapper nav div:last-child { display: flex !important; gap: 5px; }
    
    /* Style untuk tombol angka dan panah */
    .pagination-wrapper span, .pagination-wrapper a { 
        background-color: #1c2128 !important; 
        color: #9ca3af !important; 
        border: 1px solid #374151 !important;
        border-radius: 4px !important;
        padding: 5px 12px !important;
        font-size: 11px !important;
        text-decoration: none !important;
    }
    
    /* Style untuk halaman aktif */
    .pagination-wrapper .active span, 
    .pagination-wrapper [aria-current="page"] span { 
        background-color: #e06c1a !important; 
        color: white !important; 
        border-color: #e06c1a !important;
    }
    
    /* Hover effect */
    .pagination-wrapper a:hover { 
        background-color: #2d333b !important; 
        color: white !important; 
    }

    /* Ukuran icon panah */
    .pagination-wrapper svg { width: 16px; height: 16px; vertical-align: middle; }
</style>

{{-- Script untuk Search Filter Otomatis --}}
<script>
    function filterTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("dendaTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            if (tr[i].id === "noDataRow") continue;

            let tdBuku = tr[i].getElementsByTagName("td")[1];
            let tdNama = tr[i].getElementsByTagName("td")[2];
            
            if (tdBuku || tdNama) {
                let textValueBuku = tdBuku.textContent || tdBuku.innerText;
                let textValueNama = tdNama.textContent || tdNama.innerText;
                
                if (textValueBuku.toUpperCase().indexOf(filter) > -1 || textValueNama.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
@endsection