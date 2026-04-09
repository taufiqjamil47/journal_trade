# 📊 Trading Journal

Aplikasi Trading Journal yang komprehensif untuk mencatat, menganalisis, dan mengelola catatan trading secara profesional. Platform ini dirancang khusus untuk trader yang ingin melacak performa trading mereka dengan detail dan akurat.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-646CFF?style=flat-square&logo=vite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-blue?style=flat-square)

---

## 🎯 Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Stack Teknologi](#stack-teknologi)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi Cepat](#instalasi-cepat)
- [Struktur Proyek](#struktur-proyek)
- [Impor & Ekspor Data](#impor--ekspor-data)
- [Schema Database](#schema-database)
- [API Endpoints](#api-endpoints)
- [Testing](#testing)
- [Panduan Penggunaan](#panduan-penggunaan)
- [Troubleshooting](#troubleshooting)
- [Berkontribusi](#berkontribusi)
- [Lisensi](#lisensi)
- [Kontak & Dukungan](#kontak--dukungan)

---

## ✨ Fitur Utama

- ✅ **Pencatatan Trade** - Catat setiap transaksi trading dengan detail lengkap (entry, exit, profit/loss, dll)
- 📊 **Analisis Performa** - Dashboard analytics untuk menampilkan statistik trading (win rate, ROI, average profit/loss, dll)
- 📤 **Impor/Ekspor Data** - Import dari Excel/CSV dan ekspor laporan dalam berbagai format
- 💼 **Manajemen Multi Akun** - Kelola multiple trading accounts sekaligus
- 🏷️ **Manajemen Simbol** - Organize trading symbols/instrumen dengan kategori
- 📈 **Tracking Progress** - Monitor perkembangan trading sepanjang waktu
- 🔍 **Filtering & Sorting** - Cari dan filter trade berdasarkan berbagai kriteria
- 📱 **Responsive Design** - Akses dari desktop maupun mobile device

---

## 🛠️ Stack Teknologi

| Komponen | Teknologi |
|----------|-----------|
| **Backend** | PHP 8.1+, Laravel Framework |
| **Database** | MySQL / MariaDB |
| **Frontend** | Blade Template, Tailwind CSS (assumed), Vite |
| **Package Manager** | Composer (PHP), npm/yarn (Node.js) |
| **Build Tool** | Vite |
| **Testing** | PHPUnit, Laravel Testing |

---

## 📋 Persyaratan Sistem

### Keharusan
- **PHP 8.1+** dengan ekstensi: PDO, mbstring, OpenSSL, JSON, Tokenizer, BCMath, Ctype, Fileinfo
- **Composer** (versi terbaru)
- **Node.js 16+** & npm/yarn
- **MySQL 5.7+** atau **MariaDB 10.2+**
- **Git** (untuk clone repository)

### Opsional
- **XAMPP** (Windows) atau **LAMP/LEMP stack** (Linux)
- **Docker** (untuk development containerized)
- **IDE**: VS Code, PHPStorm, atau editor favorit Anda

---

## 🚀 Instalasi Cepat

### Langkah 1: Clone Repository

```powershell
git clone https://github.com/taufiqjamil47/journal_trade.git
cd journal_trade
```

### Langkah 2: Install Dependencies PHP

```powershell
composer install
```

### Langkah 3: Install Dependencies JavaScript

```powershell
npm install
```

### Langkah 4: Setup Environment

```powershell
copy .env.example .env
php artisan key:generate
```

### Langkah 5: Konfigurasi Database

Edit file `.env` dan atur kredensial database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=journal_trade
DB_USERNAME=root
DB_PASSWORD=
```

**Catatan:** Pastikan database sudah dibuat di MySQL terlebih dahulu:
```sql
CREATE DATABASE journal_trade;
```

### Langkah 6: Jalankan Migrasi Database

```powershell
php artisan migrate
php artisan db:seed
```

### Langkah 7: Setup Storage (Opsional)

```powershell
php artisan storage:link
```

### Langkah 8: Build Assets

**Mode Development:**
```powershell
npm run dev
```

**Mode Production:**
```powershell
npm run build
```

### Langkah 9: Jalankan Aplikasi

```powershell
php artisan serve
```

Akses aplikasi di: **http://127.0.0.1:8000**

---

## 📁 Struktur Proyek

```
journal_trade/
├── app/
│   ├── Models/              # Model Eloquent (Trade, Account, Symbol, dll)
│   ├── Http/
│   │   ├── Controllers/     # Request handlers
│   │   └── Requests/        # Form validation
│   ├── Imports/             # Logic untuk import data (maatwebsite/excel)
│   ├── Exports/             # Logic untuk export data
│   └── Services/            # Business logic & utilities
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                 # Stylesheet (Tailwind, dll)
│   └── js/                  # JavaScript files
├── database/
│   ├── migrations/          # Database schema
│   ├── seeders/             # Sample data
│   └── factories/            # Model factories untuk testing
├── public/                  # Publicly accessible files
├── storage/                 # File uploads & cache
├── routes/                  # Route definitions (web.php, api.php)
├── config/                  # Configuration files
├── tests/                   # Unit & Feature tests
├── .env.example             # Environment template
├── composer.json            # PHP dependencies
├── package.json             # Node.js dependencies
└── README.md                # Dokumentasi ini
```

---

## 📤 Impor & Ekspor Data

### Import Trade Data

Fitur impor memungkinkan Anda memasukkan data trading dari file Excel/CSV:

**File Kunci:** `app/Imports/TradesImport.php`

**Cara Menggunakan:**
1. Siapkan file Excel dengan kolom: Date, Entry Price, Exit Price, Quantity, Profit/Loss, Symbol, Account, dll
2. Login ke aplikasi
3. Navigasi ke halaman Import
4. Upload file Excel
5. Sistem akan memvalidasi dan insert data ke database

**Persyaratan Format File:**
- Extension: `.xlsx`, `.xls`, atau `.csv`
- Header kolom harus sesuai dengan schema Trade
- Data tidak boleh kosong

### Export Trade Data

**File Kunci:** `app/Exports/TradesExport.php`

**Fitur Export:**
- Export semua trade atau filter tertentu
- Format: Excel (.xlsx) atau CSV
- Include statistik summary (Win Rate, Total P&L, ROI, dll)
- Format profesional untuk laporan

**Cara Menggunakan:**
1. Login ke aplikasi
2. Navigasi ke Trade List
3. Klik tombol "Export"
4. Pilih format dan filter
5. File akan otomatis download

---

## 🗄️ Schema Database

### Tabel Utama

#### 1. **trades** - Catatan setiap trade
```sql
CREATE TABLE trades (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    account_id BIGINT NOT NULL,
    symbol_id BIGINT NOT NULL,
    entry_price DECIMAL(15, 4) NOT NULL,
    exit_price DECIMAL(15, 4),
    quantity DECIMAL(15, 8) NOT NULL,
    entry_date TIMESTAMP NOT NULL,
    exit_date TIMESTAMP,
    profit_loss DECIMAL(15, 4),
    commission DECIMAL(15, 4),
    notes TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (account_id) REFERENCES accounts(id),
    FOREIGN KEY (symbol_id) REFERENCES symbols(id)
);
```

#### 2. **accounts** - Data akun trading
```sql
CREATE TABLE accounts (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    balance DECIMAL(15, 4) NOT NULL,
    broker VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

#### 3. **symbols** - Instrumen/aset trading
```sql
CREATE TABLE symbols (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    type VARCHAR(50), -- stock, forex, crypto, commodity
    description TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

**Relasi ERD:**
```
users (1) ──── (N) accounts
           └── (N) trades ── (N) symbols
```

---

## 🔌 API Endpoints

Aplikasi menyediakan API endpoints untuk integrasi:

### Trades
- `GET /api/trades` - Dapatkan semua trade
- `GET /api/trades/{id}` - Dapatkan detail trade
- `POST /api/trades` - Buat trade baru
- `PUT /api/trades/{id}` - Update trade
- `DELETE /api/trades/{id}` - Hapus trade

### Accounts
- `GET /api/accounts` - Dapatkan semua akun
- `POST /api/accounts` - Buat akun baru
- `GET /api/accounts/{id}/stats` - Dapatkan statistik akun

### Analytics
- `GET /api/analytics/summary` - Ringkasan performa
- `GET /api/analytics/monthly` - Data analytics per bulan

**Contoh Request:**
```bash
curl -H "Authorization: Bearer {token}" \
     http://127.0.0.1:8000/api/trades
```

---

## 🧪 Testing

### Jalankan Test

```powershell
php artisan test
```

Atau gunakan PHPUnit langsung:

```powershell
vendor/bin/phpunit
```

### Struktur Test

```
tests/
├── Unit/              # Unit tests untuk functions, classes
├── Feature/           # Feature tests untuk API endpoints
└── TestCase.php       # Base test class
```

### Contoh Test

```php
public function test_user_can_create_trade()
{
    $response = $this->post('/api/trades', [
        'entry_price' => 100,
        'exit_price' => 110,
        'quantity' => 1,
        'symbol_id' => 1,
    ]);
    
    $response->assertStatus(201);
}
```

---

## 📖 Panduan Penggunaan

### 1. Login & Setup Awal
- Buka `http://127.0.0.1:8000` di browser
- Login dengan akun Anda (atau register jika baru)
- Buat akun trading baru

### 2. Input Trade Manual
- Navigasi ke **Trade > Tambah Trade**
- Isi form: Symbol, Entry Price, Exit Price, Quantity, dll
- Klik **Simpan**

### 3. Import Data Bulk
- Siapkan file Excel dengan format yang benar
- Navigasi ke **Import > Trade**
- Upload file
- Review dan konfirmasi

### 4. Lihat Analytics
- Dashboard menampilkan statistik real-time
- Filtering berdasarkan periode, akun, symbol
- Export laporan untuk kebutuhan analisis lebih lanjut

---

## ⚠️ Troubleshooting

### ❌ Error: "SQLSTATE[HY000] [2002] Connection refused"

**Penyebab:** Database tidak berjalan atau kredensial salah

**Solusi:**
1. Pastikan MySQL/MariaDB service berjalan
2. Verifikasi konfigurasi di `.env` (DB_HOST, DB_USERNAME, DB_PASSWORD)
3. Pastikan database `journal_trade` sudah dibuat:
   ```sql
   CREATE DATABASE journal_trade;
   ```

### ❌ Error: "Class 'Maatwebsite\Excel\Excel' not found"

**Penyebab:** Package Excel tidak terinstall

**Solusi:**
```powershell
composer require maatwebsite/excel
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
```

### ❌ Error: Npm modules not found

**Penyebab:** Dependencies npm belum diinstall

**Solusi:**
```powershell
npm install
npm run dev
```

### ❌ Error: "Unable to locate factory"

**Penyebab:** Model factory belum dibuat

**Solusi:**
```powershell
php artisan make:factory TradeFactory --model=Trade
```

### ❌ Asset tidak terupdate

**Solusi:**
```powershell
npm run dev
php artisan cache:clear
php artisan config:clear
```

### ✅ Clear Cache & Optimize

```powershell
php artisan optimize:clear
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

---

## 🤝 Berkontribusi

Kami menyambut kontribusi dari komunitas! Berikut langkah-langkahnya:

### 1. Fork Repository
Klik tombol **Fork** di halaman repository

### 2. Clone Repositori Lokal Anda
```powershell
git clone https://github.com/YOUR_USERNAME/journal_trade.git
cd journal_trade
```

### 3. Buat Branch Fitur
```powershell
git checkout -b feature/nama-fitur-baru
```

**Konvensi naming:**
- `feature/add-export-pdf` - Untuk fitur baru
- `fix/bug-import-validation` - Untuk bug fixes
- `docs/update-readme` - Untuk dokumentasi
- `refactor/optimize-queries` - Untuk refactoring

### 4. Commit Perubahan
```powershell
git add .
git commit -m "Add: deskripsi perubahan yang jelas"
```

**Konvensi commit message:**
- `Add:` untuk fitur baru
- `Fix:` untuk bug fixes
- `Docs:` untuk dokumentasi
- `Refactor:` untuk perubahan kode
- `Test:` untuk test cases

### 5. Push ke Remote
```powershell
git push origin feature/nama-fitur-baru
```

### 6. Buat Pull Request
- Buka GitHub dan klik **"Compare & Pull Request"**
- Isi template PR dengan detail perubahan
- Tunggu review dari maintainer

### Coding Standards
- Ikuti PSR-12 untuk PHP code style
- Gunakan meaningful variable names
- Tambahkan comments untuk logika kompleks
- Pastikan code sudah ditest

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah **MIT License** - silakan lihat file [LICENSE](LICENSE) untuk detail lengkap.

---

## 📞 Kontak & Dukungan

### Butuh Bantuan?

1. **Cek Documentation** - Baca bagian Troubleshooting di atas
2. **Buka Issue** - [Buat issue baru](https://github.com/taufiqjamil47/journal_trade/issues/new)
3. **Hubungi Maintainer** - Kontak via GitHub discussions

### Info Penting
- **Repository:** https://github.com/taufiqjamil47/journal_trade
- **Issue Tracker:** https://github.com/taufiqjamil47/journal_trade/issues
- **Discussions:** https://github.com/taufiqjamil47/journal_trade/discussions

---

## 🎉 Credits

Terima kasih kepada:
- **Laravel Framework** - Web framework yang powerful
- **Maatwebsite Excel** - Library untuk impor/ekspor
- **Vite** - Build tool modern
- **Kontributor** - Semua yang telah berkontribusi

---

**Happy Trading! 📈**