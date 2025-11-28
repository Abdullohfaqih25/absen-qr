<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Admin Panel') - AbsensiQR</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body{background:#f4f6f9}
    .sidebar{height:100vh;background:#fff;border-right:1px solid #e6e6e6}
    .sidebar .nav-link{color:#333}
    .topbar{background:#fff;border-bottom:1px solid #e6e6e6}
    .card-ghost{box-shadow:none;border:1px solid #e9ecef}
  </style>
</head>
<body>
  <div class="d-flex">
    <div class="sidebar p-3" style="width:250px;">
      <h5>AbsensiQR</h5>
      <hr>
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fa fa-chart-line me-2"></i>Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.students.index') }}"> <i class="fa fa-user-graduate me-2"></i>Data Siswa</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.teachers.index') }}"> <i class="fa fa-chalkboard-teacher me-2"></i>Data Guru</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.kelas.index') }}"> <i class="fa fa-school me-2"></i>Kelas</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.schedules.index') }}"> <i class="fa fa-calendar me-2"></i>Jadwal</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('admin.attendances.index') }}"> <i class="fa fa-clipboard-list me-2"></i>Absensi</a></li>
      </ul>
    </div>
    <div class="flex-fill">
      <nav class="topbar p-2 d-flex justify-content-between align-items-center">
        <div>
          <button class="btn btn-sm btn-light d-md-none" id="toggleSidebar">≡</button>
        </div>
        <div>
          <span class="me-3">{{ auth()->user()->name ?? 'Guest' }}</span>
          <form method="POST" action="{{ route('logout') }}" style="display:inline">@csrf<button class="btn btn-sm btn-outline-secondary">Logout</button></form>
        </div>
      </nav>

      <div class="p-4">
        @include('components.alerts')
        @yield('content')
      </div>

    </div>
  </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
