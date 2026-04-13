<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Tambahan untuk Soft Deletes

class Buku extends Model
{
    use HasFactory, SoftDeletes; // Tambahan SoftDeletes di sini

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'judul',
        'penerbit',
        'pengarang',
        'thn_terbit',
        'stok',
        'deskripsi',
        'cover'
    ];

    /**
     * Relasi: Satu Buku bisa dipinjam berkali-kali (memiliki banyak data peminjaman)
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }
    
}