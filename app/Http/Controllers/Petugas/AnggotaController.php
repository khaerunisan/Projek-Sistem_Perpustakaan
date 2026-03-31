<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\User; // Mengasumsikan data anggota ada di tabel users dengan role anggota
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        // Mengambil user yang rolenya 'anggota'
        $anggota = User::where('role', 'anggota')->latest()->get();
        return view('page.backend.petugas.anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('page.backend.petugas.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'alamat'   => 'nullable',
            'telp'     => 'nullable',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'anggota',
            'alamat'   => $request->alamat,
            'telp'     => $request->telp,
        ]);

        return redirect()->route('petugas.anggota')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function show($id)
    {
        $anggota = User::findOrFail($id);
        return view('page.backend.petugas.anggota.show', compact('anggota'));
    }

    public function edit($id)
    {
        $anggota = User::findOrFail($id);
        return view('page.backend.petugas.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = User::findOrFail($id);

        $request->validate([
            'name'   => 'required',
            'email'  => 'required|email|unique:users,email,' . $id,
            'alamat' => 'nullable',
            'telp'   => 'nullable',
        ]);

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'alamat' => $request->alamat,
            'telp'   => $request->telp,
        ];

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $anggota->update($data);

        return redirect()->route('petugas.anggota')->with('success', 'Data anggota diperbarui!');
    }

    public function destroy($id)
    {
        $anggota = User::findOrFail($id);
        $anggota->delete();

        return redirect()->route('petugas.anggota')->with('success', 'Anggota berhasil dihapus!');
    }
}