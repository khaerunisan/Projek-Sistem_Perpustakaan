<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    public function create()
    {
        // PERBAIKAN: Sesuaikan dengan lokasi folder kamu
        return view('page.backend.auth.register');
    }

    public function store(Request $request)
    {
        // TAMBAHAN: Paksa email jadi huruf kecil agar tidak error 'lowercase'
        $request->merge(['email' => strtolower($request->email)]);

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'prodi'    => ['required', 'string', 'max:255'],
            'alamat'   => ['required', 'string'],
            'phone'    => ['required', 'string', 'max:20'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            // TAMBAHAN: 'confirmed' wajib agar input password_confirmation dicek
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'prodi'    => $request->prodi,
            'alamat'   => $request->alamat,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'anggota',
        ]);

        event(new Registered($user));
        Auth::login($user);

        // TIPS: Sesuaikan redirect ke '/' agar masuk ke dashboard utama
        return redirect('/');
    }
}