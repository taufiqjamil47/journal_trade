# Trading Journal

Aplikasi Trading Journal untuk mencatat, menganalisis, dan mengelola catatan trading. Proyek ini dibuat dengan Laravel dan menyediakan fitur impor/ekspor, analisis trade, dan manajemen simbol/akun.

**Ringkasan:**

-   **Stack:** PHP (Laravel), MySQL, Composer, Node (Vite)
-   **Folder penting:** `app/Models`, `app/Http/Controllers`, `app/Imports`, `app/Exports`, `database/migrations`

**Persyaratan**

-   PHP 8.1+ dan ekstensi umum (PDO, mbstring, OpenSSL, dll.)
-   Composer
-   Node.js & npm (untuk assets / Vite)
-   MySQL atau MariaDB
-   XAMPP (opsional di Windows) atau web server lain

## Instalasi

Ikuti langkah-langkah berikut dari command line (PowerShell direkomendasikan di Windows):

1. Clone repository

```powershell
git clone https://github.com/taufiqjamil47/journal_trade.git
cd journal_trade
```

2. Install dependency PHP

```powershell
composer install
```

3. Install dependency JavaScript

```powershell
npm install
```

4. Salin file environment dan buat application key

```powershell
copy .env.example .env
php artisan key:generate
```

5. Konfigurasikan koneksi database di file `.env` (atur `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)

6. Jalankan migrasi dan seeder (jika ada)

```powershell
php artisan migrate
php artisan db:seed
```

7. (Opsional) Buat symlink storage

```powershell
php artisan storage:link
```

8. Build assets (development atau production)

Development:

```powershell
npm run dev
```

Production:

```powershell
npm run build
```

9. Jalankan aplikasi

Gunakan built-in server Laravel (untuk pengembangan cepat):

```powershell
php artisan serve
```

Atau konfigurasikan virtual host di XAMPP/Apache dan arahkan ke folder `public`.

## Import / Export

-   Import trade: periksa `app/Imports/TradesImport.php`.
-   Export trade: periksa `app/Exports/TradesExport.php`.

Jika aplikasi menggunakan package Excel (mis. `maatwebsite/excel`), import/export biasanya lewat UI atau command khusus.

## Menjalankan test

```powershell
php artisan test
```

atau

```powershell
vendor/bin/phpunit
```

## Penggunaan singkat

-   Masuk ke aplikasi di browser (mis. `http://127.0.0.1:8000` jika memakai `php artisan serve`).
-   Gunakan fitur impor untuk memasukkan data trade, lalu lihat analisis di halaman yang tersedia.

## Kontribusi

-   Fork repository, buat branch fitur (`feature/<nama-fitur>`), lalu buat pull request.
-   Ikuti coding style proyek dan sertakan deskripsi perubahan di PR.

## Troubleshooting

-   Error migration: periksa kredensial DB di `.env` dan pastikan database sudah dibuat.
-   Error dependency: jalankan `composer install` dan `npm install` lagi, lalu clear cache: `php artisan config:clear && php artisan cache:clear`.

## Lisensi

Lisensi proyek: sesuaikan dengan yang diinginkan (tidak ditentukan di repo ini). Tambahkan file `LICENSE` jika diperlukan.

## Kontak

Jika perlu bantuan, buka issue di repository atau hubungi maintainer.
