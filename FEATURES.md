# 🎯 AbsenQR - Complete Features Documentation

Dokumentasi lengkap semua fitur yang tersedia di aplikasi AbsenQR.

---

## 📊 Admin Dashboard

### Statistik Harian
- **Hadir Hari Ini** - Jumlah siswa yang hadir hari ini
- **Terlambat** - Jumlah dan persentase siswa terlambat
- **Chart Mingguan** - Grafik absensi 7 hari terakhir

### Navigasi Sidebar
- Dashboard
- Data Siswa
- Data Guru
- Kelas
- Jadwal
- Absensi
- Logout

---

## 👥 Management Data Siswa

### Features:
- **List View** dengan pagination (25 per halaman)
- **Search** berdasarkan:
  - NIS (Nomor Induk Siswa)
  - Nama lengkap
- **Tampil Info:**
  - NIS
  - Nama
  - Kelas
  - Action buttons

### CRUD Operations:
- **Create** - Tambah siswa baru
  - Input: NIS, Nama
  - Auto generate email: {nis}@student.absenqr.local
  - Auto create user account
  
- **Read** - Lihat daftar siswa
  - Pagination support
  - Search functionality
  
- **Update** - Edit data siswa
  - Edit NIS dan Nama
  - Update user account
  
- **Delete** - Hapus siswa
  - Confirmation dialog
  - Cascade delete user account

### Validations:
- ✅ NIS: Required, Unique
- ✅ Nama: Required
- ✅ Email: Auto-generated, Unique

---

## 👨‍🏫 Management Data Guru

### Features:
- **List View** dengan pagination
- **Tampil Info:**
  - Nama Guru
  - Email
  - NIP
  - Action buttons

### CRUD Operations:
- **Create** - Tambah guru baru
  - Input: Nama, Email (optional), NIP (optional)
  - Auto generate email jika tidak diisi
  - Auto create user account
  
- **Read** - Lihat daftar guru
  - Simple list view
  
- **Update** - Edit guru
  - Edit semua field
  
- **Delete** - Hapus guru
  - Cascade delete user account

### Validations:
- ✅ Nama: Required
- ✅ Email: Optional, Unique
- ✅ NIP: Optional, Unique

---

## 🏫 Management Kelas

### Features:
- **List View** dengan informasi:
  - Nama Kelas
  - Ruangan
  - Jumlah Siswa (dihitung dari students)
  - Action buttons

### CRUD Operations:
- **Create** - Tambah kelas baru
  - Input: Nama kelas, Ruangan (optional)
  
- **Read** - Lihat semua kelas
  - Dengan jumlah siswa
  
- **Update** - Edit kelas
  - Edit nama dan ruangan
  
- **Delete** - Hapus kelas
  - Confirmation dialog

### Validations:
- ✅ Nama: Required
- ✅ Ruangan: Optional

---

## 📚 Management Jadwal Pelajaran

### Features:
- **List View** dengan detail:
  - Kelas
  - Guru
  - Mata Pelajaran
  - Hari
  - Waktu (dari - sampai)
  - Action buttons

### CRUD Operations:
- **Create** - Tambah jadwal baru
  - Dropdown: Pilih Kelas
  - Dropdown: Pilih Guru
  - Input: Mata Pelajaran (text)
  - Dropdown: Hari (Senin-Sabtu)
  - Time Picker: Jam Mulai
  - Time Picker: Jam Selesai
  
- **Read** - Lihat semua jadwal
  - Formatted dengan relasi kelas & guru
  
- **Update** - Edit jadwal
  - Bisa mengubah semua field
  
- **Delete** - Hapus jadwal
  - Confirmation dialog

### Validations:
- ✅ Kelas: Required
- ✅ Guru: Required
- ✅ Mata Pelajaran: Required
- ✅ Hari: Required (Monday-Saturday)
- ✅ Jam Mulai: Required, Time format
- ✅ Jam Selesai: Required, Time format

---

## 📋 Attendance Management

### Features:
- **List View** dengan informasi:
  - NIS Siswa
  - Nama Siswa
  - Kelas
  - Tanggal & Waktu (format: DD-MM-YYYY HH:MM)
  - Status (Hadir/Terlambat)

### Filter Options:
- **Berdasarkan Tanggal** - Filter absensi pada tanggal tertentu
- **Berdasarkan Kelas** - Lihat absensi kelas tertentu
- **Berdasarkan NIS/Nama** - Cari absensi siswa

### Status Indicators:
- 🟢 **Hadir** - Green badge
- 🟡 **Terlambat** - Yellow badge
- 🔴 **Izin/Alpha** - Red badge

### Export Features:
- **Export to Excel** (.xlsx format)
- Dengan filter yang sedang aktif
- Semua kolom include dalam export
- Timestamp untuk referensi

### Pagination:
- 25 records per halaman
- Navigation buttons
- Jump to page

---

## 🔐 Authentication

### Login Features:
- **Email-based login**
- **Password authentication** dengan bcrypt hashing
- **Remember me** checkbox
- **Error handling** dengan message yang jelas

### Role-based Redirect:
- Admin → `/admin/dashboard`
- Guru → `/guru/qr.show`
- Siswa → `/siswa/scan`

### Session Management:
- Session timeout configuration
- Secure cookies
- CSRF token protection

### Logout:
- Secure session destruction
- Redirect to login

---

## 🎨 UI/UX Features

### Responsive Design:
- ✅ Desktop (full-width)
- ✅ Tablet (optimized layout)
- ✅ Mobile (hamburger menu)

### Components:
- **Navbar** - Navigasi top dengan user info
- **Sidebar** - Navigation menu dengan icons
- **Forms** - Input validation feedback
- **Tables** - DataTables integration
- **Modals** - Confirmation dialogs
- **Cards** - Dashboard statistics
- **Badges** - Status indicators

### Visual Elements:
- Bootstrap 5 framework
- Font Awesome 6 icons
- Chart.js untuk grafik
- DataTables plugin
- SweetAlert2 notifications
- Custom CSS styling

---

## 🔧 Technical Features

### Backend:
- Laravel 11 framework
- Eloquent ORM
- Model relationships
- Query builder
- Migration system
- Seeding system

### Database:
- MySQL/MariaDB
- Proper indexing
- Foreign keys
- Cascading deletes
- Timestamp tracking (created_at, updated_at)

### Security:
- CSRF protection
- SQL injection prevention
- XSS protection
- Password hashing (bcrypt)
- Middleware authentication
- Role-based authorization

### Validation:
- Server-side validation
- Form request validation
- Unique constraints
- Required fields
- Email format validation
- Time format validation

---

## 📊 Data Export

### Excel Export Features:
- **Attendance Export:**
  - Filtered data export
  - Maintain filter criteria
  - Professional formatting
  - Date formatted
  - All columns included

### Export Format:
- Excel 2007+ (.xlsx)
- Proper column headers
- Date/time formatting
- Number formatting

---

## 🔔 Notifications

### User Feedback:
- **Success Messages:**
  - "Siswa ditambahkan"
  - "Diupdate"
  - "Dihapus"
  
- **Error Messages:**
  - Validation errors
  - Business logic errors
  - System errors

### Notification Style:
- SweetAlert2 popups
- Toast notifications
- In-page alerts
- Confirmation dialogs

---

## 📱 Mobile Features

### Responsive Views:
- Collapsible sidebar
- Touch-friendly buttons
- Optimized table layout
- Mobile-optimized forms

### Mobile Considerations:
- Smaller font sizes
- Reduced padding
- Single-column layouts
- Bottom navigation option

---

## 🔍 Search & Filter Features

### Student Search:
- Real-time search
- Search by NIS or Name
- Case-insensitive matching
- Partial string matching

### Attendance Filters:
- Date range filtering
- Class-based filtering
- Student-based search
- Chained filtering
- Reset filter option

---

## 📈 Reporting Features

### Dashboard Report:
- Daily attendance count
- Attendance percentage
- 7-day trend chart
- Real-time statistics

### Attendance Report:
- List view with filtering
- Export capability
- Date range support
- Class-wise breakdown

---

## ⚙️ Configuration Features

### App Configuration:
- Configurable pagination
- Customizable table rows per page
- Session timeout
- Cache configuration
- Database configuration

### Role Configuration:
- Admin access
- Guru access  
- Siswa access
- Route protection

---

## 🚀 Performance Features

### Optimization:
- Eager loading (with())
- Pagination for large datasets
- Caching support
- Database indexing
- Query optimization

### Asset Loading:
- CSS/JS bundling
- CDN resources
- Minified assets
- Lazy loading support

---

## 🔄 Data Management

### Automatic Features:
- Auto-generate emails
- Auto-create user accounts
- Timestamp auto-update
- Soft delete support (optional)

### Data Validation:
- Unique constraint checking
- Foreign key validation
- Format validation
- Required field checking

---

## 📚 Additional Features

### User Management:
- Role assignment
- Account activation
- Password management
- Email verification support

### Audit Trail:
- Created/Updated timestamps
- User tracking (future)
- Activity logging (future)

### Extensibility:
- Easy to add new roles
- Easy to add new features
- Modular controller structure
- Reusable components

---

## 🎓 Demo/Testing Features

### Seeding:
- Sample admin user
- Sample kelas data
- Sample student data
- Sample teacher data
- Sample schedule data
- QR tokens for testing

### Fake Data:
- Faker for realistic data
- Factory patterns
- Customizable seeds

---

## 🏁 Conclusion

AbsenQR provides a **complete, production-ready** attendance management system dengan:
- ✅ Full CRUD functionality
- ✅ Role-based access control
- ✅ Professional UI/UX
- ✅ Data export capabilities
- ✅ Responsive design
- ✅ Comprehensive documentation

---

*Documentation Version: 1.0*
*Last Updated: November 28, 2025*
