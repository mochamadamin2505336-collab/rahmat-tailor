<?php

namespace App\Models;

use App\Enums\StatusPesanan;
use App\Enums\SumberPesanan;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'kode_pesanan', 'sumber', 'pelanggan_id', 'layanan_id', 'bahan', 'catatan',
    'foto_referensi', 'harga', 'target_tanggal', 'deadline', 'status',
])]
class Pesanan extends Model
{
    protected $table = 'pesanan';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sumber' => SumberPesanan::class,
            'status' => StatusPesanan::class,
            'harga' => 'integer',
            'target_tanggal' => 'date',
            'deadline' => 'date',
        ];
    }

    /**
     * @return BelongsTo<Pelanggan, $this>
     */
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    /**
     * @return BelongsTo<Layanan, $this>
     */
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }

    /**
     * @return HasOne<Ukuran, $this>
     */
    public function ukuran(): HasOne
    {
        return $this->hasOne(Ukuran::class);
    }

    /**
     * @return HasMany<StatusLog, $this>
     */
    public function statusLog(): HasMany
    {
        return $this->hasMany(StatusLog::class)->orderBy('waktu')->orderBy('id');
    }

    /**
     * @return HasMany<Pembayaran, $this>
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class)->orderBy('tanggal')->orderBy('id');
    }

    /**
     * Memakai hasil withSum('pembayaran as total_dibayar', 'jumlah') bila tersedia
     * supaya daftar pesanan tidak menembak satu query per baris.
     */
    public function totalDibayar(): int
    {
        return (int) ($this->total_dibayar ?? Pembayaran::query()->where('pesanan_id', $this->id)->sum('jumlah'));
    }

    public function sisaTagihan(): ?int
    {
        if ($this->harga === null) {
            return null;
        }

        return max(0, $this->harga - $this->totalDibayar());
    }

    /**
     * Tahapan pengerjaan untuk ditampilkan sebagai garis waktu (PB-09).
     * Tahap verifikasi hanya muncul bila pesanan memang pernah melewatinya.
     *
     * @return array<int, array{status: string, label: string, tercapai: bool, waktu: mixed}>
     */
    public function langkahStatus(): array
    {
        $log = $this->statusLog->keyBy(fn (StatusLog $item): string => $item->status->value);
        $langkah = [];

        foreach (StatusPesanan::cases() as $status) {
            if ($status === StatusPesanan::Verifikasi && ! $log->has($status->value)) {
                continue;
            }

            $langkah[] = [
                'status' => $status->value,
                'label' => $status->label(),
                'tercapai' => $log->has($status->value),
                'waktu' => $log->get($status->value)?->waktu,
            ];
        }

        return $langkah;
    }

    /**
     * Ringkasan satu baris pesanan untuk daftar di akun pelanggan maupun panel admin.
     *
     * @return array<string, mixed>
     */
    public function ringkas(): array
    {
        return [
            'id' => $this->id,
            'kode' => $this->kode_pesanan,
            'sumber' => $this->sumber->value,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'layanan' => $this->layanan?->nama,
            'deadline' => $this->deadline?->toDateString(),
            'harga' => $this->harga,
            'total_dibayar' => $this->totalDibayar(),
            'sisa_tagihan' => $this->sisaTagihan(),
            'dibuat' => $this->created_at?->toIso8601String(),
            'pelanggan' => $this->relationLoaded('pelanggan') ? [
                'id' => $this->pelanggan->id,
                'nama' => $this->pelanggan->nama,
                'no_whatsapp' => $this->pelanggan->no_whatsapp,
            ] : null,
        ];
    }
}
