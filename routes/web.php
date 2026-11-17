<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('beranda');

Route::get('/pemesanan', function () {
    return view('pemesanan');
})->name('pemesanan');

Route::get('/pesan', function () {
    return redirect()->route('pemesanan');
});

Route::get('/admin/{any?}', function () {
    return view('admin');
})->where('any', '.*')->name('admin');

