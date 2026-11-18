<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PembayaranController extends Controller
{
    /**
     * PB-13: catat uang muka atau pelunasan. Pembayaran online di luar cakupan,
     * jadi metode hanya mencatat cara bayar yang diterima admin.
     */
    public function store(Request $request, Pesanan $pesanan): JsonResponse
    {
        if ($pesanan->harga === null) {
            return response()->json(['pesan' => 'Tetapkan harga pesanan sebelum mencatat pembayaran.'], 422);
        }

        $data = $this->validasi($request, [
            'jenis' => ['required', Rule::in(['dp', 'pelunasan'])],
            'metode' => ['required', Rule::in(['transfer', 'cash', 'qris'])],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal' => ['nullable', 'date', 'before_or_equal:today'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ], [
            'jenis' => 'Jenis pembayaran',
            'metode' => 'Metode pembayaran',
            'jumlah' => 'Jumlah',
            'tanggal' => 'Tanggal',
            'catatan' => 'Catatan',
        ]);

        $sisa = $pesanan->sisaTagihan();

        if ($data['jumlah'] > $sisa) {
            return response()->json([
                'pesan' => 'Jumlah melebihi sisa tagihan (Rp '.number_format($sisa, 0, ',', '.').').',
            ], 422);
        }

        $pesanan->pembayaran()->create([
            'jenis' => $data['jenis'],
            'metode' => $data['metode'],
            'jumlah' => $data['jumlah'],
            'tanggal' => $data['tanggal'] ?? today()->toDateString(),
            'catatan' => $data['catatan'] ?? null,
        ]);

        return response()->json([
            'pesan' => 'Pembayaran tercatat.',
            'total_dibayar' => $pesanan->totalDibayar(),
            'sisa_tagihan' => $pesanan->sisaTagihan(),
        ], 201);
    }

    /**
     * Data invoice untuk dicetak dari modal cetak di panel admin.
     */
    public function invoice(Pesanan $pesanan): JsonResponse
    {
        $pesanan->load(['pelanggan', 'layanan', 'pembayaran']);

        return response()->json([
            'kode' => $pesanan->kode_pesanan,
            'tanggal_cetak' => today()->toDateString(),
            'pelanggan' => $pesanan->pelanggan->nama,
            'layanan' => $pesanan->layanan->nama,
            'harga' => $pesanan->harga,
            'pembayaran' => $pesanan->pembayaran,
            'total_dibayar' => $pesanan->totalDibayar(),
            'sisa_tagihan' => $pesanan->sisaTagihan(),
        ]);
    }
}
