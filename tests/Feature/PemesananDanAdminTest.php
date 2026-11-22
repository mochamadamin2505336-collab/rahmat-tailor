<?php

namespace Tests\Feature;

use App\Enums\PeranPengguna;
use App\Enums\StatusPesanan;
use App\Enums\SumberPesanan;
use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\Ukuran;
use App\Models\Testimoni;
use App\Models\Galeri;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PemesananDanAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_pelanggan_bisa_mengirim_testimoni_ke_database(): void
    {
        $akun = User::factory()->create(['peran' => PeranPengguna::Pelanggan]);
        Pelanggan::create([
            'user_id' => $akun->id,
            'nama' => 'Pelanggan Testimoni',
            'no_whatsapp' => '6281234567893',
        ]);

        $this->actingAs($akun)
            ->postJson('/api/testimoni', [
                'isi' => 'Pelayanan jahit sangat rapi dan tepat waktu.',
                'bintang' => 5,
            ])
            ->assertCreated();

        $this->assertDatabaseHas('testimoni', [
            'isi' => 'Pelayanan jahit sangat rapi dan tepat waktu.',
            'bintang' => 5,
            'tampil' => false,
        ]);
    }

    public function test_landing_page_menampilkan_url_galeri_dari_database(): void
    {
        Storage::fake('public');
        $galeri = Galeri::create([
            'judul' => 'Jas Galeri Test',
            'kategori' => 'Baju/Jas',
            'berkas_foto' => 'galeri/test-image.jpg',
        ]);

        Storage::disk('public')->put(
            $galeri->berkas_foto,
            UploadedFile::fake()->image('test-image.jpg', 800, 600)->get(),
        );

        $this->assertSame(
            Storage::disk('public')->url($galeri->berkas_foto),
            $galeri->url,
        );
    }

    public function test_landing_page_menampilkan_layanan_dan_testimoni_dari_database(): void
    {
        Layanan::create([
            'nama' => 'Layanan Landing Test',
            'kategori' => 'Test',
            'deskripsi' => 'Deskripsi layanan dari database.',
            'harga_min' => 100000,
            'harga_max' => 200000,
            'estimasi_hari' => 5,
            'aktif' => true,
            'urutan' => 1,
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => 'Pelanggan Testimoni',
            'no_whatsapp' => '6281234567892',
        ]);
        Testimoni::create([
            'pelanggan_id' => $pelanggan->id,
            'isi' => 'Testimoni dari database untuk landing page.',
            'bintang' => 5,
            'tampil' => true,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Layanan Landing Test')
            ->assertSee('Pelanggan Testimoni')
            ->assertSee('Testimoni dari database untuk landing page.');
    }

    public function test_pemesanan_dan_admin_mewajibkan_autentikasi(): void
    {
        $this->get('/pemesanan')->assertRedirect('/masuk');
        $this->get('/admin')->assertRedirect('/masuk');
    }

    public function test_admin_detail_pesanan_menampilkan_url_model_pelanggan(): void
    {
        Storage::fake('public');

        $layanan = Layanan::create([
            'nama' => 'Jas Referensi',
            'kategori' => 'Jas',
            'deskripsi' => 'Jahit jas dengan referensi pelanggan.',
            'harga_min' => 100000,
            'harga_max' => 300000,
            'estimasi_hari' => 7,
            'aktif' => true,
            'urutan' => 1,
        ]);
        $pelanggan = Pelanggan::create([
            'nama' => 'Pelanggan Model',
            'no_whatsapp' => '6281234567899',
        ]);
        $pesanan = Pesanan::create([
            'kode_pesanan' => 'MODEL123',
            'sumber' => SumberPesanan::Online,
            'pelanggan_id' => $pelanggan->id,
            'layanan_id' => $layanan->id,
            'bahan' => 'sendiri',
            'catatan' => 'Saku miring.',
            'foto_referensi' => 'referensi/model-pelanggan.jpg',
            'status' => StatusPesanan::Verifikasi,
        ]);

        Storage::disk('public')->put(
            $pesanan->foto_referensi,
            UploadedFile::fake()->image('model-pelanggan.jpg', 640, 360)->get(),
        );

        $admin = User::factory()->create(['peran' => PeranPengguna::Admin]);

        $this->actingAs($admin)
            ->getJson("/api/admin/pesanan/{$pesanan->id}")
            ->assertOk()
            ->assertJsonPath('foto_referensi', 'referensi/model-pelanggan.jpg')
            ->assertJsonPath(
                'foto_referensi_url',
                Storage::disk('public')->url($pesanan->foto_referensi),
            );
    }

    public function test_halaman_masuk_menampilkan_popup_tanpa_layout_navbar(): void
    {
        $this->get('/masuk')
            ->assertOk()
            ->assertSee('Masuk ke akun')
            ->assertDontSee('Navigasi Utama Desktop');
    }

    public function test_halaman_daftar_menampilkan_popup_tanpa_layout_navbar(): void
    {
        $this->get('/daftar')
            ->assertOk()
            ->assertSee('Daftar pelanggan')
            ->assertDontSee('Navigasi Utama Desktop');
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
            'target_tanggal' => today()->addDays(15)->toDateString(),
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
        $pesanan = \App\Models\Pesanan::query()->latest('id')->firstOrFail();
        $admin = User::factory()->create(['peran' => PeranPengguna::Admin]);
        $this->actingAs($admin)
            ->getJson("/api/admin/pesanan/$pesanan->id")
            ->assertOk()
            ->assertJsonPath('target_tanggal', today()->addDays(15)->toDateString());
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

    public function test_admin_bisa_menyimpan_pesanan_offline_dengan_ukuran(): void
    {
        $admin = User::factory()->create(['peran' => PeranPengguna::Admin]);
        $layanan = Layanan::create([
            'nama' => 'Jas Offline',
            'kategori' => 'Jas',
            'harga_min' => 1000000,
            'harga_max' => 3000000,
            'estimasi_hari' => 7,
            'aktif' => true,
            'urutan' => 1,
        ]);

        $respons = $this->actingAs($admin)->postJson('/api/admin/pesanan', [
            'nama' => 'Pelanggan Offline',
            'no_whatsapp' => '081234567890',
            'bahan' => 'sendiri',
            'deadline' => today()->addDays(10)->toDateString(),
            'kategori_busana' => 'celana',
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
        $this->assertDatabaseHas('pesanan', [
            'sumber' => 'offline',
            'layanan_id' => $layanan->id,
        ]);
        $this->assertDatabaseHas('pelanggan', [
            'nama' => 'Pelanggan Offline',
            'no_whatsapp' => '6281234567890',
        ]);
        $this->assertDatabaseHas('ukuran', [
            'kategori' => 'celana',
            'lingkar_pinggang_celana' => 84,
        ]);
    }

    public function test_admin_bisa_verifikasi_pesanan_online(): void
    {
        $admin = User::factory()->create(['peran' => PeranPengguna::Admin]);
        $layanan = Layanan::create([
            'nama' => 'Seragam Test',
            'kategori' => 'Seragam',
            'harga_min' => 1000000,
            'harga_max' => 2500000,
            'estimasi_hari' => 10,
            'aktif' => true,
            'urutan' => 1,
        ]);
        $pelanggan = Pelanggan::create([
            'nama' => 'Pelanggan Verifikasi',
            'no_whatsapp' => '6281234567891',
        ]);
        $pesanan = Pesanan::create([
            'kode_pesanan' => 'TEST0001',
            'sumber' => SumberPesanan::Online,
            'pelanggan_id' => $pelanggan->id,
            'layanan_id' => $layanan->id,
            'bahan' => 'sendiri',
            'status' => StatusPesanan::Verifikasi,
        ]);
        Ukuran::create([
            'pelanggan_id' => $pelanggan->id,
            'pesanan_id' => $pesanan->id,
            'kategori' => 'seragam',
            'lingkar_pinggang_celana' => 84,
            'lingkar_panggul_celana' => 98,
            'lingkar_dada' => 104,
        ]);

        $this->actingAs($admin)->patchJson("/api/admin/pesanan/$pesanan->id", [
            'harga' => 1500000,
            'deadline' => today()->addDays(10)->toDateString(),
        ])->assertOk();

        $this->actingAs($admin)->postJson("/api/admin/pesanan/$pesanan->id/status")
            ->assertOk();

        $this->assertDatabaseHas('pesanan', [
            'id' => $pesanan->id,
            'status' => StatusPesanan::Diterima->value,
            'harga' => 1500000,
        ]);
    }
}
