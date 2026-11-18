<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    /**
     * Pesan galat berbahasa Indonesia (PRD bagian 9, kegunaan).
     *
     * @var array<string, string>
     */
    private const PESAN = [
        'required' => ':attribute wajib diisi.',
        'required_if' => ':attribute wajib diisi.',
        'string' => ':attribute harus berupa teks.',
        'email' => 'Format :attribute tidak valid.',
        'unique' => ':attribute sudah dipakai.',
        'exists' => ':attribute tidak ditemukan.',
        'numeric' => ':attribute harus berupa angka.',
        'integer' => ':attribute harus berupa bilangan bulat.',
        'boolean' => ':attribute harus bernilai ya atau tidak.',
        'array' => ':attribute tidak valid.',
        'in' => 'Pilihan :attribute tidak valid.',
        'date' => 'Format :attribute tidak valid.',
        'date_format' => 'Format :attribute tidak valid.',
        'after_or_equal' => ':attribute tidak boleh sebelum hari ini.',
        'before_or_equal' => ':attribute tidak boleh setelah hari ini.',
        'confirmed' => 'Konfirmasi :attribute tidak cocok.',
        'digits' => ':attribute harus :digits digit angka.',
        'image' => ':attribute harus berupa gambar.',
        'mimes' => ':attribute harus berformat :values.',
        'uploaded' => 'Unggahan :attribute gagal. Coba lagi dengan berkas yang lebih kecil.',
        'min.numeric' => ':attribute minimal :min.',
        'max.numeric' => ':attribute maksimal :max.',
        'between.numeric' => ':attribute harus antara :min dan :max.',
        'gte.numeric' => ':attribute tidak boleh lebih kecil dari :value.',
        'min.string' => ':attribute minimal :min karakter.',
        'max.string' => ':attribute maksimal :max karakter.',
        'size.string' => ':attribute harus :size karakter.',
        'max.file' => 'Ukuran :attribute maksimal :max KB.',
    ];

    /**
     * Validasi dengan pesan Indonesia. Mengembalikan data tervalidasi.
     *
     * @param  array<string, mixed>  $aturan
     * @param  array<string, string>  $nama  nama tampilan kolom
     * @return array<string, mixed>
     */
    protected function validasi(Request $request, array $aturan, array $nama = []): array
    {
        return $request->validate($aturan, self::PESAN, $nama);
    }
}
