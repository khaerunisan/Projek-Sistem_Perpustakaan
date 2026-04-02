@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    <h2 class="text-white font-bold text-lg mb-6 ml-2 uppercase italic tracking-wider">Denda</h2>
    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 shadow-2xl">
        <div class="mb-6">
            <form action="{{ route('kepala.denda') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Anggota..." 
                       class="w-full bg-[#1c1f26] text-gray-400 text-xs rounded-full py-2 pl-10 border border-gray-800 outline-none focus:ring-1 focus:ring-red-600">
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border border-gray-800">
                <thead>
                    <tr class="text-white bg-[#000000] border-b border-gray-800 text-[11px]">
                        <th class="px-4 py-3 border-r border-gray-800">Id Denda</th>
                        <th class="px-4 py-3 border-r border-gray-800">Judul Buku</th>
                        <th class="px-4 py-3 border-r border-gray-800">Nama Anggota</th>
                        <th class="px-4 py-3 border-r border-gray-800 text-center">Terlambat</th>
                        <th class="px-4 py-3 border-r border-gray-800">Jumlah Denda</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-400 text-xs">
                    @foreach($denda as $item)
                    <tr class="border-b border-gray-800 hover:bg-white/5">
                        <td class="px-4 py-4 border-r border-gray-800">#DND{{ $item->id }}</td>
                        <td class="px-4 py-4 border-r border-gray-800">{{ $item->buku->judul }}</td>
                        <td class="px-4 py-4 border-r border-gray-800">{{ $item->user->name }}</td>
                        <td class="px-4 py-4 border-r border-gray-800 text-center">
                            @php
                                $to = \Carbon\Carbon::parse($item->tgl_kembali);
                                $from = \Carbon\Carbon::parse($item->tgl_pinjam);
                                $days = $to->diffInDays($from);
                            @endphp
                            {{ $days }} Hari
                        </td>
                        <td class="px-4 py-4 border-r border-gray-800 text-red-500 font-bold">
                            Rp. {{ number_format($item->denda, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4 text-center">
                           <a href="{{ route('kepala.show_denda', $item->id) }}" class="bg-red-600 text-white px-3 py-1 rounded text-[10px] font-bold uppercase">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection