@extends('layouts.backend.app')

@section('content')
<main class="flex-1 bg-[#0b0e14] p-6 flex justify-center items-center min-h-screen">
    <div class="bg-[#161b22] w-full max-w-4xl rounded-xl p-8 shadow-2xl border border-gray-800">
        <h2 class="text-white font-semibold mb-6">Form Peminjaman</h2>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            <div class="md:col-span-5 space-y-4">
                <div class="bg-[#4b5563] p-4 rounded-2xl flex justify-center items-center shadow-inner">
                    @if($buku->cover)
                        {{-- PERBAIKAN: Menggunakan storage karena di database sudah ada tulisan 'buku/' --}}
                        <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-auto rounded-lg shadow-md object-cover">
                    @else
                        <div class="py-20 text-gray-400">No Cover</div>
                    @endif
                </div>

                <div class="bg-[#64748b] p-4 rounded-xl text-xs text-gray-900 font-medium space-y-2">
                    <p>Lama Pinjam: 7 Hari</p>
                    <p>Denda Keterlambatan: Rp 15.000/hari</p>
                </div>
            </div>

            <form action="#" method="POST" class="md:col-span-7 space-y-4">
                @csrf
                {{-- Input Judul Buku --}}
                <div>
                    <input type="text" value="{{ $buku->judul }}" readonly 
                        class="w-full bg-black border border-gray-800 text-gray-400 p-3 rounded-lg focus:outline-none text-sm" placeholder="Judul Buku">
                </div>

                {{-- Input Pengarang --}}
                <div>
                    <input type="text" value="{{ $buku->pengarang }}" readonly 
                        class="w-full bg-black border border-gray-800 text-gray-400 p-3 rounded-lg focus:outline-none text-sm" placeholder="Pengarang">
                </div>

                {{-- Input ID Peminjaman (Otomatis) --}}
                <div>
                    <input type="text" name="id_peminjaman" value="PMJ-{{ rand(1000, 9999) }}" readonly
                        class="w-full bg-black border border-gray-800 text-gray-400 p-3 rounded-lg focus:outline-none text-sm" placeholder="Id Peminjaman">
                </div>

                {{-- Input Tanggal Pinjam --}}
                <div class="relative w-2/3">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="far fa-calendar-alt text-gray-400"></i>
                    </span>
                    <input type="date" name="tgl_pinjam" value="{{ date('Y-m-d') }}"
                        class="w-full bg-black border border-gray-800 text-gray-400 p-3 pl-10 rounded-lg focus:outline-none text-sm">
                </div>

                <div class="flex justify-end gap-4 mt-10">
                    <a href="{{ route('buku.show', $buku->id) }}" 
                        class="bg-[#64748b] hover:bg-gray-500 text-white px-8 py-2 rounded-lg text-sm transition-all">
                        Kembali
                    </a>
                    <button type="submit" 
                        class="bg-[#f37021] hover:bg-orange-600 text-white px-10 py-2 rounded-lg text-sm font-semibold shadow-lg transition-all">
                        Pinjam
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection