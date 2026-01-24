<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CashMit | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/summernote/summernote-bs4.min.css')}}">
  
  <!-- Custom Styles untuk Navbar -->
  <style>
    :root {
      --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      --primary-light: #f0f5ff;
      --secondary-color: #6c757d;
      --success-color: #10b981;
      --info-color: #3b82f6;
      --warning-color: #f59e0b;
      --danger-color: #ef4444;
    }

    /* =========================================
       FIX UTAMA AGAR NAVBAR TIDAK GESER KE KANAN
       ========================================= */
    .main-header {
      margin-left: 0 !important; /* Hapus efek AdminLTE */
      width: 100% !important;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
      border-bottom: 1px solid #e9ecef;
      background: white !important;
    }

    .main-header .container-fluid {
      padding-left: 0 !important;
      padding-right: 0 !important;
    }

    /* Navbar Styling */
    .navbar-light .navbar-nav .nav-link {
      color: #4b5563;
      font-weight: 500;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      transition: all 0.2s ease;
      position: relative;
      display: flex;
      align-items: center;
    }

    .navbar-light .navbar-nav .nav-link:hover {
      color: #3b82f6;
      background-color: #f8fafc;
    }

    .navbar-light .navbar-nav .nav-link.active {
      color: #3b82f6;
      background-color: #eff6ff;
    }

    .navbar-light .navbar-nav .nav-link.active:after {
      content: '';
      position: absolute;
      bottom: -1px;
      left: 1rem;
      right: 1rem;
      height: 3px;
      background: #3b82f6;
      border-radius: 3px 3px 0 0;
    }

    /* Notification Badge */
    .navbar-badge {
      font-size: 0.6rem;
      padding: 0.15rem 0.35rem;
      position: absolute;
      top: 8px;
      right: 5px;
    }

    /* User Dropdown */
    .nav-item.dropdown .nav-link {
      padding-right: 0.5rem;
    }

    .user-dropdown-header {
      min-width: 280px;
      padding: 1.5rem 1rem;
      background: linear-gradient(135deg, #f0f5ff 0%, #e6f0ff 100%);
      border-bottom: 1px solid #e5e7eb;
    }

    .user-avatar {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border: 3px solid white;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .user-avatar-placeholder {
      width: 50px;
      height: 50px;
      background: var(--primary-gradient);
      display: flex;
      align-items: center;
      justify-content: center;
      border: 3px solid white;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .status-dot{
      bottom: 1px;
      right: 18px;
    }

    /* Dropdown Menu */
    .dropdown-menu {
      border: 1px solid #e5e7eb;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      border-radius: 0.5rem;
      overflow: hidden;
    }

    .dropdown-item {
      padding: 0.75rem 1.25rem;
      color: #4b5563;
      transition: all 0.2s;
      display: flex;
      align-items: center;
    }

    .dropdown-item:hover {
      background-color: #f8fafc;
      color: #3b82f6;
      padding-left: 1.5rem;
    }

    /* Role Badges */
    .role-badge {
      font-size: 0.7rem;
      padding: 0.25rem 0.5rem;
      border-radius: 50rem;
      font-weight: 600;
    }

    .badge-admin {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: white;
    }

    .badge-supervisor {
      background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
      color: white;
    }

    .badge-petugas {
      background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
      color: white;
    }

    /* Mobile Responsiveness */
    @media (max-width: 767.98px) {
      .navbar-nav {
        padding-top: 0.5rem;
      }

      .navbar-light .navbar-nav .nav-link {
        padding: 0.75rem 1rem;
        border-radius: 0;
        border-bottom: 1px solid #f1f5f9;
      }

      .navbar-light .navbar-nav .nav-link.active:after {
        left: 0;
        right: 0;
        bottom: 0;
      }

      .nav-item.dropdown .dropdown-menu {
        position: absolute !important;
        margin-top: 0;
      }
    }

    /* Preloader */
    .preloader {
      background: white;
    }

    .animation__shake {
      animation: shake 0.82s cubic-bezier(.36,.07,.19,.97) both infinite;
      transform: translate3d(0, 0, 0);
    }

    @keyframes shake {
      10%, 90% { transform: translate3d(-1px, 0, 0); }
      20%, 80% { transform: translate3d(2px, 0, 0); }
      30%, 50%, 70% { transform: translate3d(-2px, 0, 0); }
      40%, 60% { transform: translate3d(2px, 0, 0); }
    }
</style>
</head>
<body>
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('adminlte/dist/img/LogoCashMit.png')}}" alt="CashmitLogo" height="60" width="60">
  </div>

@include('layout.partials.navbar_petugas')

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->

  <footer class="main-footer flex flex-col sm:flex-row justify-between items-center sm:items-baseline space-y-2 sm:space-y-0">
    <div class="mb-2 md:mb-0">
      <span class="font-semibold text-indigo-600">CASHMIT</span> 
      <span class="text-gray-400">© {{ date('Y') }}</span>
      <span class="hidden sm:inline">— Solusi Tarik Tunai Digital Mahasiswa</span>
    </div>
    <div class="flex items-center space-x-4">
      <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-medium">
        Campus Fintech
      </span>
      <span class="text-xs text-gray-400">
        v1.0.0
      </span>
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/dist/js/adminlte.js')}}"></script>

<!-- Custom Script untuk Interaksi -->
<script>
  $(document).ready(function() {
    // Highlight active nav item
    $('.navbar-nav .nav-link').each(function() {
      if ($(this).hasClass('active')) {
        $(this).closest('.nav-item').addClass('active-item');
      }
    });
    
    // Notification dropdown animation
    $('.dropdown-toggle').on('click', function(e) {
      e.stopPropagation();
    });
    
    // Mobile menu close on click
    $('.navbar-nav .nav-link').on('click', function() {
      $('.navbar-collapse').collapse('hide');
    });
    
    // Add ripple effect to dropdown items
    $('.dropdown-item').on('click', function(e) {
      let $div = $('<div/>'),
          btnOffset = $(this).offset(),
          xPos = e.pageX - btnOffset.left,
          yPos = e.pageY - btnOffset.top;
      
      $div.addClass('ripple-effect');
      $div.css({
        top: yPos,
        left: xPos,
        background: $(this).data('ripple-color') || 'rgba(59, 130, 246, 0.3)'
      });
      
      $(this).append($div);
      
      window.setTimeout(function() {
        $div.remove();
      }, 2000);
    });
  });
</script>

@yield('js')
</body>
</html>