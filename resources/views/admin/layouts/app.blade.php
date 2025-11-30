<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Admin Panel') - AbsensiQR</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      font-family: 'Inter', sans-serif;
    }
    
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
    }
    
    .main-wrapper {
      background: #f8f9fa;
      min-height: 100vh;
      margin-left: 260px;
      border-radius: 20px 0 0 20px;
      box-shadow: -10px 0 30px rgba(0,0,0,0.1);
    }
    
    .sidebar {
      height: 100vh;
      background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
      position: fixed;
      left: 0;
      top: 0;
      width: 260px;
      padding: 2rem 0;
      z-index: 1000;
    }
    
    .sidebar-brand {
      padding: 0 1.5rem 2rem;
      color: #fff;
      font-size: 1.5rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    
    .sidebar-brand i {
      background: rgba(255,255,255,0.2);
      padding: 0.5rem;
      border-radius: 10px;
      font-size: 1.2rem;
    }
    
    .sidebar .nav-link {
      color: rgba(255,255,255,0.8);
      padding: 0.875rem 1.5rem;
      margin: 0.25rem 1rem;
      border-radius: 10px;
      transition: all 0.3s ease;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    
    .sidebar .nav-link:hover {
      background: rgba(255,255,255,0.1);
      color: #fff;
      transform: translateX(5px);
    }
    
    .sidebar .nav-link.active {
      background: rgba(255,255,255,0.2);
      color: #fff;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .sidebar .nav-link i {
      width: 20px;
      text-align: center;
    }
    
    .topbar {
      background: #fff;
      border-bottom: 1px solid #e9ecef;
      padding: 1.25rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-radius: 20px 0 0 0;
    }
    
    .user-section {
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    
    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-weight: 600;
    }
    
    .user-info {
      display: flex;
      flex-direction: column;
    }
    
    .user-name {
      font-weight: 600;
      font-size: 0.95rem;
      margin-bottom: 0;
    }
    
    .user-role {
      font-size: 0.75rem;
      color: #6c757d;
    }
    
    .btn-logout {
      padding: 0.5rem 1.25rem;
      border-radius: 8px;
      font-weight: 500;
      border: 1px solid #e9ecef;
      background: #fff;
      transition: all 0.3s ease;
    }
    
    .btn-logout:hover {
      background: #f8f9fa;
      border-color: #dee2e6;
      transform: translateY(-2px);
    }
    
    .content-area {
      padding: 2rem;
    }
    
    .stats-card {
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      background: #fff;
    }
    
    .stats-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }
    
    .icon-box {
      width: 50px;
      height: 50px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
    }
    
    .bg-primary-subtle {
      background: rgba(13, 110, 253, 0.1) !important;
    }
    
    .bg-warning-subtle {
      background: rgba(255, 193, 7, 0.1) !important;
    }
    
    .bg-info-subtle {
      background: rgba(13, 202, 240, 0.1) !important;
    }
    
    .bg-success-subtle {
      background: rgba(25, 135, 84, 0.1) !important;
    }
    
    .badge {
      padding: 0.35rem 0.75rem;
      border-radius: 6px;
      font-weight: 500;
      font-size: 0.75rem;
    }
    
    .dashboard-header h2 {
      color: #1e293b;
      margin-bottom: 0.5rem;
    }
    
    .dashboard-header p {
      font-size: 0.95rem;
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }
      
      .sidebar.show {
        transform: translateX(0);
      }
      
      .main-wrapper {
        margin-left: 0;
        border-radius: 0;
      }
      
      .topbar {
        border-radius: 0;
      }
      
      #toggleSidebar {
        display: block !important;
      }
    }
    
    #toggleSidebar {
      display: none;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      font-size: 1.25rem;
    }
  </style>
</head>
<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <div class="sidebar-brand">
        <i class="fas fa-qrcode"></i>
        <span>AbsensiQR</span>
      </div>
      <hr style="border-color: rgba(255,255,255,0.2); margin: 0 1.5rem 1rem;">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="fa fa-chart-line"></i>Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/students*') ? 'active' : '' }}" href="{{ route('admin.students.index') }}">
            <i class="fa fa-user-graduate"></i>Data Siswa
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/teachers*') ? 'active' : '' }}" href="{{ route('admin.teachers.index') }}">
            <i class="fa fa-chalkboard-teacher"></i>Data Guru
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/kelas*') ? 'active' : '' }}" href="{{ route('admin.kelas.index') }}">
            <i class="fa fa-school"></i>Kelas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/mapels*') ? 'active' : '' }}" href="{{ route('admin.mapels.index') }}">
            <i class="fa fa-book"></i>Mapel
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/schedules*') ? 'active' : '' }}" href="{{ route('admin.schedules.index') }}">
            <i class="fa fa-calendar"></i>Jadwal
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/day-templates*') ? 'active' : '' }}" href="{{ route('admin.day-templates.index') }}">
            <i class="fa fa-clock"></i>Day
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/week-templates*') ? 'active' : '' }}" href="{{ route('admin.week-templates.index') }}">
            <i class="fa fa-calendar-alt"></i>Week
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/attendances*') ? 'active' : '' }}" href="{{ route('admin.attendances.index') }}">
            <i class="fa fa-clipboard-list"></i>Absensi
          </a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="main-wrapper flex-fill">
      <nav class="topbar">
        <div>
          <button class="btn btn-sm" id="toggleSidebar">
            <i class="fas fa-bars"></i>
          </button>
        </div>
        <div class="user-section">
          <div class="user-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'G', 0, 1)) }}
          </div>
          <div class="user-info d-none d-md-block">
            <div class="user-name">{{ auth()->user()->name ?? 'Guest' }}</div>
            <div class="user-role">Administrator</div>
          </div>
          <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button class="btn btn-logout">
              <i class="fas fa-sign-out-alt me-2"></i>Logout
            </button>
          </form>
        </div>
      </nav>

      <div class="content-area">
        @include('components.alerts')
        @yield('content')
      </div>
    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Toggle Sidebar for Mobile
  document.getElementById('toggleSidebar')?.addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('show');
  });
  
  // Active Menu Highlight
  document.querySelectorAll('.sidebar .nav-link').forEach(link => {
    if (link.href === window.location.href) {
      link.classList.add('active');
    }
  });
</script>
@stack('scripts')
</body>
</html>