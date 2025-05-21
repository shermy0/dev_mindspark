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
        Schema::table('bukus', function (Blueprint $table) {
            // Cek dulu apakah kolom 'CoverBuku' belum ada supaya gak error
            if (!Schema::hasColumn('bukus', 'CoverBuku')) {
                $table->string('CoverBuku')->after('id');
            }
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            // Hapus kolom 'CoverBuku' kalau ada
            if (Schema::hasColumn('bukus', 'CoverBuku')) {
                $table->dropColumn('CoverBuku');
            }
        });
    }
};
