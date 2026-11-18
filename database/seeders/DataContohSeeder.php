<?php

namespace Database\Seeders;

use App\Enums\PeranPengguna;
use App\Enums\StatusJadwal;
use App\Enums\StatusPesanan;
use App\Enums\SumberPesanan;
use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\User;
use App\Support\AturanUkuran;
use App\Support\PesananService;
use Illuminate\Database\Seeder;

/**
 * Data CONTOH untuk pengembangan lokal. Semua nama dan nomor di bawah fiktif
 * dan jangan dipakai sebagai testimoni atau bukti sosial. Testimoni sengaja
 * tidak diisi: hanya pelanggan nyata yang boleh menulisnya.
 */
class DataContohSeeder extends Seeder
{
    public function run(): void
    {
        if (Pesanan::query()->exists()) {
            return;
        }

        $servis = new PesananService();
        $admin = User::query()->where('peran', PeranPengguna::Admin->value)->first();

        $baju = AturanUkuran::siapkan('baju', [
            'lebar_punggung' => 44, 'lebar_bahu' => 46, 'panjang_lengan' => 61,
            'lingkar_lengan_atas' => 36, 'lingkar_lengan_bawah' => 24, 'lingkar_dada' => 104,
            'lingkar_pinggang_baju' => 90, 'lingkar_panggul_baju' => 102, 'panjang_baju' => 74,
        ]);

        $celana = AturanUkuran::siapkan('celana', [
            'lingkar_pinggang_celana' => 84, 'lingkar_panggul_celana' => 98, 'lingkar_pesak' => 68,
            'lingkar_paha' => 58, 'lingkar_lutut' => 42, 'lingkar_celana_bawah' => 36, 'panjang_celana' => 98,
        ]);

        // Pelanggan online dengan akun (kata sandi lokal "password").
        $akun = User::query()->updateOrCreate(
            ['email' => 'pelanggan.contoh@example.test'],
            ['name' => 'Pelanggan Contoh Online', 'password' => 'password', 'peran' => PeranPengguna::Pelanggan],
        );
        $online = Pelanggan::query()->updateOrCreate(
            ['user_id' => $akun->id],
            ['nama' => 'Pelanggan Contoh Online', 'no_whatsapp' => '081200000001'],
        );
        $offlineA = Pelanggan::query()->create(['nama' => 'Pelanggan Contoh A', 'no_whatsapp' => '081200000002']);
        $offlineB = Pelanggan::query()->create(['nama' => 'Pelanggan Contoh B', 'no_whatsapp' => '081200000003']);

        $jas = Layanan::query()->where('nama', 'Jas Formal')->firstOrFail();
        $batik = Layanan::query()->where('nama', 'Kemeja Batik')->firstOrFail();
        $celanaFormal = Layanan::query()->where('nama', 'Celana Formal')->firstOrFail();

        // 1. Online, masih menunggu verifikasi ukuran (PB-20).
        $servis->buat($online, SumberPesanan::Online, [
            'layanan_id' => $batik->id, 'bahan' => 'sendiri', 'catatan' => 'Contoh pesanan online.',
        ], $baju, null, $akun);

        // 2. Offline, sedang dijahit, uang muka sudah dibayar.
        $dijahit = $servis->buat($offlineA, SumberPesanan::Offline, [
            'layanan_id' => $jas->id, 'bahan' => 'toko', 'harga' => 4500000, 'deadline' => today()->addDays(7)->toDateString(),
        ], $baju, null, $admin);
        $this->majukan($dijahit, StatusPesanan::Dijahit, $servis, $admin);
        $dijahit->pembayaran()->create([
            'jenis' => 'dp', 'metode' => 'transfer', 'jumlah' => 2250000, 'tanggal' => today()->subDays(3)->toDateString(),
        ]);

        // 3. Offline, siap diambil dan sudah lunas.
        $lunas = $servis->buat($offlineB, SumberPesanan::Offline, [
            'layanan_id' => $celanaFormal->id, 'bahan' => 'sendiri', 'harga' => 800000, 'deadline' => today()->addDays(1)->toDateString(),
        ], $celana, null, $admin);
        $this->majukan($lunas, StatusPesanan::SiapDiambil, $servis, $admin);
        $lunas->pembayaran()->create([
            'jenis' => 'dp', 'metode' => 'cash', 'jumlah' => 400000, 'tanggal' => today()->subDays(6)->toDateString(),
        ]);
        $lunas->pembayaran()->create([
            'jenis' => 'pelunasan', 'metode' => 'cash', 'jumlah' => 400000, 'tanggal' => today()->toDateString(),
        ]);

        // Dua jadwal ukur untuk tab Jadwal.
        $offlineA->jadwal()->create([
            'jenis' => 'fitting', 'jenis_jahitan' => 'Jas Formal', 'bahan' => 'toko',
            'waktu' => today()->addDays(2)->setTime(10, 0), 'status' => StatusJadwal::Dikonfirmasi,
        ]);
        $offlineB->jadwal()->create([
            'jenis' => 'ukur', 'jenis_jahitan' => 'Celana Formal', 'bahan' => 'sendiri',
            'waktu' => today()->addDays(3)->setTime(14, 30),
        ]);
    }

    /**
     * Naikkan status satu per satu sampai target supaya status_log lengkap.
     */
    private function majukan(Pesanan $pesanan, StatusPesanan $target, PesananService $servis, ?User $oleh): void
    {
        while ($pesanan->status !== $target) {
            $berikutnya = $pesanan->status->berikutnya();

            if ($berikutnya === null) {
                return;
            }

            $pesanan->update(['status' => $berikutnya]);
            $servis->catatStatus($pesanan, $berikutnya, $oleh);
        }
    }
}
