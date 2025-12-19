@extends('layout.admin.master')

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-5">
        <div class="mb-3 mb-md-0">
            <h1 class="h2 fw-bold mb-2">
                <span class="text-gradient">👥 Daftar Customer</span>
            </h1>
            <p class="text-muted mb-0">Kelola semua customer dengan mudah dan cepat ✨</p>
        </div>
        
        <div class="d-flex flex-column flex-sm-row gap-3">
            <div class="position-relative" style="width: 280px;">
                <input type="text" 
                       placeholder="Cari customer..." 
                       class="form-control ps-5 pe-4 py-2 rounded-pill border-light shadow-sm">
                <i class="fas fa-search position-absolute start-3 top-50 translate-middle-y text-muted"></i>
            </div>
            <a href="{{ route('admin.users.create') }}" 
               class="btn btn-primary d-flex align-items-center gap-2 px-4 py-2 rounded-pill shadow-sm">
                <i class="fas fa-user-plus"></i>
                <span>Tambah Customer</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-6 col-md-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-2">Total Customer</p>
                            <h3 class="fw-bold text-primary mb-0">{{ $customers->count() }}</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>12%
                            </small>
                        </div>
                        <div class="icon-wrapper bg-primary-subtle rounded-2 p-3">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-2">Aktif</p>
                            <h3 class="fw-bold text-success mb-0">{{ $activeCount ?? $customers->where('status', 'active')->count() }}</h3>
                            <small class="text-success">
                                {{ number_format(($activeCount ?? $customers->where('status', 'active')->count()) / max($customers->count(), 1) * 100, 1) }}%
                            </small>
                        </div>
                        <div class="icon-wrapper bg-success-subtle rounded-2 p-3">
                            <i class="fas fa-user-check text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-2">Banned</p>
                            <h3 class="fw-bold text-danger mb-0">{{ $bannedCount ?? $customers->where('status', 'banned')->count() }}</h3>
                            <small class="text-danger">
                                Perlu perhatian
                            </small>
                        </div>
                        <div class="icon-wrapper bg-danger-subtle rounded-2 p-3">
                            <i class="fas fa-user-slash text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-2">Hari Ini</p>
                            <h3 class="fw-bold text-warning mb-0">{{ $todayCount ?? 0 }}</h3>
                            <small class="text-warning">
                                <i class="fas fa-bolt me-1"></i>Bertumbuh!
                            </small>
                        </div>
                        <div class="icon-wrapper bg-warning-subtle rounded-2 p-3">
                            <i class="fas fa-chart-line text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
        <!-- Table Header -->
        <div class="card-header bg-light py-3 px-3 px-md-4 border-bottom">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <h5 class="mb-1 fw-bold">📋 Daftar Customer</h5>
                    <p class="text-muted small mb-0">{{ $customers->count() }} customer ditemukan</p>
                </div>
                
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle py-2 px-3 rounded-pill" 
                                type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-2"></i>Status
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Semua</a></li>
                            <li><a class="dropdown-item" href="#">Aktif</a></li>
                            <li><a class="dropdown-item" href="#">Banned</a></li>
                        </ul>
                    </div>
                    
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle py-2 px-3 rounded-pill" 
                                type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-sort me-2"></i>Urutkan
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Terbaru</a></li>
                            <li><a class="dropdown-item" href="#">Terlama</a></li>
                            <li><a class="dropdown-item" href="#">Nama A-Z</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 px-4 border-bottom-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user me-2 text-primary"></i>
                                Customer
                            </div>
                        </th>
                        <th class="py-3 px-4 border-bottom-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-id-card me-2 text-primary"></i>
                                NIM/NIP
                            </div>
                        </th>
                        <th class="py-3 px-4 border-bottom-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                Email
                            </div>
                        </th>
                        <th class="py-3 px-4 border-bottom-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-circle me-2 text-primary"></i>
                                Status
                            </div>
                        </th>
                        <th class="py-3 px-4 border-bottom-0 text-end">
                            <div class="d-flex align-items-center justify-content-end">
                                <i class="fas fa-cog me-2 text-primary"></i>
                                Aksi
                            </div>
                        </th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($customers as $user)
                    <tr class="border-bottom">
                        <!-- Customer Column -->
                        <td class="py-3 px-4">
                            <div class="d-flex align-items-center">
                                <div class="position-relative me-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=2d9cca&color=fff&size=40&rounded=true" 
                                         alt="{{ $user->nama }}"
                                         class="rounded-circle border border-2 border-white shadow-sm"
                                         style="width: 40px; height: 40px;">
                                    <span class="position-absolute bottom-0 end-0 translate-middle bg-{{ $user->status == 'active' ? 'success' : 'danger' }} rounded-circle border border-2 border-white"
                                          style="width: 12px; height: 12px;"></span>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $user->nama }}</h6>
                                    <small class="text-muted d-flex align-items-center">
                                        <i class="fas fa-user-tag me-1 fs-6"></i>
                                        {{ ucfirst($user->role) }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        
                        <!-- NIM/NIP Column -->
                        <td class="py-3 px-4">
                            <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                <i class="fas fa-hashtag me-1"></i>
                                {{ $user->nim_nip }}
                            </span>
                        </td>
                        
                        <!-- Email Column -->
                        <td class="py-3 px-4">
                            <div class="text-truncate" style="max-width: 200px;">
                                <i class="fas fa-envelope text-muted me-2"></i>
                                {{ $user->email }}
                            </div>
                        </td>
                        
                        <!-- Status Column -->
                        <td class="py-3 px-4">
                            @if($user->status == 'active')
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                Aktif
                            </span>
                            @else
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">
                                <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                Banned
                            </span>
                            @endif
                        </td>
                        
                        <!-- Actions Column -->
                        <td class="py-3 px-4 text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <button class="btn btn-outline-primary rounded-start-pill px-3" 
                                        data-bs-toggle="tooltip" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <!-- Status Toggle -->
                                @if($user->status == 'active')
                                <form action="{{ route('admin.users.suspend', $user->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Yakin ingin menonaktifkan user ini?')"
                                            class="btn btn-outline-danger px-3"
                                            data-bs-toggle="tooltip"
                                            title="Suspend">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.users.activate', $user->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-outline-success px-3"
                                            data-bs-toggle="tooltip"
                                            title="Activate">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                
                                <!-- Change Role Button (Triggers Modal) -->
                                <button type="button" 
                                        class="btn btn-outline-warning px-3 btn-change-role"
                                        data-bs-toggle="modal"
                                        data-bs-target="#changeRoleModal"
                                        data-user-id="{{ $user->id }}"
                                        data-user-name="{{ $user->nama }}"
                                        data-current-role="{{ $user->role }}">
                                    <i class="fas fa-user-tag"></i>
                                </button>
                                
                                <!-- More Actions Dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary rounded-end-pill px-3 dropdown-toggle"
                                            type="button" 
                                            data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-edit me-2"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-envelope me-2"></i>Kirim Email
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#">
                                                <i class="fas fa-trash me-2"></i>Hapus
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Table Footer -->
        <div class="card-footer bg-light py-3 px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="text-muted small">
                    Menampilkan <strong>{{ $customers->count() }}</strong> customer
                </div>
                
                <!-- Simple Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Empty State -->
    @if($customers->isEmpty())
    <div class="text-center py-8">
        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-3 p-5 mb-4">
            <i class="fas fa-users fa-3x text-primary"></i>
        </div>
        <h4 class="fw-bold mb-3">Belum ada customer</h4>
        <p class="text-muted mb-4">Mulai tambahkan customer pertama Anda</p>
        <a href="{{ route('admin.users.create') }}" 
           class="btn btn-primary px-4 py-2 rounded-pill">
            <i class="fas fa-user-plus me-2"></i>Tambah Customer Pertama
        </a>
    </div>
    @endif
</div>

<!-- Change Role Modal (POPUP - akan muncul di atas konten) -->
<div class="modal fade" id="changeRoleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white border-0 rounded-top-3 py-4 px-4">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-user-tag me-2"></i>Ubah Role User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle p-4 mb-3">
                        <i class="fas fa-user-circle fa-3x text-primary"></i>
                    </div>
                    <h6 class="fw-bold mb-1" id="modalUserName">Nama User</h6>
                    <p class="text-muted small" id="modalUserEmail">Email user</p>
                </div>
                
                <form id="changeRoleForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold mb-3">Pilih Role Baru</label>
                        <div class="d-grid gap-2">
                            <div class="form-check-card">
                                <input class="form-check-input" type="radio" name="role" value="customer" id="roleCustomer">
                                <label class="form-check-label w-100 p-3 border rounded-2" for="roleCustomer">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle bg-primary bg-opacity-10 p-2 me-3">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Customer</h6>
                                            <p class="text-muted small mb-0">Pengguna biasa</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="form-check-card">
                                <input class="form-check-input" type="radio" name="role" value="petugas" id="rolePetugas">
                                <label class="form-check-label w-100 p-3 border rounded-2" for="rolePetugas">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle bg-success bg-opacity-10 p-2 me-3">
                                            <i class="fas fa-user-tie text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Petugas</h6>
                                            <p class="text-muted small mb-0">Staff operasional</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="form-check-card">
                                <input class="form-check-input" type="radio" name="role" value="admin" id="roleAdmin">
                                <label class="form-check-label w-100 p-3 border rounded-2" for="roleAdmin">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle bg-warning bg-opacity-10 p-2 me-3">
                                            <i class="fas fa-crown text-warning"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Admin</h6>
                                            <p class="text-muted small mb-0">Full system access</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2 rounded-pill">
                            <i class="fas fa-save me-2"></i>Update Role
                        </button>
                        <button type="button" class="btn btn-outline-secondary py-2 rounded-pill" data-bs-dismiss="modal">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styles */
    .text-gradient {
        background: linear-gradient(135deg, #2d9cca 0%, #20c997 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .stat-card {
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }
    
    .icon-wrapper {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .form-check-card {
        position: relative;
        cursor: pointer;
    }
    
    .form-check-input {
        position: absolute;
        top: 15px;
        left: 15px;
        width: 18px;
        height: 18px;
        margin: 0;
    }
    
    .form-check-input:checked + .form-check-label {
        border-color: #2d9cca !important;
        background-color: rgba(45, 156, 202, 0.05);
    }
    
    .form-check-input:checked + .form-check-label::after {
        content: '✓';
        position: absolute;
        top: -8px;
        right: -8px;
        background: #2d9cca;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }
    
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Modal Animation */
    .modal.fade .modal-dialog {
        transform: scale(0.9);
        opacity: 0;
        transition: all 0.3s ease-out;
    }
    
    .modal.show .modal-dialog {
        transform: scale(1);
        opacity: 1;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
        
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-group-sm .btn {
            padding-left: 8px;
            padding-right: 8px;
        }
        
        .modal-dialog {
            margin: 10px;
        }
    }
    
    /* Table hover effect */
    .table-hover tbody tr:hover {
        background-color: rgba(45, 156, 202, 0.05);
    }
    
    /* Custom scrollbar for table */
    .table-responsive::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
</style>

<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Change Role Modal Logic
        var changeRoleButtons = document.querySelectorAll('.btn-change-role');
        var changeRoleModal = document.getElementById('changeRoleModal');
        var modalUserName = document.getElementById('modalUserName');
        var changeRoleForm = document.getElementById('changeRoleForm');
        
        changeRoleButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var userId = this.getAttribute('data-user-id');
                var userName = this.getAttribute('data-user-name');
                var currentRole = this.getAttribute('data-current-role');
                
                // Update modal content
                modalUserName.textContent = userName;
                
                // Update form action
                changeRoleForm.action = '/admin/users/' + userId + '/change-role';
                
                // Check current role radio button
                document.querySelectorAll('#changeRoleForm input[name="role"]').forEach(function(radio) {
                    radio.checked = radio.value === currentRole;
                });
                
                // Animate modal show
                var modal = new bootstrap.Modal(changeRoleModal);
                modal.show();
            });
        });
        
        // Animate radio selection
        document.querySelectorAll('.form-check-input').forEach(function(radio) {
            radio.addEventListener('change', function() {
                // Reset all labels
                document.querySelectorAll('.form-check-label').forEach(function(label) {
                    label.style.transform = 'scale(1)';
                });
                
                // Highlight selected
                if (this.checked) {
                    var label = this.nextElementSibling;
                    label.style.transform = 'scale(1.02)';
                }
            });
        });
        
        // Search functionality
        var searchInput = document.querySelector('input[type="text"]');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                var searchTerm = e.target.value.toLowerCase();
                var rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(function(row) {
                    var text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
        
        // Add loading effect to buttons
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function() {
                var submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
                    submitBtn.disabled = true;
                }
            });
        });
    });
</script>
@endsection