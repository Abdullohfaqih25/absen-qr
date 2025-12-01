@extends('layouts.app')
@section('title','Dashboard Siswa')
@section('content')
<div class="dashboard-header mb-4">
  <h2 class="fw-bold">Dashboard Siswa</h2>
  <p class="text-muted mb-0">Selamat datang, {{ $student->name ?? 'Siswa' }}</p>
</div>

<div class="row g-4">
  <!-- Profile & Attendance Card -->
  <div class="col-lg-5">
    <div class="card profile-card border-0 h-100">
      <div class="card-body p-4">
        <!-- Profile Section -->
        <div class="profile-section mb-4">
          <div class="d-flex align-items-center mb-4">
            @if(isset($student) && $student->photo)
              <div class="profile-photo-wrapper">
                <img src="{{ asset('storage/' . $student->photo) }}" alt="Foto {{ $student->name }}" class="profile-photo">
                <div class="status-indicator"></div>
              </div>
            @else
              <div class="profile-photo-wrapper">
                <div class="profile-avatar">
                  {{ strtoupper(substr($student->name ?? 'S',0,1)) }}
                </div>
                <div class="status-indicator"></div>
              </div>
            @endif
            <div class="ms-3 flex-grow-1">
              <h5 class="mb-1 fw-bold">{{ $student->name ?? 'Siswa' }}</h5>
              <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary-subtle text-primary">
                  <i class="fas fa-id-card me-1"></i>{{ $student->nis ?? '-' }}
                </span>
                <span class="badge bg-success-subtle text-success">
                  <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Aktif
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Attendance Stats -->
        <div class="attendance-stats mb-4">
          <div class="stats-header mb-3">
            <h6 class="fw-semibold mb-0">
              <i class="fas fa-chart-bar text-primary me-2"></i>Rekap Kehadiran
            </h6>
          </div>
          
          <div class="stats-box mb-3">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <div class="text-muted small mb-1">Total Kehadiran</div>
                <h3 class="fw-bold mb-0">{{ $totalPresent }}</h3>
              </div>
              <div class="icon-circle bg-primary-subtle">
                <i class="fas fa-check text-primary"></i>
              </div>
            </div>
          </div>

          @if($last)
            <div class="last-attendance">
              <div class="d-flex align-items-start gap-3">
                <div class="timeline-dot"></div>
                <div class="flex-grow-1">
                  <div class="small text-muted mb-1">Kehadiran Terakhir</div>
                  <div class="fw-semibold">{{ $last->absent_at }}</div>
                  <span class="badge bg-{{ $last->status == 'hadir' ? 'success' : ($last->status == 'terlambat' ? 'warning' : 'danger') }}-subtle text-{{ $last->status == 'hadir' ? 'success' : ($last->status == 'terlambat' ? 'warning' : 'danger') }} mt-2">
                    {{ ucfirst($last->status) }}
                  </span>
                </div>
              </div>
            </div>
          @else
            <div class="empty-state text-center py-3">
              <i class="fas fa-calendar-times text-muted mb-2" style="font-size: 2rem;"></i>
              <p class="text-muted small mb-0">Belum ada riwayat absen</p>
            </div>
          @endif
        </div>

        <!-- Scanner Button -->
        <a class="btn btn-primary btn-scanner w-100" href="{{ route('siswa.scan') }}">
          <i class="fas fa-qrcode me-2"></i>Buka Scanner QR
        </a>
      </div>
    </div>
  </div>

  <!-- Today's Schedule Card -->
  <div class="col-lg-7">
    <div class="card schedule-card border-0 h-100">
      <div class="card-body p-4">
        <div class="schedule-header mb-4">
          <div class="d-flex justify-content-between align-items-center">
            <h6 class="fw-semibold mb-0">
              <i class="fas fa-calendar-day text-info me-2"></i>Jadwal Pelajaran Hari Ini
            </h6>
            <div class="d-flex align-items-center gap-2">
              <span class="badge bg-info-subtle text-info">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</span>
              <a href="{{ route('siswa.jadwal.index') }}" class="btn btn-sm btn-outline-primary">Lihat Jadwal</a>
            </div>
          </div>
        </div>

        @if(isset($todaySchedules) && $todaySchedules->count())
          <div class="schedule-list">
            @foreach($todaySchedules as $index => $sch)
              <div class="schedule-item {{ $loop->last ? '' : 'mb-3' }}">
                <div class="d-flex gap-3">
                  <div class="schedule-time">
                    <div class="time-badge">
                      <i class="fas fa-clock"></i>
                      <div class="time-text">
                        <div class="fw-semibold">{{ $sch->start_time }}</div>
                        <div class="small">{{ $sch->end_time }}</div>
                      </div>
                    </div>
                  </div>
                  <div class="schedule-content flex-grow-1">
                    <div class="subject-card">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-semibold mb-0">{{ $sch->subject }}</h6>
                        <span class="badge bg-light text-dark">
                          Sesi {{ $index + 1 }}
                        </span>
                      </div>
                      <div class="d-flex align-items-center gap-2 text-muted small">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>{{ $sch->teacher_name ?? ($sch->teacher->name ?? 'Guru tidak tersedia') }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="empty-state-schedule text-center py-5">
            <div class="empty-icon mb-3">
              <i class="fas fa-calendar-times text-muted"></i>
            </div>
            <h6 class="text-muted mb-2">Tidak Ada Pelajaran</h6>
            <p class="text-muted small mb-0">Tidak ada jadwal pelajaran untuk hari ini</p>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Weekly Schedule -->
<div class="row mt-4">
  <div class="col-12">
    <div class="card border-0">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h6 class="fw-semibold mb-0"><i class="fas fa-calendar-week text-primary me-2"></i>Jadwal Mingguan (Minggu {{ \Carbon\Carbon::now()->weekOfYear % 2 ? 1 : 2 }})</h6>
          <div class="small text-muted">Kelas: {{ $student->kelas?->name ?? '-' }}</div>
        </div>

        <div class="row">
          @php
            $weekDays = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
          @endphp
          @foreach($weekDays as $wd)
            <div class="col-md-6 col-lg-4 mb-3">
              <div class="card h-100">
                <div class="card-header fw-bold">{{ \Carbon\Carbon::parse($wd)->isoFormat('dddd') }}</div>
                <div class="card-body p-3">
                  @if(isset($weekSchedules[$wd]) && count($weekSchedules[$wd]))
                    @foreach($weekSchedules[$wd] as $slot)
                      <div class="mb-2">
                        <div class="small text-muted">{{ $slot->start_time }} - {{ $slot->end_time }}</div>
                        <div class="fw-semibold">{{ $slot->subject ?? '-' }}</div>
                        <div class="small text-muted">{{ $slot->teacher ?? '-' }}</div>
                      </div>
                    @endforeach
                  @else
                    <div class="text-muted small">Tidak ada jadwal</div>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<style>
.dashboard-header h2 {
  color: #1e293b;
  margin-bottom: 0.5rem;
}

.profile-card, .schedule-card {
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
  background: #fff;
}

.profile-card:hover, .schedule-card:hover {
  box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}

.profile-photo-wrapper {
  position: relative;
}

.profile-photo {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid #fff;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.profile-avatar {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-weight: 700;
  font-size: 2rem;
  border: 4px solid #fff;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.status-indicator {
  position: absolute;
  bottom: 5px;
  right: 5px;
  width: 16px;
  height: 16px;
  background: #10b981;
  border: 3px solid #fff;
  border-radius: 50%;
  box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
}

.stats-box {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  padding: 1.25rem;
  border-radius: 12px;
}

.icon-circle {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
}

.bg-primary-subtle {
  background: rgba(13, 110, 253, 0.1) !important;
}

.bg-success-subtle {
  background: rgba(25, 135, 84, 0.1) !important;
}

.bg-info-subtle {
  background: rgba(13, 202, 240, 0.1) !important;
}

.bg-warning-subtle {
  background: rgba(255, 193, 7, 0.1) !important;
}

.bg-danger-subtle {
  background: rgba(220, 53, 69, 0.1) !important;
}

.last-attendance {
  background: #f8f9fa;
  padding: 1rem;
  border-radius: 10px;
  border-left: 3px solid #0d6efd;
}

.timeline-dot {
  width: 12px;
  height: 12px;
  background: #0d6efd;
  border-radius: 50%;
  margin-top: 5px;
  flex-shrink: 0;
}

.btn-scanner {
  padding: 0.875rem 1.5rem;
  border-radius: 10px;
  font-weight: 600;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(13, 110, 253, 0.2);
}

.btn-scanner:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(13, 110, 253, 0.3);
}

.schedule-item {
  padding-bottom: 1rem;
  border-bottom: 1px solid #e9ecef;
}

.schedule-item:last-child {
  border-bottom: none;
  padding-bottom: 0;
}

.schedule-time {
  flex-shrink: 0;
}

.time-badge {
  background: linear-gradient(135deg, #0dcaf0 0%, #0891b2 100%);
  color: #fff;
  padding: 0.75rem 1rem;
  border-radius: 10px;
  text-align: center;
  min-width: 90px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.25rem;
  box-shadow: 0 4px 15px rgba(13, 202, 240, 0.2);
}

.time-badge i {
  font-size: 1.25rem;
  margin-bottom: 0.25rem;
}

.time-text {
  font-size: 0.75rem;
  line-height: 1.2;
}

.subject-card {
  background: #f8f9fa;
  padding: 1rem;
  border-radius: 10px;
  border-left: 3px solid #0dcaf0;
}

.empty-state {
  padding: 2rem 0;
}

.empty-state-schedule {
  padding: 3rem 0;
}

.empty-icon {
  font-size: 3rem;
  color: #dee2e6;
}

.empty-icon i {
  font-size: 4rem;
}

.badge {
  padding: 0.35rem 0.75rem;
  border-radius: 6px;
  font-weight: 500;
  font-size: 0.75rem;
}

@media (max-width: 768px) {
  .schedule-time {
    display: none;
  }
  
  .subject-card {
    border-left: none;
    border-top: 3px solid #0dcaf0;
  }
}
</style>
@endsection