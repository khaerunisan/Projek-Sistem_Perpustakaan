<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Petugas\BukuController as PetugasBukuController;
use App\Http\Controllers\Petugas\AnggotaController as PetugasAnggotaController;
use App\Http\Controllers\Petugas\PetugasController; // TAMBAHAN BARU
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjamanController; // Tambahan Baru
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Guest Routes (Hanya bisa diakses jika BELUM login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    // Jika login menggunakan proses manual
    Route::post('login', [LoginController::class, 'login']);

    // Register
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    // Jika menggunakan controller register bawaan atau RegisteredUserController
    Route::post('register', [RegisteredUserController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Harus Login dulu baru bisa akses)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Dashboard (Bisa diakses semua role yang sudah login)
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Hak Akses: PETUGAS
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:petugas')->group(function () {
        // Dashboard Petugas
        Route::get('/petugas/dashboard', [AdminDashboardController::class, 'index'])->name('petugas.dashboard');

        // Data Buku (Halaman Utama)
        Route::get('/petugas/buku', [PetugasBukuController::class, 'index'])->name('petugas.buku');

        // Tambah Buku (Menampilkan Form)
        Route::get('/petugas/buku/create', [PetugasBukuController::class, 'create'])->name('petugas.buku.create');

        // Simpan Buku (Proses Submit Form)
        Route::post('/petugas/buku/store', [PetugasBukuController::class, 'store'])->name('petugas.buku.store');

        // Hapus Buku
        Route::delete('/petugas/buku/{id}', [PetugasBukuController::class, 'destroy'])->name('petugas.buku.destroy');

        Route::get('/petugas/buku/{id}/edit', [PetugasBukuController::class, 'edit'])->name('petugas.buku.edit');
        
        Route::put('/petugas/buku/{id}', [PetugasBukuController::class, 'update'])->name('petugas.buku.update');

        // TAMBAHAN: Detail Buku Petugas
        Route::get('/petugas/buku/{id}', [PetugasBukuController::class, 'show'])->name('petugas.buku.show');

        // --- DATA ANGGOTA  ---
        Route::get('/petugas/anggota', [PetugasAnggotaController::class, 'index'])->name('petugas.anggota');
        Route::get('/petugas/anggota/create', [PetugasAnggotaController::class, 'create'])->name('petugas.anggota.create');
        Route::post('/petugas/anggota/store', [PetugasAnggotaController::class, 'store'])->name('petugas.anggota.store');
        Route::get('/petugas/anggota/{id}', [PetugasAnggotaController::class, 'show'])->name('petugas.anggota.show');
        Route::get('/petugas/anggota/{id}/edit', [PetugasAnggotaController::class, 'edit'])->name('petugas.anggota.edit');
        Route::put('/petugas/anggota/{id}', [PetugasAnggotaController::class, 'update'])->name('petugas.anggota.update');
        Route::delete('/petugas/anggota/{id}', [PetugasAnggotaController::class, 'destroy'])->name('petugas.anggota.destroy');

        // --- RIWAYAT PEMINJAMAN & PENGEMBALIAN  ---
        Route::get('/petugas/peminjaman', [PetugasPeminjamanController::class, 'index'])->name('petugas.peminjaman');
        Route::get('/petugas/peminjaman/{id}', [PetugasPeminjamanController::class, 'show'])->name('petugas.peminjaman.show');
        
        // --- TAMBAHAN BARU: EDIT & UPDATE DATA PEMINJAMAN ---
        Route::get('/petugas/peminjaman/{id}/edit', [PetugasPeminjamanController::class, 'edit'])->name('petugas.peminjaman.edit');
        Route::put('/petugas/peminjaman/{id}', [PetugasPeminjamanController::class, 'update'])->name('petugas.peminjaman.update');

        // FIX: Rute Simpan Data Peminjaman (Tanpa Route Create)
        Route::post('/petugas/peminjaman/store', [PetugasPeminjamanController::class, 'store'])->name('petugas.peminjaman.store');
        
        // FIX: Rute Hapus Peminjaman agar tidak RouteNotFound
        Route::delete('/petugas/peminjaman/{id}', [PetugasPeminjamanController::class, 'destroy'])->name('petugas.peminjaman.destroy');
        
        // --- TAMBAHAN BARU: PROSES KEMBALIKAN BUKU ---
        Route::put('/petugas/peminjaman/kembali/{id}', [PetugasPeminjamanController::class, 'kembalikanBuku'])->name('petugas.peminjaman.kembali');

        // TAMBAHAN ROUTE PENGEMBALIAN DAN HAPUS
        Route::get('/petugas/pengembalian', [PetugasPeminjamanController::class, 'riwayatPengembalian'])->name('petugas.pengembalian');
        Route::get('/petugas/pengembalian/{id}', [PetugasPeminjamanController::class, 'detailPengembalian'])->name('petugas.pengembalian.detail');
        
        // --- TAMBAHAN BARU: EDIT & UPDATE PENGEMBALIAN ---
        Route::get('/petugas/pengembalian/{id}/edit', [PetugasPeminjamanController::class, 'editPengembalian'])->name('petugas.pengembalian.edit');
        Route::put('/petugas/pengembalian/{id}', [PetugasPeminjamanController::class, 'updatePengembalian'])->name('petugas.pengembalian.update');
        
        Route::delete('/petugas/pengembalian/{id}', [PetugasPeminjamanController::class, 'destroy'])->name('petugas.pengembalian.destroy');
        
        // TAMBAHAN ROUTE DENDA PETUGAS
        Route::get('/petugas/denda', [PetugasPeminjamanController::class, 'daftarDenda'])->name('petugas.denda');

        // --- ROUTE CREATE DENDA ---
        Route::get('/petugas/denda/create', [PetugasPeminjamanController::class, 'createDenda'])->name('petugas.denda.create');
        
        // --- PERBAIKAN: Sekarang mengarah ke createPengembalian agar tidak Not Found ---
        Route::get('/petugas/pengembalian/create', [PetugasPeminjamanController::class, 'createPengembalian'])->name('petugas.pengembalian.create');
        Route::post('/petugas/pengembalian/store', [PetugasPeminjamanController::class, 'storePengembalian'])->name('petugas.pengembalian.store_baru');
    });

    /*
    |--------------------------------------------------------------------------
    | Hak Akses: KEPALA
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:kepala')->group(function () {
        Route::get('/laporan', function() {
            return "Halaman Laporan Cetak";
        })->name('kepala.laporan');

        // PERBAIKAN: Sekarang memanggil PetugasController agar data tidak tertukar dengan anggota
        Route::get('/petugas-data', [PetugasController::class, 'index'])->name('kepala.petugas');

        // --- PERBAIKAN: Menggunakan name unik dan memanggil PetugasController ---
        Route::get('/info-petugas/detail/{id}', [PetugasController::class, 'show'])->name('kepala.petugas.show');
        
        Route::get('/kepala/data-buku', [AdminDashboardController::class, 'dataBukuKepala'])->name('kepala.data-buku');
        Route::get('/kepala/buku-detail/{id}', [AdminDashboardController::class, 'showBukuKepala'])->name('kepala.buku.show');
        Route::get('/kepala/data-anggota', [AdminDashboardController::class, 'dataAnggotaKepala'])->name('kepala.anggota');
        Route::get('/kepala/anggota/{id}', [AdminDashboardController::class, 'showAnggotaKepala'])->name('kepala.anggota.show');
       
        // Halaman daftar peminjaman kepala
        Route::get('/kepala/peminjaman', [AdminDashboardController::class, 'dataPeminjamanKepala'])->name('kepala.peminjaman');
        Route::get('/kepala/peminjaman/detail/{id}', [AdminDashboardController::class, 'showPeminjamanKepala'])->name('kepala.show_peminjaman');
        
        // Halaman daftar pengembalian kepala
        Route::get('/kepala/pengembalian', [AdminDashboardController::class, 'dataPengembalianKepala'])->name('kepala.pengembalian');
        Route::get('/kepala/pengembalian/detail/{id}', [AdminDashboardController::class, 'showPengembalianKepala'])->name('kepala.show_pengembalian');
        Route::get('/kepala/denda', [AdminDashboardController::class, 'dataDendaKepala'])->name('kepala.denda');
        Route::get('/kepala/denda/detail/{id}', [AdminDashboardController::class, 'showDendaKepala'])->name('kepala.show_denda');
    });

    /*
    |--------------------------------------------------------------------------
    | Hak Akses: ANGGOTA
    |--------------------------------------------------------------------------
    */
   Route::middleware('role:anggota')->group(function () {
        // Daftar Buku & Detail
        Route::get('/daftarbuku', [BukuController::class, 'daftarBuku'])->name('anggota.daftarbuku');
        Route::get('/daftarbuku/{id}', [BukuController::class, 'show'])->name('buku.show');
        
        // Peminjaman
        Route::get('/buku/pinjam/{id}', [BukuController::class, 'pinjam'])->name('buku.pinjam');
        Route::post('/buku/pinjam/{id}', [BukuController::class, 'pinjamStore'])->name('pinjam.store');
        Route::get('/peminjaman', [BukuController::class, 'riwayatPeminjaman'])->name('peminjaman.index');

        // Pengembalian & Store (Proses Simpan)
        Route::get('/pengembalian/buku/{id}', [BukuController::class, 'pengembalian'])->name('buku.pengembalian');
        Route::post('/pengembalian/buku/{id}', [BukuController::class, 'pengembalianStore'])->name('pengembalian.store');

        // Halaman Rekap Denda
        Route::get('/denda', [BukuController::class, 'daftarDenda'])->name('denda.index');
        
        // Opsional: Jika ingin riwayat khusus pengembalian
        Route::get('/pengembalian', function() {
            return "Halaman Riwayat Pengembalian Buku";
        })->name('pengembalian.index');
    });

});