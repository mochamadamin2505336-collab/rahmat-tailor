<?php

namespace App\Http\Controllers;

use App\Enums\SumberPesanan;
use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Ukuran;
use App\Support\AturanUkuran;
use App\Support\PesananService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

/**
 * Jalur online untuk pelanggan yang sudah masuk (PB-04, PB-05, PB-06, PB-19).
 * Pelanggan hanya pernah menyentuh data miliknya sendiri (aturan bisnis 9).
 */
class PemesananController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $pesanan = $this->pelangganSaya($request)
            ->pesanan()
            ->with('layanan:id,nama')
            ->withSum('pembayaran as total_dibayar', 'jumlah')
            ->latest()
            ->get()
            ->map(fn (Pesanan $item): array => $item->ringkas());

        return response()->json($pesanan);
    }

    public function show(Request $request, string $kode): JsonResponse
    {
        $pesanan = $this->pelangganSaya($request)
            ->pesanan()
            ->with(['layanan', 'ukuran', 'statusLog'])
            ->where('kode_pesanan', $kode)
            ->firstOrFail();

        return response()->json($pesanan->ringkas() + [
            'bahan' => $pesanan->bahan,
            'catatan' => $pesanan->catatan,
            'ukuran' => $pesanan->ukuran,
            'langkah' => $pesanan->langkahStatus(),
        ]);
    }

    public function store(Request $request, PesananService $servis): JsonResponse
    {
        $pelanggan = $this->pelangganSaya($request);
        $diToko = $request->boolean('ukuran_di_toko');

        $aturan = [
            'layanan_id' => ['required', Rule::exists('layanan', 'id')->where('aktif', true)],
            'bahan' => ['required', Rule::in(['sendiri', 'toko'])],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'target_tanggal' => ['nullable', 'date', 'after_or_equal:today'],
            'foto_referensi' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'kategori_busana' => ['required', Rule::in(AturanUkuran::KATEGORI)],
            'ukuran_di_toko' => ['nullable', 'boolean'],
        ];

        // PB-05: ukuran boleh diganti jadwal ukur di toko.
        if ($diToko) {
            $aturan['jadwal_tanggal'] = ['required', 'date', 'after_or_equal:today'];
            $aturan['jadwal_jam'] = ['required', 'date_format:H:i'];
        } else {
            $aturan += AturanUkuran::aturan((string) $request->input('kategori_busana'));
        }

        $data = $this->validasi($request, $aturan, [
            'layanan_id' => 'Layanan',
            'bahan' => 'Bahan kain',
            'catatan' => 'Catatan',
            'target_tanggal' => 'Target tanggal',
            'foto_referensi' => 'Foto referensi',
            'kategori_busana' => 'Kategori busana',
            'jadwal_tanggal' => 'Tanggal jadwal ukur',
            'jadwal_jam' => 'Jam jadwal ukur',
        ] + AturanUkuran::namaAtribut());

        $jadwal = null;
        $ukuran = null;

        if ($diToko) {
            $jadwal = [
                'waktu' => Carbon::parse($data['jadwal_tanggal'])->setTimeFromTimeString($data['jadwal_jam']),
                'jenis_jahitan' => Layanan::findOrFail($data['layanan_id'])->nama,
            ];
        } else {
            $ukuran = AturanUkuran::siapkan($data['kategori_busana'], $data['ukuran']);
        }

        $pesanan = $servis->buat(
            $pelanggan,
            SumberPesanan::Online,
            $data,
            $ukuran,
            $request->file('foto_referensi'),
            $request->user(),
            $jadwal,
        );

        return response()->json([
            'pesan' => 'Pesanan diterima. Simpan kode pesanan Anda untuk memantau status.',
            'kode' => $pesanan->kode_pesanan,
            'status' => $pesanan->status->value,
            'status_label' => $pesanan->status->label(),
        ], 201);
    }

    /**
     * PB-19: riwayat ukuran milik pelanggan yang sedang masuk.
     */
    public function ukuranSaya(Request $request): JsonResponse
    {
        $daftar = Ukuran::query()
            ->where('pelanggan_id', $this->pelangganSaya($request)->id)
            ->latest()
            ->get();

        return response()->json($daftar);
    }

    private function pelangganSaya(Request $request): Pelanggan
    {
        $pelanggan = $request->user()->pelanggan;

        if ($pelanggan === null) {
            abort(403, 'Akun ini tidak memiliki profil pelanggan.');
        }

        return $pelanggan;
    }
}
