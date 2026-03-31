@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    <h2 class="text-white font-bold text-lg mb-6 ml-2 italic uppercase tracking-wider">Riwayat Peminjaman</h2>

    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 shadow-2xl">
        
        {{-- Search & Tambah Button --}}
        <div class="flex justify-between items-center mb-6 gap-4">
            <div class="relative flex-1 max-w-2xl">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" id="searchInput" placeholder="Cari Anggota atau Judul Buku..." 
                       class="w-full bg-[#1c2128] text-gray-300 text-xs rounded-full py-2.5 pl-10 pr-4 border border-gray-800 outline-none focus:ring-1 focus:ring-orange-500 transition">
            </div>
            
            <button class="bg-[#e06c1a] hover:bg-[#c95f16] text-white px-10 py-2.5 rounded-full text-xs font-bold transition shadow-lg uppercase tracking-widest">
                Tambah
            </button>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="peminjamanTable">
                <thead>
                    <tr class="text-gray-400 border-b border-gray-800 text-[11px] uppercase tracking-wider bg-[#1c2128]/50">
                        <th class="px-4 py-4 font-semibold text-center w-16">No</th>
                        <th class="px-4 py-4 font-semibold">Nama</th>
                        <th class="px-4 py-4 font-semibold">Judul Buku</th>
                        <th class="px-4 py-4 font-semibold">Kode Peminjaman</th>
                        <th class="px-4 py-4 font-semibold text-center">Tanggal Pinjam</th>
                        <th class="px-4 py-4 font-semibold text-center">Tanggal Pengembalian</th>
                        <th class="px-4 py-4 font-semibold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300 text-xs">
                    @forelse($peminjaman as $index => $item)
                    <tr class="border-b border-gray-800/50 hover:bg-white/5 transition table-row-data">
                        <td class="px-4 py-5 text-center text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-5 text-gray-400 font-medium nama-anggota">{{ $item->user->name ?? 'User Terhapus' }}</td>
                        <td class="px-4 py-5 text-gray-500 judul-buku">{{ $item->buku->judul ?? 'Buku Terhapus' }}</td>
                        {{-- DISINI PERBAIKANNYA: Sesuai foto database kamu, kolomnya adalah kode_peminjaman --}}
                        <td class="px-4 py-5 text-gray-500 font-mono italic">{{ $item->kode_peminjaman }}</td>
                        <td class="px-4 py-5 text-center text-gray-500">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') }}</td>
                        <td class="px-4 py-5 text-center text-gray-500 italic">{{ $item->tgl_kembali ?? '-' }}</td>
                        <td class="px-4 py-5">
                            <div class="flex items-center justify-center gap-2">
                               <a href="{{ route('petugas.peminjaman.show', $item->id) }}" class="bg-[#b91c1c] text-[10px] text-white px-3 py-1.5 rounded-sm font-bold uppercase hover:opacity-80 transition shadow-sm inline-block">
                                   Detail
                               </a>
                                <button class="bg-[#10b981] text-[10px] text-white px-3 py-1.5 rounded-sm font-bold uppercase hover:opacity-80 transition">Edit</button>
                                <form action="{{ route('petugas.peminjaman.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-[#e06c1a] text-[10px] text-white px-3 py-1.5 rounded-sm font-bold uppercase hover:opacity-80 transition">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-gray-600 italic uppercase tracking-widest text-[10px]">
                            Belum ada data peminjaman yang masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SCRIPT SEARCH UNTUK TABEL --}}
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#peminjamanTable .table-row-data');

        rows.forEach(row => {
            let nama = row.querySelector('.nama-anggota').textContent.toLowerCase();
            let judul = row.querySelector('.judul-buku').textContent.toLowerCase();
            if (nama.includes(filter) || judul.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>
@endsection