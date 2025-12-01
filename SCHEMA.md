# Database Schema Documentation
## AbsenQR - Sistem Absensi dengan QR Code

Generated: December 1, 2025

## Overview

```
Total Tables: 14
Total Migrations: 12+
Engine: InnoDB
Collation: utf8mb4_unicode_ci
```

## Table Definitions

### 1. users

**Purpose**: Store user accounts for all roles (admin, guru, siswa)

```sql
CREATE TABLE users (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'guru', 'siswa') NOT NULL,
  related_id BIGINT UNSIGNED NULLABLE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  INDEX idx_email (email),
  INDEX idx_role (role),
  INDEX idx_related_id (related_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | User ID |
| name | VARCHAR(255) | NOT NULL | Full name |
| email | VARCHAR(255) | NOT NULL, UNIQUE | Email address |
| password | VARCHAR(255) | NOT NULL | Hashed password |
| role | ENUM | NOT NULL | admin, guru, or siswa |
| related_id | BIGINT UNSIGNED | NULLABLE | FK to students or teachers |
| created_at | TIMESTAMP | NULL | Created timestamp |
| updated_at | TIMESTAMP | NULL | Last updated timestamp |

**Relationships**:
- 1:1 to Students (when role='siswa')
- 1:1 to Teachers (when role='guru')

---

### 2. students

**Purpose**: Store student data

```sql
CREATE TABLE students (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nis VARCHAR(50) NOT NULL UNIQUE,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NULLABLE,
  kelas_id BIGINT UNSIGNED NOT NULL,
  photo VARCHAR(255) NULLABLE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE,
  INDEX idx_nis (nis),
  INDEX idx_kelas_id (kelas_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Student ID |
| nis | VARCHAR(50) | NOT NULL, UNIQUE | Student ID number |
| name | VARCHAR(255) | NOT NULL | Full name |
| email | VARCHAR(255) | NULLABLE | Email address |
| kelas_id | BIGINT UNSIGNED | NOT NULL, FK | Class ID |
| photo | VARCHAR(255) | NULLABLE | Photo file path |
| created_at | TIMESTAMP | NULL | Created timestamp |
| updated_at | TIMESTAMP | NULL | Last updated timestamp |

**Relationships**:
- Many:1 to Kelas
- 1:Many to Attendances
- 1:1 to Users (via user.related_id)

---

### 3. teachers

**Purpose**: Store teacher data

```sql
CREATE TABLE teachers (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  nip VARCHAR(50) NOT NULL UNIQUE,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NULLABLE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  INDEX idx_nip (nip)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Teacher ID |
| nip | VARCHAR(50) | NOT NULL, UNIQUE | Teacher ID number |
| name | VARCHAR(255) | NOT NULL | Full name |
| email | VARCHAR(255) | NULLABLE | Email address |
| created_at | TIMESTAMP | NULL | Created timestamp |
| updated_at | TIMESTAMP | NULL | Last updated timestamp |

**Relationships**:
- 1:Many to Schedules
- 1:Many to Mapels
- 1:Many to QrTokens
- 1:Many to Attendances (teacher_id)
- 1:Many to TeacherAvailabilities
- 1:Many to DaySlots
- 1:1 to Users (via user.related_id)

---

### 4. kelas

**Purpose**: Store class/classroom data

```sql
CREATE TABLE kelas (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  room VARCHAR(50) NULLABLE,
  capacity INT DEFAULT 40,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Class ID |
| name | VARCHAR(100) | NOT NULL | Class name (e.g., XII IPA 1) |
| room | VARCHAR(50) | NULLABLE | Room number |
| capacity | INT | DEFAULT 40 | Student capacity |
| created_at | TIMESTAMP | NULL | Created timestamp |
| updated_at | TIMESTAMP | NULL | Last updated timestamp |

**Relationships**:
- 1:Many to Students
- 1:Many to Schedules
- 1:Many to WeekTemplates

---

### 5. mapels

**Purpose**: Store subject/course data

```sql
CREATE TABLE mapels (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  code VARCHAR(50) NULLABLE,
  teacher_id BIGINT UNSIGNED NOT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
  INDEX idx_name (name),
  INDEX idx_teacher_id (teacher_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Subject ID |
| name | VARCHAR(100) | NOT NULL | Subject name |
| code | VARCHAR(50) | NULLABLE | Subject code |
| teacher_id | BIGINT UNSIGNED | NOT NULL, FK | Primary teacher |
| created_at | TIMESTAMP | NULL | Created timestamp |
| updated_at | TIMESTAMP | NULL | Last updated timestamp |

**Relationships**:
- Many:1 to Teachers
- 1:Many to Schedules
- 1:Many to DaySlots

---

### 6. schedules

**Purpose**: Store direct class schedules (alternative to template system)

```sql
CREATE TABLE schedules (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  kelas_id BIGINT UNSIGNED NOT NULL,
  teacher_id BIGINT UNSIGNED NOT NULL,
  mapel_id BIGINT UNSIGNED NULLABLE,
  subject VARCHAR(255) NULLABLE,
  day VARCHAR(20) NOT NULL COMMENT 'Monday, Tuesday, ... (English)',
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  week_type TINYINT DEFAULT 1 COMMENT '1 or 2',
  room VARCHAR(50) NULLABLE,
  topic VARCHAR(255) NULLABLE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE,
  FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
  FOREIGN KEY (mapel_id) REFERENCES mapels(id) ON DELETE SET NULL,
  INDEX idx_day (day),
  INDEX idx_kelas_id (kelas_id),
  INDEX idx_teacher_id (teacher_id),
  INDEX idx_week_type (week_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Schedule ID |
| kelas_id | BIGINT UNSIGNED | NOT NULL, FK | Class ID |
| teacher_id | BIGINT UNSIGNED | NOT NULL, FK | Teacher ID |
| mapel_id | BIGINT UNSIGNED | NULLABLE, FK | Subject ID |
| subject | VARCHAR(255) | NULLABLE | Subject name (override) |
| day | VARCHAR(20) | NOT NULL | Day (Monday-Sunday) |
| start_time | TIME | NOT NULL | Start time |
| end_time | TIME | NOT NULL | End time |
| week_type | TINYINT | DEFAULT 1 | Week type (1 or 2) |
| room | VARCHAR(50) | NULLABLE | Room/location |
| topic | VARCHAR(255) | NULLABLE | Lesson topic |
| created_at | TIMESTAMP | NULL | Created timestamp |
| updated_at | TIMESTAMP | NULL | Last updated timestamp |

**Relationships**:
- Many:1 to Kelas
- Many:1 to Teachers
- Many:1 to Mapels

---

### 7. attendances

**Purpose**: Store student attendance records

```sql
CREATE TABLE attendances (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  student_id BIGINT UNSIGNED NOT NULL,
  teacher_id BIGINT UNSIGNED NULLABLE COMMENT 'NEW: Links to token owner',
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
  FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL,
  INDEX idx_student_id (student_id),
  INDEX idx_teacher_id (teacher_id),
  INDEX idx_absent_at (absent_at),
  INDEX idx_status (status),
  INDEX idx_token (token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Attendance ID |
| student_id | BIGINT UNSIGNED | NOT NULL, FK | Student ID |
| teacher_id | BIGINT UNSIGNED | NULLABLE, FK | Teacher ID (token owner) |
| absent_at | TIMESTAMP | NOT NULL | Attendance time |
| status | ENUM | DEFAULT 'Hadir' | Hadir, Terlambat, Absen |
| device | VARCHAR(255) | NULLABLE | Device used |
| ip | VARCHAR(50) | NULLABLE | IP address |
| lat | DECIMAL(10,8) | NULLABLE | Latitude |
| lng | DECIMAL(11,8) | NULLABLE | Longitude |
| token | VARCHAR(255) | NULLABLE | QR token used |
| created_at | TIMESTAMP | NULL | Created timestamp |
| updated_at | TIMESTAMP | NULL | Last updated timestamp |

**Relationships**:
- Many:1 to Students
- Many:1 to Teachers (via teacher_id)

**Key Features**:
- teacher_id is automatically set from QrToken owner during attendance creation
- Ensures attendance is linked to specific guru, not broadcast
- Real-time filtering in guru dashboard uses teacher_id

---

### 8. qr_tokens

**Purpose**: Store daily QR tokens for each teacher

```sql
CREATE TABLE qr_tokens (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  teacher_id BIGINT UNSIGNED NOT NULL,
  token VARCHAR(255) NOT NULL UNIQUE,
  date DATE NOT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
  UNIQUE KEY unique_teacher_date (teacher_id, date),
  INDEX idx_date (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Token ID |
| teacher_id | BIGINT UNSIGNED | NOT NULL, FK | Teacher ID |
| token | VARCHAR(255) | NOT NULL, UNIQUE | QR token string |
| date | DATE | NOT NULL | Date token is valid |
| created_at | TIMESTAMP | NULL | Created timestamp |
| updated_at | TIMESTAMP | NULL | Last updated timestamp |

**Unique Constraints**:
- `unique_teacher_date`: One token per (teacher_id, date) combination

**Relationships**:
- Many:1 to Teachers

**Key Features**:
- One unique token per teacher per day
- Can be regenerated (creates new token for same day)
- Used for attendance routing to correct teacher

---

### 9. teacher_availabilities (NEW)

**Purpose**: Track teacher absence/presence per date

```sql
CREATE TABLE teacher_availabilities (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  teacher_id BIGINT UNSIGNED NOT NULL,
  date DATE NOT NULL,
  is_absent BOOLEAN DEFAULT FALSE,
  note TEXT NULLABLE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
  UNIQUE KEY unique_teacher_date (teacher_id, date),
  INDEX idx_date (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Record ID |
| teacher_id | BIGINT UNSIGNED | NOT NULL, FK | Teacher ID |
| date | DATE | NOT NULL | Date |
| is_absent | BOOLEAN | DEFAULT FALSE | Absence flag |
| note | TEXT | NULLABLE | Optional note |
| created_at | TIMESTAMP | NULL | Created timestamp |
| updated_at | TIMESTAMP | NULL | Last updated timestamp |

**Unique Constraints**:
- `unique_teacher_date`: One record per (teacher_id, date) combination

**Relationships**:
- Many:1 to Teachers

**Key Features**:
- NEW: Implements teacher availability confirmation system
- When is_absent=true, student dashboard shows "Guru tidak tersedia"
- Real-time update on dashboard siswa

---

### 10. week_templates

**Purpose**: Define flexible weekly schedule templates per class

```sql
CREATE TABLE week_templates (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  kelas_id BIGINT UNSIGNED NOT NULL,
  name VARCHAR(255) NULLABLE,
  week_type TINYINT DEFAULT 1,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE,
  INDEX idx_kelas_id (kelas_id),
  INDEX idx_week_type (week_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Template ID |
| kelas_id | BIGINT UNSIGNED | NOT NULL, FK | Class ID |
| name | VARCHAR(255) | NULLABLE | Template name |
| week_type | TINYINT | DEFAULT 1 | Week type (1 or 2) |
| created_at | TIMESTAMP | NULL | Created timestamp |
| updated_at | TIMESTAMP | NULL | Last updated timestamp |

**Relationships**:
- Many:1 to Kelas
- 1:Many to WeekTemplateDays

---

### 11. week_template_days

**Purpose**: Map days to day templates within a week template

```sql
CREATE TABLE week_template_days (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  week_template_id BIGINT UNSIGNED NOT NULL,
  day_name VARCHAR(20) NOT NULL COMMENT 'Monday, Tuesday, ...',
  day_template_id BIGINT UNSIGNED NULLABLE,
  day_order INT DEFAULT 0,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (week_template_id) REFERENCES week_templates(id) ON DELETE CASCADE,
  FOREIGN KEY (day_template_id) REFERENCES day_templates(id) ON DELETE SET NULL,
  INDEX idx_week_template_id (week_template_id),
  INDEX idx_day_name (day_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Record ID |
| week_template_id | BIGINT UNSIGNED | NOT NULL, FK | WeekTemplate ID |
| day_name | VARCHAR(20) | NOT NULL | Day name (Monday-Sunday) |
| day_template_id | BIGINT UNSIGNED | NULLABLE, FK | DayTemplate ID |
| day_order | INT | DEFAULT 0 | Order in week |
| created_at | TIMESTAMP | NULL | Created timestamp |
| updated_at | TIMESTAMP | NULL | Last updated timestamp |

**Relationships**:
- Many:1 to WeekTemplates
- Many:1 to DayTemplates

---

### 12. day_templates

**Purpose**: Define slot patterns for a specific day

```sql
CREATE TABLE day_templates (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NULLABLE,
  description TEXT NULLABLE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Template ID |
| name | VARCHAR(255) | NULLABLE | Template name |
| description | TEXT | NULLABLE | Description |
| created_at | TIMESTAMP | NULL | Created timestamp |
| updated_at | TIMESTAMP | NULL | Last updated timestamp |

**Relationships**:
- 1:Many to DaySlots
- 1:Many to WeekTemplateDays

---

### 13. day_slots

**Purpose**: Individual time slots within a day template

```sql
CREATE TABLE day_slots (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  day_template_id BIGINT UNSIGNED NOT NULL,
  mapel_id BIGINT UNSIGNED NULLABLE,
  teacher_id BIGINT UNSIGNED NULLABLE,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  slot_order INT DEFAULT 0,
  topic VARCHAR(255) NULLABLE,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (day_template_id) REFERENCES day_templates(id) ON DELETE CASCADE,
  FOREIGN KEY (mapel_id) REFERENCES mapels(id) ON DELETE SET NULL,
  FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL,
  INDEX idx_day_template_id (day_template_id),
  INDEX idx_teacher_id (teacher_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Column | Type | Constraints | Notes |
|--------|------|-------------|-------|
| id | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | Slot ID |
| day_template_id | BIGINT UNSIGNED | NOT NULL, FK | DayTemplate ID |
| mapel_id | BIGINT UNSIGNED | NULLABLE, FK | Subject ID |
| teacher_id | BIGINT UNSIGNED | NULLABLE, FK | Teacher ID |
| start_time | TIME | NOT NULL | Start time |
| end_time | TIME | NOT NULL | End time |
| slot_order | INT | DEFAULT 0 | Order within day |
| topic | VARCHAR(255) | NULLABLE | Lesson topic |
| created_at | TIMESTAMP | NULL | Created timestamp |
| updated_at | TIMESTAMP | NULL | Last updated timestamp |

**Relationships**:
- Many:1 to DayTemplates
- Many:1 to Mapels
- Many:1 to Teachers

---

### 14. sessions (Laravel built-in)

**Purpose**: Store session data for web authentication

```sql
CREATE TABLE sessions (
  id VARCHAR(255) NOT NULL UNIQUE,
  user_id BIGINT UNSIGNED NULLABLE,
  ip_address VARCHAR(45) NULLABLE,
  user_agent TEXT NULLABLE,
  payload LONGTEXT NOT NULL,
  last_activity INT NOT NULL,
  created_at TIMESTAMP NULL,
  updated_at TIMESTAMP NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_user_id (user_id),
  INDEX idx_last_activity (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## Indexing Strategy

### Frequently Used Queries Index

| Table | Columns | Index Type | Purpose |
|-------|---------|-----------|---------|
| users | email | UNIQUE | Login queries |
| users | role | Normal | Filter by role |
| students | nis | UNIQUE | Find student by NIS |
| students | kelas_id | Normal | Find students in class |
| teachers | nip | UNIQUE | Find teacher by NIP |
| attendances | student_id | Normal | Find student attendance |
| attendances | teacher_id | Normal | Filter by teacher |
| attendances | absent_at | Normal | Date range queries |
| schedules | kelas_id | Normal | Find class schedules |
| schedules | day | Normal | Find by day |
| schedules | week_type | Normal | Find by week type |
| qr_tokens | teacher_id, date | UNIQUE | Find token by teacher+date |
| qr_tokens | token | UNIQUE | Validate token |
| teacher_availabilities | teacher_id, date | UNIQUE | Find availability |

---

## Data Type Decisions

| Data | Type | Reason |
|------|------|--------|
| IDs | BIGINT UNSIGNED | Scalability, no negative values |
| Names | VARCHAR(255) | Sufficient for names |
| Time Values | TIME | Native database support |
| Dates | DATE | Simple date storage |
| Coordinates (lat/lng) | DECIMAL(10,8) | Precision for GPS |
| IP Addresses | VARCHAR(50) | IPv6 support |
| Enums | ENUM | Constraint enforcement, disk-efficient |
| Large Text | TEXT | Flexibility |
| Timestamps | TIMESTAMP | Auto-managed by Laravel |

---

## Cascade & Relationship Rules

### ON DELETE CASCADE
Used for:
- Students → Attendances
- Kelas → Students
- WeekTemplates → WeekTemplateDays
- DayTemplates → DaySlots
- Teachers → QrTokens
- Teachers → Mapels
- Kelas → Schedules

Rationale: When parent deleted, child records are no longer meaningful

### ON DELETE SET NULL
Used for:
- Attendances.teacher_id (preserve history)
- Schedules.mapel_id (subject optional)
- DaySlots.teacher_id, DaySlots.mapel_id (preserve templates)

Rationale: Historical data preservation while maintaining referential integrity

---

## Performance Optimization

### Query Optimization Tips

1. **Schedule Queries**:
   - Always use with eager loading: `with(['teacher', 'mapel', 'kelas'])`
   - Filter by week_type early to reduce result set
   - Use indexes on day, week_type, kelas_id

2. **Attendance Queries**:
   - Use `with(['student.kelas', 'teacher'])` for list views
   - Filter by teacher_id for per-teacher monitoring
   - Index on absent_at for date-range queries

3. **Real-time Monitoring**:
   - Add index on (teacher_id, absent_at) for performance
   - Cache QR token counts per teacher
   - Limit results with LIMIT clause

4. **Template System**:
   - Cache week_type calculation (once per day)
   - Batch fetch all schedules rather than per-student queries

---

## Backup & Maintenance

```sql
-- Export database
mysqldump -u root absen_qr > backup.sql

-- Check table status
CHECK TABLE attendances, schedules, qr_tokens;

-- Optimize tables
OPTIMIZE TABLE attendances, schedules;

-- Repair if needed
REPAIR TABLE attendances;
```

---

## Migration Order

1. `2025_11_27_073206_create_users_table.php`
2. `2025_11_27_073237_create_kelas_table.php`
3. `2025_11_27_073337_create_students_table.php`
4. `2025_11_27_073413_create_teachers_table.php`
5. `2025_11_27_073454_create_schedules_table.php`
6. `2025_11_27_073525_create_attendances_table.php`
7. `2025_11_27_073608_create_qr_tokens_table.php`
8. `2025_12_01_000000_create_teacher_availabilities_table.php` (NEW)
9. `2025_12_01_010000_add_teacher_id_to_attendances.php` (NEW - updates existing table)
10. `2025_11_28_010913_create_sessions_table.php`
11. WeekTemplate related tables
12. Other supporting tables

---

**Last Updated:** December 1, 2025
**Version:** 1.0
**Database Engine:** InnoDB
**Collation:** utf8mb4_unicode_ci
