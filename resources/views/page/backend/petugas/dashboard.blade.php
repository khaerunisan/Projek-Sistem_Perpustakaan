@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- Header Dashboard (Tanpa Jam) --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-white text-2xl font-bold tracking-tight">Dashboard Petugas</h1>
        </div>
    </div>

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        {{-- Kotak 1: Buku Dipinjam (Data Aktif) --}}
        <div class="bg-[#1c1c1e] p-6 rounded-md flex items-center gap-5 shadow-xl border border-gray-800/50 hover:border-[#ef3d3d]/50 transition-all group">
            <div class="flex items-center justify-center">
                <i class="fas fa-chart-line text-[#ef3d3d] text-4xl group-hover:scale-110 transition-transform"></i>
            </div>
            <div>
                <p class="text-gray-400 text-[12px] font-medium tracking-wide uppercase">Buku Dipinjam</p>
                <h3 class="text-white font-bold text-xl">{{ $totalPinjamAktif ?? 0 }}</h3>
            </div>
        </div>

        {{-- Kotak 2: Total Pinjam (Semua Riwayat) --}}
        <div class="bg-[#1c1c1e] p-6 rounded-md flex items-center gap-5 shadow-xl border border-gray-800/50 hover:border-[#ef3d3d]/50 transition-all group">
            <div class="flex items-center justify-center">
                <i class="fas fa-chart-bar text-[#ef3d3d] text-4xl group-hover:scale-110 transition-transform"></i>
            </div>
            <div>
                <p class="text-gray-400 text-[12px] font-medium tracking-wide uppercase">Total Pinjam</p>
                <h3 class="text-white font-bold text-xl">{{ $totalPinjam ?? 0 }}</h3>
            </div>
        </div>

        {{-- Kotak 3: Total Denda --}}
        <div class="bg-[#1c1c1e] p-6 rounded-md flex items-center gap-5 shadow-xl border border-gray-800/50 hover:border-[#ef3d3d]/50 transition-all group">
            <div class="flex items-center justify-center">
                <i class="fas fa-chart-area text-[#ef3d3d] text-4xl group-hover:scale-110 transition-transform"></i>
            </div>
            <div>
                <p class="text-gray-400 text-[12px] font-medium tracking-wide uppercase">Total Denda</p>
                <h3 class="text-white font-bold text-xl">Rp{{ number_format($totalDenda ?? 0, 0, ',', '.') }}</h3>
            </div>
        </div>

        {{-- Kotak 4: Koleksi Buku --}}
        <div class="bg-[#1c1c1e] p-6 rounded-md flex items-center gap-5 shadow-xl border border-gray-800/50 hover:border-[#ef3d3d]/50 transition-all group">
            <div class="flex items-center justify-center">
                <i class="fas fa-chart-pie text-[#ef3d3d] text-4xl group-hover:scale-110 transition-transform"></i>
            </div>
            <div>
                <p class="text-gray-400 text-[12px] font-medium tracking-wide uppercase">Koleksi Buku</p>
                <h3 class="text-white font-bold text-xl">{{ $totalBuku ?? 0 }}</h3>
            </div>
        </div>
    </div>

    {{-- Tabel Peminjaman --}}
    <div class="bg-[#1c1c1e] rounded-md shadow-xl mb-6 border border-gray-800/50">
        <div class="px-5 pt-5 pb-3">
            <h2 class="text-white font-bold text-xs uppercase tracking-widest mb-4 italic flex items-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                Peminjaman Aktif
            </h2>
            
            <div class="relative mb-5">
                <input type="text" id="searchPeminjaman" placeholder="Cari Anggota..." class="w-full bg-[#111111] border border-gray-800 rounded-full px-10 py-2 text-gray-400 text-xs focus:outline-none focus:border-[#ef3d3d] transition">
                <i class="fas fa-search absolute left-4 top-2.5 text-gray-600 text-[10px]"></i>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-400" id="tablePeminjaman">
                    <thead class="bg-[#111111] text-[10px] uppercase text-gray-600">
                        <tr>
                            <th class="p-4 border-b border-gray-800">No</th>
                            <th class="p-4 border-b border-gray-800">Nama</th>
                            <th class="p-4 border-b border-gray-800">Judul Buku</th>
                            <th class="p-4 border-b border-gray-800">Id Buku</th>
                            <th class="p-4 border-b border-gray-800">Tanggal Pinjam</th>
                            <th class="p-4 border-b border-gray-800 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50">
                        @forelse($peminjamanAktif as $key => $item)
                        <tr class="hover:bg-[#252528] transition-colors row-peminjaman">
                            <td class="p-4 text-gray-600 text-center">{{ $key + 1 }}</td>
                            <td class="p-4 font-medium text-gray-200 nama-anggota">{{ $item->user->name ?? 'User Terhapus' }}</td>
                            <td class="p-4 text-gray-300 italic">{{ $item->buku->judul ?? 'Buku Terhapus' }}</td>
                            <td class="p-4 text-gray-600 font-mono">#BK-{{ $item->buku_id }}</td>
                            <td class="p-4">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') }}</td>
                            <td class="p-4 text-center">
                                <span class="bg-[#174d32]/30 text-[#34e287] text-[10px] px-3 py-1 rounded font-bold uppercase tracking-tighter border border-[#34e287]/20">Dipinjam</span>
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
    <div class="bg-[#1c1c1e] rounded-md shadow-xl border border-gray-800/50">
        <div class="px-5 pt-5 pb-3">
            <h2 class="text-white font-bold text-xs uppercase tracking-widest mb-4 italic flex items-center gap-2">
                <i class="fas fa-history text-gray-500 text-[10px]"></i>
                Riwayat Pengembalian
            </h2>
            
            <div class="relative mb-5">
                <input type="text" id="searchPengembalian" placeholder="Cari Anggota..." class="w-full bg-[#111111] border border-gray-800 rounded-full px-10 py-2 text-gray-400 text-xs focus:outline-none focus:border-[#ef3d3d] transition">
                <i class="fas fa-search absolute left-4 top-2.5 text-gray-600 text-[10px]"></i>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-400" id="tablePengembalian">
                    <thead class="bg-[#111111] text-[10px] uppercase text-gray-600">
                        <tr>
                            <th class="p-4 border-b border-gray-800">No</th>
                            <th class="p-4 border-b border-gray-800">Nama</th>
                            <th class="p-4 border-b border-gray-800">Judul Buku</th>
                            <th class="p-4 border-b border-gray-800">Id Buku</th>
                            <th class="p-4 border-b border-gray-800">Tanggal Pengembalian</th>
                            <th class="p-4 border-b border-gray-800">Denda</th>
                            <th class="p-4 border-b border-gray-800 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50">
                        @forelse($pengembalian as $key => $item)
                        <tr class="hover:bg-[#252528] transition-colors row-pengembalian">
                            <td class="p-4 text-gray-600 text-center">{{ $key + 1 }}</td>
                            <td class="p-4 font-medium text-gray-200 nama-anggota">{{ $item->user->name ?? 'User Terhapus' }}</td>
                            <td class="p-4 text-gray-300 italic">{{ $item->buku->judul ?? 'Buku Terhapus' }}</td>
                            <td class="p-4 text-gray-600 font-mono">#BK-{{ $item->buku_id }}</td>
                            <td class="p-4">{{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y') }}</td>
                            <td class="p-4">
                                @if($item->denda > 0)
                                    <span class="text-red-500 font-bold">Rp. {{ number_format($item->denda, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-gray-600 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <span class="bg-gray-800/50 text-gray-400 text-[10px] px-3 py-1 rounded font-bold uppercase tracking-tighter">Selesai</span>
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

<script>
    // Pencarian Tabel Peminjaman
    document.getElementById('searchPeminjaman').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.row-peminjaman');
        rows.forEach(row => {
            let nama = row.querySelector('.nama-anggota').textContent.toLowerCase();
            row.style.display = nama.includes(filter) ? "" : "none";
        });
    });

    // Pencarian Tabel Pengembalian
    document.getElementById('searchPengembalian').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.row-pengembalian');
        rows.forEach(row => {
            let nama = row.querySelector('.nama-anggota').textContent.toLowerCase();
            row.style.display = nama.includes(filter) ? "" : "none";
        });
    });
</script>
@endsection