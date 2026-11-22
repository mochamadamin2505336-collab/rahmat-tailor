<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

#[Fillable(['judul', 'kategori', 'berkas_foto', 'layanan_id'])]
class Galeri extends Model
{
    protected $table = 'galeri';

    /**
     * @return BelongsTo<Layanan, $this>
     */
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }

    /**
     * URL publik dipakai landing page dan respons API untuk file galeri.
     */
    protected function url(): Attribute
    {
        return Attribute::get(
            fn (): string => Storage::disk('public')->url($this->berkas_foto),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return parent::toArray() + ['url' => Storage::disk('public')->url($this->berkas_foto)];
    }
}
