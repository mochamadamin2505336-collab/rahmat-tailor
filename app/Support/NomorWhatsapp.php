<?php

namespace App\Support;

use Closure;

/**
 * Menyeragamkan nomor WhatsApp ke format 62xxxxxxxxxx supaya aturan
 * "satu nomor, satu pelanggan" (PRD aturan bisnis 5) bisa ditegakkan.
 */
final class NomorWhatsapp
{
    public static function normalisasi(string $nomor): string
    {
        $digit = preg_replace('/\D+/', '', $nomor) ?? '';

        if (str_starts_with($digit, '0')) {
            return '62'.substr($digit, 1);
        }

        if (str_starts_with($digit, '8')) {
            return '62'.$digit;
        }

        return $digit;
    }

    public static function empatDigitAkhir(string $nomor): string
    {
        return substr(self::normalisasi($nomor), -4);
    }

    public static function valid(string $nomor): bool
    {
        return preg_match('/^628\d{8,11}$/', self::normalisasi($nomor)) === 1;
    }

    /**
     * Aturan validasi siap pakai untuk kolom nomor WhatsApp.
     *
     * @return array<int, string|Closure>
     */
    public static function aturan(): array
    {
        return [
            'required',
            'string',
            function (string $atribut, mixed $nilai, Closure $gagal): void {
                if (! self::valid((string) $nilai)) {
                    $gagal('Nomor WhatsApp tidak valid. Contoh: 0812 3456 7890.');
                }
            },
        ];
    }

    public static function tautan(string $nomor, string $pesan): string
    {
        return 'https://wa.me/'.self::normalisasi($nomor).'?text='.rawurlencode($pesan);
    }
}
