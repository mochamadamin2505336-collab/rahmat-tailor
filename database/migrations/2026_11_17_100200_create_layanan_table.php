<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Harga disimpan sebagai rupiah bulat. Kolom aktif dan urutan ditambahkan
     * supaya admin bisa menyembunyikan layanan tanpa menghapusnya (PB-10).
     */
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('kategori', 60);
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('harga_min');
            $table->unsignedBigInteger('harga_max');
            $table->unsignedSmallInteger('estimasi_hari');
            $table->boolean('aktif')->default(true);
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
