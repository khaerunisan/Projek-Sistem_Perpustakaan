@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- Header --}}
    <div class="flex items-center gap-2 mb-6 ml-2">
        <a href="{{ route('petugas.pengembalian') }}" class="text-gray-500 hover:text-red-500 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h2 class="text-white font-bold text-lg uppercase italic tracking-wider">Form Pengembalian Buku</h2>
    </div>

    <div class="max-w-full">
        <div class="bg-[#111419] rounded-xl border border-gray-800 shadow-2xl overflow-hidden">
            
            {{-- Form diarahkan ke updatePengembalian --}}
            <form action="" method="POST" id="formPengembalian">
                @csrf
                @method('PUT')

                <div class="p-8 space-y-6">
                    {{-- Pilih Transaksi --}}
                    <div class="w-full">
                        <label class="text-orange-500 text-[10px] uppercase font-black tracking-widest block mb-2">Pilih Transaksi Peminjaman Aktif</label>
                        <select name="peminjaman_id" id="peminjaman_id" onchange="updateAction(this.value)" class="w-full bg-[#1c2128] text-gray-300 text-xs rounded-lg py-3 px-4 border border-gray-800 outline-none focus:ring-1 focus:ring-red-600 transition" required>
                            <option value="">-- Pilih Kode Pinjam | Nama Anggota | Judul Buku --</option>
                            @foreach($peminjaman as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->kode_peminjaman }} | {{ $p->user->name }} | {{ $p->buku->judul }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[9px] text-gray-600 mt-2 italic">*Hanya menampilkan buku yang statusnya masih 'Dipinjam'.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Tanggal Kembali --}}
                        <div class="w-full">
                            <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2">Tanggal Pengembalian</label>
                            <input type="date" name="tgl_kembali" value="{{ date('Y-m-d') }}" 
                                   class="w-full bg-[#1c2128] text-gray-300 text-xs rounded-lg py-3 px-4 border border-gray-800 outline-none focus:ring-1 focus:ring-red-600 transition" required>
                        </div>

                        {{-- Denda --}}
                        <div class="w-full">
                            <label class="text-gray-500 text-[10px] uppercase font-black tracking-widest block mb-2">Denda (Rp)</label>
                            <input type="number" name="denda" value="0" placeholder="0" 
                                   class="w-full bg-[#1c2128] text-gray-300 text-xs rounded-lg py-3 px-4 border border-gray-800 outline-none focus:ring-1 focus:ring-red-600 transition" required>
                            <p class="text-[9px] text-gray-600 mt-2">*Isi 0 jika tidak ada denda.</p>
                        </div>
                    </div>

                    {{-- Informasi Otomatis --}}
                    <div class="p-4 bg-blue-500/5 border border-blue-500/20 rounded-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-[10px] text-gray-400 leading-relaxed">
                                <span class="text-blue-400 font-bold uppercase">Sistem Otomatis:</span><br>
                                Menekan tombol simpan akan mengubah status menjadi <span class="text-green-500">DIKEMBALIKAN</span> dan mengembalikan <span class="text-green-500 text-xs font-bold">+1 STOK</span> ke data buku terkait.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Footer Buttons --}}
                <div class="bg-[#0d0f13] px-8 py-6 border-t border-gray-800 flex justify-end gap-4">
                    <a href="{{ route('petugas.pengembalian') }}" class="px-6 py-2.5 text-gray-500 text-[10px] font-black uppercase tracking-widest hover:text-white transition">
                        Batal
                    </a>
                    <button type="submit" class="bg-[#b91c1c] text-white px-10 py-2.5 rounded-sm text-[10px] font-black uppercase tracking-widest hover:bg-red-700 transition shadow-xl border border-red-900">
                        Proses Pengembalian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    /**
     * Fungsi ini mengubah tujuan form secara dinamis berdasarkan ID peminjaman yang dipilih.
     */
    function updateAction(id) {
        const form = document.getElementById('formPengembalian');
        if(id) {
            // Gunakan template URL Laravel
            let url = "{{ route('petugas.pengembalian.update', ':id') }}";
            // Ganti placeholder :id dengan ID asli dari select
            form.action = url.replace(':id', id);
        } else {
            form.action = "";
        }
    }
</script>
@endsection