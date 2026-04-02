@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    <h2 class="text-white font-bold text-lg mb-6 ml-2 uppercase italic tracking-wider">Pengembalian</h2>

    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 shadow-2xl">
        
        {{-- Search Bar --}}
        <div class="flex justify-between items-center mb-6 gap-4">
            <form action="{{ route('kepala.pengembalian') }}" method="GET" class="relative flex-1">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Anggota..." 
                       class="w-full bg-[#1c1f26] text-gray-400 text-xs rounded-full py-2 pl-10 pr-4 border border-gray-800 outline-none focus:ring-1 focus:ring-red-600 transition-all">
            </form>
        </div>

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
                        <th class="px-4 py-3 font-bold border-r border-gray-800 text-center">Denda</th>
                        <th class="px-4 py-3 font-bold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-400 text-xs">
                    @forelse($pengembalian as $index => $item)
                    <tr class="border-b border-gray-800 hover:bg-white/5 transition">
                        <td class="px-4 py-4 text-center border-r border-gray-800">
                            {{ ($pengembalian->currentPage() - 1) * $pengembalian->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-4 border-r border-gray-800 text-gray-200 uppercase">
                            {{ $item->user->name ?? '-' }}
                        </td>
                        <td class="px-4 py-4 border-r border-gray-800 italic uppercase">
                            {{ $item->buku->judul ?? '-' }}
                        </td>
                        <td class="px-4 py-4 border-r border-gray-800 font-mono">
                            {{ $item->buku->id_buku ?? $item->buku_id ?? '-' }}
                        </td>
                        <td class="px-4 py-4 border-r border-gray-800">
                            {{ $item->tgl_pinjam ? \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') : '-' }}
                        </td>
                        <td class="px-4 py-4 border-r border-gray-800">
                            {{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y') : '-' }}
                        </td>
                        <td class="px-4 py-4 border-r border-gray-800 text-center text-red-500 font-bold">
                            {{ $item->denda > 0 ? 'Rp ' . number_format($item->denda, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            {{-- Link detail ini akan kita pakai di langkah selanjutnya --}}
                            <a href="{{ route('kepala.show_pengembalian', $item->id) }}" class="bg-[#b91c1c] text-[10px] text-white px-3 py-1 rounded font-bold hover:bg-red-700 transition uppercase shadow-md">
                                 Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-10 text-center text-gray-600 italic">Data pengembalian tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $pengembalian->links() }}
        </div>

    </div>
</div>
@endsection