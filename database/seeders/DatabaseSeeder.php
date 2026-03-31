<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Buku; 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Petugas
        User::create([
            'name'     => 'Petugas Perpustakaan',
            'email'    => 'petugas@mail.com',
            'password' => Hash::make('password'),
            'role'     => 'petugas',
            'prodi'    => 'Administrasi',
            'alamat'   => 'Kantor Perpustakaan',
            'phone'    => '08123456789',
        ]);

        // 2. Akun Kepala Sekolah
        User::create([
            'name'     => 'Kepala Perpustakaan',
            'email'    => 'kepala@mail.com',
            'password' => Hash::make('password'),
            'role'     => 'kepala',
            'prodi'    => 'Manajemen',
            'alamat'   => 'Ruang Utama',
            'phone'    => '08998877665',
        ]);

        // 3. Akun Anggota
        User::create([
            'name'     => 'Siswa Anggota',
            'email'    => 'anggota@mail.com',
            'password' => Hash::make('password'),
            'role'     => 'anggota',
            'prodi'    => 'Teknik Informatika',
            'alamat'   => 'Jl. Pendidikan No. 1',
            'phone'    => '08554433221',
        ]);

        // --- DATA BUKU (Nama kolom disesuaikan dengan Database kamu: pengarang & thn_terbit & cover) ---

        Buku::create([
            'judul'      => 'Diary of Canva',
            'penerbit'   => 'Akad',
            'pengarang'  => 'Itakrn', 
            'thn_terbit' => 2022,
            'stok'       => 5,
            'deskripsi'  => 'Canva merupakan seorang anak dari keluarga yang berkecukupan.',
            'cover'      => 'buku/canva.jpg' 
        ]);

        Buku::create([
            'judul'      => 'Cantik Itu Luka',
            'penerbit'   => 'Gramedia',
            'pengarang'  => 'Eka Kurniawan',
            'thn_terbit' => 2002,
            'stok'       => 3,
            'deskripsi'  => 'Sebuah mahakarya yang menggabungkan sejarah dan realisme magis.',
            'cover'      => 'buku/cantik.jfif'
        ]);

        Buku::create([
            'judul'      => 'Filosofi Teras',
            'penerbit'   => 'Buku Kompas',
            'pengarang'  => 'Henry Manampiring',
            'thn_terbit' => 2019,
            'stok'       => 10,
            'deskripsi'  => 'Filsafat Yunani-Romawi kuno untuk mental tangguh di masa kini.',
            'cover'      => 'buku/filosofi.jfif'
        ]);

        Buku::create([
            'judul'      => 'Pulang',
            'penerbit'   => 'Penerbit Karima',
            'pengarang'  => 'Karima Ikhla',
            'thn_terbit' => 2023,
            'stok'       => 4,
            'deskripsi'  => 'Kisah tentang perjalanan menemukan arti rumah yang sesungguhnya.',
            'cover'      => 'buku/pulang.webp'
        ]);

        Buku::create([
            'judul'      => 'Cinderella Tanpa Nama',
            'penerbit'   => 'Gramedia Pustaka Utama',
            'pengarang'  => 'Patricia Alodie',
            'thn_terbit' => 2021,
            'stok'       => 2,
            'deskripsi'  => 'Misteri dibalik sepatu kaca yang tidak pernah ditemukan pemiliknya.',
            'cover'      => 'buku/cinderella.jpg'
        ]);

        Buku::create([
            'judul'      => 'Sejarah Dunia Lengkap',
            'penerbit'   => 'Anak Hebat Indonesia',
            'pengarang'  => 'Tim Penulis Sejarah',
            'thn_terbit' => 2020,
            'stok'       => 6,
            'deskripsi'  => 'Rangkuman peristiwa besar yang membentuk peradaban manusia.',
            'cover'      => 'buku/sejarah.jfif'
        ]);

        Buku::create([
            'judul'      => 'Dasar Manajemen',
            'penerbit'   => 'Kemendikbudristek',
            'pengarang'  => 'Tim Ahli Manajemen',
            'thn_terbit' => 2022,
            'stok'       => 15,
            'deskripsi'  => 'Buku panduan dasar mengenai tata kelola organisasi.',
            'cover'      => 'buku/akl.jfif'
        ]);

        Buku::create([
            'judul'      => 'Pendidikan Jasmani',
            'penerbit'   => 'Kemendikbudristek',
            'pengarang'  => 'Tim PJOK',
            'thn_terbit' => 2022,
            'stok'       => 12,
            'deskripsi'  => 'Materi pembelajaran kesehatan dan aktivitas fisik untuk siswa.',
            'cover'      => 'buku/pjok.jfif'
        ]);

        Buku::create([
            'judul'      => 'Kamu Gak Sendiri',
            'penerbit'   => 'GagasMedia',
            'pengarang'  => 'Syahid Muhammad',
            'thn_terbit' => 2019,
            'stok'       => 7,
            'deskripsi'  => 'Sebuah teman bagi kamu yang sedang berjuang dengan diri sendiri.',
            'cover'      => 'buku/sendiri.jfif'
        ]);

        Buku::create([
            'judul'      => 'Segala-galanya Ambyar',
            'penerbit'   => 'HarperCollins',
            'pengarang'  => 'Mark Manson',
            'thn_terbit' => 2019,
            'stok'       => 8,
            'deskripsi'  => 'Buku tentang harapan dari penulis Mark Manson.',
            'cover'      => 'buku/ambyar.jfif'
        ]);
    }
}