<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            // cek apakah kolom kode_buku belum ada sebelum menambah
            if (!Schema::hasColumn('bukus', 'kode_buku')) {
                $table->string('kode_buku')->unique()->after('id');
            }
            if (!Schema::hasColumn('bukus', 'stok')) {
                $table->integer('stok')->default(0)->after('kode_buku');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            // Drop index dulu sebelum drop kolom
            if (Schema::hasColumn('bukus', 'kode_buku')) {
                $table->dropUnique(['kode_buku']);
                $table->dropColumn('kode_buku');
            }
            if (Schema::hasColumn('bukus', 'stok')) {
                $table->dropColumn('stok');
            }
        });
    }
};
