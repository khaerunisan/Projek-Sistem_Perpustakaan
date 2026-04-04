<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Peminjaman; 

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',   // Sudah ada dari langkah sebelumnya
        'id_anggota', // Tambahkan ini agar ID Anggota bisa disimpan
        'prodi',  // Tambahkan ini
        'alamat', // Tambahkan ini
        'phone',  // Sudah ada
        'telp',   // Tambahkan ini agar No Telphon bisa disimpan
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: Satu User bisa memiliki banyak data Peminjaman
     */
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'user_id');
    }
}