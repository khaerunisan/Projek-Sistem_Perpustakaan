<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\User; 
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // MENGAMBIL DATA KHUSUS ROLE PETUGAS
        $petugas = User::where('role', 'petugas')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        // Pastikan file view ini ada di: resources/views/page/backend/petugas/index.blade.php
        return view('page.backend.petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('page.backend.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone'    => 'nullable',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'petugas', 
            'phone'    => $request->phone,
        ]);

        return redirect()->route('petugas.petugas.index')->with('success', 'Petugas berhasil ditambahkan!');
    }

    public function show($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        return view('page.backend.petugas.show', compact('petugas'));
    }

    public function edit($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        return view('page.backend.petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $request->validate([
            'name'   => 'required',
            'email'  => 'required|email|unique:users,email,' . $id,
            'phone'  => 'nullable',
        ]);

        $data = [
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
        ];

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $petugas->update($data);

        return redirect()->route('petugas.petugas.index')->with('success', 'Data petugas diperbarui!');
    }

    public function destroy($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        $petugas->delete();

        return redirect()->route('petugas.petugas.index')->with('success', 'Petugas berhasil dihapus!');
    }
}