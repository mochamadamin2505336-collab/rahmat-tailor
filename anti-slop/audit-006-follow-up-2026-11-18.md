# Audit 006 Follow-up

## Status

Semua temuan 1 sampai 9 sudah ditangani dalam implementasi.

## Perbaikan

1. **R-26 dan R-35 diperbaiki.**
   - Form pemesanan online sekarang mengirim `layanan_id`, kategori, bahan, catatan, tanggal target, foto referensi, dan ukuran ke `POST /api/pesanan`.
   - Berhasil menampilkan kode nota yang benar dari respons backend.
   - Gagal menampilkan pesan validasi atau gangguan koneksi.

2. **R-24 dan R-26 diperbaiki.**
   - Rute `/pemesanan` memakai middleware `auth`.
   - Ditambahkan halaman masuk dan daftar pelanggan.
   - Pengguna yang belum login diarahkan ke halaman masuk.

3. **R-24 dan R-26 diperbaiki.**
   - Rute halaman `/admin/{any?}` memakai middleware `auth, admin`.

4. **R-26 dan R-38 diperbaiki.**
   - Tautan panel admin di footer hanya dirender untuk pengguna dengan peran admin.

5. **R-38 diperbaiki.**
   - Halaman beranda mengambil layanan aktif dari database.
   - Tampilan kartu mempertahankan struktur lama dan memakai `@forelse` beserta state kosong.

6. **R-38 diperbaiki.**
   - Halaman beranda mengambil galeri dari database.
   - Kartu galeri memakai data berkas, judul, dan kategori dari model database.
   - Ditambahkan state kosong ketika belum ada karya.

7. **R-38 diperbaiki.**
   - Form pemesanan menyimpan ukuran melalui `PemesananController` dan `PesananService`.
   - Tab Riwayat Ukuran admin mengambil data pelanggan dan detail ukuran dari endpoint admin.
   - Tampilan statis pelanggan diganti dengan data dari database dan pencarian nama atau nomor.

8. **R-35 diperbaiki.**
   - Pelacakan pesanan sekarang memakai `POST /api/pelacakan`.
   - Reservasi jadwal sekarang memakai `POST /api/jadwal`.
   - Kode nota statis dan data sukses imitasi pada alur pemesanan, pelacakan, dan jadwal diganti respons atau galat nyata.

9. **R-27 diperbaiki.**
   - Layanan dan galeri menampilkan state kosong saat koleksi tidak tersedia.
   - Alur pemesanan, pelacakan, dan jadwal menampilkan hasil atau galat yang dapat dibaca pengguna.

## Verifikasi

- `php artisan migrate --force`: lulus.
- `npm run build`: lulus.
- `php artisan view:cache`: lulus.
- `php artisan test`: 5 tes lulus dengan 9 assertion.
- Pengujian HTTP: beranda merespons 200, `/pemesanan` dan `/admin` mengembalikan 302 untuk pengguna anonim.
