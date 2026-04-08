@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- TAMBAHAN: FORM FILTER (No Print) --}}
    <div class="mb-8 no-print bg-[#111419] p-6 rounded-xl border border-gray-800 shadow-xl">
        <form action="{{ request()->url() }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex flex-col gap-2">
                <label class="text-gray-500 text-[10px] uppercase tracking-widest font-black">Rentang Waktu</label>
                <select name="filter" class="bg-[#000000] text-white border border-gray-700 rounded-lg px-4 py-2 text-xs focus:border-blue-500 outline-none transition w-48">
                    <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Semua Data</option>
                    <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="weekly" {{ request('filter') == 'weekly' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="monthly" {{ request('filter') == 'monthly' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="yearly" {{ request('filter') == 'yearly' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Terapkan Filter
            </button>

            @if(request('filter'))
                <a href="{{ request()->url() }}" class="text-gray-500 hover:text-white text-[10px] uppercase font-bold mb-3 ml-2 underline">Reset</a>
            @endif
        </form>
    </div>

    {{-- Header & Tombol Cetak --}}
    <div class="flex justify-between items-center mb-8 no-print">
        <div>
            <h2 class="text-white font-bold text-2xl italic uppercase tracking-wider">Laporan Perpustakaan</h2>
            <p class="text-gray-500 text-[10px] uppercase tracking-widest mt-1">
                Rekapitulasi: 
                <span class="text-blue-500 font-black">
                    @if(request('filter') == 'today') PER HARI (HARI INI)
                    @elseif(request('filter') == 'weekly') PER MINGGU
                    @elseif(request('filter') == 'monthly') PER BULAN
                    @elseif(request('filter') == 'yearly') PER TAHUN
                    @else SEMUA DATA
                    @endif
                </span>
            </p>
        </div>
        
        <button onclick="window.print()" class="bg-white text-black px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-gray-200 transition shadow-lg flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Cetak Laporan
        </button>
    </div>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-[#111419] p-6 rounded-xl border border-gray-800 shadow-xl">
            <label class="text-gray-500 text-[10px] uppercase tracking-[2px] font-bold">Total Transaksi</label>
            <p class="text-white text-3xl font-black mt-2">{{ $totalPeminjaman }}</p>
        </div>
        <div class="bg-[#111419] p-6 rounded-xl border border-gray-800 shadow-xl">
            <label class="text-gray-500 text-[10px] uppercase tracking-[2px] font-bold">Sedang Dipinjam</label>
            <p class="text-blue-500 text-3xl font-black mt-2">{{ $totalPinjamAktif }}</p>
        </div>
        <div class="bg-[#111419] p-6 rounded-xl border border-gray-800 shadow-xl">
            <label class="text-gray-500 text-[10px] uppercase tracking-[2px] font-bold">Buku Telah Kembali</label>
            <p class="text-green-500 text-3xl font-black mt-2">{{ $totalKembali }}</p>
        </div>
        <div class="bg-[#111419] p-6 rounded-xl border border-gray-800 shadow-xl">
            <label class="text-gray-500 text-[10px] uppercase tracking-[2px] font-bold">Total Pendapatan Denda</label>
            <p class="text-red-500 text-3xl font-black mt-2">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- KOTAK 1: TABEL PEMINJAMAN --}}
    <div class="mb-10 bg-[#111419] rounded-xl border border-gray-800 overflow-hidden shadow-2xl printable-area">
        <div class="p-6 border-b border-gray-800 flex justify-between items-center bg-[#161b22]">
            <h3 class="text-blue-500 font-bold uppercase text-xs tracking-widest">Daftar Peminjaman (Belum Kembali)</h3>
            <span class="text-gray-500 text-[10px] italic">Jumlah: {{ $dataPeminjaman->count() }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#1c2128] text-gray-400">
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest">ID</th>
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest">Nama Anggota</th>
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest">Judul Buku</th>
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest text-center">Tgl Pinjam</th>
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300 divide-y divide-gray-800">
                    @forelse($dataPeminjaman as $item)
                    <tr class="hover:bg-[#161b22] transition text-[11px]">
                        <td class="p-4 font-mono italic">#{{ $item->id }}</td>
                        <td class="p-4">
                            <span class="block font-bold text-white uppercase tracking-tight text-xs">{{ $item->user->name }}</span>
                        </td>
                        <td class="p-4 text-orange-500 font-medium italic">{{ $item->buku->judul }}</td>
                        <td class="p-4 text-center">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}</td>
                        <td class="p-4 text-center">
                            <span class="text-yellow-500 text-[9px] font-bold border border-yellow-500/30 px-2 py-0.5 rounded uppercase">Dipinjam</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-8 text-center text-gray-600 italic uppercase text-[10px]">Tidak ada peminjaman aktif</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- KOTAK 2: TABEL PENGEMBALIAN --}}
    <div class="mb-10 bg-[#111419] rounded-xl border border-gray-800 overflow-hidden shadow-2xl printable-area">
        <div class="p-6 border-b border-gray-800 flex justify-between items-center bg-[#161b22]">
            <h3 class="text-green-500 font-bold uppercase text-xs tracking-widest">Riwayat Pengembalian Buku</h3>
            <span class="text-gray-500 text-[10px] italic">Jumlah: {{ $dataPengembalian->count() }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#1c2128] text-gray-400">
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest">Nama Anggota</th>
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest">Judul Buku</th>
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest text-center">Tgl Pinjam</th>
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest text-center">Tgl Kembali</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300 divide-y divide-gray-800">
                    @forelse($dataPengembalian as $item)
                    <tr class="hover:bg-[#161b22] transition text-[11px]">
                        <td class="p-4 font-bold text-white uppercase text-xs">{{ $item->user->name }}</td>
                        <td class="p-4 text-orange-500 font-medium italic">{{ $item->buku->judul }}</td>
                        <td class="p-4 text-center">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}</td>
                        <td class="p-4 text-center">{{ \Carbon\Carbon::parse($item->tgl_kembali_realitas)->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="p-8 text-center text-gray-600 italic uppercase text-[10px]">Belum ada data pengembalian</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- KOTAK 3: TABEL DENDA --}}
    <div class="bg-[#111419] rounded-xl border border-gray-800 overflow-hidden shadow-2xl printable-area">
        <div class="p-6 border-b border-gray-800 flex justify-between items-center bg-[#161b22]">
            <h3 class="text-red-500 font-bold uppercase text-xs tracking-widest">Laporan Pendapatan Denda</h3>
            <span class="text-gray-500 text-[10px] italic">Total: Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#1c2128] text-gray-400">
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest">Nama Anggota</th>
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest">Judul Buku</th>
                        <th class="p-4 text-[10px] font-black uppercase tracking-widest text-right">Jumlah Denda</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300 divide-y divide-gray-800">
                    @forelse($dataDenda as $item)
                    <tr class="hover:bg-[#161b22] transition text-[11px]">
                        <td class="p-4 font-bold text-white uppercase text-xs">{{ $item->user->name }}</td>
                        <td class="p-4 text-orange-500 font-medium italic">{{ $item->buku->judul }}</td>
                        <td class="p-4 text-right font-bold text-red-500">Rp {{ number_format($item->denda, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="p-8 text-center text-gray-600 italic uppercase text-[10px]">Tidak ada data denda</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- CSS KHUSUS PRINT --}}
<style>
    @media print {
        body { background-color: white !important; color: black !important; }
        .no-print, nav, sidebar, .sidebar-wrapper, button, footer { display: none !important; }
        .bg-[#000000], .bg-[#111419], .bg-[#161b22], .bg-[#1c2128] { 
            background-color: white !important; 
            color: black !important; 
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }
        .text-white, .text-gray-300, .text-gray-400, .text-orange-500, .text-blue-500, .text-green-500, .text-red-500 { color: black !important; }
        .printable-area { width: 100%; border: 1px solid #000 !important; margin-bottom: 20px; page-break-inside: avoid; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd !important; padding: 8px !important; font-size: 10px !important; }
    }
</style>
@endsection