<aside class="main-sidebar sidebar-light elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link text-decoration-none">
    <div class="brand-logo-container d-flex align-items-center">
      <div class="logo-bg">
        <img src="{{ asset('adminlte/dist/img/LogoCashMit.png') }}" alt="AdminLTE Logo" class="brand-image">
      </div>
      <span class="brand-text fw-bold">{{ config('app.name') }}</span>
    </div>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-4 pb-3 mb-4 d-flex align-items-center">
      <div class="user-avatar">
        <div class="avatar-wrapper">
          <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-avatar" alt="User Image">
          <div class="online-status"></div>
        </div>
      </div>
      <div class="user-info">
        <a href="#" class="user-name text-decoration-none">{{ auth()->user()->nama }}</a>
        <span class="user-role">Administrator</span>
      </div>
      <div class="user-actions">
        <i class="fas fa-ellipsis-v action-icon"></i>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboard" class="nav-link {{(request()->is('dashboard')) ? 'active' : ''}}">
            <div class="nav-icon-wrapper">
              <i class="nav-icon fas fa-tachometer-alt"></i>
            </div>
            <div class="nav-content">
              <p class="nav-text">Dashboard</p>
              <i class="nav-arrow fas fa-chevron-right"></i>
            </div>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.customer.index') }}" class="nav-link {{(request()->routeIs('admin.customer.*')) ? 'active' : ''}}">
            <div class="nav-icon-wrapper">
              <i class="nav-icon fas fa-users"></i>
            </div>
            <div class="nav-content">
              <p class="nav-text">Manajemen Customer</p>
              <i class="nav-arrow fas fa-chevron-right"></i>
            </div>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.petugas.index') }}" class="nav-link {{(request()->routeIs('admin.petugas.*')) ? 'active' : ''}}">
            <div class="nav-icon-wrapper">
              <i class="nav-icon fas fa-users"></i>
            </div>
            <div class="nav-content">
              <p class="nav-text">Manajemen Petugas</p>
              <i class="nav-arrow fas fa-chevron-right"></i>
            </div>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.tariktunai.index') }}" class="nav-link {{ request()->routeIs('admin.tariktunai.*') ? 'active' : '' }}">
            <div class="nav-icon-wrapper">
              <i class="nav-icon fas fa-money-bill-alt"></i>
            </div>
            <div class="nav-content">
              <p class="nav-text">Tarik Tunai</p>
              <i class="nav-arrow fas fa-chevron-right"></i>
            </div>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.lokasi.index') }}" class="nav-link {{ request()->routeIs('admin.lokasi.*') ? 'active' : '' }}">
            <div class="nav-icon-wrapper">
              <i class="nav-icon fas fa-map-marker-alt"></i>
            </div>
            <div class="nav-content">
              <p class="nav-text">Manajemen Lokasi COD</p>
              <i class="nav-arrow fas fa-chevron-right"></i>
            </div>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.payment.index') }}" class="nav-link {{ request()->routeIs('admin.payment.*') ? 'active' : '' }}">
            <div class="nav-icon-wrapper">
              <i class="nav-icon fas fa-receipt"></i>
            </div>
            <div class="nav-content">
              <p class="nav-text">Manajemen Pembayaran</p>
              <i class="nav-arrow fas fa-chevron-right"></i>
            </div>
          </a>
        </li>
      </ul>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer">
      <div class="logout-section">
        <a href="{{ route('logout') }}" class="logout-link text-decoration-none">
          <div class="logout-icon">
            <i class="fas fa-sign-out-alt"></i>
          </div>
          <span>Logout</span>
        </a>
      </div>
      <div class="version-info">
        <span>v1.0.0</span>
      </div>
    </div>
  </div>
</aside>

<style>
  :root {
    --primary-blue: #4A90E2;
    --light-blue: #87CEEB;
    --gradient-blue: linear-gradient(135deg, #4A90E2 0%, #87CEEB 100%);
    --white: #FFFFFF;
    --gray-100: #F8F9FA;
    --gray-200: #E9ECEF;
    --gray-300: #DEE2E6;
    --gray-600: #6C757D;
    --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.08);
    --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.1);
    --radius-md: 12px;
    --radius-lg: 20px;
  }

  /* Sidebar Container */
  .main-sidebar {
    background: var(--white) !important;
    border-right: 1px solid var(--gray-200);
    box-shadow: var(--shadow-md);
  }

  /* Brand Logo */
  .brand-logo-container {
    padding: 20px 15px;
    background: var(--white);
  }

  .logo-bg {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    box-shadow: var(--shadow-sm);
  }

  .navbar-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 700;
    font-size: 1.5rem;
    color: var(--primary);
  }

  .navbar-brand img {
    transition: var(--transition);
  }

  .navbar-brand:hover img {
    transform: scale(1.05);
  }

  .brand-text {
    color: var(--primary-blue);
    font-size: 1.4rem;
    letter-spacing: -0.5px;
    background: linear-gradient(45deg, #4A90E2, #87CEEB);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  /* User Panel */
  .user-panel {
    padding: 0 20px;
    position: relative;
  }

  .avatar-wrapper {
    position: relative;
    width: 50px;
    height: 50px;
    margin-right: 15px;
  }

  .img-avatar {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--white);
    box-shadow: var(--shadow-sm);
  }

  .online-status {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    background: #4CAF50;
    border: 2px solid var(--white);
    border-radius: 50%;
  }

  .user-info {
    flex-grow: 1;
  }

  .user-name {
    color: #2C3E50;
    font-weight: 600;
    font-size: 1rem;
    display: block;
    margin-bottom: 2px;
  }

  .user-role {
    color: var(--gray-600);
    font-size: 0.8rem;
    background: var(--gray-100);
    padding: 2px 8px;
    border-radius: 10px;
    display: inline-block;
  }

  .user-actions .action-icon {
    color: var(--gray-600);
    cursor: pointer;
    padding: 5px;
    border-radius: 6px;
    transition: all 0.3s ease;
  }

  .user-actions .action-icon:hover {
    background: var(--gray-200);
    color: var(--primary-blue);
  }

  /* Navigation */
  .nav-sidebar .nav-item {
    margin: 4px 15px;
  }

  .nav-link {
    display: flex !important;
    align-items: center;
    padding: 12px 15px !important;
    border-radius: var(--radius-md) !important;
    background: transparent;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none !important;
    position: relative;
    overflow: hidden;
  }

  .nav-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background: var(--gradient-blue);
    transform: translateX(-10px);
    transition: transform 0.3s ease;
    border-radius: 0 var(--radius-md) var(--radius-md) 0;
  }

  .nav-link:hover {
    background: linear-gradient(135deg, rgba(74, 144, 226, 0.1) 0%, rgba(135, 206, 235, 0.1) 100%);
    transform: translateX(5px);
  }

  .nav-link:hover::before {
    transform: translateX(0);
  }

  .nav-link.active {
    background: var(--gradient-blue) !important;
    box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
    color: white !important;
  }

  .nav-link.active::before {
    display: none;
  }

  .nav-link.active .nav-text,
  .nav-link.active .nav-arrow {
    color: white !important;
  }

  /* Icon Wrapper */
  .nav-icon-wrapper {
    width: 40px;
    height: 40px;
    background: var(--white);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
  }

  .nav-link.active .nav-icon-wrapper {
    background: rgba(255, 255, 255, 0.2);
  }

  .nav-icon {
    color: var(--primary-blue);
    font-size: 1rem;
  }

  .nav-link.active .nav-icon {
    color: white;
  }

  /* Content Area */
  .nav-content {
    flex-grow: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .nav-text {
    color: #2C3E50;
    font-weight: 500;
    font-size: 0.95rem;
    margin: 0;
  }

  .nav-arrow {
    color: var(--gray-300);
    font-size: 0.8rem;
    transition: transform 0.3s ease;
  }

  .nav-link:hover .nav-arrow {
    transform: translateX(3px);
    color: var(--primary-blue);
  }

  /* Sidebar Footer */
  .sidebar-footer {
    padding: 20px;
    margin-top: 20px;
    border-top: 1px solid var(--gray-200);
  }

  .logout-link {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    border-radius: var(--radius-md);
    background: var(--gray-100);
    transition: all 0.3s ease;
    color: #2C3E50;
  }

  .logout-link:hover {
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.1) 0%, rgba(255, 77, 77, 0.1) 100%);
    color: #FF6B6B;
    transform: translateX(5px);
  }

  .logout-icon {
    width: 40px;
    height: 40px;
    background: var(--white);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    box-shadow: var(--shadow-sm);
    color: #FF6B6B;
  }

  .version-info {
    text-align: center;
    margin-top: 15px;
    color: var(--gray-600);
    font-size: 0.8rem;
  }

  /* Animation */
  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateX(-20px);
    }

    to {
      opacity: 1;
      transform: translateX(0);
    }
  }

  .nav-item {
    animation: slideIn 0.5s ease forwards;
  }

  .nav-item:nth-child(1) {
    animation-delay: 0.1s;
  }

  .nav-item:nth-child(2) {
    animation-delay: 0.2s;
  }

  .nav-item:nth-child(3) {
    animation-delay: 0.3s;
  }

  .nav-item:nth-child(4) {
    animation-delay: 0.4s;
  }

  .nav-item:nth-child(5) {
    animation-delay: 0.5s;
  }

  .nav-item:nth-child(6) {
    animation-delay: 0.6s;
  }

  /* Scrollbar Styling */
  .sidebar::-webkit-scrollbar {
    width: 6px;
  }

  .sidebar::-webkit-scrollbar-track {
    background: var(--gray-100);
  }

  .sidebar::-webkit-scrollbar-thumb {
    background: var(--light-blue);
    border-radius: 10px;
  }

  .sidebar::-webkit-scrollbar-thumb:hover {
    background: var(--primary-blue);
  }

  /* Responsive */
  @media (max-width: 768px) {
    .sidebar {
      padding-bottom: 80px;
    }

    .nav-link {
      padding: 10px 12px !important;
    }

    .nav-text {
      font-size: 0.9rem;
    }
  }
</style>

<script>
  // Tambahkan interaksi hover yang smooth
  document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
      link.addEventListener('mouseenter', function() {
        this.style.transform = 'translateX(5px)';
      });

      link.addEventListener('mouseleave', function() {
        if (!this.classList.contains('active')) {
          this.style.transform = 'translateX(0)';
        }
      });
    });

    // Tambahkan efek klik pada item menu
    navLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        if (this.getAttribute('href') === '#') {
          e.preventDefault();
          // Toggle active class untuk demo
          navLinks.forEach(l => l.classList.remove('active'));
          this.classList.add('active');

          // Animasi klik
          this.style.transform = 'scale(0.98)';
          setTimeout(() => {
            this.style.transform = '';
          }, 150);
        }
      });
    });
  });
</script>