<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User; // Penting agar error di VS Code hilang
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            
            // PERBAIKAN LOGIKA: Total Pinjam menghitung SEMUA riwayat agar muncul angka 7
            $totalPinjam = Peminjaman::count(); 
            
            // PERBAIKAN LOGIKA: Buku Dipinjam (Variabel Baru agar sinkron dengan blade) menghitung status 'dipinjam' agar muncul angka 2
            $totalPinjamAktif = Peminjaman::where('status', 'dipinjam')->count();
            
            // Tambahan: Hitung Total Denda Keseluruhan untuk Petugas
            $totalDenda = Peminjaman::sum('denda');

            // Perbaikan Logika Terlambat: membandingkan tgl_kembali (deadline) dengan waktu sekarang
            $totalTerlambat = Peminjaman::where('status', 'dipinjam')
                                ->where('tgl_kembali', '<', now())
                                ->count();

            // Ambil data untuk tabel - Menggunakan Eager Loading 'with' agar tidak berat
            $peminjamanAktif = Peminjaman::with(['user', 'buku'])
                                ->where('status', 'dipinjam')
                                ->latest()->get();

            // Diubah menjadi $pengembalian agar sinkron dengan file Blade
            $pengembalian = Peminjaman::with(['user', 'buku'])
                                ->where('status', 'dikembalikan')
                                ->latest()->get();

            // Arahkan ke folder petugas dan file dashboard yang baru kamu buat
            return view('page.backend.petugas.dashboard', compact(
                'totalBuku', 'totalAnggota', 'totalPinjam', 'totalPinjamAktif', 'totalTerlambat', 'totalDenda',
                'peminjamanAktif', 'pengembalian'
            ));
        }

        // --- JALUR UNTUK KEPALA ---
        if ($role == 'kepala') {
            // Mengambil data untuk 4 kartu statistik sesuai permintaan:
            $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count(); // Kartu 1: Dipinjam
            $totalPinjam = Peminjaman::count();                              // Kartu 2: Total Pinjam (Semua Riwayat)
            $totalDenda = Peminjaman::sum('denda');                          // Kartu 3: Total Denda
            $jumlahBuku = Buku::count();                                     // Kartu 4: Koleksi Buku

            // Variabel tambahan untuk tabel di bawah kartu (tetap dipertahankan)
            $peminjamanAktif = Peminjaman::with(['user', 'buku'])
                                ->where('status', 'dipinjam')
                                ->latest()->take(5)->get();
                                
            $riwayatTerbaru = Peminjaman::with(['user', 'buku'])
                                ->where('status', 'dikembalikan')
                                ->latest()->take(5)->get();

            // Arahkan ke folder kepala yang baru dibuat
            return view('page.backend.kepala.index', compact(
                'bukuDipinjam', 'totalPinjam', 'totalDenda', 'jumlahBuku',
                'peminjamanAktif', 'riwayatTerbaru'
            ));
        }

        // Jika role tidak dikenali, redirect ke home atau login
        return redirect('/');
    }

    // --- FUNGSI BARU: DATA BUKU KHUSUS KEPALA (DITAMBAHKAN SEARCH & PAGINATE) ---
    public function dataBukuKepala(Request $request)
    {
        $search = $request->input('search');
        $allBuku = Buku::when($search, function ($query, $search) {
                        return $query->where('judul', 'like', "%{$search}%")
                                     ->orWhere('penulis', 'like', "%{$search}%");
                    })
                    ->latest()
                    ->paginate(10);

        return view('page.backend.kepala.data_buku', compact('allBuku'));
    }

    // --- FUNGSI BARU: DATA PETUGAS KHUSUS KEPALA (DITAMBAHKAN SEARCH & PAGINATE) ---
    public function dataPetugas(Request $request)
    {
        $search = $request->input('search');
        $petugas = User::where('role', 'petugas')
                    ->when($search, function ($query, $search) {
                        return $query->where('name', 'like', "%{$search}%")
                                     ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->latest()
                    ->paginate(10);

        return view('page.backend.kepala.data_petugas', compact('petugas'));
    }

    // --- FUNGSI BARU: DETAIL BUKU KHUSUS KEPALA ---
    public function showBukuKepala($id)
    {
        $buku = Buku::findOrFail($id);
        return view('page.backend.kepala.show', compact('buku'));
    }

    // --- FUNGSI BARU: DATA ANGGOTA KHUSUS KEPALA (DITAMBAHKAN SEARCH & PAGINATE) ---
    public function dataAnggotaKepala(Request $request)
    {
        $search = $request->input('search');
        $anggota = User::where('role', 'anggota')
                    ->when($search, function ($query, $search) {
                        return $query->where('name', 'like', "%{$search}%")
                                     ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->latest()
                    ->paginate(10);

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
                })->orWhereHas('buku', function($q) use ($search) {
                    $q->where('judul', 'like', "%$search%");
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
                })->orWhereHas('buku', function($q) use ($search) {
                    $q->where('judul', 'like', "%$search%");
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

   
    public function laporan()
    {
        // 1. Mengambil semua data peminjaman
        $semuaPeminjaman = Peminjaman::with(['user', 'buku'])->latest()->get();

        // 2. Memisahkan data agar bisa tampil di kotak-kotak (card/tabel) terpisah
        $dataPeminjaman = $semuaPeminjaman->where('status', 'dipinjam');
        $dataPengembalian = $semuaPeminjaman->where('status', 'dikembalikan');
        $dataDenda = $semuaPeminjaman->where('denda', '>', 0);

        // 3. Menghitung data statistik
        $totalPeminjaman = $semuaPeminjaman->count();
        $totalKembali = $dataPengembalian->count();
        $totalPinjamAktif = $dataPeminjaman->count();
        $totalDenda = $semuaPeminjaman->sum('denda');

        // 4. Mengirim data ke view laporan
        return view('page.backend.kepala.laporan', compact(
            'semuaPeminjaman', 
            'dataPeminjaman', 
            'dataPengembalian', 
            'dataDenda', 
            'totalPeminjaman', 
            'totalKembali',
            'totalPinjamAktif',
            'totalDenda'
        ));
    }
}