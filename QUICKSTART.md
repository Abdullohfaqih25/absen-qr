# ⚡ Quick Start Guide - AbsenQR

Panduan cepat untuk menjalankan aplikasi dalam 5 menit.

## 🚀 Quick Setup (jika sudah punya project)

### 1. Update Dependencies
```bash
cd c:\xampp\htdocs\AbsenQR
composer install
npm install
```

### 2. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configure Database (.env)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absenqr
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Create Database
```bash
# Buka phpMyAdmin
# Create new database: absenqr
```

### 5. Migrate & Seed
```bash
php artisan migrate
php artisan db:seed
```

### 6. Build Assets
```bash
npm run build
```

### 7. Run Server
```bash
php artisan serve
```

**Done!** Buka: http://localhost:8000

---

## 🔑 Login Sekarang

### Admin
- Email: `admin@sekolah.test`
- Password: `password`

### Guru  
- Email: `budisantoso@guru.absenqr.local`
- Password: `password`

### Siswa
- Email: `2025123@student.absenqr.local` (sesuaikan NIS)
- Password: `password`

---

## 📊 Admin Panel Features

### Dashboard
- Statistik absensi
- Chart minggu ini

### Data Management
- 👥 Kelola Siswa (CRUD)
- 👨‍🏫 Kelola Guru (CRUD)
- 🏫 Kelola Kelas (CRUD)
- 📚 Kelola Jadwal (CRUD)
- 📋 Lihat Absensi (Filter & Export)

---

## ⚙️ Commands Penting

```bash
# Development
npm run dev                 # Hot reload CSS/JS
php artisan serve          # Start server

# Database
php artisan migrate        # Run migrations
php artisan migrate:fresh  # Reset database
php artisan db:seed        # Populate with demo data
php artisan tinker         # Interactive PHP shell

# Cache & Clearing
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# Testing
php artisan test
```

---

## 🎯 Workflow

1. **Login** di http://localhost:8000/login
2. **Dashboard** - Lihat statistik
3. **Data Siswa** - Manage siswa
4. **Data Guru** - Manage guru
5. **Kelas** - Manage kelas
6. **Jadwal** - Manage jadwal
7. **Absensi** - Lihat & export

---

## 🐛 Common Issues & Quick Fixes

| Issue | Solution |
|-------|----------|
| Database Error | `php artisan migrate:fresh && php artisan db:seed` |
| Login Failed | Pastikan database di-seed |
| Assets Not Loading | `npm run build` |
| Port 8000 Taken | `php artisan serve --port=8001` |
| Permission Denied | Run terminal as Administrator |

---

## 📱 Responsive Design

✅ Desktop - Full featured
✅ Tablet - Optimized layout  
✅ Mobile - Mobile-friendly navigation

---

## 🔐 First Time Admin Setup

1. Login dengan `admin@sekolah.test`
2. Ganti password di profile (future feature)
3. Tambah data siswa, guru, kelas
4. Setup jadwal pelajaran
5. Guru mulai generate QR code

---

## 📞 Support

- Check `README.md` untuk dokumentasi lengkap
- Check `INSTALLATION.md` untuk setup detail
- Check `CHANGES_SUMMARY.md` untuk perubahan yang dilakukan

---

**Happy Learning! 🎓**

*Last Updated: November 28, 2025*
