<?php

namespace App\Http\Controllers\Akun;

use App\Enums\PeranPengguna;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\User;
use App\Support\NomorWhatsapp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PendaftaranController extends Controller
{
    /**
     * PB-17: pendaftaran pelanggan online. Kata sandi di-hash lewat cast pada model User.
     */
    public function store(Request $request): JsonResponse
    {
        $request->merge(['email' => Str::lower(trim((string) $request->input('email')))]);

        $data = $this->validasi($request, [
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'no_whatsapp' => NomorWhatsapp::aturan(),
            'kata_sandi' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nama' => 'Nama',
            'email' => 'Email',
            'no_whatsapp' => 'Nomor WhatsApp',
            'kata_sandi' => 'Kata sandi',
        ]);

        $nomor = NomorWhatsapp::normalisasi($data['no_whatsapp']);

        // Pertanyaan terbuka PRD nomor 7: nomor yang sudah tercatat tidak ditautkan
        // otomatis ke akun baru, karena tanpa verifikasi siapa pun bisa membaca
        // riwayat pesanan orang lain hanya dengan mengetik nomornya.
        if (Pelanggan::where('no_whatsapp', $nomor)->exists()) {
            throw ValidationException::withMessages([
                'no_whatsapp' => 'Nomor WhatsApp ini sudah tercatat. Jika Anda pernah memesan di toko, hubungi admin untuk menautkan akun.',
            ]);
        }

        $pengguna = DB::transaction(function () use ($data, $nomor): User {
            $pengguna = User::create([
                'name' => $data['nama'],
                'email' => $data['email'],
                'password' => $data['kata_sandi'],
                'peran' => PeranPengguna::Pelanggan,
            ]);

            Pelanggan::create([
                'user_id' => $pengguna->id,
                'nama' => $data['nama'],
                'no_whatsapp' => $nomor,
            ]);

            return $pengguna;
        });

        Auth::login($pengguna);
        $request->session()->regenerate();

        return response()->json([
            'pesan' => 'Pendaftaran berhasil.',
            'pengguna' => MasukController::ringkas($pengguna),
        ], 201);
    }
}
