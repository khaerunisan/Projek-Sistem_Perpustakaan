<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kita tambahkan kolom sesuai input di desain Register kamu
            $table->string('prodi')->nullable()->after('role');
            $table->text('alamat')->nullable()->after('prodi');
            $table->string('phone')->nullable()->after('alamat');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Untuk membatalkan (rollback)
            $table->dropColumn(['prodi', 'alamat', 'phone']);
        });
    }
};