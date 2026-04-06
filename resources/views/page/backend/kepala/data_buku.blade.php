@extends('layouts.backend.app')

@section('content')
<div class="min-h-screen bg-[#000000] p-6 text-sm font-sans">
    
    {{-- Header Section: Judul dan Search --}}
    <div class="mb-10">
        {{-- Judul dengan ukuran lebih besar --}}
        <h2 class="text-white font-extrabold text-2xl mb-6 ml-2 italic uppercase tracking-tighter leading-none"> 
            Data Buku
        </h2>
        
        {{-- Search Bar: Melebar Penuh (Max-w-none) --}}
        <div class="w-full px-2">
            <form action="#" method="GET" class="w-full" onsubmit="return false;">
                <div class="relative w-full">
                    {{-- Icon Pencarian --}}
                    <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-red-600 text-sm"></i>
                    </span>
                    {{-- Input Search dengan Padding Kiri yang Pas agar tidak numpuk --}}
                    <input type="text" 
                           id="searchInput" 
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari Judul Buku atau Nama Penulis" 
                           class="w-full bg-[#111419] border border-gray-800 text-gray-300 text-xs rounded-full py-3.5 pl-12 pr-6 focus:ring-1 focus:ring-red-600 focus:border-red-600 outline-none transition-all duration-300 shadow-2xl">
                </div>
            </form>
        </div>
    </div>

    {{-- Grid Buku --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6" id="bukuGrid">
        @forelse($allBuku ?? [] as $buku)
        <div class="buku-card bg-[#111419] rounded-xl overflow-hidden border border-gray-800 flex flex-col h-full shadow-lg transition-all duration-300 hover:border-red-600 group">
            <div class="p-4 flex-grow text-center">
                {{-- Cover --}}
                <div class="aspect-[3/4] rounded-lg overflow-hidden mb-3 shadow-md bg-black border border-gray-800">
                    @if($buku->cover)
                        <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-700 font-bold uppercase italic text-[9px]">No Cover</div>
                    @endif
                </div>
                
                {{-- Judul & Penulis --}}
                <h4 class="text-white text-[10px] font-bold line-clamp-2 uppercase leading-tight mb-1 group-hover:text-red-500 transition-colors">
                    {{ $buku->judul }}
                </h4>
                <p class="text-gray-500 text-[9px] italic mb-3">{{ $buku->penulis }}</p>
            </div>

            {{-- Action Detail --}}
            <div class="p-4 pt-0">
                <a href="{{ route('kepala.buku.show', $buku->id) }}" 
                   class="flex items-center justify-center gap-2 w-full bg-[#1c2128] text-gray-400 hover:bg-red-600 hover:text-white text-[9px] font-bold py-2.5 rounded-lg text-center uppercase tracking-widest transition-all duration-300 border border-gray-800 hover:border-red-600">
                    <span>Lihat Detail</span>
                    <i class="fas fa-arrow-right text-[7px]"></i>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <i class="fas fa-book-open text-gray-800 text-3xl mb-3"></i>
            <p class="italic text-gray-600 uppercase tracking-widest text-[10px]">Belum ada data buku tersedia.</p>
        </div>
        @endforelse
    </div>

    {{-- BAGIAN PAGINATION --}}
    <div class="mt-10 mb-10">
        {{ $allBuku->appends(request()->query())->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const cards = document.querySelectorAll('.buku-card');

        searchInput.addEventListener('input', function() {
            const filter = searchInput.value.toLowerCase();
            cards.forEach(card => {
                const title = card.querySelector('h4').textContent.toLowerCase();
                const author = card.querySelector('p').textContent.toLowerCase();
                if (title.includes(filter) || author.includes(filter)) {
                    card.style.display = "flex";
                } else {
                    card.style.display = "none";
                }
            });
        });
    });
</script>
@endsection