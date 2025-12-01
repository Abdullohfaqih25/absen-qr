# UML Class Diagram & Architecture
## AbsenQR - Sistem Absensi dengan QR Code

Generated: December 1, 2025

## UML Class Diagram (Text Format)

### Core Models

```
┌────────────────────────────────────────────────────────────┐
│                      User                                  │
├────────────────────────────────────────────────────────────┤
│ Attributes:                                                │
│ - id: int (PK)                                            │
│ - name: string                                            │
│ - email: string (UNIQUE)                                  │
│ - password: string                                        │
│ - role: string(admin|guru|siswa)                         │
│ - related_id: int (FK)                                    │
├────────────────────────────────────────────────────────────┤
│ Methods:                                                   │
│ + isAdmin(): bool                                         │
│ + isGuru(): bool                                          │
│ + isSiswa(): bool                                         │
│ + student(): hasOne<Student>                             │
│ + teacher(): hasOne<Teacher>                             │
│ + attendance_records(): hasMany<Attendance>              │
└────────────────────────────────────────────────────────────┘
           △            △              △
           │            │              │
    ┌──────┴────────────┼──────────────┴──────┐
    │                   │                     │
    │ 1:1 (siswa)       │ 1:1 (guru)         │ 1:1 (admin)
    │                   │                     │
    ↓                   ↓                     ↓
┌──────────────────┐ ┌──────────────────┐ ┌─────────────┐
│   Student        │ │    Teacher       │ │  Admin      │
├──────────────────┤ ├──────────────────┤ ├─────────────┤
│ - id: int        │ │ - id: int        │ │ (inherits   │
│ - nis: string    │ │ - nip: string    │ │  from User) │
│ - name: string   │ │ - name: string   │ └─────────────┘
│ - email: string  │ │ - email: string  │
│ - kelas_id: int  │ │                  │
│ - photo: string  │ │ Methods:         │
├──────────────────┤ ├──────────────────┤
│ Methods:         │ │ + user():        │
│ + user():        │ │   belongsTo<U>   │
│   belongsTo<U>   │ │ + kelas():       │
│ + kelas():       │ │   belongsTo<K>   │
│   belongsTo<K>   │ │ + mapels():      │
│ + attendances(): │ │   hasMany<Map>   │
│   hasMany<Att>   │ │ + schedules():   │
│ + schedules():   │ │   hasMany<Sch>   │
│   hasMany<Sch>   │ │ + qr_tokens():   │
│ + isLate():      │ │   hasMany<Qrt>   │
│   bool           │ │ + availabilities:│
│ + hasAttended(): │ │   hasMany<Tav>   │
│   bool           │ │ + day_slots():   │
│ + today():       │ │   hasMany<Dsl>   │
│   static<Sch>    │ │ + isAvailable(): │
└──────────────────┘ │   bool           │
                     └──────────────────┘

┌────────────────────────────────────────────────────────────┐
│                    Attendance                              │
├────────────────────────────────────────────────────────────┤
│ Attributes:                                                │
│ - id: int (PK)                                            │
│ - student_id: int (FK)                                    │
│ - teacher_id: int (FK)  ← NEW: Links to token owner      │
│ - absent_at: datetime                                      │
│ - status: enum(Hadir|Terlambat|Absen)                    │
│ - device: string                                          │
│ - ip: string                                              │
│ - lat: decimal                                            │
│ - lng: decimal                                            │
│ - token: string                                           │
├────────────────────────────────────────────────────────────┤
│ Methods:                                                   │
│ + student(): belongsTo<Student>                          │
│ + teacher(): belongsTo<Teacher>                          │
│ + qr_token(): belongsTo<QrToken>                         │
│ + isLate(): bool                                          │
│ + getStatus(): string                                     │
│ + isToday(): bool                                         │
│ + getTodayCount(): static<int>                           │
│ + getTodayByTeacher(): static<Att[]>                     │
└────────────────────────────────────────────────────────────┘
        △                      △
        │ belongs_to           │ belongs_to
        │ (student_id)         │ (teacher_id)
        │                      │
    STUDENT               TEACHER

┌────────────────────────────────────────────────────────────┐
│                    QrToken                                 │
├────────────────────────────────────────────────────────────┤
│ Attributes:                                                │
│ - id: int (PK)                                            │
│ - teacher_id: int (FK)                                    │
│ - token: string (UNIQUE)                                  │
│ - date: date                                              │
├────────────────────────────────────────────────────────────┤
│ Methods:                                                   │
│ + teacher(): belongsTo<Teacher>                          │
│ + attendances(): hasMany<Attendance>                     │
│ + generate(): static<string>                             │
│ + getTodayForTeacher(): static<QrToken>                  │
│ + getOrCreate(): static<QrToken>                         │
│ + regenerate(): static<QrToken>                          │
│ + getCountToday(): int                                   │
└────────────────────────────────────────────────────────────┘
        △
        │ belongs_to
        │ (teacher_id)
        │
    TEACHER

┌────────────────────────────────────────────────────────────┐
│              TeacherAvailability                           │
├────────────────────────────────────────────────────────────┤
│ Attributes:                                                │
│ - id: int (PK)                                            │
│ - teacher_id: int (FK) [UNIQUE with date]                │
│ - date: date          [UNIQUE with teacher_id]           │
│ - is_absent: boolean DEFAULT false                        │
│ - note: text NULLABLE                                     │
├────────────────────────────────────────────────────────────┤
│ Methods:                                                   │
│ + teacher(): belongsTo<Teacher>                          │
│ + toggle(date): static<TeacherAvailability>             │
│ + isAbsentToday(): static<bool>                          │
│ + getTodayForTeacher(): static<TeacherAvailability>     │
│ + markAbsent(): void                                      │
│ + markPresent(): void                                     │
└────────────────────────────────────────────────────────────┘
        △
        │ belongs_to
        │ (teacher_id)
        │
    TEACHER

┌────────────────────────────────────────────────────────────┐
│                    Schedule                                │
├────────────────────────────────────────────────────────────┤
│ Attributes:                                                │
│ - id: int (PK)                                            │
│ - kelas_id: int (FK)                                      │
│ - teacher_id: int (FK)                                    │
│ - mapel_id: int (FK)                                      │
│ - subject: string                                         │
│ - day: string (Monday, Tuesday, ...)                      │
│ - start_time: time                                        │
│ - end_time: time                                          │
│ - week_type: tinyint (1|2)                               │
│ - room: string                                            │
│ - topic: string                                           │
├────────────────────────────────────────────────────────────┤
│ Methods:                                                   │
│ + kelas(): belongsTo<Kelas>                              │
│ + teacher(): belongsTo<Teacher>                          │
│ + mapel(): belongsTo<Mapel>                              │
│ + getTodaySchedules(): static<Sch[]>                     │
│ + getByDay(day, weekType): static<Sch[]>                 │
│ + getForClass(klasId): static<Sch[]>                     │
│ + getForTeacher(teacherId): static<Sch[]>                │
│ + getDuration(): int                                      │
└────────────────────────────────────────────────────────────┘
        │       │       │
        │       │       │ belongs_to
        │       │       │
        ↓       ↓       ↓
    KELAS  TEACHER  MAPEL

┌────────────────────────────────────────────────────────────┐
│                     Kelas                                  │
├────────────────────────────────────────────────────────────┤
│ Attributes:                                                │
│ - id: int (PK)                                            │
│ - name: string                                            │
│ - room: string                                            │
│ - capacity: int DEFAULT 40                                │
├────────────────────────────────────────────────────────────┤
│ Methods:                                                   │
│ + students(): hasMany<Student>                           │
│ + schedules(): hasMany<Schedule>                         │
│ + weekTemplates(): hasMany<WeekTemplate>                 │
│ + getStudentCount(): int                                 │
│ + getTodaySchedules(): Sch[]                             │
│ + getAttendanceStats(): array                            │
└────────────────────────────────────────────────────────────┘

┌────────────────────────────────────────────────────────────┐
│                     Mapel                                  │
├────────────────────────────────────────────────────────────┤
│ Attributes:                                                │
│ - id: int (PK)                                            │
│ - name: string                                            │
│ - code: string                                            │
│ - teacher_id: int (FK)                                    │
├────────────────────────────────────────────────────────────┤
│ Methods:                                                   │
│ + teacher(): belongsTo<Teacher>                          │
│ + schedules(): hasMany<Schedule>                         │
│ + daySlots(): hasMany<DaySlot>                           │
└────────────────────────────────────────────────────────────┘
        △
        │ belongs_to
        │ (teacher_id)
        │
    TEACHER
```

### Schedule System (Template-based)

```
┌────────────────────────────────────────────────────────────┐
│                 WeekTemplate                               │
├────────────────────────────────────────────────────────────┤
│ Attributes:                                                │
│ - id: int (PK)                                            │
│ - kelas_id: int (FK)                                      │
│ - name: string NULLABLE                                   │
│ - week_type: tinyint (1|2)                               │
├────────────────────────────────────────────────────────────┤
│ Methods:                                                   │
│ + kelas(): belongsTo<Kelas>                              │
│ + weekTemplateDays(): hasMany<WTD>                       │
│ + getDaysForWeek(): WTD[]                                │
│ + getSlotsByDay(dayName): DaySlot[]                      │
└────────────────────────────────────────────────────────────┘
        │
        │ 1:many
        │
        ↓
┌────────────────────────────────────────────────────────────┐
│             WeekTemplateDay                                │
├────────────────────────────────────────────────────────────┤
│ Attributes:                                                │
│ - id: int (PK)                                            │
│ - week_template_id: int (FK)                              │
│ - day_name: string (Monday, Tuesday, ...)                │
│ - day_template_id: int (FK) NULLABLE                      │
│ - day_order: int                                          │
├────────────────────────────────────────────────────────────┤
│ Methods:                                                   │
│ + weekTemplate(): belongsTo<WeekTemplate>                │
│ + dayTemplate(): belongsTo<DayTemplate>                  │
│ + daySlots(): hasMany<DaySlot> (via DayTemplate)         │
└────────────────────────────────────────────────────────────┘
        │
        │ 1:many
        │
        ↓
┌────────────────────────────────────────────────────────────┐
│              DayTemplate                                   │
├────────────────────────────────────────────────────────────┤
│ Attributes:                                                │
│ - id: int (PK)                                            │
│ - name: string NULLABLE                                   │
│ - description: text NULLABLE                              │
├────────────────────────────────────────────────────────────┤
│ Methods:                                                   │
│ + daySlots(): hasMany<DaySlot>                           │
│ + getSlots(): DaySlot[]                                  │
└────────────────────────────────────────────────────────────┘
        │
        │ 1:many
        │
        ↓
┌────────────────────────────────────────────────────────────┐
│                DaySlot                                     │
├────────────────────────────────────────────────────────────┤
│ Attributes:                                                │
│ - id: int (PK)                                            │
│ - day_template_id: int (FK)                               │
│ - mapel_id: int (FK) NULLABLE                             │
│ - teacher_id: int (FK) NULLABLE                           │
│ - start_time: time                                        │
│ - end_time: time                                          │
│ - slot_order: int                                         │
│ - topic: string NULLABLE                                  │
├────────────────────────────────────────────────────────────┤
│ Methods:                                                   │
│ + dayTemplate(): belongsTo<DayTemplate>                  │
│ + mapel(): belongsTo<Mapel>                              │
│ + teacher(): belongsTo<Teacher>                          │
│ + getDuration(): int                                      │
│ + getDisplayTime(): string                               │
└────────────────────────────────────────────────────────────┘
```

## Controller Architecture

### Authentication Flow

```
┌─────────────────────────────────────────┐
│     AuthController / LoginController    │
├─────────────────────────────────────────┤
│ Routes:                                 │
│ - POST /login                          │
│ - POST /logout                         │
│ - GET /select-role                     │
├─────────────────────────────────────────┤
│ Methods:                                │
│ + login(Request): Response             │
│ + logout(): RedirectResponse           │
│ + selectRole(): View                   │
│ + authenticate(): Response             │
└─────────────────────────────────────────┘
        │
        │ Redirects to:
        │
    ┌───┴─────────┬─────────────┬─────────────┐
    │             │             │             │
    ↓             ↓             ↓             ↓
Admin         Guru           Siswa
Dashboard    Dashboard      Dashboard
```

### Guru Controllers

```
┌──────────────────────────────────────────────────────────┐
│           Guru/DashboardController                       │
├──────────────────────────────────────────────────────────┤
│ Routes:                                                  │
│ - GET /guru/dashboard                                  │
├──────────────────────────────────────────────────────────┤
│ Methods:                                                 │
│ + index(): View                                         │
│   ├─ Get QR token for today                           │
│   ├─ Count attendances via token                      │
│   ├─ Fetch today's schedules (WTemplate + Schedule)   │
│   ├─ Check teacher availability                       │
│   └─ Return dashboard view                            │
└──────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────┐
│           Guru/QRController                              │
├──────────────────────────────────────────────────────────┤
│ Routes:                                                  │
│ - GET /guru/qr                                         │
│ - POST /guru/qr/regenerate                            │
│ - GET /guru/qr/realtime                               │
├──────────────────────────────────────────────────────────┤
│ Methods:                                                 │
│ + showToday(): View                                     │
│   ├─ Get or create QR token for today                 │
│   └─ Return QR display view                           │
│                                                        │
│ + regenerate(): JsonResponse                           │
│   ├─ Create new token for today                       │
│   ├─ Invalidate old token                             │
│   └─ Return new token                                 │
│                                                        │
│ + realtimeList(): View                                 │
│   ├─ Filter attendances by teacher_id                │
│   ├─ Eager load student.kelas                        │
│   └─ Return real-time attendance list                │
└──────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────┐
│        Guru/AvailabilityController (NEW)                 │
├──────────────────────────────────────────────────────────┤
│ Routes:                                                  │
│ - POST /guru/availability/toggle                       │
├──────────────────────────────────────────────────────────┤
│ Methods:                                                 │
│ + toggle(): JsonResponse                               │
│   ├─ Get/create TeacherAvailability                   │
│   ├─ Toggle is_absent flag                           │
│   └─ Return updated status                            │
└──────────────────────────────────────────────────────────┘
```

### Siswa Controllers

```
┌──────────────────────────────────────────────────────────┐
│          Siswa/DashboardController                       │
├──────────────────────────────────────────────────────────┤
│ Routes:                                                  │
│ - GET /siswa/dashboard                                 │
├──────────────────────────────────────────────────────────┤
│ Methods:                                                 │
│ + index(): View                                         │
│   ├─ Get student profile & stats                       │
│   ├─ Fetch today's schedules                          │
│   ├─ Check teacher availability for each schedule     │
│   ├─ Get last attendance record                       │
│   ├─ Calculate attendance percentage                  │
│   └─ Return dashboard view                            │
└──────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────┐
│            Siswa/ScanController                          │
├──────────────────────────────────────────────────────────┤
│ Routes:                                                  │
│ - GET /siswa/scan                                      │
│ - POST /siswa/scan                                     │
├──────────────────────────────────────────────────────────┤
│ Methods:                                                 │
│ + index(): View                                         │
│   └─ Return QR scanner interface                       │
│                                                        │
│ + store(Request): JsonResponse                         │
│   ├─ Validate NIS & token exist                       │
│   ├─ Check no duplicate attendance today              │
│   ├─ Extract teacher_id from QrToken                 │
│   ├─ Calculate status (Hadir/Terlambat)              │
│   ├─ Create Attendance record                         │
│   └─ Return {success, status, time}                   │
└──────────────────────────────────────────────────────────┘
```

## Service Layer (Optional)

```
┌───────────────────────────────────────────┐
│        AttendanceService                  │
├───────────────────────────────────────────┤
│ Methods:                                  │
│ + record(student, teacher, token)        │
│ + getStatus(time): string                │
│ + getTodayStats(teacher): array          │
│ + getTeacherAttendances(teacher): Att[]  │
│ + validateDuplicate(student, date): bool │
└───────────────────────────────────────────┘

┌───────────────────────────────────────────┐
│        ScheduleService                    │
├───────────────────────────────────────────┤
│ Methods:                                  │
│ + getTodaySchedules(student): Sch[]      │
│ + getTodaySchedules(teacher): Sch[]      │
│ + getWeekSchedules(class): Sch[]         │
│ + aggregateSchedules(class): Sch[]       │
│ + applyTeacherAvailability(schedules)   │
└───────────────────────────────────────────┘

┌───────────────────────────────────────────┐
│        QRTokenService                     │
├───────────────────────────────────────────┤
│ Methods:                                  │
│ + generateToken(teacher, date): string   │
│ + getOrCreateToken(teacher): QrToken    │
│ + regenerateToken(teacher): QrToken     │
│ + validateToken(token): Teacher|null    │
│ + getTeacherFromToken(token): Teacher   │
└───────────────────────────────────────────┘

┌───────────────────────────────────────────┐
│   TeacherAvailabilityService              │
├───────────────────────────────────────────┤
│ Methods:                                  │
│ + toggle(teacher, date): bool            │
│ + isAbsentToday(teacher): bool           │
│ + markAbsent(teacher): void              │
│ + markPresent(teacher): void             │
│ + getAvailability(teacher, date): TAv   │
└───────────────────────────────────────────┘
```

## Mermaid Diagram (Alternative)

```mermaid
classDiagram
    class User {
        id: int
        name: string
        email: string
        password: string
        role: string
        related_id: int
        isAdmin()
        isGuru()
        isSiswa()
        student()
        teacher()
    }

    class Student {
        id: int
        nis: string
        name: string
        email: string
        kelas_id: int
        photo: string
        user()
        kelas()
        attendances()
        schedules()
    }

    class Teacher {
        id: int
        nip: string
        name: string
        email: string
        user()
        schedules()
        mapels()
        qr_tokens()
        attendances()
        availabilities()
    }

    class Attendance {
        id: int
        student_id: int
        teacher_id: int
        absent_at: datetime
        status: string
        token: string
        student()
        teacher()
        isLate()
    }

    class QrToken {
        id: int
        teacher_id: int
        token: string
        date: date
        teacher()
        attendances()
        generate()
    }

    class TeacherAvailability {
        id: int
        teacher_id: int
        date: date
        is_absent: boolean
        note: string
        teacher()
        toggle()
    }

    class Schedule {
        id: int
        kelas_id: int
        teacher_id: int
        mapel_id: int
        day: string
        start_time: time
        end_time: time
        kelas()
        teacher()
        mapel()
    }

    class Kelas {
        id: int
        name: string
        room: string
        capacity: int
        students()
        schedules()
        weekTemplates()
    }

    class Mapel {
        id: int
        name: string
        code: string
        teacher_id: int
        teacher()
        schedules()
    }

    User <|-- Student : 1:1
    User <|-- Teacher : 1:1
    Student -- Kelas : belongs_to
    Student -- Attendance : 1:*
    Teacher -- Attendance : 1:*
    Teacher -- QrToken : 1:*
    Teacher -- TeacherAvailability : 1:*
    Teacher -- Schedule : 1:*
    Teacher -- Mapel : 1:*
    Kelas -- Schedule : 1:*
    Mapel -- Schedule : 1:*
    QrToken -- Attendance : via token
```

---

**Last Updated:** December 1, 2025
**Version:** 1.0
**Laravel Version:** 11
