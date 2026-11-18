<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Kolom ukuran banyak (19) dan selalu disaring lewat App\Support\AturanUkuran
 * sebelum disimpan, jadi cukup melindungi kolom id saja.
 */
class Ukuran extends Model
{
    protected $table = 'ukuran';

    protected $guarded = ['id'];

    /**
     * @return BelongsTo<Pelanggan, $this>
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    /**
     * @return BelongsTo<Pesanan, $this>
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }
}
