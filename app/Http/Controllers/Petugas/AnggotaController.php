<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\User; 
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // PERBAIKAN: Mengambil data anggota (bukan petugas)
        // Set paginate(2) agar dengan 5 data, tombol navigasi halaman muncul
        $petugas = User::where('role', 'anggota')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(2); 

        // SESUAIKAN JALUR: Karena folder anggota ada di dalam folder petugas
        return view('page.backend.petugas.anggota.index', compact('petugas'));
    }

    public function create()
    {
        // Jalur ke folder petugas/anggota file create.blade.php
        return view('page.backend.petugas.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'alamat'   => 'nullable',
            'phone'    => 'nullable',
            'prodi'    => 'nullable', // Tambahkan validasi prodi
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'anggota', // Simpan sebagai anggota
            'alamat'   => $request->alamat,
            'phone'    => $request->phone,
            'prodi'    => $request->prodi, // Tambahkan penyimpanan prodi
        ]);

        return redirect()->route('petugas.anggota')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function show($id)
    {
        // Ambil data anggota berdasarkan ID
        $petugas = User::where('role', 'anggota')->findOrFail($id);
        
        // PERBAIKAN: Nama file di folder kamu adalah show.blade.php
        return view('page.backend.petugas.anggota.show', compact('petugas'));
    }

    public function edit($id)
    {
        $petugas = User::where('role', 'anggota')->findOrFail($id);
        // Jalur ke folder petugas/anggota file edit.blade.php
        return view('page.backend.petugas.anggota.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $petugas = User::where('role', 'anggota')->findOrFail($id);

        $request->validate([
            'name'   => 'required',
            'email'  => 'required|email|unique:users,email,' . $id,
            'alamat' => 'nullable',
            'phone'  => 'nullable',
            'prodi'  => 'nullable', // Tambahkan validasi prodi
        ]);

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'alamat' => $request->alamat,
            'phone'  => $request->phone,
            'prodi'  => $request->prodi, // Tambahkan update data prodi
        ];

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $petugas->update($data);

        return redirect()->route('petugas.anggota')->with('success', 'Data anggota diperbarui!');
    }

    public function destroy($id)
    {
        $petugas = User::where('role', 'anggota')->findOrFail($id);
        $petugas->delete();

        return redirect()->route('petugas.anggota')->with('success', 'Anggota berhasil dihapus!');
    }
}