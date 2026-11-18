<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama', 'kategori', 'deskripsi', 'harga_min', 'harga_max', 'estimasi_hari', 'aktif', 'urutan'])]
class Layanan extends Model
{
    protected $table = 'layanan';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'harga_min' => 'integer',
            'harga_max' => 'integer',
            'estimasi_hari' => 'integer',
            'aktif' => 'boolean',
            'urutan' => 'integer',
        ];
    }

    /**
     * @return HasMany<Pesanan, $this>
     */
    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }

    /**
     * @return HasMany<Galeri, $this>
     */
    public function galeri(): HasMany
    {
        return $this->hasMany(Galeri::class);
    }
}
