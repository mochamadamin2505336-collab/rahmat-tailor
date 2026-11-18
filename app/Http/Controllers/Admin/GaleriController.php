<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * PB-10: admin mengelola foto galeri. Batas unggah memakai usulan awal PRD
 * pertanyaan terbuka nomor 6: JPG atau PNG, maksimal 5 MB.
 */
class GaleriController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Galeri::query()->latest()->get());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validasi($request, $this->aturan(fotoWajib: true), $this->nama());

        $galeri = Galeri::create([
            'judul' => $data['judul'],
            'kategori' => $data['kategori'],
            'layanan_id' => $data['layanan_id'] ?? null,
            'berkas_foto' => $request->file('foto')->store('galeri', 'public'),
        ]);

        return response()->json($galeri, 201);
    }

    public function update(Request $request, Galeri $galeri): JsonResponse
    {
        $data = $this->validasi($request, $this->aturan(fotoWajib: false), $this->nama());

        $galeri->fill([
            'judul' => $data['judul'],
            'kategori' => $data['kategori'],
            'layanan_id' => $data['layanan_id'] ?? null,
        ]);

        if ($request->hasFile('foto')) {
            Storage::disk('public')->delete($galeri->berkas_foto);
            $galeri->berkas_foto = $request->file('foto')->store('galeri', 'public');
        }

        $galeri->save();

        return response()->json($galeri);
    }

    public function destroy(Galeri $galeri): JsonResponse
    {
        Storage::disk('public')->delete($galeri->berkas_foto);
        $galeri->delete();

        return response()->json(['pesan' => 'Foto dihapus.']);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function aturan(bool $fotoWajib): array
    {
        return [
            'judul' => ['required', 'string', 'max:150'],
            'kategori' => ['required', 'string', 'max:60'],
            'layanan_id' => ['nullable', 'integer', 'exists:layanan,id'],
            'foto' => [$fotoWajib ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function nama(): array
    {
        return [
            'judul' => 'Judul',
            'kategori' => 'Kategori',
            'layanan_id' => 'Layanan',
            'foto' => 'Foto',
        ];
    }
}
