<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('petugas.tariktunai.index') }}" class="nav-link {{ request()->routeIs('tariktunai.index') ? 'active' : '' }}">
                <i class="fas fa-tasks mr-1"></i> Tugas
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link {{ request()->routeIs('petugas/history.*') ? 'active' : '' }}">
                <i class="fas fa-history mr-1"></i> History
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">2</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">2 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-money-check text-primary mr-2"></i> Penarikan baru menunggu
                    <span class="float-right text-muted text-sm">5 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user-clock text-info mr-2"></i> Customer menunggu verifikasi
                    <span class="float-right text-muted text-sm">1 hour</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>

        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user-circle fa-lg"></i>
                <span class="ml-1">{{ Auth::user()->nama ?? 'Petugas' }}</span>
                @if(Auth::user()->role === 'admin')
                    <span class="badge badge-success ml-1">Admin</span>
                @elseif(Auth::user()->role === 'supervisor')
                    <span class="badge badge-info ml-1">Supervisor</span>
                @else
                    <span class="badge badge-secondary ml-1">Petugas</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-item text-center py-2">
                    <div class="image mb-2">
                        @if(Auth::user()->foto)
                            <img src="{{ asset('storage/' . Auth::user()->foto) }}" 
                                 class="img-circle elevation-2" 
                                 alt="User Image"
                                 style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                            <div class="img-circle bg-warning elevation-2 d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 60px; height: 60px;">
                                <i class="fas fa-user-tie text-white fa-2x"></i>
                            </div>
                        @endif
                    </div>
                    <h5 class="mb-0">{{ Auth::user()->nama ?? 'Petugas' }}</h5>
                    <div class="mb-2">
                        @if(Auth::user()->role === 'admin')
                            <span class="badge badge-success">Admin</span>
                        @elseif(Auth::user()->role === 'supervisor')
                            <span class="badge badge-info">Supervisor</span>
                        @else
                            <span class="badge badge-secondary">Petugas</span>
                        @endif
                    </div>
                    <small class="text-muted">{{ Auth::user()->email ?? '' }}</small>
                </div>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profil
                </a>
                @if(Auth::user()->role === 'admin')
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-cog mr-2"></i> Pengaturan Sistem
                    </a>
                @else
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-cog mr-2"></i> Pengaturan Akun
                    </a>
                @endif
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

        <!-- Mobile Toggle -->
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>

<style>
    /* Style yang sama dengan navbar customer */
    .navbar-light .navbar-nav .nav-link.active {
        background: linear-gradient(135deg, #FF9800 0%, #FFC107 100%);
        color: white !important;
        border-radius: 20px;
        padding: 6px 15px !important;
        margin: 0 5px;
        font-weight: 500;
    }

    .navbar-light .navbar-nav .nav-link:hover {
        color: #FF9800 !important;
    }

    .navbar-badge {
        font-size: 0.6rem;
        padding: 2px 5px;
        position: absolute;
        top: 5px;
        right: 5px;
    }

    .dropdown-menu-lg {
        min-width: 300px;
    }

    .dropdown-item {
        padding: 12px 20px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        padding-left: 25px;
    }

    .dropdown-header {
        font-weight: 600;
        color: #495057;
        background-color: #f8f9fa;
        padding: 10px 20px;
    }

    .img-circle {
        border-radius: 50%;
        border: 2px solid #e9ecef;
    }

    .dropdown-item.text-center {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .main-header {
        border-bottom: 1px solid #dee2e6;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .nav-link > i {
        font-size: 1.1em;
    }

    /* Style khusus untuk petugas */
    .badge {
        font-size: 0.7rem;
        font-weight: 500;
        padding: 0.25rem 0.5rem;
    }
    
    .bg-warning {
        background-color: #FF9800 !important;
    }

    @media (max-width: 767.98px) {
        .navbar-nav .nav-link {
            padding: 0.5rem 0.8rem;
        }
        
        .d-none.d-sm-inline-block {
            display: inline-block !important;
        }
        
        .badge {
            font-size: 0.6rem;
        }
    }
</style>

<script>
    // Highlight active menu
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        
        navLinks.forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
        
        // Update badge notifikasi
        updateNotificationBadge();
    });
    
    function updateNotificationBadge() {
        // Anda bisa menambahkan logika untuk mengambil jumlah notifikasi dari API
        // Contoh sederhana:
        // fetch('/api/petugas/notifications/count')
        //     .then(response => response.json())
        //     .then(data => {
        //         const badge = document.querySelector('.navbar-badge');
        //         if (badge && data.count > 0) {
        //             badge.textContent = data.count;
        //             badge.style.display = 'inline-block';
        //         } else if (badge) {
        //             badge.style.display = 'none';
        //         }
        //     });
    }
</script>