<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();
        
        // Menambahkan logika agar nomor telpon muncul jika di database masih kosong
        // Diperbaiki: Mengambil data dari kolom 'phone' agar sama dengan data anggota
        if (!$user->telp) {
            $user->telp = $user->phone ?? '0812-3456-7890';
        }

        // Menambahkan logika agar alamat muncul jika di database masih kosong
        if (!$user->alamat) {
            $user->alamat = 'Alamat belum dilengkapi';
        }

        // Mengarahkan ke file blade profile
        return view('page.backend.profile.index', compact('user'));
    }
}