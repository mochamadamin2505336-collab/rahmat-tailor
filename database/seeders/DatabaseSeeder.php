<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PenggunaSeeder::class,
            LayananSeeder::class,
        ]);

        // Data contoh hanya untuk mengisi tampilan panel admin saat pengembangan.
        if (app()->environment('local')) {
            $this->call(DataContohSeeder::class);
        }
    }
}
