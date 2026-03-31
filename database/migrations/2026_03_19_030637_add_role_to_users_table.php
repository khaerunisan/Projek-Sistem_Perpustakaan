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
    Schema::table('users', function (Blueprint $table) {
        // Kita tambah kolom role setelah password
        // Defaultnya kita set 'anggota' supaya user baru otomatis jadi anggota
        $table->enum('role', ['petugas', 'kepala', 'anggota'])->default('anggota')->after('password');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}
};
