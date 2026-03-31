<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        // --- JALUR UNTUK ANGGOTA ---
        if ($role == 'anggota') {
            $userId = Auth::id();

            // Menghitung data khusus untuk anggota yang login
            $totalDipinjam = Peminjaman::where('user_id', $userId)
                                        ->where('status', 'dipinjam')
                                        ->count();

            $totalRiwayat = Peminjaman::where('user_id', $userId)->count();

            $totalDenda = Peminjaman::where('user_id', $userId)->sum('denda');

            $totalBuku = Buku::count();

            // Mengirim variabel ke view admin.index (dashboard anggota)
            return view('page.backend.admin.index', compact(
                'totalDipinjam', 
                'totalRiwayat', 
                'totalDenda', 
                'totalBuku'
            ));
        }

        // --- JALUR UNTUK PETUGAS ---
        if ($role == 'petugas') {
            // Ambil angka untuk kartu statistik
            $totalBuku = Buku::count();
            $totalAnggota = User::where('role', 'anggota')->count();
            $totalPinjam = Peminjaman::where('status', 'dipinjam')->count();
            $totalTerlambat = Peminjaman::where('status', 'dipinjam')
                                ->where('tgl_kembali', '<', now())
                                ->count();

            // Ambil data untuk tabel
            $peminjamanAktif = Peminjaman::with(['user', 'buku'])
                                ->where('status', 'dipinjam')
                                ->latest()->take(5)->get();

            // Diubah menjadi $pengembalian agar sinkron dengan file Blade
            $pengembalian = Peminjaman::with(['user', 'buku'])
                                ->where('status', 'dikembalikan')
                                ->latest()->take(5)->get();

            // Arahkan ke folder petugas dan file dashboard yang baru kamu buat
            return view('page.backend.petugas.dashboard', compact(
                'totalBuku', 'totalAnggota', 'totalPinjam', 'totalTerlambat',
                'peminjamanAktif', 'pengembalian'
            ));
        }

        // --- JALUR UNTUK KEPALA ---
        if ($role == 'kepala') {
            // Mengambil data yang sama dengan petugas untuk ditampilkan di dashboard kepala
            $jumlahBuku = Buku::count();
            $jumlahAnggota = User::where('role', 'anggota')->count();
            $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();
            $bukuTerlambat = Peminjaman::where('status', 'dipinjam')
                                ->where('tgl_kembali', '<', now())
                                ->count();

            $peminjamanAktif = Peminjaman::with(['user', 'buku'])
                                ->where('status', 'dipinjam')
                                ->latest()->take(5)->get();
                                
            $riwayatTerbaru = Peminjaman::with(['user', 'buku'])
                                ->where('status', 'dikembalikan')
                                ->latest()->take(5)->get();

            // Arahkan ke folder kepala yang baru dibuat
            // Hapus 'allBuku' dari sini agar grid buku tidak muncul di dashboard
            return view('page.backend.kepala.index', compact(
                'jumlahBuku', 'jumlahAnggota', 'bukuDipinjam', 'bukuTerlambat',
                'peminjamanAktif', 'riwayatTerbaru'
            ));
        }
    }

    // --- FUNGSI BARU: DATA BUKU KHUSUS KEPALA ---
    public function dataBukuKepala()
    {
        $allBuku = Buku::all();
        return view('page.backend.kepala.data_buku', compact('allBuku'));
    }

    // --- FUNGSI BARU: DATA PETUGAS KHUSUS KEPALA ---
    public function dataPetugas()
    {
        $petugas = User::where('role', 'petugas')->get();
        return view('page.backend.kepala.data_petugas', compact('petugas'));
    }

    // --- FUNGSI BARU: DETAIL BUKU KHUSUS KEPALA (TAMBAHAN) ---
    public function showBukuKepala($id)
    {
        $buku = Buku::findOrFail($id);
        return view('page.backend.kepala.show', compact('buku'));
    }

    // --- FUNGSI BARU: DATA ANGGOTA KHUSUS KEPALA (TAMBAHAN UNTUK LANGKAH 1) ---
    public function dataAnggotaKepala()
    {
        // Mengambil data user yang memiliki role anggota
        $anggota = User::where('role', 'anggota')->get();
        return view('page.backend.kepala.anggota', compact('anggota'));
    }

    // --- FUNGSI BARU: DETAIL ANGGOTA KHUSUS KEPALA (AMBIL DARI DATA REGISTER/USER) ---
    public function showAnggotaKepala($id)
    {
        // Mencari user berdasarkan ID yang memiliki role anggota
        $anggota = User::where('role', 'anggota')->findOrFail($id);
        return view('page.backend.kepala.show_anggota', compact('anggota'));
    }
}