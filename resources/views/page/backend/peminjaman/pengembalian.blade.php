@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#0b0e14] flex items-center justify-center p-6">
    <div class="bg-[#1c2128] w-full max-w-4xl rounded-xl shadow-2xl p-8 border border-gray-800">
        <h2 class="text-white font-bold mb-6 text-lg">Form Pengembalian</h2>

        <form action="{{ route('pengembalian.store', $pinjam->id) }}" method="POST">
            @csrf
            {{-- Tambahan input agar data denda terkirim ke Controller --}}
            <input type="hidden" name="denda" value="{{ $denda }}">
            <input type="hidden" name="terlambat" value="{{ $terlambat }}">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                
                <div class="md:col-span-5 space-y-4">
                    <div class="bg-[#30363d] rounded-2xl p-6 flex flex-col items-center border border-gray-700">
                        {{-- PERBAIKAN: Menggunakan storage/ karena di database sudah ada tulisan 'buku/' --}}
                        @if($pinjam->buku->cover)
                            <img src="{{ asset('storage/' . $pinjam->buku->cover) }}" class="w-48 rounded-lg shadow-2xl mb-4 border border-gray-600" alt="Cover Buku">
                        @else
                            <div class="w-48 h-64 bg-gray-700 rounded-lg flex items-center justify-center text-gray-400">No Image</div>
                        @endif
                    </div>
                    <div class="bg-[#343942] rounded-xl p-5 text-sm text-gray-300 space-y-2 border border-gray-700 text-center md:text-left">
                        <p class="font-medium italic">Lama Pinjam: {{ $durasi }} Hari</p>
                        <p class="font-medium italic">Denda Keterlambatan: <span class="text-orange-400">Rp 15.000/hari</span></p>
                    </div>
                </div>

                <div class="md:col-span-7 space-y-4 text-sm">
                    <div>
                        <label class="text-gray-400 text-xs block mb-1 uppercase tracking-wider">Nama</label>
                        <input type="text" value="{{ $pinjam->user->name }}" class="w-full bg-[#0d1117] border border-gray-800 rounded-md p-2.5 text-gray-300 focus:outline-none" readonly>
                    </div>
                    <div>
                        <label class="text-gray-400 text-xs block mb-1 uppercase tracking-wider">Id Peminjaman</label>
                        <input type="text" value="{{ $pinjam->id_peminjaman }}" class="w-full bg-[#0d1117] border border-gray-800 rounded-md p-2.5 text-gray-300 focus:outline-none" readonly>
                    </div>
                    <div>
                        <label class="text-gray-400 text-xs block mb-1 uppercase tracking-wider">Tanggal Pinjam</label>
                        <input type="text" value="{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d F Y') }}" class="w-full bg-[#0d1117] border border-gray-800 rounded-md p-2.5 text-gray-300 focus:outline-none" readonly>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-gray-400 text-xs block mb-1 uppercase tracking-wider">Tanggal Kembali</label>
                            <input type="text" value="{{ $tgl_kembali->format('d F Y') }}" class="w-full bg-[#0d1117] border border-gray-800 rounded-md p-2.5 text-gray-300 focus:outline-none" readonly>
                        </div>
                        <div>
                            <label class="text-gray-400 text-xs block mb-1 uppercase tracking-wider">Durasi Pinjam</label>
                            <div class="flex items-center gap-2">
                                <input type="text" value="{{ $durasi }} Hari" class="w-full bg-[#0d1117] border border-gray-800 rounded-md p-2.5 text-gray-300 focus:outline-none" readonly>
                                @if($terlambat > 0)
                                <span class="bg-[#1c2128] border border-red-900 text-red-500 text-[10px] px-2 py-1.5 rounded whitespace-nowrap">Terlambat {{ $terlambat }} hari</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($denda > 0)
                    <div>
                        <label class="text-gray-400 text-xs block mb-1 uppercase tracking-wider">Metode Pembayaran (Denda: Rp {{ number_format($denda, 0, ',', '.') }})</label>
                        <select name="metode_pembayaran" class="w-full bg-[#0d1117] border border-gray-800 rounded-md p-2.5 text-gray-300 focus:ring-1 focus:ring-orange-500 focus:outline-none">
                            <option value="Tunai">Tunai / Bayar di Pustakawan</option>
                            <option value="Dana">Dana - 08123456789 (A/N Perpustakaan)</option>
                        </select>
                        <p class="text-[10px] text-gray-500 mt-1 italic">*Silakan pilih metode pembayaran untuk melunasi denda.</p>
                    </div>
                    @else
                    <div class="bg-green-900/20 border border-green-900/50 p-3 rounded-md">
                        <p class="text-green-500 text-xs italic">Buku dikembalikan tepat waktu. Tidak ada denda yang perlu dibayar.</p>
                    </div>
                    @endif

                    <div class="flex justify-end gap-3 mt-8">
                        <a href="{{ route('peminjaman.index') }}" class="bg-[#484f58] hover:bg-gray-600 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-200 text-center">Kembali</a>
                        <button type="submit" class="bg-[#f37021] hover:bg-orange-600 text-white px-8 py-2 rounded-md text-sm font-bold transition duration-200 shadow-lg shadow-orange-900/20">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection