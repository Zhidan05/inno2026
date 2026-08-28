# Panduan Instalasi InnoElectrica Expo 2026 (IEE 2026) ⚡

Panduan ini berisi langkah-langkah detail untuk mengatur dan menjalankan proyek **InnoElectrica Expo 2026** di komputer lokal (Cloner PC).

## Persyaratan Sistem (Prerequisites)
Pastikan komputer Anda sudah terinstal:
- **PHP** >= 8.3
- **Composer** (Package manager untuk PHP)
- **Node.js** & **NPM** (Untuk manajemen aset frontend Tailwind/CSS)
- **MySQL / MariaDB** (atau Anda bisa menggunakan SQLite secara bawaan)
- Web Server lokal seperti **Laragon**, **XAMPP**, atau Laravel Herd.

---

## Langkah Instalasi

### 1. Clone Repository
Clone repositori ini ke dalam folder server lokal Anda (misalnya di dalam `C:\laragon\www\` jika menggunakan Laragon):
```bash
git clone <URL_REPOSITORY_ANDA> inno2026
cd inno2026
```

### 2. Instalasi Dependensi PHP
Instal seluruh package Laravel dan Filament menggunakan Composer:
```bash
composer install
```

### 3. Instalasi Dependensi Node.js
Instal package untuk frontend:
```bash
npm install
```

### 4. Konfigurasi Environment (File .env)
Duplikat file konfigurasi bawaan Laravel:
```bash
cp .env.example .env
```
*(Untuk pengguna Windows CMD/PowerShell, Anda bisa meng-copy paste file `.env.example` secara manual dan mengubah namanya menjadi `.env`)*

Buka file `.env` di text editor (VS Code, dll) dan sesuaikan konfigurasi database.
Jika menggunakan **MySQL**:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inno2026
DB_USERNAME=root
DB_PASSWORD=
```
*(Pastikan Anda sudah membuat database kosong bernama `inno2026` di phpMyAdmin / HeidiSQL)*

### 5. Generate Application Key
Jalankan perintah ini untuk mengamankan enkripsi Laravel:
```bash
php artisan key:generate
```

### 6. Migrasi dan Seeding Database
Langkah ini sangat penting untuk membangun struktur tabel (peserta, kompetisi, nilai) dan memasukkan data awal (akun Super Admin).
```bash
php artisan migrate --seed
```
*Catatan: Seeder akan otomatis membuat 1 akun Super Admin default. Detail login dapat dicek di file `DatabaseSeeder.php` atau `UserSeeder.php`.*

### 7. Tautkan Storage (Storage Link)
Karena proyek ini mengelola upload file (bukti pembayaran, dokumen karya, galeri, logo sponsor), Anda **wajib** menautkan folder storage publik:
```bash
php artisan storage:link
```

### 8. Build Aset Frontend
Kompilasi CSS dan JavaScript (termasuk Filament panel styling):
```bash
npm run build
```

### 9. Jalankan Aplikasi
Jalankan development server Laravel:
```bash
php artisan serve
```

Aplikasi sekarang dapat diakses di browser melalui:
- **Landing Page & Peserta:** `http://localhost:8000`
- **Panel Admin (Super Admin, Moderator, Judge):** `http://localhost:8000/admin`

---

## Troubleshooting Umum
- **Gambar Tidak Muncul:** Pastikan Anda telah menjalankan `php artisan storage:link`.
- **SQL Error saat Migrate:** Pastikan database `inno2026` sudah dibuat di MySQL sebelum menjalankan perintah migrate.
- **Error Vite / CSS Hancur:** Pastikan Anda sudah menjalankan `npm install` dan `npm run build`.

Selamat mencoba! **- Codename: LenFrogg**
