<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index(): JsonResponse
    {
        $daftar = Testimoni::query()
            ->with('pelanggan:id,nama')
            ->latest()
            ->get()
            ->map(fn (Testimoni $item): array => [
                'id' => $item->id,
                'nama' => $item->pelanggan->nama,
                'bintang' => $item->bintang,
                'isi' => $item->isi,
                'tampil' => $item->tampil,
                'dibuat' => $item->created_at?->toIso8601String(),
            ]);

        return response()->json($daftar);
    }

    /**
     * PB-15: admin menampilkan atau menyembunyikan testimoni di beranda.
     */
    public function update(Request $request, Testimoni $testimoni): JsonResponse
    {
        $data = $this->validasi($request, ['tampil' => ['required', 'boolean']], ['tampil' => 'Status tampil']);

        $testimoni->update($data);

        return response()->json(['pesan' => 'Testimoni diperbarui.', 'tampil' => $testimoni->tampil]);
    }

    public function destroy(Testimoni $testimoni): JsonResponse
    {
        $testimoni->delete();

        return response()->json(['pesan' => 'Testimoni dihapus.']);
    }
}
