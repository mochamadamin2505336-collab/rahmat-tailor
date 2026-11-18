<?php

namespace App\Models;

use App\Support\NomorWhatsapp;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'nama', 'no_whatsapp', 'alamat'])]
class Pelanggan extends Model
{
    protected $table = 'pelanggan';

    /**
     * Nomor selalu disimpan dalam format 62xxxxxxxxxx.
     *
     * @return Attribute<string, string>
     */
    protected function noWhatsapp(): Attribute
    {
        return Attribute::make(
            set: fn (string $nilai): string => NomorWhatsapp::normalisasi($nilai),
        );
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<Pesanan, $this>
     */
    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }

    /**
     * @return HasMany<Ukuran, $this>
     */
    public function ukuran(): HasMany
    {
        return $this->hasMany(Ukuran::class);
    }

    /**
     * @return HasMany<Jadwal, $this>
     */
    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    /**
     * @return HasMany<Testimoni, $this>
     */
    public function testimoni(): HasMany
    {
        return $this->hasMany(Testimoni::class);
    }
}
