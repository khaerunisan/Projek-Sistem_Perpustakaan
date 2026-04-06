@extends('layouts.backend.app')

@section('content')

    <style>
        body { background-color: #0b0e14; }
        .sidebar { background-color: #161b22; }
        /* Warna abu-abu kartu sesuai desain kamu */
        .card-book { background-color: #4b5563; } 
        .search-bg { background-color: #21262d; }
    </style>

    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="p-6 pb-2">
            <div class="flex items-center gap-4 mb-6">
                <h1 class="text-2xl font-semibold text-gray-400">Data Buku</h1>
            </div>

            <div class="flex gap-4 items-center mb-6">
                {{-- Form Pencarian: Diarahkan ke route anggota.daftarbuku --}}
                <form action="{{ route('anggota.daftarbuku') }}" method="GET" class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                    {{-- Tambahan onchange agar search langsung berfungsi --}}
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Judul Buku" class="w-full search-bg py-2.5 pl-12 pr-4 rounded-full border border-gray-700 focus:outline-none text-sm text-white" onchange="this.form.submit()">
                </form>
            </div>
        </header>

        <div class="px-6 pb-10 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 overflow-y-auto">
            
            {{-- Menggunakan variabel $semuaBuku agar tidak Undefined --}}
            @forelse($semuaBuku as $buku)
                <div class="card-book p-3 rounded-2xl flex flex-col shadow-xl">
                    {{-- Container Gambar --}}
                    <div class="w-full aspect-[3/4] rounded-lg overflow-hidden mb-3 bg-gray-700 flex items-center justify-center">
                        @if($buku->cover)
                           {{-- Karena di database sudah ada tulisan 'buku/', kita cukup panggil storage saja --}}
                            <img src="{{ asset('storage/' . $buku->cover) }}" class="w-full h-full object-cover" alt="{{ $buku->judul }}">
                        @else
                            {{-- Placeholder jika gambar tidak ada --}}
                            <div class="flex flex-col items-center text-gray-400">
                                <i class="fas fa-book fa-2x mb-2"></i>
                                <span class="text-[8px]">No Cover</span>
                            </div>
                        @endif
                    </div>

                    {{-- Info Buku --}}
                    <div class="text-center flex-1">
                        <h3 class="text-[10px] font-bold text-gray-100 leading-tight uppercase line-clamp-2">{{ $buku->judul }}</h3>
                        <p class="text-[9px] text-gray-300 mt-1 mb-3">{{ $buku->pengarang }}</p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex gap-1">
                        {{-- Route Detail --}}
                        <a href="{{ route('buku.show', $buku->id) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white text-[9px] py-1.5 rounded flex-1 text-center flex items-center justify-center transition-colors">
                            Lihat Detail
                        </a>
                        {{-- Route Pinjam --}}
                        <a href="{{ route('buku.pinjam', $buku->id) }}" 
                           class="bg-[#e74c3c] hover:bg-red-700 text-white text-[9px] py-1.5 rounded flex-1 text-center flex items-center justify-center transition-colors">
                            Pinjam Buku
                        </a>
                    </div>
                </div>
            @empty
                {{-- Tampilan jika data tidak ditemukan --}}
                <div class="col-span-2 md:col-span-3 lg:col-span-5 py-20 text-center">
                    <p class="text-gray-500 italic">Data buku "{{ request('search') }}" tidak ditemukan.</p>
                </div>
            @endforelse

        </div>

        {{-- BAGIAN PAGINATION --}}
        <div class="px-6 mb-10">
            <div class="mt-4">
                {{-- Menjaga parameter pencarian tetap ada saat pindah halaman --}}
                {{ $semuaBuku->appends(request()->query())->links() }}
            </div>
        </div>
    </main>

@endsection