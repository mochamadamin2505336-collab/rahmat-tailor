<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Pencarian pelanggan lewat nama atau nomor WhatsApp, dipakai form pesanan offline
     * (PB-18) untuk menemukan pelanggan lama.
     */
    public function index(Request $request): JsonResponse
    {
        $cari = trim((string) $request->query('q'));
        $digit = preg_replace('/\D+/', '', $cari) ?? '';

        $daftar = Pelanggan::query()
            ->when($cari !== '', function (Builder $query) use ($cari, $digit): void {
                $query->where(function (Builder $kondisi) use ($cari, $digit): void {
                    $kondisi->where('nama', 'like', "%{$cari}%");

                    if ($digit !== '') {
                        $kondisi->orWhere('no_whatsapp', 'like', "%{$digit}%");
                    }
                });
            })
            ->orderBy('nama')
            ->paginate(20);

        return response()->json($daftar);
    }

    /**
     * PB-14: riwayat pesanan dan ukuran per pelanggan. id ukuran dari sini
     * dikirim sebagai salin_ukuran_id saat membuat pesanan baru.
     */
    public function show(Pelanggan $pelanggan): JsonResponse
    {
        $pelanggan->load(['ukuran' => fn ($query) => $query->latest()]);

        $pesanan = $pelanggan->pesanan()
            ->with('layanan:id,nama')
            ->withSum('pembayaran as total_dibayar', 'jumlah')
            ->latest()
            ->get()
            ->map(fn (Pesanan $item): array => $item->ringkas());

        return response()->json([
            'pelanggan' => $pelanggan->only(['id', 'nama', 'no_whatsapp', 'alamat']) + [
                'punya_akun' => $pelanggan->user_id !== null,
            ],
            'ukuran' => $pelanggan->ukuran,
            'pesanan' => $pesanan,
        ]);
    }
}
