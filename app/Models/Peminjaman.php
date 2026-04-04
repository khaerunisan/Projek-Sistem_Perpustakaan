<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Tambahan eksplisit agar tidak error
use App\Models\Buku; // Tambahan eksplisit agar tidak error

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjamans';

    protected $fillable = [
        'id_peminjaman',
        'user_id',
        'buku_id',
        'tgl_pinjam',
        'tgl_kembali',
        'status',
        'denda' // <-- Tambahan agar data denda bisa masuk ke database
    ];

    /**
     * Otomatis mengubah string tanggal menjadi objek Carbon
     */
    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_kembali' => 'date',
    ];

    /**
     * Relasi ke model User (Siapa yang meminjam)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model Buku (Buku apa yang dipinjam)
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}