@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- 4 CARD STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Card Buku Dipinjam --}}
        <div class="bg-[#111419] p-6 rounded-xl border border-gray-800 flex items-center gap-5">
            <div class="shrink-0">
                <i class="fas fa-chart-line text-red-600 text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Buku Dipinjam</p>
                <h3 class="text-white text-2xl font-black">{{ $bukuDipinjam ?? 0 }}</h3>
            </div>
        </div>

        {{-- Card Total Pinjam --}}
        <div class="bg-[#111419] p-6 rounded-xl border border-gray-800 flex items-center gap-5">
            <div class="shrink-0">
                <i class="fas fa-chart-bar text-red-600 text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Total Pinjam</p>
                <h3 class="text-white text-2xl font-black">{{ $totalPinjam ?? 0 }}</h3>
            </div>
        </div>

        {{-- Card Total Denda --}}
        <div class="bg-[#111419] p-6 rounded-xl border border-gray-800 flex items-center gap-5">
            <div class="shrink-0">
                <i class="fas fa-chart-area text-red-600 text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Total Denda</p>
                <h3 class="text-white text-2xl font-black text-[18px]">Rp{{ number_format($totalDenda ?? 0, 0, ',', '.') }}</h3>
            </div>
        </div>

        {{-- Card Koleksi Buku --}}
        <div class="bg-[#111419] p-6 rounded-xl border border-gray-800 flex items-center gap-5">
            <div class="shrink-0">
                <i class="fas fa-chart-pie text-red-600 text-2xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest">Koleksi Buku</p>
                <h3 class="text-white text-2xl font-black">{{ $jumlahBuku ?? 0 }}</h3>
            </div>
        </div>
    </div>

    {{-- TABEL PEMINJAMAN --}}
    <h2 class="text-white font-bold text-sm mb-4 italic uppercase tracking-widest">Peminjaman Aktif</h2>
    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 mb-8">
        <div class="overflow-x-auto text-[11px]">
            <table class="w-full text-left border-collapse border border-gray-800">
                <thead>
                    <tr class="text-gray-300 border-b border-gray-800 uppercase bg-[#1c2128]/50">
                        <th class="px-4 py-3 border-r border-gray-800 text-center w-12">No</th>
                        <th class="px-4 py-3 border-r border-gray-800">Nama</th>
                        <th class="px-4 py-3 border-r border-gray-800">Judul Buku</th>
                        <th class="px-4 py-3 border-r border-gray-800">Id Pinjam</th>
                        <th class="px-4 py-3 border-r border-gray-800 text-center">Tanggal Pinjam</th>
                        <th class="px-4 py-3 border-r border-gray-800 text-center">Batas Kembali</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-400">
                    @forelse($peminjamanAktif ?? [] as $index => $item)
                    <tr class="border-b border-gray-800/50 hover:bg-white/5 transition">
                        <td class="px-4 py-3 border-r border-gray-800 text-center italic">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 border-r border-gray-800">{{ $item->user->name ?? 'User' }}</td>
                        <td class="px-4 py-3 border-r border-gray-800">{{ $item->buku->judul ?? 'Buku' }}</td>
                        <td class="px-4 py-3 border-r border-gray-800 font-mono italic">{{ $item->id_peminjaman }}</td>
                        <td class="px-4 py-3 border-r border-gray-800 text-center italic text-gray-500">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') }}</td>
                        <td class="px-4 py-3 border-r border-gray-800 text-center italic text-red-500 font-bold">{{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="bg-yellow-600/20 text-yellow-500 text-[9px] px-2 py-1 rounded-sm font-bold uppercase">Dipinjam</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-10 text-center italic text-gray-600">Tidak ada data peminjaman aktif.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TABEL RIWAYAT --}}
    <h2 class="text-white font-bold text-sm mb-4 italic uppercase tracking-widest">Riwayat Pengembalian</h2>
    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800">
        <div class="overflow-x-auto text-[11px]">
            <table class="w-full text-left border-collapse border border-gray-800">
                <thead>
                    <tr class="text-gray-300 border-b border-gray-800 uppercase bg-[#1c2128]/50">
                        <th class="px-4 py-3 border-r border-gray-800 text-center w-12">No</th>
                        <th class="px-4 py-3 border-r border-gray-800">Nama</th>
                        <th class="px-4 py-3 border-r border-gray-800">Judul Buku</th>
                        <th class="px-4 py-3 border-r border-gray-800">Id Pinjam</th>
                        <th class="px-4 py-3 border-r border-gray-800 text-center">Tanggal Pinjam</th>
                        <th class="px-4 py-3 border-r border-gray-800 text-center text-white">Tanggal Kembali</th>
                        <th class="px-4 py-3 border-r border-gray-800 text-center">Denda</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-400">
                    @forelse($riwayatTerbaru ?? [] as $index => $item)
                    <tr class="border-b border-gray-800/50 hover:bg-white/5 transition">
                        <td class="px-4 py-3 border-r border-gray-800 text-center italic">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 border-r border-gray-800">{{ $item->user->name ?? 'User' }}</td>
                        <td class="px-4 py-3 border-r border-gray-800">{{ $item->buku->judul ?? 'Buku' }}</td>
                        <td class="px-4 py-3 border-r border-gray-800 font-mono italic">{{ $item->id_peminjaman }}</td>
                        <td class="px-4 py-3 border-r border-gray-800 text-center italic text-gray-500">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') }}</td>
                        <td class="px-4 py-3 border-r border-gray-800 text-center text-white italic font-bold">{{ \Carbon\Carbon::parse($item->updated_at)->format('d F Y') }}</td>
                        <td class="px-4 py-3 border-r border-gray-800 text-center font-bold text-gray-300">Rp{{ number_format($item->denda, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="bg-[#10b981] text-[9px] text-white px-2 py-1 rounded-sm font-bold uppercase">Selesai</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="py-10 text-center italic text-gray-600">Belum ada riwayat pengembalian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection