@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    <h2 class="text-white font-bold text-lg mb-6 ml-2 italic uppercase tracking-wider">Riwayat Pengembalian</h2>

    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 shadow-2xl">
        
        <div class="flex justify-between items-center mb-6 gap-4">
            <div class="relative flex-1 max-w-2xl">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" placeholder="Cari Anggota" class="w-full bg-[#1c2128] text-gray-300 text-xs rounded-full py-2.5 pl-10 pr-4 border border-gray-800 outline-none">
            </div>
            <button class="bg-[#e06c1a] text-white px-10 py-2.5 rounded-full text-xs font-bold uppercase tracking-widest">Tambah</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 border-b border-gray-800 text-[11px] uppercase tracking-wider bg-[#1c2128]/50">
                        <th class="px-4 py-4 text-center w-16">No</th>
                        <th class="px-4 py-4">Nama</th>
                        <th class="px-4 py-4">Judul Buku</th>
                        <th class="px-4 py-4">Id Buku</th>
                        <th class="px-4 py-4 text-center">Tanggal Pinjam</th>
                        <th class="px-4 py-4 text-center">Tanggal Pengembalian</th>
                        <th class="px-4 py-4 text-center">Denda</th>
                        <th class="px-4 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300 text-xs">
                    @foreach($pengembalian as $index => $item)
                    <tr class="border-b border-gray-800/50 hover:bg-white/5 transition">
                        <td class="px-4 py-5 text-center text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-5 text-gray-400 font-medium">{{ $item->user->name }}</td>
                        <td class="px-4 py-5 text-gray-500">{{ $item->buku->judul }}</td>
                        <td class="px-4 py-5 text-gray-500 font-mono italic">{{ $item->id_peminjaman }}</td>
                        <td class="px-4 py-5 text-center text-gray-500">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d F Y') }}</td>
                        <td class="px-4 py-5 text-center text-gray-500 italic">{{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d F Y') }}</td>
                        <td class="px-4 py-5 text-center text-red-500 font-bold">
                            {{ $item->denda > 0 ? 'Rp. ' . number_format($item->denda, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-4 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('petugas.pengembalian.detail', $item->id) }}" class="bg-[#b91c1c] text-[10px] text-white px-3 py-1.5 rounded-sm font-bold uppercase hover:opacity-80 transition">
                                    Detail
                                </a>
                                <button class="bg-[#10b981] text-[10px] text-white px-3 py-1.5 rounded-sm font-bold uppercase">Edit</button>
                                <form action="{{ route('petugas.peminjaman.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="bg-[#e06c1a] text-[10px] text-white px-3 py-1.5 rounded-sm font-bold uppercase">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection