<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Kita cek satu-satu biar tidak error duplicate lagi
        if (!Schema::hasColumn('users', 'id_anggota')) {
            $table->string('id_anggota')->nullable()->after('id');
        }
        if (!Schema::hasColumn('users', 'telp')) {
            $table->string('telp')->nullable()->after('email');
        }
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['id_anggota', 'telp']);
    });
}
};
