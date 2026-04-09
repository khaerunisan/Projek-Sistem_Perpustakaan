<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();
        
        // Mengarahkan ke file blade profile
        return view('page.backend.profile.index', compact('user'));
    }
}