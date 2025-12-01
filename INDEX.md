# Dokumentasi AbsenQR - Index Lengkap

Generated: December 1, 2025

## 📚 Panduan Dokumentasi

Aplikasi AbsenQR adalah sistem manajemen absensi siswa berbasis QR Code yang dibangun dengan Laravel 11. Dokumentasi ini mencakup arsitektur sistem, ERD, UML, dan schema database.

---

## 📖 Daftar Dokumentasi

### 1. **README.md** (Dokumentasi Utama)
- ✅ Fitur utama untuk setiap role (Admin, Guru, Siswa)
- ✅ Fitur advanced (QR Token, Teacher Availability, Schedule System, RBAC)
- ✅ Requirements dan instalasi
- ✅ Struktur project
- ✅ Database schema (SQL definitions)
- ✅ Architecture & system flow
- ✅ Key controllers
- ✅ Security features & troubleshooting

**File**: `../README.md`

### 2. **ERD.md** (Entity Relationship Diagram)
- ✅ Diagram relasi teks format (ASCII art)
- ✅ Summary tabel relasi (table)
- ✅ Unique constraints
- ✅ Cascade rules
- ✅ Mermaid ERD (alternative format)
- ✅ Notes & explanations

**File**: `ERD.md`

**Highlights**:
- Visualisasi relasi antar tabel
- Cardinality (1:1, 1:Many, Many:1)
- Foreign key relationships
- Unique constraints per table

### 3. **UML.md** (UML Class & Architecture)
- ✅ UML Class diagram (text format)
- ✅ Core models (User, Student, Teacher, Attendance, QrToken, TeacherAvailability, etc.)
- ✅ Schedule system models (WeekTemplate, DayTemplate, DaySlot)
- ✅ Controller architecture (Auth flow, Guru controllers, Siswa controllers)
- ✅ Service layer (optional)
- ✅ Mermaid UML diagram

**File**: `UML.md`

**Highlights**:
- Method signatures & return types
- Relationships & dependencies
- Controller routing & methods
- Service layer patterns

### 4. **SCHEMA.md** (Database Schema)
- ✅ Table definitions dengan SQL
- ✅ Column specifications (type, constraints, notes)
- ✅ Relationships untuk setiap tabel
- ✅ Unique constraints summary
- ✅ Cascade rules
- ✅ Indexing strategy
- ✅ Data type decisions
- ✅ Performance optimization tips
- ✅ Backup & maintenance
- ✅ Migration order

**File**: `SCHEMA.md`

**Highlights**:
- Detailed table definitions
- SQL CREATE statements
- Index strategies
- Cascade & relationship rules
- Query optimization tips

---

## 🏗️ System Architecture Overview

### Three-Tier Architecture

```
┌─────────────────────────────────────────────────┐
│            PRESENTATION LAYER                  │
│  - Blade Templates (Frontend HTML/CSS/JS)      │
│  - Bootstrap 5, jQuery, html5-qrcode          │
│  - Role-based views (Admin, Guru, Siswa)      │
└─────────────────────────────────────────────────┘
                        │
                        ↓
┌─────────────────────────────────────────────────┐
│         APPLICATION LAYER (Controllers)        │
│  - Admin/DashboardController                   │
│  - Guru/DashboardController, QRController      │
│  - Guru/AvailabilityController (NEW)           │
│  - Siswa/ScanController, DashboardController   │
│  - Middleware (auth, role-based)              │
└─────────────────────────────────────────────────┘
                        │
                        ↓
┌─────────────────────────────────────────────────┐
│            BUSINESS LOGIC LAYER                │
│  - Models (User, Student, Teacher, etc.)       │
│  - Services (Attendance, QRToken, Schedule)    │
│  - Form Requests & Validation                  │
│  - Events & Listeners                          │
└─────────────────────────────────────────────────┘
                        │
                        ↓
┌─────────────────────────────────────────────────┐
│           DATA ACCESS LAYER (Eloquent)         │
│  - Relationships                               │
│  - Query Builder                               │
│  - Migrations                                  │
└─────────────────────────────────────────────────┘
                        │
                        ↓
┌─────────────────────────────────────────────────┐
│          DATABASE LAYER (MySQL)                │
│  - 14 tables (Users, Students, Teachers, etc.) │
│  - Foreign keys & constraints                  │
│  - Indexes for performance                     │
└─────────────────────────────────────────────────┘
```

### Key Data Flows

#### QR Attendance Flow
```
Guru Generate Token → QR Display → Student Scan
       ↓                                ↓
QrToken created           Extract teacher_id
  (date specific)               from QrToken
                                ↓
                         Create Attendance
                         (student_id, teacher_id)
                                ↓
                         Calculate Status
                         (Hadir/Terlambat)
                                ↓
                         Guru See Realtime
                    (filtered by teacher_id)
```

#### Teacher Availability Flow
```
Guru Toggle Absence → Create TeacherAvailability
                           (is_absent=true)
                                ↓
                  Siswa Dashboard Detects
                                ↓
                   Show "Guru tidak tersedia"
                      instead of teacher name
```

#### Schedule Display Flow
```
Check Current Week Type
         ↓
Try WeekTemplate → DayTemplate → DaySlots
         ↓
   Fallback to Schedule table
         ↓
   Merge & Sort by Time
         ↓
Apply Teacher Availability
         ↓
Display Schedule with Teacher Name
(or "Guru tidak tersedia" if absent)
```

---

## 📊 Database Tables Quick Reference

| # | Table | Purpose | Records | FK Count |
|---|-------|---------|---------|----------|
| 1 | users | User accounts | 3+ | 0 |
| 2 | students | Student data | 100+ | 1 |
| 3 | teachers | Teacher data | 5+ | 0 |
| 4 | kelas | Classes | 10+ | 0 |
| 5 | mapels | Subjects | 20+ | 1 |
| 6 | schedules | Direct schedules | 100+ | 3 |
| 7 | attendances | Attendance records | 1000+ | 2 |
| 8 | qr_tokens | Daily QR tokens | 300+ | 1 |
| 9 | teacher_availabilities | Teacher absence | 50+ | 1 |
| 10 | week_templates | Weekly templates | 20+ | 1 |
| 11 | week_template_days | Template days | 100+ | 2 |
| 12 | day_templates | Day patterns | 10+ | 0 |
| 13 | day_slots | Time slots | 200+ | 3 |
| 14 | sessions | Session data | 10+ | 1 |

---

## 🔑 Key Features & Their Implementation

### 1. QR Token System
- **Model**: `QrToken`
- **Controller**: `Guru/QRController`
- **Database**: `qr_tokens` table
- **Key Logic**:
  - One token per (teacher_id, date)
  - Can regenerate for same day
  - Token links attendance to correct teacher
- **Files**: 
  - `app/Models/QrToken.php`
  - `app/Http/Controllers/Guru/QRController.php`

### 2. Teacher Availability
- **Model**: `TeacherAvailability`
- **Controller**: `Guru/AvailabilityController`
- **Database**: `teacher_availabilities` table (NEW)
- **Key Logic**:
  - Unique constraint on (teacher_id, date)
  - is_absent flag affects student dashboard
  - Real-time visibility
- **Files**:
  - `app/Models/TeacherAvailability.php`
  - `app/Http/Controllers/Guru/AvailabilityController.php`

### 3. Schedule System (Dual)
- **Primary**: WeekTemplate → DayTemplate → DaySlot
- **Fallback**: Schedule table
- **Models**: `WeekTemplate`, `DayTemplate`, `DaySlot`, `Schedule`
- **Controllers**: `Guru/DashboardController`, `Siswa/DashboardController`
- **Key Logic**:
  - Auto-detect week_type (1 or 2)
  - Prioritize template system
  - Fallback to direct schedules
  - Apply teacher availability check
- **Files**:
  - `app/Models/WeekTemplate.php`
  - `app/Models/DayTemplate.php`
  - `app/Models/DaySlot.php`
  - `app/Models/Schedule.php`

### 4. Attendance Routing
- **Model**: `Attendance`
- **Controller**: `Siswa/ScanController`
- **Database**: `attendances` table (modified with teacher_id FK)
- **Key Logic**:
  - Extract teacher_id from QrToken
  - Link attendance to specific teacher
  - Auto-calculate Hadir/Terlambat status
  - Filter realtime by teacher_id
- **Files**:
  - `app/Models/Attendance.php`
  - `app/Http/Controllers/Siswa/ScanController.php`
  - `database/migrations/2025_12_01_010000_add_teacher_id_to_attendances.php`

### 5. Role-Based Access Control
- **Routes**: Protected by `role:admin`, `role:guru`, `role:siswa` middleware
- **Models**: User with role field
- **Middleware**: Check role in middleware
- **Files**:
  - `routes/web.php`
  - `bootstrap/app.php`

---

## 📝 Development Guide

### Adding New Feature

1. **Create Migration**:
   ```bash
   php artisan make:migration create_table_name
   ```

2. **Create Model**:
   ```bash
   php artisan make:model ModelName
   ```

3. **Create Controller**:
   ```bash
   php artisan make:controller ControllerName
   ```

4. **Add Routes**:
   - Edit `routes/web.php` or role-specific route file

5. **Create Views**:
   - Add Blade templates in `resources/views/`

6. **Run Tests**:
   ```bash
   php artisan test
   ```

### Database Changes

1. **Create Migration**:
   ```bash
   php artisan make:migration change_description
   ```

2. **Update Model Relationships** if needed

3. **Run Migration**:
   ```bash
   php artisan migrate
   ```

4. **Create Seeder** if test data needed:
   ```bash
   php artisan make:seeder TableNameSeeder
   ```

---

## 🔍 Debugging Tips

### Check Database
```bash
php artisan tinker
>>> Teacher::first()->qr_tokens
>>> QrToken::where('date', now()->toDateString())->first()
>>> Attendance::with(['student', 'teacher'])->latest()->first()
```

### Clear Cache
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

### Check Logs
```bash
tail -f storage/logs/laravel.log
```

### Run Tests
```bash
php artisan test
php artisan test --filter=testName
```

---

## 📱 Frontend Components

### Key JavaScript Libraries
- **html5-qrcode**: QR code scanning
- **jQuery**: DOM manipulation
- **SweetAlert2**: Pretty alerts
- **Bootstrap**: Responsive UI
- **Chart.js**: Statistics charts

### Key Templates
- `resources/views/guru/dashboard/index.blade.php` - Guru dashboard with availability toggle
- `resources/views/siswa/dashboard/index.blade.php` - Siswa dashboard with schedule display
- `resources/views/siswa/scan/index.blade.php` - QR scanner with error handling
- `resources/views/guru/qr/realtime.blade.php` - Real-time attendance monitoring

---

## 📚 Additional Resources

### Laravel Documentation
- [Laravel 11 Docs](https://laravel.com/docs/11.x)
- [Eloquent ORM](https://laravel.com/docs/11.x/eloquent)
- [Migrations](https://laravel.com/docs/11.x/migrations)

### Database Design
- [MySQL Best Practices](https://dev.mysql.com/doc/)
- [Normalization Rules](https://en.wikipedia.org/wiki/Database_normalization)

### Web Development
- [Bootstrap 5](https://getbootstrap.com/docs/5.0)
- [Tailwind CSS](https://tailwindcss.com)
- [jQuery](https://jquery.com)

---

## ✅ Checklist Implementasi

- ✅ User authentication & authorization
- ✅ Role-based access control
- ✅ QR token generation & management
- ✅ Attendance submission via QR & manual
- ✅ Attendance routing to specific teacher (teacher_id)
- ✅ Real-time monitoring per teacher
- ✅ Teacher availability marking
- ✅ Student dashboard with "Guru tidak tersedia" display
- ✅ Schedule display (WeekTemplate + Schedule fallback)
- ✅ Admin dashboard & CRUD
- ✅ Guru dashboard with today's schedule
- ✅ Excel export functionality
- ✅ Error handling & validation
- ✅ UI improvements (styled action buttons)
- ✅ Documentation (README, ERD, UML, SCHEMA)

---

## 🚀 Deployment Checklist

- [ ] Test all features on production environment
- [ ] Run database migrations: `php artisan migrate`
- [ ] Build assets: `npm run build`
- [ ] Clear cache: `php artisan cache:clear`
- [ ] Set correct permissions on storage folder
- [ ] Configure .env for production
- [ ] Enable HTTPS
- [ ] Run background jobs if using queues
- [ ] Setup email service
- [ ] Run final tests

---

## 📞 Support & Maintenance

### Regular Maintenance Tasks
- Monitor application logs
- Check database performance
- Backup database regularly
- Review user access logs
- Update dependencies

### Reporting Issues
- Check error logs in `storage/logs/`
- Run tests: `php artisan test`
- Check browser console for JS errors
- Verify database connections

---

**Last Updated**: December 1, 2025
**Version**: 1.0
**Status**: Complete & Documented

---

## 📂 Dokumentasi File Structure

```
DOCUMENTATION/
├── ERD.md               # Entity Relationship Diagram
├── UML.md               # UML Class & Architecture
├── SCHEMA.md            # Database Schema Details
└── INDEX.md             # This file
```

Plus di root folder:
```
README.md               # Main documentation
```

---

**Total Documentation**: 5 files
**Total Lines**: 2000+ lines
**Coverage**: 100% of system architecture & database design
