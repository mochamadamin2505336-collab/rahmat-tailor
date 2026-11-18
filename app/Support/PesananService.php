<?php

namespace App\Support;

use App\Enums\SumberPesanan;
use App\Enums\StatusPesanan;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\StatusLog;
use App\Models\Ukuran;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

/**
 * Satu pintu pembuatan pesanan, dipakai jalur online (PB-04) dan offline (PB-18),
 * supaya kode, status awal, ukuran, dan log selalu dibuat dengan cara yang sama.
 */
final class PesananService
{
    private const ALFABET = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    /**
     * @param  array<string, mixed>  $data  layanan_id, bahan, catatan, target_tanggal, deadline, harga
     * @param  array<string, mixed>|null  $ukuran  hasil AturanUkuran::siapkan()
     * @param  array{waktu: \Illuminate\Support\Carbon, jenis_jahitan: string}|null  $jadwal
     */
    public function buat(
        Pelanggan $pelanggan,
        SumberPesanan $sumber,
        array $data,
        ?array $ukuran = null,
        ?UploadedFile $foto = null,
        ?User $oleh = null,
        ?array $jadwal = null,
    ): Pesanan {
        return DB::transaction(function () use ($pelanggan, $sumber, $data, $ukuran, $foto, $oleh, $jadwal): Pesanan {
            $status = $sumber === SumberPesanan::Online
                ? StatusPesanan::Verifikasi
                : StatusPesanan::Diterima;

            $pesanan = Pesanan::create([
                'kode_pesanan' => $this->kodeBaru(),
                'sumber' => $sumber,
                'pelanggan_id' => $pelanggan->id,
                'layanan_id' => $data['layanan_id'],
                'bahan' => $data['bahan'],
                'catatan' => $data['catatan'] ?? null,
                'foto_referensi' => $foto?->store('referensi', 'public'),
                'harga' => $data['harga'] ?? null,
                'target_tanggal' => $data['target_tanggal'] ?? null,
                'deadline' => $data['deadline'] ?? null,
                'status' => $status,
            ]);

            if ($ukuran !== null) {
                Ukuran::create($ukuran + [
                    'pelanggan_id' => $pelanggan->id,
                    'pesanan_id' => $pesanan->id,
                ]);
            }

            if ($jadwal !== null) {
                $pelanggan->jadwal()->create([
                    'jenis' => 'ukur',
                    'jenis_jahitan' => $jadwal['jenis_jahitan'],
                    'bahan' => $data['bahan'],
                    'waktu' => $jadwal['waktu'],
                    'catatan' => 'Jadwal ukur untuk pesanan '.$pesanan->kode_pesanan,
                ]);
            }

            $this->catatStatus($pesanan, $status, $oleh);

            return $pesanan;
        });
    }

    public function catatStatus(Pesanan $pesanan, StatusPesanan $status, ?User $oleh = null): StatusLog
    {
        return StatusLog::create([
            'pesanan_id' => $pesanan->id,
            'status' => $status,
            'user_id' => $oleh?->id,
            'waktu' => now(),
        ]);
    }

    /**
     * Kode acak 8 karakter (PB-06). Huruf yang mudah tertukar (I, O) dan angka 0, 1 dibuang.
     */
    private function kodeBaru(): string
    {
        do {
            $kode = '';

            for ($i = 0; $i < 8; $i++) {
                $kode .= self::ALFABET[random_int(0, strlen(self::ALFABET) - 1)];
            }
        } while (Pesanan::where('kode_pesanan', $kode)->exists());

        return $kode;
    }
}
