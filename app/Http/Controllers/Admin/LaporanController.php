<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SumberPesanan;
use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    private const NAMA_BULAN = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    /**
     * PB-16: jumlah pesanan dan pendapatan per bulan, bisa difilter menurut sumber.
     * Pendapatan dihitung dari pembayaran yang benar-benar diterima, per tanggal bayar.
     * Pengelompokan dilakukan di PHP agar sama di SQLite dan MySQL; skala satu toko
     * jahit masih jauh di bawah batas yang menyulitkan.
     */
    public function index(Request $request): JsonResponse
    {
        $tahun = (int) $request->query('tahun', now()->year);
        $sumber = SumberPesanan::tryFrom((string) $request->query('sumber'));

        $pesanan = Pesanan::query()
            ->with('layanan:id,kategori')
            ->whereYear('created_at', $tahun)
            ->when($sumber, fn ($query) => $query->where('sumber', $sumber->value))
            ->get();

        $pembayaran = Pembayaran::query()
            ->with('pesanan.layanan:id,kategori')
            ->whereYear('tanggal', $tahun)
            ->when($sumber, fn ($query) => $query->whereHas('pesanan', fn ($p) => $p->where('sumber', $sumber->value)))
            ->get();

        $pesananPerBulan = $pesanan->groupBy(fn (Pesanan $item): int => $item->created_at->month);
        $bayarPerBulan = $pembayaran->groupBy(fn (Pembayaran $item): int => $item->tanggal->month);

        $bulanan = [];

        foreach (self::NAMA_BULAN as $nomor => $nama) {
            $bulanan[] = [
                'bulan' => $nomor,
                'nama' => $nama,
                'jumlah_pesanan' => $pesananPerBulan->get($nomor)?->count() ?? 0,
                'pendapatan' => (int) ($bayarPerBulan->get($nomor)?->sum('jumlah') ?? 0),
            ];
        }

        $totalPendapatan = (int) $pembayaran->sum('jumlah');
        $dp = (int) $pembayaran->where('jenis', 'dp')->sum('jumlah');
        $pelunasan = (int) $pembayaran->where('jenis', 'pelunasan')->sum('jumlah');
        $piutang = (int) $pesanan->sum(fn (Pesanan $item): int => $item->sisaTagihan() ?? 0);

        $perKategori = $pesanan
            ->groupBy(fn (Pesanan $item): string => $item->layanan->kategori)
            ->map(function ($kelompok, string $kategori) use ($pembayaran, $totalPendapatan): array {
                $pendapatan = (int) $pembayaran
                    ->filter(fn (Pembayaran $item): bool => $item->pesanan->layanan->kategori === $kategori)
                    ->sum('jumlah');

                return [
                    'kategori' => $kategori,
                    'jumlah_pesanan' => $kelompok->count(),
                    'pendapatan' => $pendapatan,
                    'proporsi_persen' => $totalPendapatan > 0 ? round($pendapatan / $totalPendapatan * 100, 1) : 0,
                ];
            })
            ->values();

        return response()->json([
            'tahun' => $tahun,
            'sumber' => $sumber?->value,
            'total_pesanan' => $pesanan->count(),
            'total_pendapatan' => $totalPendapatan,
            'dp' => $dp,
            'pelunasan' => $pelunasan,
            'piutang' => $piutang,
            'bulanan' => $bulanan,
            'per_kategori' => $perKategori,
        ]);
    }
}
