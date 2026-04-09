<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // PERBAIKAN: Sesuaikan dengan lokasi folder kamu
        return view('page.backend.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // PERBAIKAN: Menggunakan route name 'dashboard' agar lebih aman dan langsung ke tujuan
            return redirect()->intended(route('dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // TAMBAHAN: Setelah logout, lebih bagus balik ke landing page ('/') 
        // daripada ke halaman login yang sepi.
        return redirect('/')->with('success', 'Berhasil keluar');
    }
}