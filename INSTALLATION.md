# 📚 Panduan Instalasi AbsenQR

Dokumen lengkap untuk instalasi dan konfigurasi aplikasi AbsenQR.

## ✅ Prerequisites

Pastikan komputer Anda sudah memiliki:
- **XAMPP** (dengan PHP 8.1+, MySQL, Apache)
- **Composer** (https://getcomposer.org/download/)
- **Node.js & npm** (https://nodejs.org/)
- **Git** (opsional, untuk clone repo)

### Cek versi:
```bash
php -v           # Minimal PHP 8.1
composer --version
node -v
npm -v
```

## 🚀 Langkah-langkah Instalasi

### 1️⃣ Download/Clone Project

**Opsi A: Clone dengan Git**
```bash
cd c:\xampp\htdocs
git clone <repository-url> AbsenQR
cd AbsenQR
```

**Opsi B: Manual Download**
- Download project sebagai ZIP
- Extract ke `c:\xampp\htdocs\AbsenQR`
- Buka terminal di folder tersebut

### 2️⃣ Install PHP Dependencies

```bash
composer install
```

Jika ada error, coba:
```bash
composer install --no-scripts
php artisan package:discover
```

### 3️⃣ Install Node Dependencies

```bash
npm install
```

### 4️⃣ Konfigurasi Environment

Copy file environment template:
```bash
cp .env.example .env
```

**Atau manual:**
- Buka folder project dengan File Explorer
- Copy file `.env.example`
- Rename copy menjadi `.env`

Generate Laravel key:
```bash
php artisan key:generate
```

### 5️⃣ Setup Database

**Membuat Database:**
1. Buka phpMyAdmin: http://localhost/phpmyadmin
2. Klik "New" di sebelah kiri
3. Buat database baru:
   - Database name: `absenqr`
   - Collation: `utf8mb4_unicode_ci`
   - Klik "Create"

**Konfigurasi di `.env`:**
Edit file `.env` bagian database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absenqr
DB_USERNAME=root
DB_PASSWORD=
```

### 6️⃣ Jalankan Database Migration

```bash
php artisan migrate
```

Jika berhasil, akan melihat output migration yang dijalankan.

### 7️⃣ Seed Database dengan Data Demo

```bash
php artisan db:seed
```

Data yang di-seed:
- 1 Admin user
- 3 Kelas (X IPA 1, X IPA 2, X IPS 1)
- 55 Siswa dengan user account
- 3 Guru dengan user account
- QR Tokens untuk setiap guru

### 8️⃣ Build Frontend Assets

```bash
npm run build
```

Untuk development dengan hot reload:
```bash
npm run dev
```

### 9️⃣ Jalankan Application Server

```bash
php artisan serve
```

Server akan berjalan di: **http://localhost:8000**

⚠️ **PENTING:** Pastikan XAMPP sudah running (Apache dan MySQL)

## 🔑 Login Credentials

Gunakan akun berikut untuk testing:

### Admin Panel
```
Email: admin@sekolah.test
Password: password
```

### Guru Panel
```
Email: budisantoso@guru.absenqr.local
Email: sitinurhaliza@guru.absenqr.local  
Email: ahmarhidayat@guru.absenqr.local
Password: password (semua)
```

### Siswa Panel
```
Email: {NIS}@student.absenqr.local
Password: password

Contoh:
Email: 2025123@student.absenqr.local
Password: password
```

## 📊 Struktur File Penting

```
AbsenQR/
├── .env                    ← Konfigurasi aplikasi
├── app/
│   └── Http/Controllers/   ← Business logic
├── resources/views/        ← Template HTML
├── routes/web.php          ← Routing
├── database/
│   └── migrations/         ← Database schema
└── public/                 ← Public assets
```

## 🐛 Troubleshooting

### ❌ Error: "SQLSTATE[HY000]: General error"
**Solusi:**
```bash
php artisan migrate:fresh
php artisan db:seed
php artisan cache:clear
```

### ❌ Error: "No application encryption key has been specified"
**Solusi:**
```bash
php artisan key:generate
```

### ❌ Error: "Class not found"
**Solusi:**
```bash
composer dump-autoload
php artisan clear-compiled
```

### ❌ Assets tidak muncul (CSS/JS)
**Solusi:**
```bash
npm run build
php artisan view:clear
```

### ❌ Permission Denied pada storage folder
**Solusi (Windows Command Prompt as Admin):**
```bash
icacls "c:\xampp\htdocs\AbsenQR\storage" /grant Everyone:F /T
icacls "c:\xampp\htdocs\AbsenQR\bootstrap\cache" /grant Everyone:F /T
```

### ❌ XAMPP MySQL tidak berjalan
1. Buka XAMPP Control Panel
2. Klik "Start" pada MySQL
3. Pastikan tidak ada port conflict

### ❌ Port 8000 sudah terpakai
```bash
php artisan serve --port=8001
# atau
php artisan serve --host=0.0.0.0 --port=9000
```

## ✨ Verifikasi Instalasi

Setelah setup selesai, cek beberapa endpoint:

- ✅ http://localhost:8000 - Redirect ke login
- ✅ http://localhost:8000/login - Login page
- ✅ http://localhost:8000/admin/dashboard - Admin dashboard (after login)

## 🔒 Security Tips

1. **Change default credentials:**
   - Login sebagai admin
   - Ganti password yang lebih secure

2. **Update `.env` untuk production:**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

3. **Set proper folder permissions:**
   ```bash
   chmod 755 public/
   chmod -R 755 bootstrap/cache/
   chmod -R 755 storage/
   ```

## 📚 Dokumentasi Tambahan

- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap Documentation](https://getbootstrap.com/docs)
- [MySQL Documentation](https://dev.mysql.com/doc/)

## ✅ Checklist Setup

- [ ] XAMPP running (Apache + MySQL)
- [ ] PHP version >= 8.1
- [ ] Composer installed
- [ ] Node.js installed
- [ ] Project downloaded/cloned
- [ ] composer install selesai
- [ ] npm install selesai
- [ ] .env configured
- [ ] Database created
- [ ] php artisan migrate selesai
- [ ] php artisan db:seed selesai
- [ ] npm run build selesai
- [ ] php artisan serve running
- [ ] Login berhasil dengan test credentials

---

**Jika ada pertanyaan atau masalah, silakan buat issue di repository.**

Last Updated: November 28, 2025
