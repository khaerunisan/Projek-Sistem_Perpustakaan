@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm">
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        {{-- Kotak 1: Jumlah Buku --}}
        <div class="bg-[#1c1c1e] p-5 rounded-md flex items-center justify-between shadow-xl">
            <div class="flex items-center gap-4">
                <i class="fas fa-chart-line text-[#ef3d3d] text-2xl"></i>
                <p class="text-gray-400 text-[11px] font-medium tracking-wide">Jumlah Buku</p>
            </div>
            <h3 class="text-white font-bold text-lg">{{ $totalBuku }}</h3>
        </div>

        {{-- Kotak 2: Buku Dipinjam --}}
        <div class="bg-[#1c1c1e] p-5 rounded-md flex items-center justify-between shadow-xl">
            <div class="flex items-center gap-4">
                <i class="fas fa-chart-bar text-[#ef3d3d] text-2xl"></i>
                <p class="text-gray-400 text-[11px] font-medium tracking-wide">Buku Dipinjam</p>
            </div>
            <h3 class="text-white font-bold text-lg">{{ $totalPinjam }}</h3>
        </div>

        {{-- Kotak 3: Anggota --}}
        <div class="bg-[#1c1c1e] p-5 rounded-md flex items-center justify-between shadow-xl">
            <div class="flex items-center gap-4">
                <i class="fas fa-user text-[#ef3d3d] text-2xl"></i>
                <p class="text-gray-400 text-[11px] font-medium tracking-wide">Anggota</p>
            </div>
            <h3 class="text-white font-bold text-lg">{{ $totalAnggota }}</h3>
        </div>

        {{-- Kotak 4: Buku Terlambat --}}
        <div class="bg-[#1c1c1e] p-5 rounded-md flex items-center justify-between shadow-xl">
            <div class="flex items-center gap-4">
                <i class="fas fa-chart-pie text-[#ef3d3d] text-2xl"></i>
                <p class="text-gray-400 text-[11px] font-medium tracking-wide">Buku Terlambat</p>
            </div>
            <h3 class="text-white font-bold text-lg">{{ $totalTerlambat }}</h3>
        </div>
    </div>

    {{-- Tabel Peminjaman --}}
    <div class="bg-[#1c1c1e] rounded-md shadow-xl mb-6">
        <div class="px-5 pt-5 pb-3">
            <h2 class="text-white font-bold text-xs uppercase tracking-widest mb-4">Peminjaman</h2>
            
            <div class="relative mb-5">
                <input type="text" placeholder="Cari Anggota" class="w-full bg-[#111111] border border-gray-800 rounded px-10 py-2 text-gray-400 text-xs focus:outline-none focus:border-[#ef3d3d]">
                <i class="fas fa-search absolute left-4 top-2.5 text-gray-600 text-[10px]"></i>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-400">
                    <thead class="bg-[#111111] text-[10px] uppercase text-gray-600">
                        <tr>
                            <th class="p-4 border-b border-gray-800">No</th>
                            <th class="p-4 border-b border-gray-800">Nama</th>
                            <th class="p-4 border-b border-gray-800">Judul Buku</th>
                            <th class="p-4 border-b border-gray-800">Id Buku</th>
                            <th class="p-4 border-b border-gray-800">Tanggal Pinjam</th>
                            <th class="p-4 border-b border-gray-800 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50">
                        @forelse($peminjamanAktif as $key => $item)
                        <tr class="hover:bg-[#252528] transition-colors">
                            <td class="p-4 text-gray-600">{{ $key + 1 }}</td>
                            <td class="p-4 font-medium text-gray-200">{{ $item->user->name }}</td>
                            <td class="p-4 text-gray-300 italic">{{ $item->buku->judul }}</td>
                            <td class="p-4 text-gray-600">{{ $item->buku->id }}</td>
                            <td class="p-4">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') }}</td>
                            <td class="p-4 text-center">
                                <span class="bg-[#174d32] text-[#34e287] text-[10px] px-3 py-1 rounded font-bold">Selesai</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="p-5 text-center italic text-gray-700">Data Peminjaman tidak ditemukan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tabel Pengembalian --}}
    <div class="bg-[#1c1c1e] rounded-md shadow-xl">
        <div class="px-5 pt-5 pb-3">
            <h2 class="text-white font-bold text-xs uppercase tracking-widest mb-4">Pengembalian</h2>
            
            <div class="relative mb-5">
                <input type="text" placeholder="Cari Anggota" class="w-full bg-[#111111] border border-gray-800 rounded px-10 py-2 text-gray-400 text-xs focus:outline-none focus:border-[#ef3d3d]">
                <i class="fas fa-search absolute left-4 top-2.5 text-gray-600 text-[10px]"></i>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-400">
                    <thead class="bg-[#111111] text-[10px] uppercase text-gray-600">
                        <tr>
                            <th class="p-4 border-b border-gray-800">No</th>
                            <th class="p-4 border-b border-gray-800">Nama</th>
                            <th class="p-4 border-b border-gray-800">Judul Buku</th>
                            <th class="p-4 border-b border-gray-800">Id Buku</th>
                            <th class="p-4 border-b border-gray-800">Tanggal Pengembalian</th>
                            <th class="p-4 border-b border-gray-800">Denda</th>
                            <th class="p-4 border-b border-gray-800 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50">
                        @forelse($pengembalian as $key => $item)
                        <tr class="hover:bg-[#252528] transition-colors">
                            <td class="p-4 text-gray-600">{{ $key + 1 }}</td>
                            <td class="p-4 font-medium text-gray-200">{{ $item->user->name }}</td>
                            <td class="p-4 text-gray-300 italic">{{ $item->buku->judul }}</td>
                            <td class="p-4 text-gray-600">{{ $item->buku->id }}</td>
                            <td class="p-4">{{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y') }}</td>
                            <td class="p-4 text-center text-gray-400">{{ $item->denda ?? '-' }}</td>
                            <td class="p-4 text-center">
                                <span class="bg-[#174d32] text-[#34e287] text-[10px] px-3 py-1 rounded font-bold">Selesai</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="p-5 text-center italic text-gray-700">Data Pengembalian tidak ditemukan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection