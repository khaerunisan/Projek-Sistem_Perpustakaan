<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lib-Digital | Perpustakaan Masa Depan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* CSS UNTUK BACKGROUND GAMBAR */
        .bg-perpustakaan {
            /* 1. GANTI LINK DI BAWAH INI DENGAN GAMBAR KAMU */
            /* Jika pakai file lokal: url('{{ asset('img/bg-perpus.jpg') }}') */
            background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000&auto=format&fit=crop');
            
            /* 2. Pengaturan agar gambar rapi */
            background-size: cover;      /* Gambar memenuhi layar */
            background-position: center; /* Gambar rata tengah */
            background-repeat: no-repeat;
            background-attachment: fixed; /* Efek parallax (opsional, gambar diam saat di-scroll) */
        }
    </style>
</head>
{{-- Menambahkan class bg-perpustakaan di body --}}
<body class="bg-perpustakaan text-white selection:bg-blue-500 min-h-screen relative overflow-x-hidden">

    {{-- LAYER OVERLAY (Biar teks tetap jelas dibaca) --}}
    {{-- Kamu bisa atur kegelapannya di bg-black/70 (semakin besar angka, semakin gelap) --}}
    <div class="absolute inset-0 bg-black/70 z-0"></div>

    {{-- Semua konten dibungkus div relative z-10 agar berada di atas overlay --}}
    <div class="relative z-10 flex flex-col min-h-screen">
        
        {{-- Menghapus border-b agar lebih menyatu dengan background gambar --}}
        <nav class="flex justify-between items-center px-8 py-6 sticky top-0 bg-black/30 backdrop-blur-md z-50">
            <div class="text-xl font-black italic uppercase tracking-tighter text-white">
                PER<span class="text-blue-400 underline decoration-2 underline-offset-4">SDI</span>
            </div>
            
            <div class="flex items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        {{-- Jika sudah login, arahkan ke dashboard --}}
                        <a href="{{ route('dashboard') }}" class="text-[11px] uppercase font-bold tracking-widest bg-white text-black px-6 py-2.5 rounded-full hover:bg-gray-200 transition duration-300 shadow-lg">
                            Ke Dashboard
                        </a>
                    @else
                        {{-- Jika belum login --}}
                        <a href="{{ route('login') }}" class="text-[11px] uppercase font-bold tracking-widest text-gray-200 hover:text-white transition font-black">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-[11px] uppercase font-bold tracking-widest bg-blue-600 text-white px-6 py-2.5 rounded-full hover:bg-blue-700 transition shadow-[0_5px_20px_rgba(37,99,235,0.4)] font-black">
                            Daftar
                        </a>
                    @endauth
                @endif
            </div>
        </nav>

        {{-- flex-grow agar section ini mengambil sisa ruang dan footer tetap di bawah --}}
        <header class="relative flex flex-grow flex-col items-center justify-center text-center px-6 pt-10 pb-20">
            {{-- Mengubah cahaya background jadi sedikit lebih redup agar menyatu --}}
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-500/10 rounded-full blur-[150px] -z-10"></div>
            
            {{-- Mengubah text-gray-700 jadi text-gray-400 agar kelihatan di bg gelap --}}
            <h1 class="text-6xl md:text-8xl font-extrabold tracking-tighter mb-8 leading-[0.9] text-white">
                PINJAM BUKU <br> <span class="text-gray-400 italic">TANPA ANTRI</span>
            </h1>
            
            {{-- Sedikit menerangkan p agar teks lebih tajam --}}
            <p class="text-gray-200 max-w-2xl text-sm md:text-lg leading-relaxed mb-12 font-medium backdrop-blur-[2px] rounded-xl p-2">
                Akses koleksi digital, pantau riwayat peminjaman, bayar denda dalam satu platform modern dan Klik. Baca. Tahu.
            </p>
        </header>

        {{-- Menghapus border-t agar lebih bersih --}}
        <footer class="py-10 bg-black/50 backdrop-blur-sm text-center mt-auto">
            <p class="text-gray-400 text-[10px] uppercase tracking-[4px] font-bold">
                &copy; 2026 Digital Library System &bull; PERSDI
            </p>
        </footer>

    </div> {{-- Penutup Konten Relative Z-10 --}}

</body>
</html>