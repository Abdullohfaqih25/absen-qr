<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Absensi QR')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    * {
      font-family: 'Inter', sans-serif;
    }
    
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      padding-bottom: 2rem;
    }
    
    .main-container {
      background: #f8f9fa;
      min-height: calc(100vh - 2rem);
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.1);
      margin-top: 1rem;
      overflow: hidden;
    }
    
    .content-wrapper {
      padding: 2rem;
    }
    
    /* Custom Navbar Styling */
    .navbar {
      background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
      padding: 1rem 2rem;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      border-radius: 20px 20px 0 0;
    }
    
    .navbar-brand {
      font-weight: 700;
      font-size: 1.5rem;
      color: #fff !important;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    
    .navbar-brand i {
      background: rgba(255,255,255,0.2);
      padding: 0.5rem;
      border-radius: 10px;
      font-size: 1.2rem;
    }
    
    .navbar-nav .nav-link {
      color: rgba(255,255,255,0.9) !important;
      font-weight: 500;
      padding: 0.5rem 1rem !important;
      margin: 0 0.25rem;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      background: rgba(255,255,255,0.15);
      color: #fff !important;
    }
    
    .navbar-toggler {
      border-color: rgba(255,255,255,0.3);
      padding: 0.5rem 0.75rem;
    }
    
    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
    
    .user-section {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }
    
    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: rgba(255,255,255,0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-weight: 600;
      border: 2px solid rgba(255,255,255,0.3);
    }
    
    .user-name {
      color: #fff;
      font-weight: 500;
      margin-bottom: 0;
      font-size: 0.95rem;
    }
    
    .btn-logout {
      background: rgba(255,255,255,0.15);
      color: #fff;
      border: 1px solid rgba(255,255,255,0.3);
      padding: 0.5rem 1.25rem;
      border-radius: 8px;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .btn-logout:hover {
      background: rgba(255,255,255,0.25);
      color: #fff;
      border-color: rgba(255,255,255,0.5);
      transform: translateY(-2px);
    }
    
    /* Alert Styling */
    .alert {
      border: none;
      border-radius: 12px;
      padding: 1rem 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    
    .alert-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: #fff;
    }
    
    .alert-danger {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
      color: #fff;
    }
    
    .alert-warning {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      color: #fff;
    }
    
    .alert-info {
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
      color: #fff;
    }
    
    /* Card Styling */
    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }
    
    .card:hover {
      box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }
    
    /* Button Styling */
    .btn {
      border-radius: 8px;
      padding: 0.5rem 1.25rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    
    .btn-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      border: none;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    
    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    
    .btn-warning {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      border: none;
      box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }
    
    .btn-warning:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
    }
    
    .btn-danger {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
      border: none;
      box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }
    
    .btn-danger:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }
    
    /* DataTables Custom Styling */
    .dataTables_wrapper {
      padding: 1rem 0;
    }
    
    .dataTables_wrapper .dataTables_filter input {
      border-radius: 8px;
      border: 1px solid #e9ecef;
      padding: 0.5rem 1rem;
      margin-left: 0.5rem;
    }
    
    .dataTables_wrapper .dataTables_length select {
      border-radius: 8px;
      border: 1px solid #e9ecef;
      padding: 0.5rem 1rem;
      margin: 0 0.5rem;
    }
    
    table.dataTable thead th {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      font-weight: 600;
      border: none;
      padding: 1rem;
    }
    
    table.dataTable tbody td {
      padding: 0.875rem 1rem;
      vertical-align: middle;
    }
    
    table.dataTable tbody tr:hover {
      background: #f8f9fa;
    }
    
    /* SweetAlert2 Custom */
    .swal2-popup {
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    }
    
    .swal2-title {
      font-weight: 700;
    }
    
    .swal2-confirm {
      border-radius: 8px !important;
      padding: 0.75rem 2rem !important;
      font-weight: 600 !important;
    }
    
    .swal2-cancel {
      border-radius: 8px !important;
      padding: 0.75rem 2rem !important;
      font-weight: 600 !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      .main-container {
        border-radius: 0;
        margin-top: 0;
      }
      
      .navbar {
        border-radius: 0;
        padding: 1rem;
      }
      
      .content-wrapper {
        padding: 1.5rem 1rem;
      }
      
      .user-section {
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
      }
      
      .btn-logout {
        width: 100%;
        margin-top: 0.5rem;
      }
    }
    
    /* Loading Animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .content-wrapper > * {
      animation: fadeIn 0.5s ease-out;
    }
  </style>
</head>
<body>
  <div class="container-fluid px-3 px-md-5">
    <div class="main-container">
      @include('components.navbar')
      <div class="content-wrapper">
        @include('components.alerts')
        @yield('content')
      </div>
    </div>
  </div>
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // DataTables Default Configuration
    $.extend($.fn.dataTable.defaults, {
      language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
        infoFiltered: "(disaring dari _MAX_ total data)",
        paginate: {
          first: "Pertama",
          last: "Terakhir",
          next: "Selanjutnya",
          previous: "Sebelumnya"
        },
        emptyTable: "Tidak ada data tersedia",
        zeroRecords: "Tidak ada data yang cocok"
      }
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
      $('.alert').fadeOut('slow');
    }, 5000);
    
    // SweetAlert2 Custom Configuration
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    });
    
    // Make Toast available globally
    window.Toast = Toast;
  </script>
  
  @stack('scripts')
</body>
</html>