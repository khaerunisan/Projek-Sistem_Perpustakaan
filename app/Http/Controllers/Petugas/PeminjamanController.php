<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku; // Tambahkan ini
use App\Models\User; // Tambahkan ini
use Illuminate\Http\Request; // Tambahkan ini untuk handle search

class PeminjamanController extends Controller
{
    // Menampilkan buku yang SEDANG dipinjam
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Pastikan relasi 'user' dan 'buku' ada di Model Peminjaman
        $peminjaman = Peminjaman::with(['user', 'buku'])
                        ->where('status', 'dipinjam')
                        ->when($search, function ($query, $search) {
                            return $query->whereHas('user', function($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            })->orWhereHas('buku', function($q) use ($search) {
                                $q->where('judul', 'like', "%{$search}%");
                            });
                        })
                        ->latest()
                        ->paginate(10); // GANTI KE PAGINATE AGAR TIDAK ERROR firstItem

        // Ambil data untuk modal tambah (karena create dihapus)
        $users = User::where('role', 'anggota')->get();
        $buku = Buku::where('stok', '>', 0)->get();

        return view('page.backend.petugas.peminjaman.index', compact('peminjaman', 'users', 'buku'));
    }

    // --- FUNGSI STORE (UNTUK SIMPAN DATA PEMINJAMAN BARU) ---
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'buku_id' => 'required',
            'tgl_pinjam' => 'required|date',
        ]);

        $kode = 'PMJ-' . date('Ymd') . strtoupper(\Illuminate\Support\Str::random(4));

        Peminjaman::create([
            'user_id' => $request->user_id,
            'buku_id' => $request->buku_id,
            'kode_peminjaman' => $kode,
            'tgl_pinjam' => $request->tgl_pinjam,
            'status' => 'dipinjam',
            'denda' => 0
        ]);

        // Kurangi stok buku
        $buku = Buku::find($request->buku_id);
        if ($buku) {
            $buku->decrement('stok');
        }

        return redirect()->route('petugas.peminjaman')->with('success', 'Data peminjaman berhasil disimpan!');
    }

    // Menampilkan buku yang SUDAH dikembalikan
    public function riwayatPengembalian(Request $request)
    {
        $search = $request->input('search');

        $pengembalian = Peminjaman::with(['user', 'buku'])
                        ->where('status', 'dikembalikan')
                        ->when($search, function ($query, $search) {
                            return $query->whereHas('user', function($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            })->orWhereHas('buku', function($q) use ($search) {
                                $q->where('judul', 'like', "%{$search}%");
                            });
                        })
                        ->latest()
                        ->paginate(10); // GANTI KE PAGINATE AGAR TIDAK ERROR firstItem

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
        
        // Kembalikan stok jika dihapus saat masih dipinjam
        if ($peminjaman->status == 'dipinjam') {
            $buku = Buku::find($peminjaman->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }
        }

        $peminjaman->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function daftarDenda(Request $request)
    {
        $search = $request->input('search');

        // Mengambil data peminjaman yang memiliki denda (lebih dari 0)
        $denda = Peminjaman::with(['user', 'buku'])
                    ->where('denda', '>', 0)
                    ->when($search, function ($query, $search) {
                        return $query->whereHas('user', function($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })->orWhereHas('buku', function($q) use ($search) {
                            $q->where('judul', 'like', "%{$search}%");
                        });
                    })
                    ->latest()
                    ->paginate(10); // GANTI KE PAGINATE

        return view('page.backend.petugas.peminjaman.denda', compact('denda'));
    }

    // --- TAMBAHAN BARU: FUNGSI UNTUK MENAMPILKAN HALAMAN CREATE PENGEMBALIAN ---
    public function createPengembalian()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])
                        ->where('status', 'dipinjam')
                        ->get();

        return view('page.backend.petugas.peminjaman.create_pengembalian', compact('peminjaman'));
    }

    // --- TAMBAHAN BARU: FUNGSI UNTUK MENAMPILKAN HALAMAN CREATE DENDA ---
    public function createDenda()
    {
        // Mengambil data peminjaman yang statusnya masih 'dipinjam' untuk diproses dendanya
        $peminjaman = Peminjaman::with(['user', 'buku'])
                        ->where('status', 'dipinjam')
                        ->get();

        return view('page.backend.petugas.peminjaman.create_denda', compact('peminjaman'));
    }

    // --- TAMBAHAN BARU: EDIT PENGEMBALIAN ---
    public function editPengembalian($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);
        return view('page.backend.petugas.peminjaman.edit_pengembalian', compact('peminjaman'));
    }

    // --- PERBAIKAN: FUNGSI UPDATE PENGEMBALIAN (OTOMATIS SELESAI & STOK KEMBALI) ---
    public function updatePengembalian(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $request->validate([
            'tgl_kembali' => 'required|date',
            'denda' => 'required|numeric',
        ]);

        // Tambahkan stok kembali hanya jika status sebelumnya masih 'dipinjam'
        if ($peminjaman->status == 'dipinjam') {
            $buku = Buku::find($peminjaman->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }
        }

        $peminjaman->update([
            'tgl_kembali' => $request->tgl_kembali,
            'denda' => $request->denda,
            'status' => 'dikembalikan' // Pastikan status berubah
        ]);

        return redirect()->route('petugas.pengembalian')->with('success', 'Data pengembalian berhasil diperbarui!');
    }

    // --- TAMBAHAN BARU: EDIT DATA PEMINJAMAN (YANG MASIH DIPINJAM) ---
    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $users = User::where('role', 'anggota')->get();
        $buku = Buku::all();

        return view('page.backend.petugas.peminjaman.edit', compact('peminjaman', 'users', 'buku'));
    }

    // --- TAMBAHAN BARU: UPDATE DATA PEMINJAMAN (YANG MASIH DIPINJAM) ---
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $request->validate([
            'user_id' => 'required',
            'buku_id' => 'required',
            'tgl_pinjam' => 'required|date',
        ]);

        // Cek jika buku diganti, maka stok buku lama dikembalikan, stok buku baru dikurangi
        if ($peminjaman->buku_id != $request->buku_id) {
            // Balikin stok buku lama
            $bukuLama = Buku::find($peminjaman->buku_id);
            if ($bukuLama) $bukuLama->increment('stok');
            
            // Kurangi stok buku baru
            $bukuBaru = Buku::find($request->buku_id);
            if ($bukuBaru) $bukuBaru->decrement('stok');
        }

        $peminjaman->update([
            'user_id' => $request->user_id,
            'buku_id' => $request->buku_id,
            'tgl_pinjam' => $request->tgl_pinjam,
        ]);

        return redirect()->route('petugas.peminjaman')->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    // --- TAMBAHAN BARU: PROSES PENGEMBALIAN BUKU (DARI HALAMAN INDEX PEMINJAMAN) ---
    public function kembalikanBuku(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Update data peminjaman jadi dikembalikan
        $peminjaman->update([
            'tgl_kembali' => now(),
            'status' => 'dikembalikan',
            'denda' => $request->denda ?? 0
        ]);

        // Tambahkan kembali stok buku
        $buku = Buku::find($peminjaman->buku_id);
        if ($buku) {
            $buku->increment('stok');
        }

        return redirect()->route('petugas.pengembalian')->with('success', 'Buku telah berhasil dikembalikan!');
    }

    /**
     * --- TAMBAHAN BARU: FUNGSI STORE KHUSUS PENGEMBALIAN ---
     * Fungsi ini menangani input dari form create_pengembalian.blade.php
     */
    public function storePengembalian(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tgl_kembali' => 'required|date',
            'denda' => 'required|numeric',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        // Pastikan stok hanya bertambah jika sebelumnya statusnya dipinjam
        if ($peminjaman->status == 'dipinjam') {
            $buku = Buku::find($peminjaman->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }
        }

        $peminjaman->update([
            'tgl_kembali' => $request->tgl_kembali,
            'denda' => $request->denda,
            'status' => 'dikembalikan'
        ]);

        return redirect()->route('petugas.pengembalian')->with('success', 'Data pengembalian berhasil diproses!');
    }
}