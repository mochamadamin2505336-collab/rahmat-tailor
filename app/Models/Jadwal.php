<?php

namespace App\Models;

use App\Enums\StatusJadwal;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['pelanggan_id', 'jenis', 'jenis_jahitan', 'bahan', 'waktu', 'foto_referensi', 'catatan', 'status'])]
class Jadwal extends Model
{
    protected $table = 'jadwal';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'waktu' => 'datetime',
            'status' => StatusJadwal::class,
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
