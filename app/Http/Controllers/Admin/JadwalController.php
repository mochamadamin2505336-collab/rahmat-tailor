<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusJadwal;
use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Support\NomorWhatsapp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JadwalController extends Controller
{
    /**
     * PB-11: jadwal berurut waktu. Setiap baris membawa tautan WhatsApp untuk
     * konfirmasi; admin menekan kirim sendiri (aturan bisnis 8).
     */
    public function index(Request $request): JsonResponse
    {
        $status = StatusJadwal::tryFrom((string) $request->query('status'));

        $daftar = Jadwal::query()
            ->with('pelanggan')
            ->when($status, fn ($query) => $query->where('status', $status->value))
            ->when($request->filled('dari'), fn ($query) => $query->whereDate('waktu', '>=', $request->query('dari')))
            ->orderBy('waktu')
            ->get()
            ->map(fn (Jadwal $jadwal): array => [
                'id' => $jadwal->id,
                'waktu' => $jadwal->waktu->toIso8601String(),
                'jenis' => $jadwal->jenis,
                'jenis_jahitan' => $jadwal->jenis_jahitan,
                'bahan' => $jadwal->bahan,
                'catatan' => $jadwal->catatan,
                'status' => $jadwal->status->value,
                'pelanggan' => [
                    'id' => $jadwal->pelanggan->id,
                    'nama' => $jadwal->pelanggan->nama,
                    'no_whatsapp' => $jadwal->pelanggan->no_whatsapp,
                ],
                'tautan_whatsapp' => NomorWhatsapp::tautan(
                    $jadwal->pelanggan->no_whatsapp,
                    sprintf(
                        'Halo %s, jadwal %s di Rahmat Tailor pada %s kami konfirmasi.',
                        $jadwal->pelanggan->nama,
                        $jadwal->jenis,
                        $jadwal->waktu->format('d/m/Y H:i'),
                    ),
                ),
            ]);

        return response()->json($daftar);
    }

    public function update(Request $request, Jadwal $jadwal): JsonResponse
    {
        $data = $this->validasi($request, [
            'status' => ['required', Rule::in(array_column(StatusJadwal::cases(), 'value'))],
        ], ['status' => 'Status jadwal']);

        $jadwal->update($data);

        return response()->json(['pesan' => 'Status jadwal diperbarui.', 'status' => $jadwal->status->value]);
    }
}
