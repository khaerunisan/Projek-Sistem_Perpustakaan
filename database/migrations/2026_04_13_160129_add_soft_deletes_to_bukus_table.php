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
    Schema::table('bukus', function (Blueprint $table) {
        // Ini akan membuat kolom 'deleted_at' otomatis
        $table->softDeletes(); 
    });
}

public function down()
{
    Schema::table('bukus', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
}
};
