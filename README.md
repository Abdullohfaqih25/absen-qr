# AbsenQR - Sistem Absensi dengan QR Code

Aplikasi web untuk sistem manajemen absensi siswa menggunakan QR Code dengan Laravel dan Bootstrap.

## ✅ Fitur Utama

### Admin Panel
- 📊 Dashboard dengan statistik absensi real-time
- 👥 Manajemen data siswa (CRUD lengkap)
- 👨‍🏫 Manajemen data guru (CRUD lengkap)  
- 🏫 Manajemen kelas (CRUD lengkap)
- 📚 Manajemen jadwal pelajaran (CRUD lengkap)
- 📋 Laporan absensi dengan filter (tanggal, kelas, NIS)
- 📊 Export absensi ke Excel

### Guru Panel
- 🔐 Generate QR Code harian
- 🔄 Regenerate QR Code
- 👀 Real-time list absensi

### Siswa
- 📱 Scan QR Code untuk absensi
- ✅ Status absensi (Hadir/Terlambat)

## 📋 Requirements

- PHP >= 8.1
- Laravel 11
- MySQL/MariaDB 5.7+
- Composer
- Node.js & npm

## 🚀 Instalasi & Setup

### 1. Clone Repository
```bash
cd c:\xampp\htdocs
git clone <repo-url> AbsenQR
cd AbsenQR
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` untuk konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absenqr
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Migration & Seeding
```bash
php artisan migrate
php artisan db:seed
```

### 5. Build Assets
```bash
npm run build
```

### 6. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi: **http://localhost:8000**

## 🔑 Kredensial Login

Setelah menjalankan seeder, gunakan kredensial berikut:

### Admin
- Email: `admin@sekolah.test`
- Password: `password`

### Guru
- Email: `budisantoso@guru.absenqr.local`
- Password: `password`

### Siswa
- Email: `{nis}@student.absenqr.local` (misal: 2025001@student.absenqr.local)
- Password: `password`

## 📁 Struktur Project

```
AbsenQR/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers
│   │   │   ├── Guru/           # Guru controllers
│   │   │   ├── Siswa/          # Siswa controllers
│   │   │   └── Auth/           # Authentication
│   │   ├── Middleware/         # Custom middleware
│   │   └── Kernel.php
│   ├── Models/                 # Eloquent models
│   ├── Exports/                # Excel exports
│   └── Providers/
├── resources/
│   ├── views/
│   │   ├── admin/              # Admin dashboard views
│   │   ├── auth/               # Login views
│   │   ├── components/         # Reusable components
│   │   ├── layouts/            # Layout templates
│   │   └── welcome.blade.php
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php                 # Web routes
│   ├── api.php                 # API routes
│   └── auth.php                # Auth routes
├── database/
│   ├── migrations/             # Database migrations
│   ├── seeders/                # Database seeders
│   └── factories/              # Model factories
└── storage/
```

## 🔧 Troubleshooting

### Database Error
```bash
# Reset database dan jalankan seeder ulang
php artisan migrate:fresh
php artisan db:seed
```

### Asset Not Loading
```bash
npm run build
php artisan view:clear
php artisan cache:clear
```

### Permission Denied
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Login Error
- Pastikan database sudah di-seed: `php artisan db:seed`
- Clear cache: `php artisan cache:clear`
- Cek `.env` database configuration

## 📊 Models

- **User** - Pengguna (Admin, Guru, Siswa)
- **Student** - Data siswa
- **Teacher** - Data guru
- **Kelas** - Data kelas
- **Schedule** - Jadwal pelajaran
- **Attendance** - Absensi
- **QrToken** - Token QR harian

## 🔐 Autentikasi & Autorisasi

- Menggunakan Laravel Auth dengan middleware role
- Role-based access control (RBAC):
  - **admin** - Akses admin panel
  - **guru** - Akses guru panel
  - **siswa** - Akses siswa panel

## 💾 Database

### Users Table
```sql
- id, name, email, password, role, related_id, remember_token, created_at, updated_at
```

### Students Table
```sql
- id, nis (unique), name, email, kelas_id, photo, created_at, updated_at
```

### Teachers Table
```sql
- id, nip (unique), name, email, created_at, updated_at
```

### Kelas Table
```sql
- id, name, room, created_at, updated_at
```

### Schedules Table
```sql
- id, kelas_id, teacher_id, subject, day, start_time, end_time, created_at, updated_at
```

### Attendances Table
```sql
- id, student_id, absent_at, status, device, ip, lat, lng, token, created_at, updated_at
```

## 🎨 UI Framework

- Bootstrap 5.3.0
- FontAwesome 6.4.0
- DataTables 1.13.4
- SweetAlert2
- Chart.js

## 📝 License

MIT License - Lihat file LICENSE untuk detail.

## 👨‍💻 Support

Untuk pertanyaan atau issues, silakan buat issue di repository ini.

---

**Last Updated:** November 28, 2025
