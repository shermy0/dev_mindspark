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
        Schema::table('peminjaman_bukus', function (Blueprint $table) {
            $table->date('tanggal_kembali')->nullable();
            $table->integer('denda')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('peminjaman_bukus', function (Blueprint $table) {
            $table->dropColumn(['tanggal_kembali', 'denda']);
        });
    }
    
};
