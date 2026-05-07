# 📊 Trading Journal

Aplikasi Trading Journal berbasis Laravel untuk mencatat dan memonitor aktivitas trading. Dokumentasi ini disajikan secara umum agar aman untuk dilihat publik.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-646CFF?style=flat-square&logo=vite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-blue?style=flat-square)

---

## 🎯 Sekilas

Aplikasi ini dirancang untuk membantu trader mencatat transaksi dan melihat ringkasan performa. Dokumentasi ini fokus pada instalasi dan penggunaan dasar tanpa menyertakan detail struktur database internal.

---

## 🛠️ Stack Teknologi

- PHP 8.1+ dengan Laravel
- Blade templates dan Vite
- MySQL / MariaDB atau database relasional serupa
- Composer dan npm/yarn

---

## 📋 Persyaratan Sistem

- PHP 8.1+ dengan ekstensi umum Laravel
- Composer
- Node.js 16+ dan npm/yarn
- MySQL / MariaDB
- Git

---

## 🚀 Instalasi Cepat

1. Clone repository:
   ```powershell
git clone https://github.com/taufiqjamil47/journal_trade.git
cd journal_trade
```
2. Install dependencies PHP:
   ```powershell
composer install
```
3. Install dependencies JavaScript:
   ```powershell
npm install
```
4. Siapkan environment:
   ```powershell
copy .env.example .env
php artisan key:generate
```
5. Konfigurasikan database di `.env`.
6. Jalankan migrasi dan seed data standar:
   ```powershell
php artisan migrate
php artisan db:seed
```
7. Jalankan aplikasi:
   ```powershell
php artisan serve
```

---

## 📁 Struktur Proyek

- `app/` - Logika aplikasi, model, controller, import/export
- `resources/` - Tampilan dan aset front-end
- `database/` - Migrasi, seeders, factory
- `public/` - Aset publik dan entry point web
- `routes/` - Definisi rute web dan API
- `tests/` - Unit dan feature tests

---

## 📤 Fitur Utama

- Pencatatan trade
- Dashboard ringkasan performa
- Impor dan ekspor data
- Manajemen akun dan simbol
- Autentikasi pengguna

---

## 🔧 Arsitektur Umum

Aplikasi ini dibangun sebagai aplikasi Laravel standar dengan model Eloquent, controller untuk logika request, Blade view untuk tampilan, dan middleware otentikasi.

> Dokumentasi ini sengaja tidak memasukkan detail struktur database internal.

---

## 🧪 Testing

Jalankan test dengan:
```powershell
php artisan test
```

Atau:
```powershell
vendor/bin/phpunit
```

---

## 📖 Panduan Penggunaan

- Buka `http://127.0.0.1:8000`
- Login atau daftar akun
- Tambah dan kelola catatan trade
- Gunakan fitur impor/ekspor untuk data massal

---

## ⚠️ Troubleshooting

- Pastikan service database berjalan
- Pastikan `.env` dikonfigurasi dengan benar
- Jika perubahan tidak muncul, jalankan:
  ```powershell
  php artisan optimize:clear
  php artisan view:clear
  php artisan cache:clear
  php artisan config:clear
  ```

---

## 🤝 Berkontribusi

- Fork repository
- Buat branch baru
- Commit perubahan dengan pesan jelas
- Buat pull request

---

## 📄 Lisensi

Proyek ini menggunakan **MIT License**.
