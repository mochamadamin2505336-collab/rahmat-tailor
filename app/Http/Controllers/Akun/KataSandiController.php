<?php

namespace App\Http\Controllers\Akun;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class KataSandiController extends Controller
{
    /**
     * PB-17: kirim tautan atur ulang kata sandi lewat email.
     * Jawaban sengaja sama baik email terdaftar maupun tidak.
     */
    public function kirimTautan(Request $request): JsonResponse
    {
        $data = $this->validasi($request, ['email' => ['required', 'email']], ['email' => 'Email']);

        Password::sendResetLink(['email' => $data['email']]);

        return response()->json([
            'pesan' => 'Jika email terdaftar, tautan untuk mengatur ulang kata sandi sudah dikirim.',
        ]);
    }

    public function atur(Request $request): JsonResponse
    {
        $data = $this->validasi($request, [
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'kata_sandi' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email' => 'Email',
            'kata_sandi' => 'Kata sandi',
        ]);

        $berhasil = false;

        Password::reset(
            ['email' => $data['email'], 'password' => $data['kata_sandi'], 'token' => $data['token']],
            function (User $pengguna, string $kataSandi) use (&$berhasil): void {
                $pengguna->forceFill([
                    'password' => $kataSandi,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($pengguna));
                $berhasil = true;
            },
        );

        if (! $berhasil) {
            throw ValidationException::withMessages([
                'email' => 'Tautan tidak valid atau sudah kedaluwarsa. Minta tautan baru.',
            ]);
        }

        return response()->json(['pesan' => 'Kata sandi berhasil diubah. Silakan masuk.']);
    }
}
