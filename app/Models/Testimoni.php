<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['pelanggan_id', 'isi', 'bintang', 'tampil'])]
class Testimoni extends Model
{
    protected $table = 'testimoni';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'bintang' => 'integer',
            'tampil' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Pelanggan, $this>
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
