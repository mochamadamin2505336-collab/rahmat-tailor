<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom ukuran mengikuti form pemesanan: celana, baju (juga dipakai kebaya/gamis),
     * dan rok. Seragam memakai kolom celana + baju. Semua dalam sentimeter dan boleh
     * kosong karena tiap kategori hanya mengisi sebagian kolom.
     * Satu pesanan punya nol atau satu ukuran (PRD bagian 10), maka pesanan_id unik.
     */
    private const KOLOM = [
        'lingkar_pinggang_celana', 'lingkar_panggul_celana', 'lingkar_pesak', 'lingkar_paha',
        'lingkar_lutut', 'lingkar_celana_bawah', 'panjang_celana',
        'lebar_punggung', 'lebar_bahu', 'panjang_lengan', 'lingkar_lengan_atas',
        'lingkar_lengan_bawah', 'lingkar_dada', 'lingkar_pinggang_baju',
        'lingkar_panggul_baju', 'panjang_baju',
        'lingkar_pinggang_rok', 'lingkar_panggul_rok', 'panjang_rok',
    ];

    public function up(): void
    {
        Schema::create('ukuran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->cascadeOnDelete();
            $table->foreignId('pesanan_id')->nullable()->unique()->constrained('pesanan')->cascadeOnDelete();
            $table->string('kategori', 10);

            foreach (self::KOLOM as $kolom) {
                $table->decimal($kolom, 5, 1)->nullable();
            }

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ukuran');
    }
};
