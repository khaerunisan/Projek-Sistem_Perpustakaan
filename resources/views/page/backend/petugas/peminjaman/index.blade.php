@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    <h2 class="text-white font-bold text-lg mb-6 ml-2 italic uppercase tracking-wider">Riwayat Peminjaman</h2>

    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 shadow-2xl">
        
        {{-- Search - Dibuat Full Width (Mentok ke Ujung) --}}
        <div class="flex items-center mb-6">
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" id="searchInput" placeholder="Cari Anggota atau Judul Buku..." 
                       class="w-full bg-[#1c2128] text-gray-300 text-xs rounded-full py-2.5 pl-10 pr-4 border border-gray-800 outline-none focus:ring-1 focus:ring-orange-500 transition">
            </div>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="peminjamanTable">
                <thead>
                    <tr class="text-gray-400 border-b border-gray-800 text-[11px] uppercase tracking-wider bg-[#1c2128]/50">
                        <th class="px-4 py-4 font-semibold text-center w-16">No</th>
                        <th class="px-4 py-4 font-semibold">Nama</th>
                        <th class="px-4 py-4 font-semibold">Judul Buku</th>
                        <th class="px-4 py-4 font-semibold">ID Buku</th>
                        <th class="px-4 py-4 font-semibold text-center">Tanggal Pinjam</th>
                        <th class="px-4 py-4 font-semibold text-center">Tanggal Pengembalian</th>
                        <th class="px-4 py-4 font-semibold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300 text-xs">
                    @forelse($peminjaman as $index => $item)
                    <tr class="border-b border-gray-800/50 hover:bg-white/5 transition table-row-data">
                        <td class="px-4 py-5 text-center text-gray-500">{{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}</td>
                        <td class="px-4 py-5 text-gray-400 font-medium nama-anggota">{{ $item->user->name ?? 'User Terhapus' }}</td>
                        <td class="px-4 py-5 text-gray-500 judul-buku">{{ $item->buku->judul ?? 'Buku Terhapus' }}</td>
                        <td class="px-4 py-5 text-gray-500 font-mono italic">#BK-{{ $item->buku_id }}</td>
                        <td class="px-4 py-5 text-center text-gray-500">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') }}</td>
                        <td class="px-4 py-5 text-center text-gray-500 italic">{{ $item->tgl_kembali ?? '-' }}</td>
                        <td class="px-4 py-5">
                            <div class="flex items-center justify-center gap-2">
                               <a href="{{ route('petugas.peminjaman.show', $item->id) }}" class="bg-[#b91c1c] text-[10px] text-white px-3 py-1.5 rounded-sm font-bold uppercase hover:opacity-80 transition shadow-sm inline-block">
                                    Detail
                               </a>
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

        {{-- PAGINATION --}}
        @if($peminjaman->hasPages())
            <div class="mt-8 flex flex-col md:flex-row justify-between items-center gap-4 px-2 border-t border-gray-800 pt-6">
                <div class="text-gray-500 text-[11px]">
                    Menampilkan {{ $peminjaman->firstItem() }} - {{ $peminjaman->lastItem() }} dari {{ $peminjaman->total() }} Data
                </div>
                <div class="pagination-wrapper">
                    {{ $peminjaman->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

{{-- MODAL TAMBAH PEMINJAMAN --}}
<div id="modalTambah" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black/80 transition-opacity" onclick="toggleModal('modalTambah')"></div>
        <div class="bg-[#111419] border border-gray-800 w-full max-w-md p-8 rounded-2xl relative z-10 shadow-2xl">
            <h3 class="text-white font-bold italic uppercase tracking-wider mb-6 text-center">Form Peminjaman Baru</h3>
            
            <form action="{{ route('petugas.peminjaman.store') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block text-gray-400 text-[10px] uppercase tracking-widest font-bold mb-2">Pilih Anggota</label>
                    <select name="user_id" required class="w-full bg-[#1c2128] text-gray-300 text-xs rounded-lg py-2.5 px-4 border border-gray-800 outline-none focus:ring-1 focus:ring-orange-500 transition">
                        <option value="" disabled selected>Pilih Anggota...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-400 text-[10px] uppercase tracking-widest font-bold mb-2">Pilih Buku</label>
                    <select name="buku_id" required class="w-full bg-[#1c2128] text-gray-300 text-xs rounded-lg py-2.5 px-4 border border-gray-800 outline-none focus:ring-1 focus:ring-orange-500 transition">
                        <option value="" disabled selected>Pilih Buku...</option>
                        @foreach($buku as $b)
                            <option value="{{ $b->id }}">{{ $b->judul }} (Stok: {{ $b->stok }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-400 text-[10px] uppercase tracking-widest font-bold mb-2">Tanggal Pinjam</label>
                    <input type="date" name="tgl_pinjam" value="{{ date('Y-m-d') }}" required class="w-full bg-[#1c2128] text-gray-300 text-xs rounded-lg py-2.5 px-4 border border-gray-800 outline-none focus:ring-1 focus:ring-orange-500 transition">
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-[#e06c1a] hover:bg-[#c95f16] text-white py-2.5 rounded-lg text-[10px] font-bold uppercase transition tracking-widest">Simpan Data</button>
                    <button type="button" onclick="toggleModal('modalTambah')" class="flex-1 bg-gray-800 hover:bg-gray-700 text-gray-400 py-2.5 rounded-lg text-[10px] font-bold uppercase transition tracking-widest">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Styling Pagination Agar Matching Dark Mode */
    .pagination-wrapper nav div:first-child { display: none; }
    .pagination-wrapper nav div:last-child { display: flex; gap: 4px; }
    .pagination-wrapper span, .pagination-wrapper a { 
        background: #1c2128 !important; color: #9ca3af !important; border: 1px solid #374151 !important; 
        border-radius: 4px !important; padding: 6px 12px !important; font-size: 11px !important;
    }
    .pagination-wrapper .active span { background: #e06c1a !important; color: white !important; border-color: #e06c1a !important; }
    .pagination-wrapper a:hover { background: #2d333b !important; color: white !important; }
    .pagination-wrapper svg { width: 16px; height: 16px; }
</style>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.classList.toggle('hidden');
    }

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