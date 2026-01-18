<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashMit - Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
     <!-- Navbar -->
 @include('layout.partials.navbar_customer')
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
@yield('content')

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
            padding-left: 0;
            padding-right: 0;
        }
        
        .navbar-nav {
            flex-direction: row;
        }
        
        /* Navigation Links */
        .nav-link {
            color: #64748b;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
            margin: 0 4px;
            font-size: 0.95rem;
        }
        
        .nav-link:hover {
            color: #4A90E2;
            background-color: #f0f7ff;
            transform: translateY(-1px);
        }
        
        .nav-link.active {
            color: white !important;
            background: linear-gradient(135deg, #4A90E2 0%, #87CEEB 100%);
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.25);
        }
        
        .nav-link.active:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(74, 144, 226, 0.35);
        }
        
        /* Dropdown Menus */
        .dropdown-menu {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            animation: fadeIn 0.2s ease;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-header {
            border-radius: 12px 12px 0 0;
        }
        
        .dropdown-item {
            border-radius: 8px;
            margin: 2px 8px;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background-color: #f0f7ff;
            padding-left: 20px;
        }
        
        /* Notification Badge */
        .badge {
            font-size: 0.65em;
            font-weight: 600;
        }
        
        /* Avatar Styles */
        .rounded-circle {
            border: 2px solid transparent;
            transition: border-color 0.2s ease;
        }
        
        .nav-link:hover .rounded-circle {
            border-color: #4A90E2;
        }
        
        /* Responsive Design */
        @media (max-width: 767.98px) {
            .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }
            
            .nav-item {
                margin: 0 2px;
            }
            
            .nav-link {
                padding: 8px 10px !important;
                font-size: 0.85rem;
            }
            
            .nav-link span {
                display: none;
            }
            
            .nav-link i {
                margin-right: 0;
                font-size: 1.1rem;
            }
            
            .d-none.d-md-block {
                display: none !important;
            }
            
            .brand-text {
                display: none;
            }
            
            .navbar-brand {
                margin-right: 0.5rem;
            }
        }
        
        @media (min-width: 768px) {
            .container-fluid {
                padding-left: 24px;
                padding-right: 24px;
            }
        }
        
        /* Utility Classes */
        .font-weight-semibold {
            font-weight: 600;
        }
        
        .text-primary {
            color: #4A90E2 !important;
        }
        
        .bg-primary {
            background-color: #4A90E2 !important;
        }
        
        /* Smooth transitions */
        * {
            transition: background-color 0.2s ease, 
                        color 0.2s ease, 
                        transform 0.2s ease, 
                        box-shadow 0.2s ease,
                        border-color 0.2s ease;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Highlight active menu based on current URL
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link[href]');
            
            navLinks.forEach(link => {
                const linkPath = link.getAttribute('href');
                if (linkPath === currentPath || 
                    (linkPath !== '#' && currentPath.includes(linkPath))) {
                    link.classList.add('active');
                }
            });
            
            // Initialize Bootstrap dropdowns
            if (typeof $ !== 'undefined') {
                // Smooth dropdown animation
                $('.dropdown').on('show.bs.dropdown', function() {
                    $(this).find('.dropdown-menu').first().hide().slideDown(200);
                });
                
                $('.dropdown').on('hide.bs.dropdown', function() {
                    $(this).find('.dropdown-menu').first().show().slideUp(200);
                });
            }
            
            // Mobile menu optimization
            if (window.innerWidth < 768) {
                // Add click handler for mobile menu items without href
                const menuItems = document.querySelectorAll('.nav-link[href="#"]');
                menuItems.forEach(item => {
                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        // You can add mobile menu functionality here
                        console.log('Mobile menu item clicked');
                    });
                });
            }
            
            // Fullscreen toggle for mobile
            const fullscreenBtn = document.querySelector('a[href="#"][role="button"]');
            if (fullscreenBtn) {
                fullscreenBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (!document.fullscreenElement) {
                        document.documentElement.requestFullscreen().catch(err => {
                            console.log(`Error attempting to enable fullscreen: ${err.message}`);
                        });
                    } else {
                        if (document.exitFullscreen) {
                            document.exitFullscreen();
                        }
                    }
                });
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            // Update any responsive behaviors if needed
        });
    </script>
</body>
</html>