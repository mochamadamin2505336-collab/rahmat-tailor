<?php

namespace Database\Seeders;

use App\Enums\PeranPengguna;
use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class PenggunaSeeder extends Seeder
{
    /**
     * Akun admin pemilik. Email dan kata sandi dibaca dari .env
     * (ADMIN_EMAIL, ADMIN_PASSWORD) supaya tidak tertulis di repositori.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@rahmattailor.test');
        $kataSandi = env('ADMIN_PASSWORD');

        if ($kataSandi === null) {
            if (app()->isProduction()) {
                throw new RuntimeException('Isi ADMIN_PASSWORD di .env sebelum menjalankan seeder di produksi.');
            }

            $kataSandi = 'ganti-kata-sandi-ini';
            $this->command?->warn('ADMIN_PASSWORD belum diisi, memakai kata sandi bawaan lokal. Ganti sebelum dipakai di luar komputer sendiri.');
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin Rahmat Tailor',
                'password' => $kataSandi,
                'peran' => PeranPengguna::Admin,
            ],
        );
    }
}
