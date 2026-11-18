<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom status ditambahkan sesuai pertanyaan terbuka PRD nomor 4
     * (menunggu, dikonfirmasi, selesai, batal).
     */
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->cascadeOnDelete();
            $table->string('jenis', 10)->default('ukur');
            $table->string('jenis_jahitan', 100);
            $table->string('bahan', 10)->nullable();
            $table->dateTime('waktu')->index();
            $table->string('foto_referensi')->nullable();
            $table->text('catatan')->nullable();
            $table->string('status', 15)->default('menunggu')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
