<!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="padding: 0;">
        <!-- Container Fluid untuk full width -->
        <div class="container-fluid px-4">
            <!-- Logo untuk desktop -->
            <div class="navbar-brand d-none d-md-flex align-items-center me-4">
                <img src="{{ asset('adminlte/dist/img/LogoCashMit.png') }}" 
                     alt="CashMit" 
                     class="brand-icon mr-2"
                     style="width: 32px; height: 32px; border-radius: 6px;">
                <span class="brand-text font-weight-bold text-primary">CashMit</span>
            </div>

            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item mx-1">
                    <a href="{{ route('customer.tariktunai.index') }}" 
                       class="nav-link d-flex align-items-center py-2 px-3 {{ request()->routeIs('customer.tariktunai.*') ? 'active' : '' }}">
                        <i class="fas fa-money-bill-wave mr-2"></i>
                        <span class="d-none d-md-inline">Tarik Tunai</span>
                    </a>
                </li>
                <li class="nav-item mx-1">
                    <a href="#" 
                       class="nav-link d-flex align-items-center py-2 px-3 {{ request()->routeIs('customer.history.*') ? 'active' : '' }}">
                        <i class="fas fa-history mr-2"></i>
                        <span class="d-none d-md-inline">History</span>
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ms-auto">
                <!-- User Dropdown Menu -->
                <li class="nav-item dropdown mx-1">
                    <a class="nav-link d-flex align-items-center p-2" data-toggle="dropdown" href="#">
                        <div class="d-flex align-items-center">
                            <!-- Avatar -->
                            <div class="position-relative mr-2">
                                @if(Auth::user()->foto)
                                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" 
                                         class="rounded-circle border border-2 border-primary"
                                         alt="User Avatar"
                                         style="width: 38px; height: 38px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                         style="width: 38px; height: 38px;">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- User Info (Desktop only) -->
                            <div class="d-none d-md-block">
                                <div class="font-weight-semibold text-dark" style="font-size: 0.9rem; line-height: 1.2;">
                                    {{ Auth::user()->nama ?? 'Customer' }}
                                </div>
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    Customer
                                </div>
                            </div>
                            
                            <i class="fas fa-chevron-down ml-2 text-muted"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="min-width: 280px; margin-top: 10px;">
                        <!-- User Info -->
                        <div class="dropdown-header bg-light py-3">
                            <div class="d-flex align-items-center">
                                @if(Auth::user()->foto)
                                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" 
                                         class="rounded-circle me-3"
                                         alt="User Avatar"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3"
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-user text-white fa-lg"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="font-weight-semibold">{{ Auth::user()->nama ?? 'Customer' }}</div>
                                    <div class="text-muted small">{{ Auth::user()->email ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="dropdown-divider"></div>
                        
                        <!-- Menu Items -->
                        <a href="{{ route('profile.index') }}" class="dropdown-item d-flex align-items-center py-2">
                            <i class="fas fa-user text-primary mr-3" style="width: 20px;"></i>
                            <span>Profil Saya</span>
                        </a>
                        
                        <a href="#" class="dropdown-item d-flex align-items-center py-2">
                            <i class="fas fa-cog text-primary mr-3" style="width: 20px;"></i>
                            <span>Pengaturan</span>
                        </a>
                        
                        <div class="dropdown-divider"></div>
                        
                        <!-- Logout -->
                        <a href="{{ route('logout') }}" 
                           class="dropdown-item d-flex align-items-center py-2 text-danger"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-3" style="width: 20px;"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>

                <!-- Mobile Toggle (Fullscreen) -->
                <li class="nav-item d-md-none mx-1">
                    <a class="nav-link p-2" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>