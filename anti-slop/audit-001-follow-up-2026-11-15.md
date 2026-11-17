# Audit 001 Follow-up

## Status Perbaikan

1. **MEDIUM, R-27 dan R-38: Selesai**
   - Form pesanan offline sekarang menyediakan kategori Celana, Baju / Jas, dan Rok.
   - Bidang ukuran berubah mengikuti kategori yang dipilih, dan bidang yang aktif wajib diisi.
   - Submit form menampilkan umpan balik bahwa data pesanan dan ukuran sudah lengkap dan siap diproses.
   - Verifikasi: `php artisan view:cache`, `npm run build`, pergantian kategori Baju / Jas dan Rok di browser, submit data Celana, serta pengecekan lebar modal pada viewport 390px.
