# Fitur FAQ — CMS + Halaman "Testimoni & FAQ"

Fitur FAQ baru ditambahkan mengikuti pola yang sama persis dengan fitur
Testimonial yang sudah ada (Model → Request → Controller → Route →
View admin → Landing page), supaya konsisten dengan codebase.

## File baru

- `database/migrations/2026_09_15_090000_create_faqs_table.php`
- `database/factories/FaqFactory.php`
- `database/seeders/FaqSeeder.php` (5 FAQ contoh, sama seperti di desain referensi)
- `app/Models/Faq.php`
- `app/Http/Requests/Admin/StoreFaqRequest.php`
- `app/Http/Requests/Admin/UpdateFaqRequest.php`
- `app/Http/Controllers/Admin/FaqController.php`
- `resources/views/admin/faqs/index.blade.php`
- `resources/views/admin/faqs/create.blade.php`
- `resources/views/admin/faqs/edit.blade.php`

## File yang diubah

- `routes/admin.php` — tambah `Route::resource('faqs', FaqController::class)`
- `routes/web.php` — tambah query `$faqs` (hanya yang `is_published`, urut `sort_order`) dan dikirim ke view landing
- `resources/views/admin/layout.blade.php` — tambah menu sidebar "FAQ"
- `app/Http/Controllers/Admin/DashboardController.php` — tambah stat `faqs_total` / `faqs_published`
- `resources/views/admin/dashboard.blade.php` — tambah kartu ringkasan FAQ dan shortcut "Kelola FAQ"
- `resources/views/partials/landing/testimoni.blade.php` — section diubah jadi
  **"Testimoni & FAQ"** 2 kolom (testimoni slider kiri, accordion FAQ kanan),
  sesuai referensi desain. Slider testimoni yang lama **tidak diubah
  fungsinya sama sekali** (id, class, JS di `index.blade.php` tetap sama),
  cuma dibungkus ulang jadi kolom kiri.

## Cara pasang

```bash
php artisan migrate
php artisan db:seed --class=FaqSeeder   # opsional, isi 5 contoh FAQ
```

Setelah itu buka:

- **Admin CMS**: `/admin/faqs` — CRUD penuh (tambah, edit, urutkan lewat
  kolom "Urutan", publish/draft).
- **Landing page**: section "Testimoni" (`/testimoni` atau scroll ke
  `#testimoni` di beranda) sekarang otomatis menampilkan FAQ di sisi kanan.

## Desain accordion FAQ

- Item pertama (urutan terkecil) terbuka otomatis, dengan latar hijau tua
  (`brand-forest`) — sama seperti pada referensi gambar.
- Klik pertanyaan lain untuk membuka; hanya satu yang terbuka dalam satu
  waktu (accordion style).
- Animasi buka/tutup pakai CSS Grid (`grid-template-rows`) yang di-toggle
  lewat sedikit vanilla JS (tanpa library tambahan), konsisten dengan gaya
  JS yang sudah dipakai di file `index.blade.php`.
- Warna & font 100% pakai token brand yang sudah ada:
  `brand-forest` (#30483F), `brand-gold` (#B9A56F), `brand-cream` (#F7F1E5),
  font judul `font-serif` (Cormorant Garamond).
- Kalau FAQ kosong (belum diisi dari admin), otomatis tampil placeholder
  "Belum ada FAQ." — sama seperti pola testimonial.
