@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')
<div class="dashboard-header mb-4">
  <h2 class="fw-bold">Dashboard Admin</h2>
  <p class="text-muted mb-0">Selamat datang di sistem absensi QR</p>
</div>

<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="card stats-card border-0 h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div class="icon-box bg-primary-subtle">
            <i class="fas fa-user-check text-primary"></i>
          </div>
          <span class="badge bg-success-subtle text-success">Hari Ini</span>
        </div>
        <h6 class="text-muted mb-2">Hadir Hari Ini</h6>
        <h2 class="fw-bold mb-0">{{ $totalHadir }}</h2>
      </div>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="card stats-card border-0 h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div class="icon-box bg-warning-subtle">
            <i class="fas fa-clock text-warning"></i>
          </div>
          <span class="badge bg-warning-subtle text-warning">Terlambat</span>
        </div>
        <h6 class="text-muted mb-2">Siswa Terlambat</h6>
        <h2 class="fw-bold mb-0">{{ $terlambat }} <small class="fs-6 text-muted">({{ $persenTerlambat }}%)</small></h2>
      </div>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="card stats-card border-0 h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div class="icon-box bg-info-subtle">
            <i class="fas fa-chart-line text-info"></i>
          </div>
          <span class="badge bg-info-subtle text-info">7 Hari</span>
        </div>
        <h6 class="text-muted mb-2">Tren Minggu Ini</h6>
        <canvas id="chartWeek" height="80"></canvas>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = {!! json_encode(array_column($week,'date')) !!};
  const data = {!! json_encode(array_column($week,'count')) !!};
  const ctx = document.getElementById('chartWeek').getContext('2d');
  
  const gradient = ctx.createLinearGradient(0, 0, 0, 100);
  gradient.addColorStop(0, 'rgba(13, 110, 253, 0.2)');
  gradient.addColorStop(1, 'rgba(13, 110, 253, 0)');
  
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Absensi',
        data: data,
        fill: true,
        backgroundColor: gradient,
        borderColor: 'rgba(13, 110, 253, 1)',
        borderWidth: 2,
        tension: 0.4,
        pointBackgroundColor: '#fff',
        pointBorderColor: 'rgba(13, 110, 253, 1)',
        pointBorderWidth: 2,
        pointRadius: 4,
        pointHoverRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.8)',
          padding: 12,
          cornerRadius: 8,
          titleColor: '#fff',
          bodyColor: '#fff'
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: { display: false },
          ticks: { display: false }
        },
        x: {
          grid: { display: false },
          ticks: { font: { size: 10 } }
        }
      }
    }
  });
</script>
@endpush