<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Layanan;
use App\Models\Testimoni;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Data halaman publik tanpa login: layanan (PB-03), galeri (PB-02), testimoni (PB-15).
 */
class KatalogController extends Controller
{
    public function layanan(): JsonResponse
    {
        $daftar = Layanan::query()
            ->where('aktif', true)
            ->orderBy('urutan')
            ->orderBy('nama')
            ->get(['id', 'nama', 'kategori', 'deskripsi', 'harga_min', 'harga_max', 'estimasi_hari']);

        return response()->json($daftar);
    }

    public function galeri(Request $request): JsonResponse
    {
        $foto = Galeri::query()
            ->when($request->filled('kategori'), fn ($query) => $query->where('kategori', $request->query('kategori')))
            ->latest()
            ->get();

        return response()->json([
            'kategori' => Galeri::query()->distinct()->orderBy('kategori')->pluck('kategori'),
            'foto' => $foto,
        ]);
    }

    /**
     * Hanya nama, isi, dan bintang yang keluar. Nomor WhatsApp tidak ikut terkirim
     * (aturan bisnis 9).
     */
    public function testimoni(): JsonResponse
    {
        $daftar = Testimoni::query()
            ->with('pelanggan:id,nama')
            ->where('tampil', true)
            ->latest()
            ->get()
            ->map(fn (Testimoni $item): array => [
                'nama' => $item->pelanggan->nama,
                'bintang' => $item->bintang,
                'isi' => $item->isi,
            ]);

        return response()->json($daftar);
    }
}
