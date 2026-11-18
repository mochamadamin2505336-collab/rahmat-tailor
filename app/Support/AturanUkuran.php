<?php

namespace App\Support;

use App\Models\Ukuran;

/**
 * Daftar kolom ukuran per kategori busana, disesuaikan dengan form pemesanan
 * (resources/views/pemesanan.blade.php). Rentang angka dalam sentimeter:
 * celana mengikuti atribut min/max di form, sisanya batas wajar sementara
 * yang perlu dikonfirmasi pemilik.
 */
final class AturanUkuran
{
    public const KATEGORI = ['celana', 'baju', 'rok', 'seragam', 'kebaya'];

    /** @var array<string, array{0: int, 1: int}> */
    private const CELANA = [
        'lingkar_pinggang_celana' => [50, 160],
        'lingkar_panggul_celana' => [60, 170],
        'lingkar_pesak' => [40, 90],
        'lingkar_paha' => [30, 90],
        'lingkar_lutut' => [25, 70],
        'lingkar_celana_bawah' => [20, 60],
        'panjang_celana' => [60, 140],
    ];

    /** @var array<string, array{0: int, 1: int}> */
    private const BAJU = [
        'lebar_punggung' => [20, 80],
        'lebar_bahu' => [25, 80],
        'panjang_lengan' => [30, 100],
        'lingkar_lengan_atas' => [15, 70],
        'lingkar_lengan_bawah' => [10, 40],
        'lingkar_dada' => [60, 180],
        'lingkar_pinggang_baju' => [50, 170],
        'lingkar_panggul_baju' => [60, 180],
        'panjang_baju' => [40, 180],
    ];

    /** @var array<string, array{0: int, 1: int}> */
    private const ROK = [
        'lingkar_pinggang_rok' => [50, 160],
        'lingkar_panggul_rok' => [60, 170],
        'panjang_rok' => [30, 140],
    ];

    /**
     * Kolom beserta batas minimum dan maksimum untuk satu kategori.
     * Kebaya/gamis memakai panel ukuran baju, seragam memakai celana + baju.
     *
     * @return array<string, array{0: int, 1: int}>
     */
    public static function batas(string $kategori): array
    {
        return match ($kategori) {
            'celana' => self::CELANA,
            'baju', 'kebaya' => self::BAJU,
            'rok' => self::ROK,
            'seragam' => self::CELANA + self::BAJU,
            default => [],
        };
    }

    /**
     * @return array<int, string>
     */
    public static function semuaKolom(): array
    {
        return array_keys(self::CELANA + self::BAJU + self::ROK);
    }

    /**
     * Aturan validasi untuk input bersarang "ukuran.nama_kolom".
     *
     * @return array<string, array<int, string>>
     */
    public static function aturan(string $kategori): array
    {
        $aturan = ['ukuran' => ['required', 'array']];

        foreach (self::batas($kategori) as $kolom => [$min, $maks]) {
            $aturan["ukuran.$kolom"] = ['required', 'numeric', "min:$min", "max:$maks"];
        }

        return $aturan;
    }

    /**
     * Nama tampilan kolom untuk pesan galat.
     *
     * @return array<string, string>
     */
    public static function namaAtribut(): array
    {
        $nama = ['ukuran' => 'Ukuran'];

        foreach (self::semuaKolom() as $kolom) {
            $nama["ukuran.$kolom"] = ucfirst(str_replace('_', ' ', $kolom));
        }

        return $nama;
    }

    /**
     * Susun data siap simpan: semua kolom ada, yang tidak dipakai kategori bernilai null.
     *
     * @param  array<string, mixed>  $nilai
     * @return array<string, mixed>
     */
    public static function siapkan(string $kategori, array $nilai): array
    {
        $hasil = ['kategori' => $kategori] + array_fill_keys(self::semuaKolom(), null);

        foreach (array_keys(self::batas($kategori)) as $kolom) {
            $hasil[$kolom] = isset($nilai[$kolom]) ? (float) $nilai[$kolom] : null;
        }

        return $hasil;
    }

    /**
     * Salin ukuran lama untuk dipakai pada pesanan baru (PB-14).
     *
     * @return array<string, mixed>
     */
    public static function dariModel(Ukuran $ukuran): array
    {
        return self::siapkan($ukuran->kategori, $ukuran->only(self::semuaKolom()));
    }
}
