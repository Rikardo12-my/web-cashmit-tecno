<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashMit - Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Animate.css (optional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    @include('layout.partials.navbar_customer')
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="container-fluid mt-3">
        @yield('content')
    </div>

    <!-- Scripts -->
    <!-- jQuery (untuk kompatibilitas dengan kode yang ada) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Reset padding dan margin untuk full width */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        .main-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            height: 64px;
            width: 100%;
            position: relative;
        }
        
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 40px;
        }

        .timeline:before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-item.active .timeline-icon {
            background-color: #007bff;
            color: white;
        }

        .timeline-icon {
            position: absolute;
            left: -40px;
            top: 0;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        /* Card Outline Styles */
        .card-outline {
            border-top: 4px solid;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }

        .card-outline.card-primary {
            border-top-color: #007bff;
        }

        .card-outline.card-success {
            border-top-color: #28a745;
        }

        .card-outline.card-info {
            border-top-color: #17a2b8;
        }

        .card-outline.card-warning {
            border-top-color: #ffc107;
        }
        
        /* Responsive Design */
        @media (max-width: 767.98px) {
            .container-fluid {
                padding-left: 10px;
                padding-right: 10px;
            }
        }
        
        @media (min-width: 768px) {
            .container-fluid {
                padding-left: 20px;
                padding-right: 20px;
            }
        }
        
    </style>

    @stack('scripts')
</body>
</html>