@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- Header --}}
    <div class="flex items-center gap-2 mb-6 ml-2">
        <a href="{{ route('petugas.denda') }}" class="text-gray-500 hover:text-red-500 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h2 class="text-white font-bold text-lg uppercase italic tracking-wider">Tambah Data Denda</h2>
    </div>

    {{-- Container Form --}}
    <div class="max-w-full">
        <div class="bg-[#111419] rounded-xl border border-gray-800 shadow-2xl overflow-hidden w-full">
            
            {{-- PERBAIKAN: Action diarahkan ke petugas.denda.update --}}
            <form action="#" method="POST" id="formCreateDenda">
                @csrf
                @method('PUT')

                <div class="p-8 space-y-6">
                    {{-- Pilih Transaksi Peminjaman --}}
                    <div class="w-full">
                        <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2">Pilih Data Peminjaman (Anggota)</label>
                        <select name="peminjaman_id" onchange="updateAction(this.value)" class="w-full bg-[#1c1f26] text-gray-200 text-xs rounded-lg py-3 px-4 border border-gray-800 outline-none focus:ring-1 focus:ring-red-600" required>
                            <option value="">-- Pilih Transaksi (Kode - Nama Anggota) --</option>
                            @foreach($peminjaman as $p)
                                <option value="{{ $p->id }}">{{ $p->kode_peminjaman }} - {{ $p->user->name }} ({{ $p->buku->judul }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jumlah Denda --}}
                    <div class="w-full">
                        <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2 text-red-500 italic">Jumlah Denda (Rp)</label>
                        <input type="number" name="denda" placeholder="Masukkan nominal denda (contoh: 5000)" 
                               class="w-full bg-[#1c1f26] text-gray-200 text-xs rounded-lg py-3 px-4 border border-gray-800 outline-none focus:ring-1 focus:ring-red-600" required>
                    </div>

                    {{-- Tanggal Kembali --}}
                    <div class="w-full">
                        <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2">Tanggal Pengembalian</label>
                        <input type="date" name="tgl_kembali" value="{{ date('Y-m-d') }}" 
                               class="w-full bg-[#1c1f26] text-gray-200 text-xs rounded-lg py-3 px-4 border border-gray-800 outline-none focus:ring-1 focus:ring-red-600" required>
                    </div>

                    {{-- Status Otomatis --}}
                    <div class="w-full">
                        <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2">Status Akhir</label>
                        <select name="status" class="w-full bg-[#0d0f13] text-gray-500 text-xs rounded-lg py-3 px-4 border border-gray-800 outline-none cursor-not-allowed" readonly>
                            <option value="dikembalikan">DIKEMBALIKAN</option>
                        </select>
                    </div>
                </div>

                {{-- Footer Tombol --}}
                <div class="bg-[#0d0f13] px-8 py-5 border-t border-gray-800 flex justify-end gap-3">
                    <a href="{{ route('petugas.denda') }}" class="px-8 py-2.5 text-gray-400 text-[10px] font-bold uppercase hover:text-white transition tracking-widest">Batal</a>
                    <button type="submit" class="bg-[#b91c1c] text-white px-10 py-2.5 rounded text-[10px] font-bold uppercase hover:bg-red-700 transition shadow-lg tracking-widest">
                        Simpan Data Denda
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    /** * PERBAIKAN: Fungsi diarahkan ke petugas.pengembalian.update 
     * Namun karena ini dari halaman denda, Controller akan mendeteksi 
     * untuk mengembalikan ke halaman denda jika denda > 0.
     * Atau lebih amannya, pastikan di Controller fungsi updatePengembalian 
     * kamu mengarah ke denda jika input denda diisi.
     */
    function updateAction(id) {
        const form = document.getElementById('formCreateDenda');
        // Arahkan ke route update yang benar
        let url = "{{ route('petugas.pengembalian.update', ':id') }}";
        form.action = url.replace(':id', id);
    }
</script>
@endsection