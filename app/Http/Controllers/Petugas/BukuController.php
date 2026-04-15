<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman; // Tambahan namespace untuk model Peminjaman
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    // Update fungsi Index agar support Search dan Pagination
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Menggunakan paginate agar support ->links() di Blade petugas
        $buku = Buku::when($search, function ($query, $search) {
                        return $query->where('judul', 'like', "%{$search}%")
                                     ->orWhere('pengarang', 'like', "%{$search}%");
                    })
                    ->latest()
                    ->paginate(10); // Menampilkan 10 data per halaman

        return view('page.backend.petugas.buku', compact('buku'));
    }

    public function create()
    {
        return view('page.backend.petugas.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi - Ditambahkan UNIQUE pada judul agar tidak ada buku kembar
        $request->validate([
            'judul'        => 'required|unique:bukus,judul', // Judul tidak boleh sama dengan yang sudah ada
            'penulis'      => 'required',
            'penerbit'     => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok'         => 'required|numeric',
            'cover'        => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'    => 'nullable'
        ], [
            // Pesan error custom jika judul duplikat
            'judul.unique' => 'Judul buku ini sudah ada! Silakan update stok di menu edit jika ingin menambah jumlah buku yang sama.',
        ]);

        // 2. Olah data manual agar masuk ke kolom database yang benar
        $data = [
            'judul'      => $request->judul,
            'pengarang'  => $request->penulis,      // Memasukkan input 'penulis' ke kolom 'pengarang'
            'penerbit'   => $request->penerbit,
            'thn_terbit' => $request->tahun_terbit, // Memasukkan input 'tahun_terbit' ke kolom 'thn_terbit'
            'stok'       => $request->stok,
            'deskripsi'  => $request->deskripsi,
        ];

        // 3. Proses Upload Cover
        if ($request->hasFile('cover')) {
            // Menyimpan di folder 'public/buku'
            $path = $request->file('cover')->store('buku', 'public');
            $data['cover'] = $path; // Hasilnya: buku/nama_file.jpg (Sesuai kebutuhan database kamu)
        }

        // 4. Simpan ke Database
        Buku::create($data);

        return redirect()->route('petugas.buku')->with('success', 'Buku berhasil ditambahkan!');
    }

    // TAMBAHAN: Fungsi untuk menampilkan detail buku petugas
    public function show($id)
    {
        // Mengambil data buku berdasarkan ID
        $buku = Buku::findOrFail($id);
        
        // Mengarahkan ke file blade detail yang sudah dibuat
        return view('page.backend.petugas.detail', compact('buku'));
    }

    // --- LANGKAH 2: FUNGSI EDIT & UPDATE ---

    public function edit($id)
    {
        // Mengambil data buku yang mau diubah
        $buku = Buku::findOrFail($id);
        
        // Menuju ke file edit.blade.php petugas
        return view('page.backend.petugas.edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        // 1. Validasi input - Gunakan unique kecuali untuk ID buku ini sendiri saat update
        $request->validate([
            'judul'        => 'required|unique:bukus,judul,' . $id,
            'penulis'      => 'required',
            'penerbit'     => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok'         => 'required|numeric|min:0',
            'cover'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'    => 'nullable'
        ]);

        // 2. Siapkan data untuk update (Mapping input ke kolom DB)
        $data = [
            'judul'      => $request->judul,
            'pengarang'  => $request->penulis,      
            'penerbit'   => $request->penerbit,
            'thn_terbit' => $request->tahun_terbit, 
            'stok'       => $request->stok,
            'deskripsi'  => $request->deskripsi,
        ];

        // 3. Logika ganti Cover jika ada file baru
        if ($request->hasFile('cover')) {
            // Hapus file sampul lama dari storage jika ada
            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }
            
            // Simpan sampul baru
            $data['cover'] = $request->file('cover')->store('buku', 'public');
        }

        // 4. Update data di database
        $buku->update($data);

        return redirect()->route('petugas.buku')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        // CEK STATUS: Kita cek apakah buku ini masih berstatus 'Dipinjam'
        // Ini lebih akurat untuk memastikan riwayat tidak rusak
        $sedangDipinjam = Peminjaman::where('buku_id', $id)
                            ->where('status', 'Dipinjam') 
                            ->exists();

        if ($sedangDipinjam) {
            return redirect()->route('petugas.buku')->with('error', 'Gagal menghapus! Buku ini masih dalam status dipinjam oleh anggota.');
        }
        
        // Catatan: Storage::delete tidak dijalankan agar cover tetap tampil di riwayat lama
        // Jika kamu ingin tetap hapus file fisiknya, hapus tanda komentar di bawah ini:
        // if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
        //     Storage::disk('public')->delete($buku->cover);
        // }

        // Menjalankan Soft Delete
        $buku->delete();

        return redirect()->route('petugas.buku')->with('success', 'Buku berhasil dihapus!');
    }
}