# AbsenQR - Sistem Absensi dengan QR Code

Aplikasi web untuk sistem manajemen absensi siswa menggunakan QR Code dengan Laravel 11, Bootstrap 5, dan MySQL.

## ✅ Fitur Utama

### Admin Panel
- 📊 Dashboard dengan statistik absensi real-time (7 hari terakhir)
- 👥 Manajemen data siswa (CRUD lengkap)
- 👨‍🏫 Manajemen data guru (CRUD lengkap)  
- 🏫 Manajemen kelas (CRUD lengkap)
- 📚 Manajemen jadwal pelajaran & template mingguan
- 📋 Laporan absensi dengan filter (tanggal, kelas, NIS, guru)
- 📊 Export absensi ke Excel
- 📅 Manajemen template hari & minggu untuk jadwal fleksibel

### Guru Panel
- 📅 Lihat jadwal pelajaran hari ini dengan durasi & kelas
- 🔐 Generate & regenerate QR Code harian (unique per guru per tanggal)
- ✅ Konfirmasi kehadiran atau ketidakhadiran hari ini
- 👀 Real-time monitoring absensi siswa (filter berdasarkan teacher_id dari token)
- 📊 Statistik absensi (total hadir & terlambat)
- 🎨 Dashboard dengan aksi cepat (Lihat QR, Realtime Absensi)

### Siswa Panel
- 📱 Scan QR Code untuk absensi otomatis
- ⌨️ Input manual dengan NIS + Token jika scanner tidak tersedia
- ✅ Status absensi otomatis (Hadir/Terlambat) berdasarkan waktu setelah jam 07:15
- 📅 Lihat jadwal pelajaran hari ini dengan nama guru & kelas
- 👨‍🏫 Tampil "Guru tidak tersedia" jika guru mengkonfirmasi ketidakhadiran
- 📊 Tracking kehadiran & statistik personal
- 🗓️ Lihat jadwal mingguan dari template atau tabel jadwal

## 🔑 Fitur Advanced

### 1. Sistem QR Token per Guru per Tanggal
- Setiap guru dapat generate QR token unik untuk setiap hari
- QR token otomatis terasosiasi dengan `teacher_id`
- Absensi siswa melalui token automatically deroute ke guru pemilik token
- Realtime monitoring hanya menampilkan absensi siswa dari token milik guru yang login

### 2. Teacher Availability System
- Guru dapat confirm kehadiran/ketidakhadiran hari ini
- Disimpan di tabel `teacher_availabilities` dengan unique constraint (teacher_id, date)
- Siswa akan melihat "Guru tidak tersedia" jika guru mark `is_absent=true`
- Real-time update pada dashboard siswa

### 3. Multi-Source Schedule System
- **Primary:** WeekTemplate → WeekTemplateDay → DayTemplate → DaySlot (flexible template-based)
- **Fallback:** Schedule table (direct week_type + day + time)
- Controller auto-detect & prioritize template system
- Support alternatif scheduling dengan week_type (1 atau 2)

### 4. Role-Based Access Control (RBAC)
- Three roles: admin, guru, siswa
- Middleware protection pada routes
- Setiap role memiliki dashboard & fitur terpisah

### 5. Real-time Attendance Monitoring
- Guru melihat absensi masuk real-time untuk siswa yang scan token miliknya
- Auto-filtering berdasarkan `teacher_id` & `qr_token_id`
- Menampilkan data siswa dengan kelas

## 📋 Requirements

- PHP >= 8.2.12
- Laravel 11
- MySQL/MariaDB 5.7+
- Composer
- Node.js & npm
- Tailwind CSS 3

## 🚀 Instalasi & Setup

### 1. Clone Repository
```bash
cd c:\xampp\htdocs
git clone <repo-url> absen-qr
cd absen-qr
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
DB_DATABASE=absen_qr
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Migration & Seeding
```bash
php artisan migrate --seed
```

### 5. Build Assets
```bash
npm run build
# atau untuk development dengan auto-reload:
npm run dev
```

### 6. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi: **http://localhost:8000**

## 🔑 Kredensial Login Default

Setelah menjalankan seeder, gunakan kredensial berikut:

### Admin
- Email: `admin@sekolah.test`
- Password: `password`

### Guru (Contoh)
- Email: `budisantoso@guru.absenqr.local`
- Password: `password`
- Email: `sitinuthaliza@guru.absenqr.local`
- Password: `password`
- Email: `ahmdhidayat@guru.absenqr.local`
- Password: `password`

### Siswa
- Email: `{NIS}@student.absenqr.local` (contoh: `0074393733@student.absenqr.local`)
- Password: `password`

## 📁 Struktur Project

```
absen-qr/
├── app/
│   ├── Console/
│   │   └── Kernel.php                 # Console commands
│   ├── Exports/
│   │   ├── AttendancesExports.php    # Excel export untuk absensi
│   │   └── StudentsExports.php       # Excel export untuk siswa
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                # Admin controllers (Dashboard, CRUD)
│   │   │   ├── Guru/                 # Guru controllers
│   │   │   │   ├── DashboardController.php    # Dashboard dengan jadwal
│   │   │   │   ├── QRController.php           # Generate & manage QR token
│   │   │   │   ├── AvailabilityController.php # Toggle availability
│   │   │   │   └── ...
│   │   │   └── Siswa/                # Siswa controllers
│   │   │       ├── DashboardController.php    # Dashboard siswa
│   │   │       ├── ScanController.php         # Handle QR scan & manual input
│   │   │       └── ...
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Student.php
│   │   ├── Teacher.php
│   │   ├── Kelas.php
│   │   ├── Mapel.php
│   │   ├── Schedule.php
│   │   ├── Attendance.php
│   │   ├── QrToken.php
│   │   ├── TeacherAvailability.php   # NEW - Teacher absence tracking
│   │   ├── WeekTemplate.php
│   │   ├── WeekTemplateDay.php
│   │   ├── DayTemplate.php
│   │   └── DaySlot.php
│   └── Providers/
├── bootstrap/
│   ├── app.php                        # Service provider & middleware
│   └── providers.php                  # Application providers
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   │   ├── 2025_11_27_073206_create_users_table.php
│   │   ├── 2025_11_27_073237_create_kelas_table.php
│   │   ├── 2025_11_27_073337_create_students_table.php
│   │   ├── 2025_11_27_073413_create_teachers_table.php
│   │   ├── 2025_11_27_073454_create_schedules_table.php
│   │   ├── 2025_11_27_073525_create_attendances_table.php
│   │   ├── 2025_11_27_073608_create_qr_tokens_table.php
│   │   ├── 2025_12_01_000000_create_teacher_availabilities_table.php  # NEW
│   │   ├── 2025_12_01_010000_add_teacher_id_to_attendances.php       # NEW
│   │   └── ...
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/
│       ├── guru/
│       │   ├── dashboard/
│       │   ├── qr/
│       │   └── ...
│       ├── siswa/
│       │   ├── dashboard/
│       │   ├── scan/
│       │   └── ...
│       ├── auth/
│       ├── layouts/
│       └── components/
├── routes/
│   ├── web.php
│   ├── auth.php
│   └── console.php
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
└── phpunit.xml
```

## 🗄️ Database Schema

### Users Table
```sql
CREATE TABLE users (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'guru', 'siswa') NOT NULL,
  related_id BIGINT UNSIGNED NULLABLE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);
```

### Students Table
```sql
CREATE TABLE students (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nis VARCHAR(50) UNIQUE NOT NULL,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NULLABLE,
  kelas_id BIGINT UNSIGNED NOT NULL,
  photo VARCHAR(255) NULLABLE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE
);
```

### Teachers Table
```sql
CREATE TABLE teachers (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nip VARCHAR(50) UNIQUE NOT NULL,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NULLABLE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL
);
```

### Attendances Table
```sql
CREATE TABLE attendances (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  student_id BIGINT UNSIGNED NOT NULL,
  teacher_id BIGINT UNSIGNED NULLABLE,          -- NEW: Links to token owner
  absent_at TIMESTAMP NOT NULL,
  status ENUM('Hadir', 'Terlambat', 'Absen') DEFAULT 'Hadir',
  device VARCHAR(255) NULLABLE,
  ip VARCHAR(50) NULLABLE,
  lat DECIMAL(10,8) NULLABLE,
  lng DECIMAL(11,8) NULLABLE,
  token VARCHAR(255) NULLABLE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL
);
```

### QrTokens Table
```sql
CREATE TABLE qr_tokens (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  teacher_id BIGINT UNSIGNED NOT NULL,
  token VARCHAR(255) UNIQUE NOT NULL,
  date DATE NOT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  UNIQUE KEY unique_teacher_date (teacher_id, date),
  FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE
);
```

### TeacherAvailabilities Table (NEW)
```sql
CREATE TABLE teacher_availabilities (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  teacher_id BIGINT UNSIGNED NOT NULL,
  date DATE NOT NULL,
  is_absent BOOLEAN DEFAULT FALSE,
  note TEXT NULLABLE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  UNIQUE KEY unique_teacher_date (teacher_id, date),
  FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE
);
```

### Schedules Table
```sql
CREATE TABLE schedules (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  kelas_id BIGINT UNSIGNED NOT NULL,
  teacher_id BIGINT UNSIGNED NOT NULL,
  mapel_id BIGINT UNSIGNED NULLABLE,
  subject VARCHAR(255) NULLABLE,
  day VARCHAR(20) NOT NULL,  -- Monday, Tuesday, ... (English format)
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  week_type TINYINT DEFAULT 1,  -- 1 atau 2
  room VARCHAR(50) NULLABLE,
  topic VARCHAR(255) NULLABLE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE,
  FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
  FOREIGN KEY (mapel_id) REFERENCES mapels(id) ON DELETE SET NULL
);
```

### WeekTemplates & Related Tables
- **WeekTemplates**: Define flexible weekly schedules per kelas
- **WeekTemplateDays**: Map day names to DayTemplates
- **DayTemplates**: Define slot patterns for days
- **DaySlots**: Individual time slots with mapel & teacher

## 🏗️ Architecture & System Flow

### Authentication Flow
```
User Login → Verify role & credentials → Redirect to role dashboard
  - Admin → /admin/dashboard
  - Guru → /guru/dashboard
  - Siswa → /siswa/dashboard
```

### QR Attendance Flow
```
[GURU]
1. Login → Dashboard Guru
2. Click "Lihat QR" → Generate/fetch QR token for today
3. Display QR code (unique per guru per date)
4. Share QR to students

[SISWA]
1. Scan QR or input manual (NIS + Token)
2. POST /siswa/scan with {nis, token}
3. Server validates:
   - NIS exists
   - Token matches QrToken for today
   - No duplicate attendance for student today
4. Extract teacher_id from QrToken owner
5. Create Attendance record with teacher_id
6. Calculate status: time > 07:15 → "Terlambat", else "Hadir"
7. Return JSON success

[GURU - REALTIME]
1. Click "Realtime Absensi"
2. View attendance filtered by teacher_id (logged-in guru only)
3. See real-time list of students who scanned
```

### Teacher Availability Flow
```
1. Guru toggle "Tidak Masuk" at dashboard
2. Create/update TeacherAvailability record (teacher_id, date, is_absent=true)
3. Siswa dashboard detects is_absent=true
4. Display "Guru tidak tersedia" instead of teacher name
```

### Schedule Display Logic
```
Get today's schedule:
  1. Check current week_type
  2. Try WeekTemplate:
     - Find WeekTemplate for kelas & week_type
     - Get WeekTemplateDay for current day
     - Fetch DayTemplate → DaySlots (slots with mapel & teacher)
  3. Fallback to Schedule table:
     - Query Schedule where day=current & week_type=current
  4. Merge results, sort by start_time
  5. For each slot: if teacher.is_absent=true → "Guru tidak tersedia"
```

## 🔧 Key Controllers

### Guru/DashboardController
- Display QR token & attendance count
- Display today's schedule (from WeekTemplate + Schedule)
- Show teacher availability status

### Guru/QRController
- `showToday()` - Display QR code
- `regenerate()` - Generate new token
- `realtimeList()` - Filter attendance by teacher_id

### Guru/AvailabilityController
- `toggle()` - Create/update TeacherAvailability

### Siswa/ScanController
- Validate NIS & token
- Extract teacher_id from QrToken
- Create Attendance with teacher_id
- Return status (Hadir/Terlambat)

### Siswa/DashboardController
- Fetch today's schedule
- Check teacher availability
- Display teacher name or "Guru tidak tersedia"

## 🔐 Security Features

- CSRF protection pada semua form POST
- Password hashing menggunakan bcrypt
- Role-based access control via middleware
- Rate limiting (optional)
- Input validation pada semua endpoint
- SQL injection protection via Eloquent ORM

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ScanTest.php

# Run with coverage
php artisan test --coverage
```

## 🔧 Troubleshooting

### Database Error
```bash
php artisan migrate:fresh --seed
```

### Asset Not Loading
```bash
npm run build
php artisan view:clear
php artisan cache:clear
```

### QR Scanner Not Working
- Pastikan localhost/HTTPS (html5-qrcode memerlukan secure context)
- Check browser console untuk error
- Refresh page dan coba ulang

### Login Error
- Pastikan database sudah di-seed: `php artisan migrate --seed`
- Clear cache: `php artisan cache:clear`

## 📦 Tech Stack

| Komponen | Version |
|----------|---------|
| PHP | 8.2.12+ |
| Laravel | 11 |
| MySQL | 5.7+ |
| Bootstrap | 5 |
| Tailwind CSS | 3 |
| jQuery | 3.x |
| html5-qrcode | Latest |
| SweetAlert2 | Latest |
| Font Awesome | 6.x |

## 📚 Dependencies (Composer)

- `laravel/framework:^11`
- `laravel/sail:^1`
- `laravel/breeze:^2`
- `laravel/pint:^1`
- `maatwebsite/excel:^3.1`
- `phpunit/phpunit:^11`

## 📝 License

MIT License - Bebas untuk pembelajaran & pengembangan.

## 👨‍💻 Author

Abdullohfaqih25

## 📞 Support

Untuk pertanyaan atau issue, silakan buat issue di repository atau hubungi developer.

---

**Last Updated:** December 1, 2025
**Laravel Version:** 11
**PHP Version:** 8.2.12+
