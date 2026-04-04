@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- Header: Judul --}}
    <div class="flex justify-between items-center mb-6 ml-2">
        <h2 class="text-white font-bold text-lg uppercase italic tracking-wider">Data Petugas</h2>
    </div>

    {{-- Container Utama --}}
    <div class="bg-[#111419] rounded-xl p-6 border border-gray-800 shadow-2xl">
        
        {{-- Tabel Data Petugas --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border border-gray-800">
                <thead>
                    <tr class="text-gray-400 bg-[#1c1f26] border-b border-gray-800 text-[11px] uppercase tracking-widest">
                        <th class="px-6 py-4 font-bold text-center border-r border-gray-800">Id Petugas</th>
                        <th class="px-6 py-4 font-bold border-r border-gray-800">Nama Petugas</th>
                        <th class="px-6 py-4 font-bold border-r border-gray-800">Email</th>
                        <th class="px-6 py-4 font-bold text-center border-r border-gray-800">No Telphon</th>
                        <th class="px-6 py-4 font-bold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300 text-xs">
                    @forelse($petugas as $item)
                    <tr class="border-b border-gray-800 hover:bg-white/5 transition">
                        {{-- Format ID --}}
                        <td class="px-6 py-4 text-center text-gray-500 font-mono border-r border-gray-800">
                            #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        
                        <td class="px-6 py-4 font-medium text-gray-200 border-r border-gray-800 uppercase">
                            {{ $item->name }}
                        </td>
                        
                        <td class="px-6 py-4 text-gray-400 border-r border-gray-800">
                            {{ $item->email }}
                        </td>
                        
                        <td class="px-6 py-4 text-center border-r border-gray-800">
                            <span class="text-[#10b981] font-bold">
                                {{ $item->phone ?? '-' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                {{-- Tombol Detail --}}
                                <a href="{{ route('kepala.petugas.show', $item->id) }}" 
                                   class="bg-[#b91c1c] text-[10px] text-white px-4 py-1.5 rounded font-bold uppercase hover:bg-red-700 transition shadow-lg">
                                      Detail
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-600 italic">
                            Data petugas belum tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Safe --}}
        @if(method_exists($petugas, 'links'))
            <div class="mt-6">
                {{ $petugas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection