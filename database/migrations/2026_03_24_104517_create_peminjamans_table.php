<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('peminjamans', function (Blueprint $table) {
        $table->id();
        $table->string('id_peminjaman')->unique();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
        $table->date('tgl_pinjam');
        $table->date('tgl_kembali')->nullable();
        $table->string('status')->default('dipinjam'); // dipinjam, dikembalikan
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
