<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::latest()->get();
        return view('page.backend.petugas.buku', compact('buku'));
    }

    public function create()
    {
        return view('page.backend.petugas.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi (Nama field disesuaikan dengan atribut 'name' di Form HTML kamu)
        $request->validate([
            'judul'        => 'required',
            'penulis'      => 'required',
            'penerbit'     => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok'         => 'required|numeric',
            'cover'        => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'    => 'nullable'
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

        // 1. Validasi input
        $request->validate([
            'judul'        => 'required',
            'penulis'      => 'required',
            'penerbit'     => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok'         => 'required|numeric',
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
        
        // Hapus file cover dari storage sebelum hapus data
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('petugas.buku')->with('success', 'Buku berhasil dihapus!');
    }
}