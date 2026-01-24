  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-lg navbar-white navbar-light">
    <div class="container-fluid">
      <!-- Logo untuk Mobile -->
      <a class="navbar-brand" href="#">
        <img src="{{asset('adminlte/dist/img/LogoCashMit.png')}}" alt="CashMit" height="30">
        <span class="ml-2 font-weight-bold text-primary">CashMit</span>
      </a>
      
      <!-- Mobile Toggle Button -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>

        <!-- Left Navbar Links -->
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a href="{{ route('petugas.tariktunai.index') }}" class="nav-link {{ request()->routeIs('tariktunai.index') ? 'active' : '' }}">
              <i class="fas fa-tasks mr-2"></i> 
              <span>Tugas</span>
              @if(request()->routeIs('tariktunai.index'))
                <span class="badge bg-primary ms-2">Active</span>
              @endif
            </a>
          </li>
          <li class="nav-item">
    <a href="{{ route('petugas.history.index') }}" class="nav-link {{ request()->routeIs('petugas.history.*') ? 'active' : '' }}">
        <i class="fas fa-history mr-2"></i> 
        <span>History</span>
    </a>
</li>
        </ul>

        <!-- Right Navbar Links -->
        <ul class="navbar-nav ms-auto">

          <!-- User Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
              <div class="d-none d-md-flex flex-column align-items-end mr-2">
                <span class="font-weight-bold text-dark">{{ Auth::user()->nama ?? 'Petugas' }}</span>
                <small class="text-muted">
                  @if(Auth::user()->role === 'admin')
                    <span class="role-badge badge-admin">Admin</span>
                  @elseif(Auth::user()->role === 'supervisor')
                    <span class="role-badge badge-supervisor">Supervisor</span>
                  @else
                    <span class="role-badge badge-petugas">Petugas</span>
                  @endif
                </small>
              </div>
              <div class="position-relative">
                @if(Auth::user()->foto)
                  <img src="{{ asset('storage/' . Auth::user()->foto) }}" 
                       class="rounded-circle user-avatar"
                       alt="User Image">
                @else
                  <div class="rounded-circle user-avatar-placeholder">
                    <i class="fas fa-user-tie text-white fa-2x"></i>
                  </div>
                @endif
                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width: 12px; height: 12px;"></span>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
              <!-- User Header -->
              <div class="user-dropdown-header text-center">
                @if(Auth::user()->foto)
                  <img src="{{ asset('storage/' . Auth::user()->foto) }}" 
                       class="rounded-circle user-avatar mb-3"
                       alt="User Image">
                @else
                  <div class="rounded-circle user-avatar-placeholder mx-auto mb-3">
                    <i class="fas fa-user-tie text-white fa-2x"></i>
                  </div>
                @endif
                <h5 class="mb-1 font-weight-bold">{{ Auth::user()->nama ?? 'Petugas' }}</h5>
                <div class="mb-2">
                  @if(Auth::user()->role === 'admin')
                    <span class="role-badge badge-admin">Administrator</span>
                  @elseif(Auth::user()->role === 'supervisor')
                    <span class="role-badge badge-supervisor">Supervisor</span>
                  @else
                    <span class="role-badge badge-petugas">Petugas</span>
                  @endif
                </div>
                <p class="text-muted small mb-0">{{ Auth::user()->email ?? '' }}</p>
              </div>
              
              <div class="dropdown-divider"></div>
              
              <!-- Dropdown Items -->
              
              <div class="dropdown-divider"></div>
              
              <a href="{{ route('logout.post') }}" class="dropdown-item text-danger"
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </div>
          </li>

          <!-- Fullscreen Toggle -->
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- /.navbar -->