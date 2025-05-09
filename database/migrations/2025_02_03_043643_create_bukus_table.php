<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('NamaBuku');
            $table->string('deskripsi');
            $table->string('penerbit');
            $table->string('penulis');
            $table->timestamp('tanggal_terbit');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bukus');
    }
};
