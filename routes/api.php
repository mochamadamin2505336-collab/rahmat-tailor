<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Akun;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PelacakanController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\TestimoniController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Endpoint JSON (otomatis berawalan /api, grup middleware "web")
|--------------------------------------------------------------------------
| Kirim header Accept: application/json dan X-CSRF-TOKEN pada setiap fetch.
*/

// Halaman publik tanpa login (PB-01 sampai PB-03, PB-15)
Route::get('/layanan', [KatalogController::class, 'layanan']);
Route::get('/galeri', [KatalogController::class, 'galeri']);
Route::get('/testimoni', [KatalogController::class, 'testimoni']);

// Booking jadwal ukur dan pelacakan tanpa akun (PB-11, PB-09)
Route::post('/jadwal', [JadwalController::class, 'store'])->middleware('throttle:6,1');
Route::post('/pelacakan', [PelacakanController::class, 'cari'])->middleware('throttle:10,1');

// Akun pelanggan (PB-17)
Route::post('/daftar', [Akun\PendaftaranController::class, 'store'])->middleware('throttle:10,1');
Route::post('/masuk', [Akun\MasukController::class, 'store'])->middleware('throttle:10,1');
Route::post('/lupa-kata-sandi', [Akun\KataSandiController::class, 'kirimTautan'])->middleware('throttle:5,1');
Route::post('/atur-ulang-kata-sandi', [Akun\KataSandiController::class, 'atur'])->middleware('throttle:10,1');

Route::middleware('auth')->group(function (): void {
    Route::post('/keluar', [Akun\MasukController::class, 'destroy']);
    Route::get('/saya', [Akun\MasukController::class, 'saya']);

    // Pelanggan online (PB-04 sampai PB-06, PB-15, PB-19)
    Route::get('/pesanan', [PemesananController::class, 'index']);
    Route::post('/pesanan', [PemesananController::class, 'store'])->middleware('throttle:10,1');
    Route::get('/pesanan/{kode}', [PemesananController::class, 'show']);
    Route::get('/ukuran-saya', [PemesananController::class, 'ukuranSaya']);
    Route::post('/testimoni', [TestimoniController::class, 'store'])->middleware('throttle:5,1');
});

// Panel admin: wajib login dan berperan admin (PB-07 sampai PB-20)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function (): void {
    Route::get('/ringkasan', [Admin\DashboardController::class, 'ringkasan']);

    Route::get('/pesanan', [Admin\PesananController::class, 'index']);
    Route::post('/pesanan', [Admin\PesananController::class, 'store']);
    Route::get('/pesanan/{pesanan}', [Admin\PesananController::class, 'show']);
    Route::patch('/pesanan/{pesanan}', [Admin\PesananController::class, 'update']);
    Route::put('/pesanan/{pesanan}/ukuran', [Admin\PesananController::class, 'ukuran']);
    Route::post('/pesanan/{pesanan}/status', [Admin\StatusPesananController::class, 'update']);
    Route::get('/pesanan/{pesanan}/tautan-whatsapp', [Admin\StatusPesananController::class, 'tautanWhatsapp']);
    Route::post('/pesanan/{pesanan}/pembayaran', [Admin\PembayaranController::class, 'store']);
    Route::get('/pesanan/{pesanan}/invoice', [Admin\PembayaranController::class, 'invoice']);

    Route::get('/pelanggan', [Admin\PelangganController::class, 'index']);
    Route::get('/pelanggan/{pelanggan}', [Admin\PelangganController::class, 'show']);

    Route::get('/jadwal', [Admin\JadwalController::class, 'index']);
    Route::patch('/jadwal/{jadwal}', [Admin\JadwalController::class, 'update']);

    Route::get('/layanan', [Admin\LayananController::class, 'index']);
    Route::post('/layanan', [Admin\LayananController::class, 'store']);
    Route::put('/layanan/{layanan}', [Admin\LayananController::class, 'update']);
    Route::delete('/layanan/{layanan}', [Admin\LayananController::class, 'destroy']);

    // POST untuk ubah foto karena PHP tidak membaca berkas dari permintaan PUT/PATCH
    Route::get('/galeri', [Admin\GaleriController::class, 'index']);
    Route::post('/galeri', [Admin\GaleriController::class, 'store']);
    Route::post('/galeri/{galeri}', [Admin\GaleriController::class, 'update']);
    Route::delete('/galeri/{galeri}', [Admin\GaleriController::class, 'destroy']);

    Route::get('/testimoni', [Admin\TestimoniController::class, 'index']);
    Route::patch('/testimoni/{testimoni}', [Admin\TestimoniController::class, 'update']);
    Route::delete('/testimoni/{testimoni}', [Admin\TestimoniController::class, 'destroy']);

    Route::get('/laporan', [Admin\LaporanController::class, 'index']);
});
