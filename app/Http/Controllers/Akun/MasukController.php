<?php

namespace App\Http\Controllers\Akun;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MasukController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $this->validasi($request, [
            'email' => ['required', 'email'],
            'kata_sandi' => ['required', 'string'],
        ], [
            'email' => 'Email',
            'kata_sandi' => 'Kata sandi',
        ]);

        $berhasil = Auth::attempt(
            ['email' => $data['email'], 'password' => $data['kata_sandi']],
            $request->boolean('ingat_saya'),
        );

        if (! $berhasil) {
            throw ValidationException::withMessages(['email' => 'Email atau kata sandi salah.']);
        }

        $request->session()->regenerate();

        return response()->json(['pengguna' => self::ringkas($request->user())]);
    }

    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['pesan' => 'Anda sudah keluar.']);
    }

    /**
     * Pengguna yang sedang masuk, dipakai halaman untuk memutuskan menu yang tampil.
     */
    public function saya(Request $request): JsonResponse
    {
        return response()->json(['pengguna' => self::ringkas($request->user())]);
    }

    /**
     * @return array{id: int, nama: string, email: string, peran: string}
     */
    public static function ringkas(User $pengguna): array
    {
        return [
            'id' => $pengguna->id,
            'nama' => $pengguna->name,
            'email' => $pengguna->email,
            'peran' => $pengguna->peran->value,
        ];
    }
}
