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

        // Mengambil data petugas
        $petugas = User::where('role', 'petugas')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        // --- PERHATIKAN BARIS INI ---
        // Ini adalah jalur yang benar kalau filamu ada di resources/views/page/backend/petugas/index.blade.php
        return view('page.backend.petugas.index', compact('petugas'));
    }

    public function create()
    {
        // Jalur ke folder petugas file create.blade.php
        return view('page.backend.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'alamat'   => 'nullable',
            'phone'    => 'nullable',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'petugas', 
            'alamat'   => $request->alamat,
            'phone'    => $request->phone,
        ]);

        // Sesuaikan dengan name route di web.php (petugas.anggota)
        return redirect()->route('kepala.petugas')->with('success', 'Petugas berhasil ditambahkan!');
    }

    public function show($id)
    {
        // 1. Ambil data petugas berdasarkan ID
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        
        // 2. PERBAIKAN: Memanggil file detail_index.blade.php sesuai namamu
        return view('page.backend.petugas.detail_index', compact('petugas'));
    }

    public function edit($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        // Jalur ke folder petugas file edit.blade.php
        return view('page.backend.petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $request->validate([
            'name'   => 'required',
            'email'  => 'required|email|unique:users,email,' . $id,
            'alamat' => 'nullable',
            'phone'  => 'nullable',
        ]);

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'alamat' => $request->alamat,
            'phone'  => $request->phone,
        ];

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $petugas->update($data);

        // Sesuaikan dengan name route di web.php
        return redirect()->route('kepala.petugas')->with('success', 'Data petugas diperbarui!');
    }

    public function destroy($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        $petugas->delete();

        // Sesuaikan dengan name route di web.php
        return redirect()->route('kepala.petugas')->with('success', 'Petugas berhasil dihapus!');
    }
}