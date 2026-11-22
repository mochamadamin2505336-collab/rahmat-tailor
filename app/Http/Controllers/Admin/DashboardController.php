<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusJadwal;
use App\Enums\StatusPesanan;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\Testimoni;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Angka ringkas untuk kartu di tab dashboard (PB-07).
     */
    public function ringkasan(): JsonResponse
    {
        $perStatus = Pesanan::query()
            ->selectRaw('status, count(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        $pendapatanBulan = Pembayaran::query()
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->sum('jumlah');

        $statusAktif = collect(StatusPesanan::cases())
            ->reject(fn (StatusPesanan $status): bool => $status === StatusPesanan::SiapDiambil)
            ->map(fn (StatusPesanan $status): string => $status->value)
            ->all();

        $mendesak = Pesanan::query()
            ->with(['pelanggan', 'layanan:id,nama'])
            ->withSum('pembayaran as total_dibayar', 'jumlah')
            ->whereIn('status', $statusAktif)
            ->whereNotNull('deadline')
            ->orderBy('deadline')
            ->limit(5)
            ->get()
            ->map(fn (Pesanan $pesanan): array => $pesanan->ringkas());

        return response()->json([
            'total_pesanan' => (int) Pesanan::query()->count(),
            'pendapatan_bulan' => (int) $pendapatanBulan,
            'per_status' => collect(StatusPesanan::cases())->map(fn (StatusPesanan $status): array => [
                'status' => $status->value,
                'label' => $status->label(),
                'jumlah' => (int) $perStatus->get($status->value, 0),
            ]),
            'jadwal_hari_ini' => Jadwal::query()->whereDate('waktu', today())->where('status', '!=', StatusJadwal::Batal->value)->count(),
            'jadwal_menunggu_konfirmasi' => Jadwal::query()->where('status', StatusJadwal::Menunggu->value)->count(),
            'testimoni_menunggu' => Testimoni::query()->where('tampil', false)->count(),
            'pesanan_mendesak' => $mendesak,
        ]);
    }
}
