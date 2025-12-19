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
</head>
<body >
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('adminlte/dist/img/LogoCashMit.png')}}" alt="CashmitLogo" height="60" width="60">
  </div>

  <!-- Navbar -->
 @include('layout.partials.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 @include('layout.partials.sidebar')

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
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{asset('adminlte/dist/js/demo.js')}}"></script> -->

@yield('js')
</body>
</html>
