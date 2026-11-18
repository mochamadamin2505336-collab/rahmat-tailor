<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->char('kode_pesanan', 8)->unique();
            $table->string('sumber', 10)->index();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->restrictOnDelete();
            $table->foreignId('layanan_id')->constrained('layanan')->restrictOnDelete();
            $table->string('bahan', 10);
            $table->text('catatan')->nullable();
            $table->string('foto_referensi')->nullable();
            $table->unsignedBigInteger('harga')->nullable();
            $table->date('target_tanggal')->nullable();
            $table->date('deadline')->nullable()->index();
            $table->string('status', 20)->default('diterima')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
