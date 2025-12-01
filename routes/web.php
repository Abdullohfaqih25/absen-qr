<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Siswa\ScanController;
use App\Http\Controllers\Guru\QRController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\DayTemplateController;
use App\Http\Controllers\Admin\WeekTemplateController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;

Route::get('/', function(){ 
    if(auth()->check()) {
        if(auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif(auth()->user()->isGuru()) {
            return redirect()->route('guru.qr.show');
        } else {
            return redirect()->route('siswa.scan');
        }
    }
    return redirect()->route('login'); 
});

// Admin-specific login page (public). If already authenticated as admin, redirect to dashboard.
Route::get('/admin', function(Request $request){
    if(auth()->check() && auth()->user()->isAdmin()){
        return redirect()->route('admin.dashboard');
    }
    return view('auth.admin-login');
})->name('admin.login.public');

// Auth Routes
Route::middleware('guest')->group(function(){
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Siswa
Route::middleware(['auth','role:siswa','nocache'])->prefix('siswa')->name('siswa.')->group(function(){
    Route::get('dashboard', [SiswaDashboardController::class,'index'])->name('dashboard');
    Route::get('scan', [ScanController::class,'scanPage'])->name('scan');
    Route::post('scan', [ScanController::class,'store'])->name('scan.store');
    Route::get('jadwal', [\App\Http\Controllers\Siswa\ScheduleController::class,'index'])->name('jadwal.index');
});

// Guru
Route::middleware(['auth','role:guru','nocache'])->prefix('guru')->name('guru.')->group(function(){
    Route::get('dashboard', [GuruDashboardController::class,'index'])->name('dashboard');
    Route::get('qr', [QRController::class,'showToday'])->name('qr.show');
    Route::post('qr/regenerate', [QRController::class,'regenerate'])->name('qr.regenerate');
    Route::get('realtime', [QRController::class,'realtimeList'])->name('qr.realtime');
    Route::post('availability/toggle', [\App\Http\Controllers\Guru\AvailabilityController::class,'toggle'])->name('availability.toggle');
});

// Admin
Route::prefix('admin')->middleware(['auth','role:admin','nocache'])->name('admin.')->group(function(){
    Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::resource('mapels', MapelController::class);
    Route::resource('day-templates', DayTemplateController::class);
    Route::resource('week-templates', WeekTemplateController::class);
    Route::get('attendances/export', [AttendanceController::class,'export'])->name('attendances.export');
    Route::get('attendances', [AttendanceController::class,'index'])->name('attendances.index');
});
