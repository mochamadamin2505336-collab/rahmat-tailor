<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * layanan_id opsional: menjawab pertanyaan terbuka PRD nomor 5 supaya tombol
     * "Pesan model ini" nanti bisa mengisi layanan otomatis.
     */
    public function up(): void
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 150);
            $table->string('kategori', 60)->index();
            $table->string('berkas_foto');
            $table->foreignId('layanan_id')->nullable()->constrained('layanan')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};
