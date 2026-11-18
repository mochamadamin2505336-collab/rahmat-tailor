<?php

namespace Tests\Feature;

use App\Enums\PeranPengguna;
use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PemesananDanAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_pemesanan_dan_admin_mewajibkan_autentikasi(): void
    {
        $this->get('/pemesanan')->assertRedirect('/masuk');
        $this->get('/admin')->assertRedirect('/masuk');
    }

    public function test_pelanggan_tidak_bisa_membuka_halaman_admin(): void
    {
        $pelanggan = User::factory()->create(['peran' => PeranPengguna::Pelanggan]);

        $this->actingAs($pelanggan)
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_pemesanan_online_menyimpan_ukuran_ke_database(): void
    {
        $layanan = Layanan::create([
            'nama' => 'Jas Formal',
            'kategori' => 'Jas Formal',
            'deskripsi' => 'Jahit jas formal.',
            'harga_min' => 3500000,
            'harga_max' => 7500000,
            'estimasi_hari' => 14,
            'aktif' => true,
            'urutan' => 1,
        ]);

        $akun = User::factory()->create(['peran' => PeranPengguna::Pelanggan]);
        Pelanggan::create([
            'user_id' => $akun->id,
            'nama' => 'Pelanggan Test',
            'no_whatsapp' => '081234567890',
        ]);

        $respons = $this->actingAs($akun)->postJson('/api/pesanan', [
            'layanan_id' => $layanan->id,
            'bahan' => 'sendiri',
            'kategori_busana' => 'celana',
            'ukuran_di_toko' => false,
            'ukuran' => [
                'lingkar_pinggang_celana' => 84,
                'lingkar_panggul_celana' => 98,
                'lingkar_pesak' => 68,
                'lingkar_paha' => 58,
                'lingkar_lutut' => 42,
                'lingkar_celana_bawah' => 36,
                'panjang_celana' => 98,
            ],
        ]);

        $respons->assertCreated();
        $this->assertDatabaseHas('ukuran', [
            'kategori' => 'celana',
            'lingkar_pinggang_celana' => 84,
            'lingkar_panggul_celana' => 98,
        ]);
    }

    public function test_admin_bisa_mengelola_layanan(): void
    {
        $admin = User::factory()->create(['peran' => PeranPengguna::Admin]);

        $create = $this->actingAs($admin)->postJson('/api/admin/layanan', [
            'nama' => 'Layanan Test',
            'kategori' => 'Test',
            'deskripsi' => 'Layanan untuk pengujian.',
            'harga_min' => 100000,
            'harga_max' => 200000,
            'estimasi_hari' => 5,
            'aktif' => true,
            'urutan' => 1,
        ]);
        $create->assertCreated();
        $layananId = $create->json('id');

        $this->actingAs($admin)->putJson("/api/admin/layanan/$layananId", [
            'nama' => 'Layanan Diperbarui',
            'kategori' => 'Test',
            'deskripsi' => 'Deskripsi diperbarui.',
            'harga_min' => 120000,
            'harga_max' => 220000,
            'estimasi_hari' => 6,
            'aktif' => true,
            'urutan' => 2,
        ])->assertOk();

        $this->assertDatabaseHas('layanan', [
            'id' => $layananId,
            'nama' => 'Layanan Diperbarui',
        ]);

        $this->actingAs($admin)->deleteJson("/api/admin/layanan/$layananId")
            ->assertOk();
    }

    public function test_admin_bisa_mengelola_galeri(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['peran' => PeranPengguna::Admin]);

        $create = $this->actingAs($admin)->post('/api/admin/galeri', [
            'judul' => 'Galeri Test',
            'kategori' => 'Jas',
            'foto' => UploadedFile::fake()->image('galeri.jpg', 800, 600),
        ]);
        $create->assertCreated();
        $galeriId = $create->json('id');

        $this->actingAs($admin)->post("/api/admin/galeri/$galeriId", [
            'judul' => 'Galeri Diperbarui',
            'kategori' => 'Batik',
        ])->assertOk();

        $this->assertDatabaseHas('galeri', [
            'id' => $galeriId,
            'judul' => 'Galeri Diperbarui',
        ]);

        $this->actingAs($admin)->deleteJson("/api/admin/galeri/$galeriId")
            ->assertOk();
    }
}
