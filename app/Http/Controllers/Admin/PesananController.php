<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusPesanan;
use App\Enums\SumberPesanan;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Ukuran;
use App\Models\Layanan;
use App\Support\AturanUkuran;
use App\Support\NomorWhatsapp;
use App\Support\PesananService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PesananController extends Controller
{
    /**
     * Nama tampilan kolom yang dipakai bersama oleh beberapa aksi di controller ini.
     *
     * @var array<string, string>
     */
    private const NAMA = [
        'nama' => 'Nama',
        'no_whatsapp' => 'Nomor WhatsApp',
        'layanan_id' => 'Layanan',
        'bahan' => 'Bahan kain',
        'catatan' => 'Catatan',
        'harga' => 'Harga',
        'deadline' => 'Deadline',
        'foto_referensi' => 'Foto referensi',
        'kategori_busana' => 'Kategori busana',
        'salin_ukuran_id' => 'Ukuran lama',
    ];

    /**
     * PB-07: daftar pesanan berurut deadline terdekat, dengan filter status, sumber,
     * dan pencarian nama atau kode. Pesanan tanpa deadline ditaruh paling bawah.
     */
    public function index(Request $request): JsonResponse
    {
        $status = StatusPesanan::tryFrom((string) $request->query('status'));
        $sumber = SumberPesanan::tryFrom((string) $request->query('sumber'));
        $cari = trim((string) $request->query('q'));

        $daftar = Pesanan::query()
            ->with(['pelanggan', 'layanan:id,nama'])
            ->withSum('pembayaran as total_dibayar', 'jumlah')
            ->when($status, fn (Builder $query) => $query->where('status', $status->value))
            ->when($sumber, fn (Builder $query) => $query->where('sumber', $sumber->value))
            ->when($cari !== '', function (Builder $query) use ($cari): void {
                $digit = preg_replace('/\D+/', '', $cari) ?? '';

                $query->where(function (Builder $kondisi) use ($cari, $digit): void {
                    $kondisi->where('kode_pesanan', 'like', '%'.Str::upper($cari).'%')
                        ->orWhereHas('pelanggan', function (Builder $pelanggan) use ($cari, $digit): void {
                            $pelanggan->where('nama', 'like', "%{$cari}%");

                            if ($digit !== '') {
                                $pelanggan->orWhere('no_whatsapp', 'like', "%{$digit}%");
                            }
                        });
                });
            })
            ->orderByRaw('deadline IS NULL')
            ->orderBy('deadline')
            ->orderByDesc('id')
            ->paginate(20)
            ->through(fn (Pesanan $pesanan): array => $pesanan->ringkas());

        return response()->json($daftar);
    }

    public function show(Pesanan $pesanan): JsonResponse
    {
        $pesanan->load(['pelanggan', 'layanan', 'ukuran', 'statusLog', 'pembayaran']);

        return response()->json($pesanan->ringkas() + [
            'bahan' => $pesanan->bahan,
            'catatan' => $pesanan->catatan,
            'target_tanggal' => $pesanan->target_tanggal?->toDateString(),
            'foto_referensi' => $pesanan->foto_referensi,
            'foto_referensi_url' => $pesanan->foto_referensi
                ? Storage::disk('public')->url($pesanan->foto_referensi)
                : null,
            'ukuran' => $pesanan->ukuran,
            'status_log' => $pesanan->statusLog,
            'pembayaran' => $pesanan->pembayaran,
            'langkah' => $pesanan->langkahStatus(),
        ]);
    }

    /**
     * PB-18: admin mencatat pesanan offline atas nama pelanggan tanpa akun.
     * Pelanggan dicari lewat nomor WhatsApp, dibuat baru bila belum ada.
     * Ukuran bisa diisi baru atau disalin dari riwayat pelanggan (PB-14).
     */
    public function store(Request $request, PesananService $servis): JsonResponse
    {
        $salin = $request->filled('salin_ukuran_id');

        $aturan = [
            'nama' => ['required', 'string', 'max:100'],
            'no_whatsapp' => NomorWhatsapp::aturan(),
            'layanan_id' => ['nullable', 'integer', Rule::exists('layanan', 'id')->where('aktif', true)],
            'bahan' => ['required', Rule::in(['sendiri', 'toko'])],
            'catatan' => ['nullable', 'string', 'max:1000'],
            'harga' => ['nullable', 'integer', 'min:0'],
            'deadline' => ['nullable', 'date', 'after_or_equal:today'],
            'foto_referensi' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'salin_ukuran_id' => ['nullable', 'integer', 'exists:ukuran,id'],
        ];

        if (! $salin) {
            $aturan['kategori_busana'] = ['required', Rule::in(AturanUkuran::KATEGORI)];
            $aturan += AturanUkuran::aturan((string) $request->input('kategori_busana'));
        }

        $data = $this->validasi($request, $aturan, self::NAMA + AturanUkuran::namaAtribut());

        if (empty($data['layanan_id'])) {
            $layanan = Layanan::query()->where('aktif', true)->orderBy('urutan')->orderBy('nama')->first();

            if ($layanan === null) {
                throw ValidationException::withMessages([
                    'layanan_id' => 'Belum ada layanan aktif untuk pesanan offline.',
                ]);
            }

            $data['layanan_id'] = $layanan->id;
        }

        $pesanan = DB::transaction(function () use ($data, $salin, $servis, $request): Pesanan {
            $pelanggan = Pelanggan::firstOrCreate(
                ['no_whatsapp' => NomorWhatsapp::normalisasi($data['no_whatsapp'])],
                ['nama' => $data['nama']],
            );

            if ($salin) {
                $lama = Ukuran::query()->where('pelanggan_id', $pelanggan->id)->find($data['salin_ukuran_id']);

                if ($lama === null) {
                    throw ValidationException::withMessages([
                        'salin_ukuran_id' => 'Ukuran tersebut bukan milik pelanggan ini.',
                    ]);
                }

                $ukuran = AturanUkuran::dariModel($lama);
            } else {
                $ukuran = AturanUkuran::siapkan($data['kategori_busana'], $data['ukuran']);
            }

            return $servis->buat(
                $pelanggan,
                SumberPesanan::Offline,
                $data,
                $ukuran,
                $request->file('foto_referensi'),
                $request->user(),
            );
        });

        $pesanan->load(['pelanggan', 'layanan:id,nama']);

        return response()->json([
            'pesan' => 'Pesanan offline tersimpan. Kode dapat dicetak pada nota.',
            'pesanan' => $pesanan->ringkas(),
        ], 201);
    }

    /**
     * Aturan bisnis 7: harga dan deadline ditetapkan admin setelah meninjau pesanan.
     */
    public function update(Request $request, Pesanan $pesanan): JsonResponse
    {
        $data = $this->validasi($request, [
            'harga' => ['nullable', 'integer', 'min:0'],
            'deadline' => ['nullable', 'date'],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ], self::NAMA);

        $pesanan->update($data);

        return response()->json([
            'pesan' => 'Pesanan diperbarui.',
            'pesanan' => $pesanan->load(['pelanggan', 'layanan:id,nama'])->ringkas(),
        ]);
    }

    /**
     * PB-20: admin memeriksa dan, bila perlu, mengoreksi ukuran pesanan online.
     */
    public function ukuran(Request $request, Pesanan $pesanan): JsonResponse
    {
        $aturan = ['kategori_busana' => ['required', Rule::in(AturanUkuran::KATEGORI)]];
        $aturan += AturanUkuran::aturan((string) $request->input('kategori_busana'));

        $data = $this->validasi($request, $aturan, self::NAMA + AturanUkuran::namaAtribut());

        $ukuran = Ukuran::updateOrCreate(
            ['pesanan_id' => $pesanan->id],
            ['pelanggan_id' => $pesanan->pelanggan_id] + AturanUkuran::siapkan($data['kategori_busana'], $data['ukuran']),
        );

        return response()->json(['pesan' => 'Ukuran tersimpan.', 'ukuran' => $ukuran]);
    }
}
