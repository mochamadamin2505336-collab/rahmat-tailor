<?php

use Illuminate\Support\Facades\Route;
use App\Models\Galeri;
use App\Models\Layanan;

Route::get('/', function () {
    $layanan = Layanan::query()
        ->where('aktif', true)
        ->orderBy('urutan')
        ->orderBy('nama')
        ->get();

    $galeri = Galeri::query()->latest()->get();

    return view('index', compact('layanan', 'galeri'));
})->name('beranda');

Route::get('/pemesanan', function () {
    $layanan = Layanan::query()
        ->where('aktif', true)
        ->orderBy('urutan')
        ->orderBy('nama')
        ->get();

    return view('pemesanan', compact('layanan'));
})->middleware('auth')->name('pemesanan');

Route::get('/masuk', function () {
    return view('masuk');
})->middleware('guest')->name('login');

Route::get('/daftar', function () {
    return view('daftar');
})->middleware('guest')->name('daftar');

Route::get('/pesan', function () {
    return redirect()->route('pemesanan');
});

Route::get('/admin/{any?}', function () {
    return view('admin');
})->middleware(['auth', 'admin'])->where('any', '.*')->name('admin');

// Laravel memakai nama route ini pada email atur ulang kata sandi.
// Halaman pengisian kata sandi baru belum ada, jadi untuk sementara
// tautan diarahkan ke beranda dengan token di query string.
Route::get('/atur-ulang-kata-sandi/{token}', function (string $token) {
    return redirect('/?atur-ulang='.$token.'&email='.urlencode((string) request('email')));
})->name('password.reset');
