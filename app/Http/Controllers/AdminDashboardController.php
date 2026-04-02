<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    // --- FUNGSI BARU: DETAIL BUKU KHUSUS KEPALA ---
    public function showBukuKepala($id)
    {
        $buku = Buku::findOrFail($id);
        return view('page.backend.kepala.show', compact('buku'));
    }

    // --- FUNGSI BARU: DATA ANGGOTA KHUSUS KEPALA ---
    public function dataAnggotaKepala()
    {
        $anggota = User::where('role', 'anggota')->get();
        return view('page.backend.kepala.anggota', compact('anggota'));
    }

    // --- FUNGSI BARU: DETAIL ANGGOTA KHUSUS KEPALA ---
    public function showAnggotaKepala($id)
    {
        $anggota = User::where('role', 'anggota')->findOrFail($id);
        return view('page.backend.kepala.show_anggota', compact('anggota'));
    }

    // --- FUNGSI: DATA PEMINJAMAN (HANYA STATUS DIPINJAM) ---
    public function dataPeminjamanKepala(Request $request)
    {
        $search = $request->search;
        
        $peminjaman = Peminjaman::with(['user', 'buku'])
            ->where('status', 'dipinjam') // Filter agar hanya yang masih dipinjam
            ->when($search, function($query) use ($search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })->orWhereHas('buku', function($q) use ($search) {
                    $q->where('judul', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('page.backend.kepala.peminjaman', compact('peminjaman'));
    }

    public function showPeminjamanKepala($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);
        return view('page.backend.kepala.show_peminjaman', compact('peminjaman'));
    }

    // --- FUNGSI: DATA PENGEMBALIAN (HANYA STATUS DIKEMBALIKAN) ---
    public function dataPengembalianKepala(Request $request)
    {
        $search = $request->search;
        $pengembalian = Peminjaman::with(['user', 'buku'])
            ->where('status', 'dikembalikan') // Filter agar hanya yang sudah kembali
            ->when($search, function($query) use ($search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('page.backend.kepala.pengembalian', compact('pengembalian'));
    }

    // --- FUNGSI: SHOW PENGEMBALIAN (VARIABEL DISAMAKAN $peminjaman AGAR TIDAK ERROR) ---
    public function showPengembalianKepala($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);
        return view('page.backend.kepala.show_pengembalian', compact('peminjaman'));
    }

    // --- FUNGSI: DAFTAR DENDA KHUSUS KEPALA ---
    public function dataDendaKepala(Request $request)
    {
        $search = $request->search;
        $denda = Peminjaman::with(['user', 'buku'])
            ->where('denda', '>', 0) // Hanya yang ada dendanya
            ->when($search, function($query) use ($search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('page.backend.kepala.denda', compact('denda'));
    }

    public function showDendaKepala($id)
    {
        // Mencari data berdasarkan ID, pastikan hanya yang memiliki denda > 0
        $denda = Peminjaman::with(['user', 'buku'])->where('denda', '>', 0)->findOrFail($id);
        
        return view('page.backend.kepala.show_denda', compact('denda'));
    }
}