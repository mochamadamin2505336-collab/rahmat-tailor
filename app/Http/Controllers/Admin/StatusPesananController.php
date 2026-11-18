<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusPesanan;
use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Support\NomorWhatsapp;
use App\Support\PesananService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatusPesananController extends Controller
{
    /**
     * PB-08: naikkan status satu langkah. Hanya admin yang boleh, urutan tidak
     * boleh dilompati (aturan bisnis 6), dan setiap perubahan masuk status_log.
     * Respons memuat tautan WhatsApp terisi untuk PB-12; admin menekan kirim sendiri.
     */
    public function update(Request $request, Pesanan $pesanan, PesananService $servis): JsonResponse
    {
        $berikutnya = $pesanan->status->berikutnya();

        if ($berikutnya === null) {
            return response()->json(['pesan' => 'Pesanan sudah berada di status akhir.'], 422);
        }

        $diminta = $request->input('status');

        if ($diminta !== null && $diminta !== $berikutnya->value) {
            return response()->json([
                'pesan' => 'Status harus berurutan. Status berikutnya: '.$berikutnya->label().'.',
            ], 422);
        }

        $kendala = [];

        if ($berikutnya === StatusPesanan::Diterima && ! $pesanan->ukuran()->exists()) {
            $kendala[] = 'Ukuran belum diisi atau diverifikasi.';
        }

        if (in_array($berikutnya, [StatusPesanan::Diterima, StatusPesanan::Dipotong], true)
            && ($pesanan->harga === null || $pesanan->deadline === null)) {
            $kendala[] = 'Harga dan deadline harus ditetapkan lebih dulu.';
        }

        if ($kendala !== []) {
            return response()->json(['pesan' => implode(' ', $kendala)], 422);
        }

        $pesanan->update(['status' => $berikutnya]);
        $servis->catatStatus($pesanan, $berikutnya, $request->user());

        return response()->json([
            'pesan' => 'Status diubah menjadi '.$berikutnya->label().'.',
            'status' => $berikutnya->value,
            'status_label' => $berikutnya->label(),
            'tautan_whatsapp' => $this->tautan($pesanan),
        ]);
    }

    /**
     * PB-12: tautan WhatsApp untuk status saat ini, tanpa mengubah apa pun.
     */
    public function tautanWhatsapp(Pesanan $pesanan): JsonResponse
    {
        return response()->json(['tautan_whatsapp' => $this->tautan($pesanan)]);
    }

    private function tautan(Pesanan $pesanan): string
    {
        $pesanan->loadMissing('pelanggan');

        $pesan = sprintf(
            'Halo %s, pesanan %s di Rahmat Tailor kini berstatus: %s.',
            $pesanan->pelanggan->nama,
            $pesanan->kode_pesanan,
            $pesanan->status->label(),
        );

        return NomorWhatsapp::tautan($pesanan->pelanggan->no_whatsapp, $pesan);
    }
}
