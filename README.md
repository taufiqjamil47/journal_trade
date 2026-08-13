# 📊 Trading Journal

<div align="center">

<h3>Aplikasi Manajemen dan Monitoring Trading berbasis Laravel</h3>

<p>Aplikasi untuk mencatat, memonitor, dan menganalisis aktivitas trading secara efisien</p>

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat-square&logo=mysql&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-5.x-646CFF?style=flat-square&logo=vite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-blue?style=flat-square)

</div>

---

## 📋 Daftar Isi

- [Tentang Aplikasi](#-tentang-aplikasi)
- [Teknologi yang Digunakan](#️-teknologi-yang-digunakan)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Panduan Instalasi](#-panduan-instalasi)
- [Konfigurasi Environment](#️-konfigurasi-environment)
- [Menjalankan Aplikasi](#️-menjalankan-aplikasi)
- [Fitur Utama](#-fitur-utama)
- [Integrasi MetaTrader 5 (Auto Sync Trade)](#-integrasi-metatrader-5-auto-sync-trade)
- [Testing](#-testing)
- [Troubleshooting](#-troubleshooting)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## 🎯 Tentang Aplikasi

**Trading Journal** adalah aplikasi web yang dirancang khusus untuk membantu trader dalam mencatat dan memonitor aktivitas trading mereka. Dengan antarmuka yang intuitif, aplikasi ini memungkinkan pengguna untuk:

- Mencatat setiap transaksi trading secara detail
- Melihat ringkasan performa trading secara real-time
- Mengimpor dan mengekspor data trading
- Mengelola akun trading dan simbol aset

> 📌 **Catatan**: Dokumentasi ini disajikan secara umum tanpa menyertakan detail struktur database internal untuk menjaga keamanan dan kerahasiaan.

---

## 🛠️ Teknologi yang Digunakan

| Teknologi | Versi | Keterangan |
|---|---|---|
| **PHP** | ^8.1 | Bahasa pemrograman backend |
| **Laravel** | ^10.10 | Framework PHP utama |
| **MySQL/MariaDB** | 5.7+ | Database relasional |
| **Node.js** | 16+ | Runtime JavaScript |
| **Vite** | ^5.0 | Build tool dan asset bundler |
| **Composer** | 2.x | Dependency manager PHP |

### 📦 Package Penting

| Package | Fungsi |
|---|---|
| `barryvdh/laravel-dompdf` | Generate PDF dari HTML |
| `maatwebsite/excel` | Import/Export Excel (CSV, XLSX) |
| `laravel/sanctum` | Autentikasi API |
| `guzzlehttp/guzzle` | HTTP client untuk API eksternal |
| `mcamara/laravel-localization` | Manajemen multi-bahasa |

---

## 📋 Persyaratan Sistem

Pastikan sistem Anda memenuhi persyaratan berikut:

- ✅ **PHP** 8.1 atau lebih baru dengan ekstensi:
  - `BCMath`
  - `Ctype`
  - `Fileinfo`
  - `JSON`
  - `Mbstring`
  - `OpenSSL`
  - `PDO`
  - `Tokenizer`
  - `XML`
- ✅ **Composer** 2.x
- ✅ **Node.js** 16.x atau lebih baru
- ✅ **MySQL** 5.7+ atau **MariaDB** 10.2+
- ✅ **Git** (untuk cloning repository)

---

## 🚀 Panduan Instalasi

Ikuti langkah-langkah berikut untuk menginstal aplikasi di lingkungan lokal Anda:

### 1️⃣ Clone Repository

```bash
git clone https://github.com/taufiqjamil47/journal_trade.git
cd journal_trade
```

### 2️⃣ Install Dependencies PHP

```bash
composer install
```

> ⏱️ Proses ini akan mengunduh semua package PHP yang diperlukan sesuai dengan `composer.json`.

### 3️⃣ Install Dependencies JavaScript

```bash
npm install
```

> ⏱️ Proses ini akan mengunduh semua package Node.js yang diperlukan sesuai dengan `package.json`.

### 4️⃣ Setup Environment

```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

### 5️⃣ Generate Application Key

```bash
php artisan key:generate
```

> 🔑 Key ini digunakan untuk enkripsi session, cookie, dan data sensitif lainnya.

### 6️⃣ Konfigurasi Database

Buka file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=journal_trade
DB_USERNAME=root
DB_PASSWORD=your_password
```

> 💡 **Tips**: Pastikan database `journal_trade` sudah dibuat terlebih dahulu di MySQL.

### 7️⃣ Jalankan Migrasi & Seeder

```bash
php artisan migrate
php artisan db:seed
```

> 📊 Seeder akan mengisi data awal seperti akun contoh, simbol trading, dan konfigurasi dasar.

---

## ⚙️ Konfigurasi Environment

Selain database, ada beberapa konfigurasi penting lainnya di file `.env`:

### 📧 Konfigurasi Email (untuk notifikasi)

```env
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

> 💡 Untuk development, Anda bisa menggunakan **Mailpit** (bawaan Laravel Sail) atau **Mailtrap**.

### 💱 Konfigurasi API Kurs Mata Uang (Opsional)

```env
EXCHANGE_RATE_API_KEY=your-api-key
CURRENCY_CACHE_TTL=3600
CURRENCY_API_URL=https://v6.exchangerate-api.com/v6
```

> 🔑 Dapatkan API key gratis di [ExchangeRate-API](https://www.exchangerate-api.com/).

### 🔒 Konfigurasi MT5 Sync (Opsional)

```env
MT5_SYNC_TOKEN=your-secret-token
```

> Digunakan untuk sinkronisasi dengan MetaTrader 5 (jika diaktifkan).

---

## ▶️ Menjalankan Aplikasi

### Mode Development

Jalankan dua terminal secara bersamaan:

**Terminal 1 - Laravel Server:**

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://127.0.0.1:8000`

**Terminal 2 - Vite Development Server:**

```bash
npm run dev
```

Vite akan berjalan untuk hot-reload asset frontend.

### Mode Production

Untuk deployment production, build asset terlebih dahulu:

```bash
npm run build
php artisan optimize
```

### Queue Worker (untuk job asynchronous)

Jika menggunakan queue untuk tugas berat:

```bash
php artisan queue:work
```

---

## ✨ Fitur Utama

| Fitur | Deskripsi |
|---|---|
| 📝 **Pencatatan Trade** | Catat setiap transaksi dengan detail (entry, exit, lot, profit/loss) |
| 📊 **Dashboard** | Ringkasan performa trading dengan grafik dan statistik |
| 📁 **Import/Export** | Impor dan ekspor data trading dalam format Excel (XLSX/CSV) |
| 👤 **Manajemen Akun** | Kelola multiple akun trading dalam satu platform |
| 🏷️ **Manajemen Simbol** | Tambahkan dan kelola simbol aset trading |
| 🔐 **Autentikasi** | Sistem login dan registrasi dengan Laravel Sanctum |
| 📧 **Notifikasi Email** | Notifikasi terkait aktivitas trading via email |
| 🌐 **Multi-language** | Dukungan multi-bahasa (dengan `mcamara/laravel-localization`) |

---

## 🤖 Integrasi MetaTrader 5 (Auto Sync Trade)

Aplikasi ini dilengkapi **Expert Advisor (EA)** khusus — `LaravelTradeBridge.mq5` — yang mengirim data trade dari MetaTrader 5 langsung ke Trading Journal secara otomatis melalui webhook, tanpa perlu input manual.

### 📌 Cara Kerja

EA berjalan di dalam MetaTrader 5 dan mengirim data (posisi terbuka + history) ke endpoint `POST /api/mt5/webhook` dalam format JSON, setiap interval waktu tertentu atau setiap kali ada perubahan posisi (open/close). Data yang dikirim mencakup ticket, symbol, tipe (buy/sell), harga entry/exit, SL/TP, profit/loss, lot size, dan status posisi (terbuka/tertutup).

### 1️⃣ Pasang EA di MetaTrader 5

1. Buka **MetaTrader 5** → menu **File > Open Data Folder**.
2. Masuk ke folder `MQL5/Experts/`.
3. Salin file `LaravelTradeBridge.mq5` ke folder tersebut.
4. Kembali ke MetaTrader 5, buka **MetaEditor** (tekan `F4`), lalu buka file yang baru disalin dan klik **Compile** (`F7`). Pastikan tidak ada error.

### 2️⃣ Izinkan WebRequest ke URL Aplikasi

MetaTrader 5 memblokir semua request HTTP keluar secara default, sehingga URL webhook harus di-whitelist:

1. Di MetaTrader 5, buka **Tools > Options > Expert Advisors**.
2. Centang **"Allow WebRequest for listed URL"**.
3. Tambahkan URL aplikasi Anda, misalnya:
   - Untuk development lokal: `http://127.0.0.1:8000`
   - Untuk server production: `https://domain-anda.com`
4. Klik **OK**.

> ⚠️ Tanpa langkah ini, EA akan gagal mengirim data dengan error `4014` di log (`URL tidak di-allow di MetaEditor`).

### 3️⃣ Hubungkan Akun MT5 di Aplikasi

Sebelum EA bisa mengirim data, akun trading harus terhubung dulu di sisi Laravel:

1. Login ke Trading Journal, buka menu **Akun (Accounts)**.
2. Buat/pilih akun trading, lalu hubungkan ke MT5 melalui aksi **Connect MT5** (route `accounts.connect-mt5`).
3. Catat **Account ID** (angka ID akun di Laravel, bukan nomor login MT5) — ID ini akan diisi ke parameter EA di langkah berikutnya.

### 4️⃣ Pasang EA ke Chart & Atur Parameter

1. Buka chart simbol apa pun di MT5 (EA ini mengirim seluruh posisi & history akun, bukan hanya simbol pada chart).
2. Di **Navigator**, cari `LaravelTradeBridge` di bawah **Expert Advisors**, lalu drag ke chart.
3. Pada tab **Inputs**, atur:

   | Parameter | Keterangan |
   |---|---|
   | `WebhookURL` | URL endpoint webhook, contoh: `http://127.0.0.1:8000/api/mt5/webhook` |
   | `LaravelAccountId` | ID akun di Laravel (dari langkah 3️⃣ di atas) |
   | `SendOnTimer` | Kirim data otomatis tiap interval waktu |
   | `TimerInterval` | Interval pengiriman dalam detik (minimum 5) |
   | `SendOnTrade` | Kirim data setiap kali ada perubahan posisi (open/close) |
   | `IncludeHistory` | Sertakan history trade yang sudah tertutup |
   | `HistoryDays` | Jumlah hari ke belakang untuk history yang diambil |
   | `DebugMode` | Tampilkan log detail di tab **Experts** untuk debugging |

4. Pastikan tombol **AutoTrading** di toolbar MT5 dalam keadaan **aktif (hijau)** — tanpa ini EA tidak akan berjalan.
5. Klik **OK**. EA akan langsung mengirim data pertama kali saat dipasang.

### 5️⃣ Verifikasi Data Terkirim

- Buka tab **Experts** atau **Toolbox > Experts** di MT5 untuk melihat log pengiriman. Log sukses ditandai dengan `✅ Webhook sent successfully`.
- Sync manual kapan saja dengan menekan tombol **`s`** saat chart yang berisi EA sedang aktif/fokus.
- Di sisi Laravel, cek apakah trade baru muncul di halaman **Trades** atau **Dashboard**.
- Anda juga bisa memicu sinkronisasi dari sisi aplikasi lewat aksi **Sync MT5** pada akun terkait (route `accounts.sync-mt5`, memanggil `POST /api/mt5/accounts/{account}/sync`).

### 🩺 Troubleshooting EA

| Gejala | Penyebab | Solusi |
|---|---|---|
| Error `4014` di log | URL webhook belum di-whitelist | Tambahkan URL di **Tools > Options > Expert Advisors** |
| Error `1003` (timeout) | Server lambat merespons atau data terlalu besar | Perbesar `TimerInterval`, kurangi `HistoryDays`, atau cek performa server |
| Webhook mengembalikan status selain 200 | `account_id` tidak valid/tidak ditemukan, atau payload ditolak validasi | Pastikan `LaravelAccountId` sesuai ID akun yang benar-benar ada di database |
| EA tidak mengirim sama sekali | AutoTrading nonaktif atau EA gagal di-attach | Aktifkan tombol AutoTrading dan pastikan tidak ada error saat compile |
| Data tidak realtime | `SendOnTimer`/`SendOnTrade` dimatikan, atau interval terlalu besar | Aktifkan keduanya dan kecilkan `TimerInterval` sesuai kebutuhan |

---

## 🧪 Testing

Jalankan test suite untuk memastikan aplikasi berjalan dengan baik:

```bash
php artisan test
```

Atau menggunakan PHPUnit secara langsung:

```bash
vendor/bin/phpunit
```

---

## 🔧 Troubleshooting

### ❌ Masalah Koneksi Database

**Gejala**: Error `SQLSTATE[HY000] [2002] Connection refused`

**Solusi**:

1. Pastikan MySQL/MariaDB berjalan: `sudo systemctl status mysql`
2. Cek kredensial di `.env` sudah benar
3. Buat database terlebih dahulu: `CREATE DATABASE journal_trade;`

### ❌ Asset Tidak Dimuat

**Gejala**: CSS/JS tidak muncul atau error 404

**Solusi**:

```bash
npm run build
php artisan optimize:clear
```

### ❌ Error "Class not found"

**Gejala**: Class tertentu tidak ditemukan setelah `composer update`

**Solusi**:

```bash
composer dump-autoload
```

### ❌ Cache Tidak Terupdate

**Gejala**: Perubahan tidak muncul di aplikasi

**Solusi**: Jalankan perintah berikut:

```bash
php artisan optimize:clear
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### ❌ Error Permission (Linux/Mac)

**Solusi**:

```bash
chmod -R 775 storage bootstrap/cache
chmod -R 775 public
```

---

## 🤝 Kontribusi

Kami sangat terbuka untuk kontribusi dari komunitas! Berikut langkah-langkahnya:

1. **Fork** repository ini
2. **Clone** hasil fork ke lokal:

   ```bash
   git clone https://github.com/username-anda/journal_trade.git
   ```

3. **Buat branch** baru untuk fitur/perbaikan:

   ```bash
   git checkout -b fitur/nama-fitur
   ```

4. **Commit** perubahan dengan pesan jelas:

   ```bash
   git commit -m "Menambahkan fitur X untuk Y"
   ```

5. **Push** ke branch:

   ```bash
   git push origin fitur/nama-fitur
   ```

6. Buat **Pull Request** ke repository utama

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah **MIT License** - lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

---

<div align="center">

<p>Dibuat dengan ❤️ oleh <a href="https://github.com/taufiqjamil47">Taufiq Jamil</a></p>

<p>
<a href="https://github.com/taufiqjamil47/journal_trade/issues">Laporkan Bug</a> •
<a href="https://github.com/taufiqjamil47/journal_trade/issues">Request Fitur</a>
</p>

</div>
