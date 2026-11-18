<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Lima layanan dari kartu "Pilihan Layanan Jahit & Perkiraan Harga" di landing page.
     * Harga dan estimasi masih angka dari desain, bukan data pemilik: perbarui lewat
     * panel admin setelah wawancara (lihat TODO di KONTEKS-LANDING-PAGE.md).
     * Aman dijalankan berulang karena memakai updateOrCreate per nama.
     */
    public function run(): void
    {
        $daftar = [
            [
                'nama' => 'Jas Formal',
                'kategori' => 'Jas Formal',
                'deskripsi' => 'Jahit jas formal pria dengan ukuran presisi, jahitan rapi, dan desain sesuai keinginan. Bahan berkualitas, nyaman dipakai untuk acara penting.',
                'harga_min' => 3500000,
                'harga_max' => 7500000,
                'estimasi_hari' => 14,
            ],
            [
                'nama' => 'Kemeja Batik',
                'kategori' => 'Batik Tulis',
                'deskripsi' => 'Penyesuaian motif presisi simetris tanpa terpotong di dada dan saku, dilapisi furing sutra katun bernapas sejuk, kancing sembunyi rapi.',
                'harga_min' => 750000,
                'harga_max' => 1400000,
                'estimasi_hari' => 7,
            ],
            [
                'nama' => 'Kebaya Modern & Brokat',
                'kategori' => 'Kebaya Modern',
                'deskripsi' => 'Potongan pas di badan dengan payet jahit tangan yang rapi. Nyaman dipakai untuk acara wisuda, kondangan, maupun acara resmi lainnya.',
                'harga_min' => 1500000,
                'harga_max' => 3800000,
                'estimasi_hari' => 12,
            ],
            [
                'nama' => 'Celana Formal',
                'kategori' => 'Celana Formal',
                'deskripsi' => 'Potongan klasik atau modern slim, dilengkapi sabuk internal, side adjusters logam, furing lutut halus, dan lipatan setrika tahan lama.',
                'harga_min' => 600000,
                'harga_max' => 1200000,
                'estimasi_hari' => 5,
            ],
            [
                'nama' => 'Setelan Seragam PDH',
                'kategori' => 'Seragam',
                'deskripsi' => 'Bahan drill premium berstruktur kokoh, saku berpenutup berkancing rapi, standar pakaian dinas kementerian dan instansi negara.',
                'harga_min' => 1200000,
                'harga_max' => 2200000,
                'estimasi_hari' => 8,
            ],
        ];

        foreach ($daftar as $urutan => $layanan) {
            Layanan::updateOrCreate(
                ['nama' => $layanan['nama']],
                $layanan + ['aktif' => true, 'urutan' => $urutan + 1],
            );
        }
    }
}
