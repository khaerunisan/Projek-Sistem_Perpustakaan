@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#0b0e14] p-6">
    <div class="bg-[#1c2128] w-full rounded-xl shadow-2xl p-8 border border-gray-800 text-sm">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-white font-bold text-lg">Rekap Denda Peminjaman</h2>
                <p class="text-gray-500 text-xs mt-1 italic">*Menampilkan semua riwayat denda yang telah masuk sistem.</p>
            </div>
            <span class="bg-orange-900/20 text-orange-500 text-[10px] px-3 py-1 rounded-full border border-orange-900/50 font-bold uppercase tracking-wider">
                Total Data: {{ $semuaDenda->count() }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-gray-400">
                <thead class="text-[10px] text-gray-500 uppercase bg-[#0d1117] border-b border-gray-800">
                    <tr>
                        <th class="px-6 py-4 font-semibold">No</th>
                        <th class="px-6 py-4 font-semibold">Nama Peminjam</th>
                        <th class="px-6 py-4 font-semibold">Judul Buku</th>
                        <th class="px-6 py-4 font-semibold">Tgl Kembali</th>
                        <th class="px-6 py-4 font-semibold text-center">Nominal Denda</th>
                        <th class="px-6 py-4 font-semibold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($semuaDenda as $key => $item)
                    <tr class="hover:bg-[#21262d] transition-colors border-b border-gray-800/50">
                        <td class="px-6 py-4 text-gray-500">{{ $key + 1 }}</td>
                        <td class="px-6 py-4 font-medium text-gray-200">
                            {{ $item->user->name ?? 'User Terhapus' }}
                        </td>
                        <td class="px-6 py-4 italic">
                            {{ $item->buku->judul ?? 'Buku Terhapus' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->tgl_kembali ? \Carbon\Carbon::parse($item->tgl_kembali)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-orange-400 font-bold">
                                Rp {{ number_format($item->denda, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-green-900/20 text-green-500 text-[10px] px-2.5 py-1 rounded border border-green-900/50 font-bold uppercase">
                                Lunas
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-600 italic">
                            Belum ada data denda yang tercatat di database.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('peminjaman.index') }}" class="bg-[#30363d] hover:bg-gray-700 text-white px-6 py-2 rounded-md text-xs transition duration-200 border border-gray-700">
                Kembali ke Riwayat
            </a>
        </div>
    </div>
</div>
@endsection