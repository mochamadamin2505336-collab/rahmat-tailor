<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Support\NomorWhatsapp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class PelacakanController extends Controller
{
    private const BATAS_GAGAL = 5;

    private const MASA_BLOKIR_DETIK = 900;

    /**
     * PB-09: pelacakan tanpa akun memakai kode pesanan dan empat digit akhir WhatsApp.
     * Selain throttle per IP di route, setiap kode dibatasi lima kali salah per
     * 15 menit supaya empat digit tidak bisa ditebak.
     */
    public function cari(Request $request): JsonResponse
    {
        $data = $this->validasi($request, [
            'kode' => ['required', 'string', 'size:8'],
            'empat_digit' => ['required', 'digits:4'],
        ], [
            'kode' => 'Kode pesanan',
            'empat_digit' => 'Empat digit akhir WhatsApp',
        ]);

        $kode = Str::upper($data['kode']);
        $kunci = 'lacak:'.$kode;

        if (RateLimiter::tooManyAttempts($kunci, self::BATAS_GAGAL)) {
            return response()->json([
                'pesan' => 'Terlalu banyak percobaan. Coba lagi dalam '.ceil(RateLimiter::availableIn($kunci) / 60).' menit.',
            ], 429);
        }

        $pesanan = Pesanan::query()
            ->with(['pelanggan', 'layanan', 'statusLog'])
            ->where('kode_pesanan', $kode)
            ->first();

        $cocok = $pesanan !== null
            && hash_equals(NomorWhatsapp::empatDigitAkhir($pesanan->pelanggan->no_whatsapp), $data['empat_digit']);

        if (! $cocok) {
            RateLimiter::hit($kunci, self::MASA_BLOKIR_DETIK);

            // Pesan sama untuk kode salah maupun digit salah, agar kode valid tidak bisa dipastikan.
            return response()->json(['pesan' => 'Kode pesanan atau empat digit WhatsApp tidak cocok.'], 404);
        }

        RateLimiter::clear($kunci);

        return response()->json([
            'kode' => $pesanan->kode_pesanan,
            'pemesan' => $pesanan->pelanggan->nama,
            'layanan' => $pesanan->layanan->nama,
            'status' => $pesanan->status->value,
            'status_label' => $pesanan->status->label(),
            'deadline' => $pesanan->deadline?->toDateString(),
            'langkah' => $pesanan->langkahStatus(),
        ]);
    }
}
