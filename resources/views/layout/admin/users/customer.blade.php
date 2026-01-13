@extends('layout.admin.master')

@section('title', 'Management User - Customer')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-users mr-2"></i>👥 Management Customer
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Management Customer</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-cyan">
                        <div class="inner">
                            <h3>{{ $customers->count() }}</h3>
                            <p>Total Customer</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-group"></i>
                        </div>
                        <a href="#" class="small-box-footer">Lihat semua <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-success">
                        <div class="inner">
                            <h3>{{ $activeCount }}</h3>
                            <p>Customer Aktif</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-warning">
                        <div class="inner">
                            <h3>{{ $bannedCount }}</h3>
                            <p>Customer Terblokir</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-slash"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-purple">
                        <div class="inner">
                            <h3>{{ $todayCount }}</h3>
                            <p>Registrasi Hari Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <a href="#" class="small-box-footer">Analytics <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column: Table -->
                <div class="col-lg-8">
                    <!-- Customer Table -->
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list-ul mr-2"></i>
                                Daftar Customer
                            </h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 300px;">
                                    <input type="text" id="searchTable" class="form-control float-right"
                                        placeholder="Cari customer...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    <div class="ml-2">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addUserModal">
                                            <i class="fas fa-plus mr-1"></i> Tambah Customer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="customersTable">
                                    <thead class="bg-gradient-info text-white">
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 10%">Foto</th>
                                            <th style="width: 20%">Nama</th>
                                            <th style="width: 20%">Email</th>
                                            <th style="width: 15%">NIM/NIP</th>
                                            <th style="width: 10%">Status</th>
                                            <th style="width: 20%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($customers as $customer)
                                        <tr>
                                            <td class="align-middle">
                                                <span class="badge badge-secondary">{{ $loop->iteration }}</span>
                                            </td>

                                            <!-- Kolom Foto -->
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    @if($customer->foto)
                                                        @php
                                                            $imageUrl = Storage::url($customer->foto);
                                                            $imageExists = Storage::disk('public')->exists($customer->foto);
                                                        @endphp
                                                        
                                                        @if($imageExists)
                                                            <div class="position-relative">
                                                                <img src="{{ $imageUrl }}" 
                                                                     alt="{{ $customer->nama }}"
                                                                     class="img-thumbnail rounded-circle shadow-sm"
                                                                     style="width: 50px; height: 50px; object-fit: cover;"
                                                                     onclick="showImageModal('{{ $imageUrl }}')">
                                                                
                                                                <span class="badge badge-light position-absolute" style="top: -5px; right: -5px; font-size: 8px;">
                                                                    <i class="fas fa-user text-info"></i>
                                                                </span>
                                                            </div>
                                                        @else
                                                            <div class="image-error-placeholder rounded-circle d-flex flex-column align-items-center justify-content-center text-center"
                                                                 style="width: 50px; height: 50px; background: linear-gradient(45deg, #ffeaa7, #fab1a0); border: 2px dashed #e17055;"
                                                                 title="Foto tidak ditemukan di server">
                                                                <i class="fas fa-exclamation-circle text-danger mb-1"></i>
                                                                <small class="text-danger" style="font-size: 8px;">Error</small>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="image-placeholder rounded-circle d-flex align-items-center justify-content-center"
                                                             style="width: 50px; height: 50px; background: linear-gradient(45deg, #dfe6e9, #b2bec3);">
                                                            <i class="fas fa-user text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Kolom Nama -->
                                            <td class="align-middle">
                                                <div>
                                                    <strong class="d-block">{{ $customer->nama }}</strong>
                                                    <small class="text-muted">
                                                        <i class="far fa-calendar-alt mr-1"></i>
                                                        {{ $customer->created_at->format('d/m/Y') }}
                                                    </small>
                                                </div>
                                            </td>

                                            <!-- Kolom Email -->
                                            <td class="align-middle">
                                                <a href="mailto:{{ $customer->email }}" class="text-primary">
                                                    <i class="fas fa-envelope mr-1"></i>
                                                    {{ $customer->email }}
                                                </a>
                                            </td>

                                            <!-- Kolom NIM/NIP -->
                                            <td class="align-middle">
                                                <span class="badge badge-light text-dark p-2">
                                                    <i class="fas fa-id-card mr-1 text-primary"></i>
                                                    {{ $customer->nim_nip }}
                                                </span>
                                            </td>

                                            <!-- Kolom Status -->
                                            <td class="align-middle">
                                                @if($customer->status == 'active')
                                                <span class="badge badge-success badge-pill px-3 py-2">
                                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                                </span>
                                                @elseif($customer->status == 'banned')
                                                <span class="badge badge-danger badge-pill px-3 py-2">
                                                    <i class="fas fa-ban mr-1"></i> Terblokir
                                                </span>
                                                @else
                                                <span class="badge badge-warning badge-pill px-3 py-2">
                                                    <i class="fas fa-clock mr-1"></i> Pending
                                                </span>
                                                @endif
                                            </td>

                                            <!-- Kolom Aksi -->
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-info btn-view"
                                                        data-id="{{ $customer->id }}"
                                                        data-nama="{{ $customer->nama }}"
                                                        data-email="{{ $customer->email }}"
                                                        data-nim="{{ $customer->nim_nip }}"
                                                        data-role="{{ $customer->role }}"
                                                        data-status="{{ $customer->status }}"
                                                        data-created="{{ $customer->created_at->format('d/m/Y H:i') }}"
                                                        title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @if($customer->status == 'active')
                                                    <button type="button" class="btn btn-sm btn-outline-warning btn-suspend"
                                                        data-id="{{ $customer->id }}"
                                                        data-nama="{{ $customer->nama }}"
                                                        title="Blokir">
                                                        <i class="fas fa-user-slash"></i>
                                                    </button>
                                                    @else
                                                    <button type="button" class="btn btn-sm btn-outline-success btn-activate"
                                                        data-id="{{ $customer->id }}"
                                                        data-nama="{{ $customer->nama }}"
                                                        title="Aktifkan">
                                                        <i class="fas fa-user-check"></i>
                                                    </button>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-outline-primary btn-role"
                                                        data-id="{{ $customer->id }}"
                                                        data-nama="{{ $customer->nama }}"
                                                        data-current-role="{{ $customer->role }}"
                                                        title="Ubah Role">
                                                        <i class="fas fa-user-tag"></i>
                                                    </button>
                                                    @if($customer->foto)
                                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-foto"
                                                        data-id="{{ $customer->id }}"
                                                        data-foto="{{ Storage::url($customer->foto) }}"
                                                        title="Lihat Foto">
                                                        <i class="fas fa-camera"></i>
                                                    </button>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete"
                                                        data-id="{{ $customer->id }}"
                                                        data-nama="{{ $customer->nama }}"
                                                        title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-users fa-4x text-muted mb-4"></i>
                                                    <h4 class="text-muted">Belum ada customer</h4>
                                                    <p class="text-muted mb-4">Tambahkan customer pertama Anda</p>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                                                        <i class="fas fa-plus mr-2"></i>Tambah Customer Pertama
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($customers->count() > 0)
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Menampilkan <strong>{{ $customers->count() }}</strong> dari <strong>{{ $customers->count() }}</strong> customer
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Statistics & Actions -->
                <div class="col-lg-4">
                    <!-- Recent Activities -->
                    <div class="card card-outline card-gradient-indigo">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-2"></i>
                                Aktivitas Terbaru
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-time">10:00</div>
                                    <div class="timeline-icon bg-success"><i class="fas fa-user-plus"></i></div>
                                    <div class="timeline-content">
                                        <h6>User Baru</h6>
                                        <p>John Doe mendaftar sebagai customer</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-time">09:30</div>
                                    <div class="timeline-icon bg-warning"><i class="fas fa-user-slash"></i></div>
                                    <div class="timeline-content">
                                        <h6>User Diblokir</h6>
                                        <p>Jane Smith di-banned oleh admin</p>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-time">08:45</div>
                                    <div class="timeline-icon bg-primary"><i class="fas fa-user-tag"></i></div>
                                    <div class="timeline-content">
                                        <h6>Role Diubah</h6>
                                        <p>Bob Wilson diubah menjadi petugas</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-2"></i>
                                Statistik Customer
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-number text-primary">{{ $customers->count() }}</div>
                                        <div class="stat-label">Total Customer</div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-number text-success">{{ $activeCount }}</div>
                                        <div class="stat-label">Aktif</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card">
                                        <div class="stat-number text-warning">{{ $bannedCount }}</div>
                                        <div class="stat-label">Terblokir</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card">
                                        <div class="stat-number text-info">{{ $todayCount }}</div>
                                        <div class="stat-label">Hari Ini</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card card-outline card-warning">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bolt mr-2"></i>
                                Aksi Cepat
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <button class="btn btn-outline-primary btn-block btn-action" data-toggle="modal" data-target="#addUserModal">
                                        <i class="fas fa-user-plus mr-2"></i> Tambah
                                    </button>
                                </div>
                                <div class="col-6 mb-3">
                                    <button class="btn btn-outline-success btn-block btn-action" id="exportBtn">
                                        <i class="fas fa-file-export mr-2"></i> Export
                                    </button>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('admin.users.petugas') }}" class="btn btn-outline-info btn-block btn-action">
                                        <i class="fas fa-user-tie mr-2"></i> Petugas
                                    </a>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-outline-secondary btn-block btn-action" id="refreshBtn">
                                        <i class="fas fa-sync-alt mr-2"></i> Refresh
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="addUserModalLabel">
                    <i class="fas fa-user-plus mr-2"></i> Tambah User Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nim_nip" class="form-label">NIM/NIP</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="nim_nip" name="nim_nip" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-control select2" id="role" name="role" style="width: 100%;" required>
                                    <option value="customer" selected>Customer</option>
                                    <option value="petugas">Petugas</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Detail Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info text-white">
                <h5 class="modal-title" id="viewModalLabel">
                    <i class="fas fa-user-circle mr-2"></i> Detail User
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-4">
                        <div class="user-avatar">
                            <img id="detailFoto" src="" alt="Foto User" class="img-fluid rounded-circle shadow mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                            <h4 id="detailNama" class="mt-2"></h4>
                            <span id="detailStatus" class="badge badge-pill mt-1"></span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="user-info">
                            <h5 class="mb-4"><i class="fas fa-info-circle mr-2 text-primary"></i>Informasi User</h5>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <p><strong><i class="fas fa-envelope mr-2 text-muted"></i>Email:</strong><br>
                                    <span id="detailEmail" class="text-primary"></span></p>
                                </div>
                                <div class="col-6">
                                    <p><strong><i class="fas fa-id-card mr-2 text-muted"></i>NIM/NIP:</strong><br>
                                    <span id="detailNim" class="text-dark"></span></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <p><strong><i class="fas fa-user-tag mr-2 text-muted"></i>Role:</strong><br>
                                    <span id="detailRole" class="badge badge-primary"></span></p>
                                </div>
                                <div class="col-6">
                                    <p><strong><i class="fas fa-calendar-alt mr-2 text-muted"></i>Bergabung:</strong><br>
                                    <span id="detailCreated" class="text-muted"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Change Role Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="roleModalLabel">
                    <i class="fas fa-user-tag mr-2"></i> Ubah Role User
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="roleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p>Ubah role untuk user <strong id="roleUserName"></strong></p>
                    <div class="form-group">
                        <label for="roleSelect" class="form-label">Role Baru</label>
                        <select class="form-control" id="roleSelect" name="role" required>
                            <option value="customer">Customer</option>
                            <option value="petugas">Petugas</option>
                            <option value="admin">Admin</option>
                        </select>
                        <input type="hidden" name="current_role" id="currentRole">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-trash mr-2"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus user <strong id="deleteUserName"></strong>?</p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle mr-2"></i>Tindakan ini tidak dapat dibatalkan!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Batal
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info text-white">
                <h5 class="modal-title" id="imageModalLabel">
                    <i class="fas fa-image mr-2"></i> Preview Foto
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Foto User" class="img-fluid rounded shadow">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
                <a id="downloadImage" href="#" class="btn btn-primary" download>
                    <i class="fas fa-download mr-1"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    /* Tambahan CSS khusus untuk user management */
    .user-avatar {
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    
    .user-info {
        padding: 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    
    .timeline {
        position: relative;
        padding-left: 40px;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-time {
        position: absolute;
        left: -40px;
        top: 0;
        font-size: 12px;
        color: #6c757d;
        width: 40px;
        text-align: right;
        padding-right: 10px;
    }
    
    .timeline-icon {
        position: absolute;
        left: -48px;
        top: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }
    
    .timeline-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        border-left: 3px solid #667eea;
    }
    
    .timeline-content h6 {
        margin-bottom: 5px;
        color: #495057;
    }
    
    .timeline-content p {
        margin: 0;
        color: #6c757d;
        font-size: 14px;
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Table Search
        $('#searchTable').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $('#customersTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Toggle Password Visibility
        $('#togglePassword').click(function() {
            const passwordInput = $('#password');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });

        // View User Detail
        $('.btn-view').click(function() {
            const nama = $(this).data('nama');
            const email = $(this).data('email');
            const nim = $(this).data('nim');
            const role = $(this).data('role');
            const status = $(this).data('status');
            const created = $(this).data('created');
            const foto = $(this).data('foto') || '/img/default-avatar.png';

            $('#detailFoto').attr('src', foto);
            $('#detailNama').text(nama);
            $('#detailEmail').text(email);
            $('#detailNim').text(nim);
            $('#detailRole').text(role.charAt(0).toUpperCase() + role.slice(1));
            $('#detailCreated').text(created);
            
            // Set status badge
            let statusBadge = '';
            if (status === 'active') {
                statusBadge = '<span class="badge badge-success badge-pill px-3 py-2">Aktif</span>';
            } else if (status === 'banned') {
                statusBadge = '<span class="badge badge-danger badge-pill px-3 py-2">Terblokir</span>';
            } else {
                statusBadge = '<span class="badge badge-warning badge-pill px-3 py-2">Pending</span>';
            }
            $('#detailStatus').html(statusBadge);

            $('#viewModal').modal('show');
        });

        // Suspend User
        $('.btn-suspend').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');

            Swal.fire({
                title: 'Konfirmasi Blokir',
                html: `<p>Apakah Anda yakin ingin memblokir user <strong>"${nama}"</strong>?</p>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff0844',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Blokir!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/users/${id}/suspend`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT'
                        },
                        success: function(response) {
                            Toast.fire({
                                icon: 'success',
                                title: 'User berhasil diblokir!'
                            });
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(xhr) {
                            Toast.fire({
                                icon: 'error',
                                title: 'Gagal memblokir user'
                            });
                        }
                    });
                }
            });
        });

        // Activate User
        $('.btn-activate').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');

            Swal.fire({
                title: 'Konfirmasi Aktifkan',
                html: `<p>Apakah Anda yakin mengaktifkan kembali user <strong>"${nama}"</strong>?</p>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#43e97b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Aktifkan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/users/${id}/activate`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT'
                        },
                        success: function(response) {
                            Toast.fire({
                                icon: 'success',
                                title: 'User berhasil diaktifkan!'
                            });
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(xhr) {
                            Toast.fire({
                                icon: 'error',
                                title: 'Gagal mengaktifkan user'
                            });
                        }
                    });
                }
            });
        });

        // Change Role
        $('.btn-role').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const currentRole = $(this).data('current-role');

            $('#roleUserName').text(nama);
            $('#currentRole').val(currentRole);
            $('#roleSelect').val(currentRole);
            $('#roleForm').attr('action', `/admin/users/${id}/change-role`);
            $('#roleModal').modal('show');
        });

        // Delete User
        $('.btn-delete').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');

            $('#deleteUserName').text(nama);
            $('#deleteForm').attr('action', `/admin/users/${id}`);
            $('#deleteModal').modal('show');
        });

        // Delete Form Submission
        $('#deleteForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const url = form.attr('action');
            const button = form.find('button[type="submit"]');

            button.prop('disabled', true).addClass('btn-loading');

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'User berhasil dihapus!'
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    button.prop('disabled', false).removeClass('btn-loading');
                    Toast.fire({
                        icon: 'error',
                        title: 'Gagal menghapus user'
                    });
                }
            });
        });

        // Preview Foto
        $('.btn-foto').click(function() {
            const fotoUrl = $(this).data('foto');

            $('#modalImage').attr('src', fotoUrl);
            $('#downloadImage').attr('href', fotoUrl);
            $('#imageModal').modal('show');
        });

        // Global image modal function
        window.showImageModal = function(imageUrl) {
            $('#modalImage').attr('src', imageUrl);
            $('#downloadImage').attr('href', imageUrl);
            $('#imageModal').modal('show');
        };

        // Quick Actions
        $('#exportBtn').click(function() {
            Swal.fire({
                title: 'Ekspor Data',
                text: 'Fitur export akan segera tersedia!',
                icon: 'info',
                confirmButtonColor: '#667eea'
            });
        });

        $('#refreshBtn').click(function() {
            const btn = $(this);
            btn.addClass('btn-loading');
            setTimeout(() => {
                location.reload();
            }, 1000);
        });

        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap4',
            minimumResultsForSearch: Infinity
        });

        // Form Submit Loading
        $('form').on('submit', function() {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...');
        });

        // Initialize tooltips
        $('[title]').tooltip();
    });

    // SweetAlert2 Toast
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
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection