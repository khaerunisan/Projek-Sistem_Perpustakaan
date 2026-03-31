@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-8 text-sm">
    {{-- Header --}}
    <h1 class="text-white font-bold text-xl mb-6 ml-2 italic text-uppercase">Data Anggota</h1>

    {{-- Container Tabel --}}
    <div class="bg-[#1c1f26] rounded-md shadow-2xl p-6 border border-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-white border-b border-gray-700 bg-[#161920]">
                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-[11px]">Id Anggota</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-[11px]">Nama Anngota</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-[11px]">Alamat</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-[11px] text-center">No Telphon</th>
                        <th class="px-6 py-4 font-bold uppercase tracking-wider text-[11px] text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-400">
                    @forelse($anggota as $item)
                    <tr class="border-b border-gray-800 hover:bg-[#252a33] transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-300">
                            {{-- Menampilkan ID Anggota --}}
                            {{ $item->id_anggota ?? $item->id }}
                        </td>
                        <td class="px-6 py-4">{{ $item->name ?? $item->nama }}</td>
                        <td class="px-6 py-4">{{ $item->alamat ?? 'Alamat belum diisi' }}</td>
                        <td class="px-6 py-4 text-center">
                            {{-- Cek kolom no telp sesuai database --}}
                            {{ $item->no_telp ?? $item->no_hp ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{-- Tombol Detail Merah sesuai Gambar --}}
                            <a href="#" class="bg-[#ef3d3d] hover:bg-[#d32f2f] text-white text-[10px] px-5 py-1.5 rounded font-bold transition-all shadow-md uppercase tracking-tighter">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                            Belum ada data anggota yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection