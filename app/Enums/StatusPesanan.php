<?php

namespace App\Enums;

/**
 * Tahapan pesanan sesuai aturan bisnis PRD nomor 6 dan kebutuhan PB-20.
 * Nilai teks sengaja sama dengan atribut data-status di panel admin.
 */
enum StatusPesanan: string
{
    case Verifikasi = 'verifikasi';
    case Diterima = 'diterima';
    case Dipotong = 'dipotong';
    case Dijahit = 'dijahit';
    case Fitting = 'fitting';
    case Selesai = 'selesai';
    case SiapDiambil = 'siap-diambil';

    public function label(): string
    {
        return match ($this) {
            self::Verifikasi => 'Menunggu verifikasi ukuran',
            self::Diterima => 'Diterima',
            self::Dipotong => 'Dipotong',
            self::Dijahit => 'Dijahit',
            self::Fitting => 'Fitting',
            self::Selesai => 'Selesai',
            self::SiapDiambil => 'Siap diambil',
        };
    }

    /**
     * Status yang boleh dituju berikutnya, atau null bila sudah di ujung alur.
     */
    public function berikutnya(): ?self
    {
        $urutan = self::cases();
        $indeks = array_search($this, $urutan, true);

        return $urutan[$indeks + 1] ?? null;
    }
}
