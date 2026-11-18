<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    /**
     * PB-15: pelanggan online mengirim testimoni. Baru tampil di beranda
     * setelah admin mengubah kolom tampil.
     */
    public function store(Request $request): JsonResponse
    {
        $pelanggan = $request->user()->pelanggan;

        if ($pelanggan === null) {
            abort(403, 'Akun ini tidak memiliki profil pelanggan.');
        }

        $data = $this->validasi($request, [
            'isi' => ['required', 'string', 'min:10', 'max:500'],
            'bintang' => ['required', 'integer', 'between:1,5'],
        ], [
            'isi' => 'Isi testimoni',
            'bintang' => 'Bintang',
        ]);

        $pelanggan->testimoni()->create($data + ['tampil' => false]);

        return response()->json([
            'pesan' => 'Terima kasih. Testimoni Anda akan tampil setelah ditinjau admin.',
        ], 201);
    }
}
