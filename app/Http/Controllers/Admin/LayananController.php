<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * PB-10: admin mengelola layanan tanpa bantuan developer.
 */
class LayananController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Layanan::query()->orderBy('urutan')->orderBy('nama')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $layanan = Layanan::create($this->data($request));

        return response()->json($layanan, 201);
    }

    public function update(Request $request, Layanan $layanan): JsonResponse
    {
        $layanan->update($this->data($request));

        return response()->json($layanan);
    }

    /**
     * Layanan yang sudah dipakai pesanan tidak dihapus supaya riwayat tetap utuh;
     * cukup dinonaktifkan lewat kolom aktif.
     */
    public function destroy(Layanan $layanan): JsonResponse
    {
        if ($layanan->pesanan()->exists()) {
            return response()->json([
                'pesan' => 'Layanan ini sudah dipakai pesanan. Nonaktifkan saja agar riwayat tidak hilang.',
            ], 422);
        }

        $layanan->delete();

        return response()->json(['pesan' => 'Layanan dihapus.']);
    }

    /**
     * @return array<string, mixed>
     */
    private function data(Request $request): array
    {
        return $this->validasi($request, [
            'nama' => ['required', 'string', 'max:100'],
            'kategori' => ['required', 'string', 'max:60'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'harga_min' => ['required', 'integer', 'min:0'],
            'harga_max' => ['required', 'integer', 'gte:harga_min'],
            'estimasi_hari' => ['required', 'integer', 'between:1,365'],
            'aktif' => ['nullable', 'boolean'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ], [
            'nama' => 'Nama layanan',
            'kategori' => 'Kategori',
            'deskripsi' => 'Deskripsi',
            'harga_min' => 'Harga minimum',
            'harga_max' => 'Harga maksimum',
            'estimasi_hari' => 'Estimasi hari',
            'aktif' => 'Status aktif',
            'urutan' => 'Urutan',
        ]);
    }
}
