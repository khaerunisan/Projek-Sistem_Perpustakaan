<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    // Menampilkan buku yang SEDANG dipinjam
    public function index()
    {
        // Pastikan relasi 'user' dan 'buku' ada di Model Peminjaman
        $peminjaman = Peminjaman::with(['user', 'buku'])
                        ->where('status', 'dipinjam')
                        ->latest()
                        ->get();

        return view('page.backend.petugas.peminjaman.index', compact('peminjaman'));
    }

    // Menampilkan buku yang SUDAH dikembalikan
    public function riwayatPengembalian()
    {
        $pengembalian = Peminjaman::with(['user', 'buku'])
                        ->where('status', 'dikembalikan')
                        ->latest()
                        ->get();

        return view('page.backend.petugas.peminjaman.pengembalian', compact('pengembalian'));
    }

    // Detail untuk yang MASIH dipinjam
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);
        return view('page.backend.petugas.peminjaman.show', compact('peminjaman'));
    }

    // Detail untuk yang SUDAH kembali (Halaman Pengembalian)
    public function detailPengembalian($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);
        return view('page.backend.petugas.peminjaman.detail_pengembalian', compact('peminjaman'));
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function daftarDenda()
    {
        // Mengambil data peminjaman yang memiliki denda (lebih dari 0)
        $denda = Peminjaman::with(['user', 'buku'])
                    ->where('denda', '>', 0)
                    ->latest()
                    ->get();

        return view('page.backend.petugas.peminjaman.denda', compact('denda'));
    }
}