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
        Schema::create('tiket_parkirs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket')->unique();
            $table->string('plat_nomor');
            $table->enum('kategori', ['motor', 'mobil']);
            $table->timestamp('waktu_masuk');
            $table->enum('status', ['masuk', 'keluar'])->default('masuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_parkirs');
    }
};
