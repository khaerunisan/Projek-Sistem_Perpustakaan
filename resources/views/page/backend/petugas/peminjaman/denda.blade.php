@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    <h2 class="text-white font-bold text-lg mb-6 ml-2 italic uppercase tracking-wider">Denda</h2>

    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 shadow-2xl">
        
        <div class="flex justify-between items-center mb-6 gap-4">
            {{-- Search Bar - Dibuat Mentok Sampai Ujung --}}
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" placeholder="Cari Anggota" class="w-full bg-[#1c2128] text-gray-300 text-xs rounded-full py-2.5 pl-10 pr-4 border border-gray-800 outline-none focus:ring-1 focus:ring-orange-500 transition">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border border-gray-800">
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
                <tbody class="text-gray-400 text-xs">
                    @forelse($denda as $item)
                    <tr class="border-b border-gray-800/50 hover:bg-white/5 transition">
                        <td class="px-4 py-5 border-r border-gray-800 text-center font-mono italic">{{ $item->id_peminjaman }}</td>
                        <td class="px-4 py-5 border-r border-gray-800 font-medium text-gray-300">{{ $item->buku->judul }}</td>
                        <td class="px-4 py-5 border-r border-gray-800">{{ $item->user->name }}</td>
                        <td class="px-4 py-5 border-r border-gray-800 text-center italic">
                            @php
                                $to = \Carbon\Carbon::parse($item->tgl_kembali);
                                $from = \Carbon\Carbon::parse($item->tgl_pinjam)->addDays(7); // Asumsi durasi pinjam 7 hari
                                $days = $to > $from ? $to->diffInDays($from) : 0;
                            @endphp
                            {{ $days }} Hari
                        </td>
                        <td class="px-4 py-5 border-r border-gray-800 font-bold text-gray-200">Rp. {{ number_format($item->denda, 0, ',', '.') }}</td>
                        <td class="px-4 py-5">
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- Detail --}}
                                <a href="{{ route('petugas.pengembalian.detail', $item->id) }}" class="bg-[#b91c1c] text-[9px] text-white px-2.5 py-1.5 rounded-sm font-bold uppercase hover:opacity-80 transition">Detail</a>
                                {{-- Edit --}}
                                <a href="#" class="bg-[#10b981] text-[9px] text-white px-2.5 py-1.5 rounded-sm font-bold uppercase hover:opacity-80 transition">Edit</a>
                                {{-- Delete --}}
                                <form action="{{ route('petugas.peminjaman.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data denda?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-[#e67e22] text-[9px] text-white px-2.5 py-1.5 rounded-sm font-bold uppercase hover:opacity-80 transition">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-gray-600 italic">Tidak ada data denda saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection