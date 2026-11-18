<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Support\NomorWhatsapp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class JadwalController extends Controller
{
    /**
     * PB-11: booking jadwal ukur atau fitting tanpa login.
     * Nomor yang sudah ada dipakai ulang, data pelanggan lama tidak ditimpa.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $this->validasi($request, [
            'nama' => ['required', 'string', 'max:100'],
            'no_whatsapp' => NomorWhatsapp::aturan(),
            'jenis' => ['nullable', Rule::in(['ukur', 'fitting'])],
            'jenis_jahitan' => ['required', 'string', 'max:100'],
            'bahan' => ['nullable', Rule::in(['sendiri', 'toko'])],
            'tanggal' => ['required', 'date', 'after_or_equal:today'],
            'jam' => ['required', 'date_format:H:i'],
            'catatan' => ['nullable', 'string', 'max:500'],
            'foto_referensi' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ], [
            'nama' => 'Nama',
            'no_whatsapp' => 'Nomor WhatsApp',
            'jenis' => 'Jenis jadwal',
            'jenis_jahitan' => 'Jenis jahitan',
            'bahan' => 'Bahan kain',
            'tanggal' => 'Tanggal',
            'jam' => 'Jam',
            'catatan' => 'Catatan',
            'foto_referensi' => 'Foto referensi',
        ]);

        $pelanggan = Pelanggan::firstOrCreate(
            ['no_whatsapp' => NomorWhatsapp::normalisasi($data['no_whatsapp'])],
            ['nama' => $data['nama']],
        );

        $jadwal = $pelanggan->jadwal()->create([
            'jenis' => $data['jenis'] ?? 'ukur',
            'jenis_jahitan' => $data['jenis_jahitan'],
            'bahan' => $data['bahan'] ?? null,
            'waktu' => Carbon::parse($data['tanggal'])->setTimeFromTimeString($data['jam']),
            'catatan' => $data['catatan'] ?? null,
            'foto_referensi' => $request->file('foto_referensi')?->store('referensi', 'public'),
        ]);

        return response()->json([
            'pesan' => 'Jadwal tersimpan. Admin akan mengonfirmasi lewat WhatsApp.',
            'jadwal' => [
                'waktu' => $jadwal->waktu->toIso8601String(),
                'jenis' => $jadwal->jenis,
                'jenis_jahitan' => $jadwal->jenis_jahitan,
            ],
        ], 201);
    }
}
