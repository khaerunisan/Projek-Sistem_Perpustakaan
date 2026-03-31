<?php

namespace App\Http\Controllers;

use App\Models\Buku; 
use App\Models\Peminjaman; // Import Model Peminjaman
use Illuminate\Http\Request; // Import Request
use Illuminate\Support\Facades\Auth; // Import Auth
use Carbon\Carbon; // Tambahkan ini agar pemanggilan Carbon lebih simpel

class BukuController extends Controller
{
    // Menampilkan semua daftar buku
    public function daftarBuku()
    {
        $semuaBuku = Buku::all(); 
        // Disesuaikan dengan gambar folder kamu: Buku (B besar)
        return view('page.backend.Buku.daftarbuku', compact('semuaBuku'));
    }

    // Menampilkan detail buku berdasarkan ID
    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        // Disesuaikan dengan gambar folder kamu: Buku (B besar)
        return view('page.backend.Buku.detail', compact('buku')); 
    }

    // --- TAMBAHKAN FUNGSI DI BAWAH INI ---

    // 1. Menampilkan Form Peminjaman (Halaman yang ada gambar bukunya)
    public function pinjam($id)
    {
        $buku = Buku::findOrFail($id);
        // Folder peminjaman kamu di gambar pakai huruf kecil
        return view('page.backend.peminjaman.create', compact('buku'));
    }

    // 2. Memproses penyimpanan data peminjaman ke database
    public function pinjamStore(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        // Validasi jika stok habis
        if ($buku->stok <= 0) {
            return back()->with('error', 'Maaf, stok buku ini sudah habis!');
        }

        // Simpan data ke tabel peminjaman
        Peminjaman::create([
            'id_peminjaman' => $request->id_peminjaman,
            'user_id'       => Auth::id(), // ID user yang sedang login
            'buku_id'       => $id,
            'tgl_pinjam'    => $request->tgl_pinjam,
            'status'        => 'dipinjam',
        ]);

        // Kurangi stok buku secara otomatis
        $buku->decrement('stok');

        // DIUBAH: Redirect ke halaman riwayat peminjaman dengan pesan khusus
        return redirect()->route('peminjaman.index')->with('success_pinjam', 'Berhasil Meminjam Buku');
    }

    // 3. Menampilkan daftar riwayat peminjaman user yang sedang login
    public function riwayatPeminjaman()
    {
        $riwayat = Peminjaman::with('buku', 'user')
                    ->where('user_id', Auth::id())
                    ->get();

        // Folder peminjaman kamu di gambar pakai huruf kecil
        return view('page.backend.peminjaman.index', compact('riwayat'));
    }

    // 1. Menampilkan Form Pengembalian & Hitung Denda
    public function pengembalian($id)
    {
        // Cari data peminjaman berdasarkan ID
        $pinjam = Peminjaman::with('buku', 'user')->findOrFail($id);
        
        // --- PERBAIKAN: Cek apakah di database sudah ada tgl_kembali (hasil edit manual) ---
        // Jika ada di DB, gunakan itu. Jika NULL, gunakan tanggal sekarang.
        $tgl_kembali = $pinjam->tgl_kembali ? Carbon::parse($pinjam->tgl_kembali) : Carbon::now();
        
        $tgl_pinjam = Carbon::parse($pinjam->tgl_pinjam);
        
        // Hitung durasi selisih hari antara pinjam dan kembali
        $durasi = ceil($tgl_pinjam->diffInDays($tgl_kembali));

        // Jika durasi 0 (hari yang sama), kita anggap 1 hari
        if ($durasi <= 0) {
            $durasi = 1;
        }
        
        // Aturan denda: Misal batas pinjam 7 hari, denda 15rb/hari
        $batas_pinjam = 7;
        $terlambat = 0;
        $denda = 0;

        if ($durasi > $batas_pinjam) {
            $terlambat = $durasi - $batas_pinjam;
            $denda = $terlambat * 15000;
        }

        return view('page.backend.peminjaman.pengembalian', compact('pinjam', 'durasi', 'terlambat', 'denda', 'tgl_kembali'));
    }

   // 2. Memproses data pengembalian ke Database
    public function pengembalianStore(Request $request, $id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $buku = Buku::findOrFail($pinjam->buku_id);

        // Menangkap data denda dari input hidden di Blade
        $denda = $request->input('denda');

        // --- PERBAIKAN: Gunakan tanggal dari form (request) agar sinkron dengan tampilan ---
        $pinjam->update([
            'tgl_kembali' => $request->tgl_kembali ?? Carbon::now(),
            'status' => 'dikembalikan',
            'denda' => $denda // Nilai denda masuk ke database di sini
        ]);

        // Kembalikan stok buku (+1)
        $buku->increment('stok');

        // Redirect dengan pesan sukses
        return redirect()->route('peminjaman.index')->with('success_pinjam', 'Buku Berhasil Dikembalikan. Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }

    // Menampilkan daftar semua denda yang masuk ke sistem
    public function daftarDenda()
    {
        // Ambil data peminjaman yang dendanya lebih dari 0, urutkan dari yang terbaru
        $semuaDenda = Peminjaman::with(['buku', 'user'])
                        ->where('denda', '>', 0)
                        ->orderBy('updated_at', 'desc')
                        ->get();

        // Mengirim data ke file denda.blade.php yang baru saja kamu buat
        return view('page.backend.peminjaman.denda', compact('semuaDenda'));
    }
}