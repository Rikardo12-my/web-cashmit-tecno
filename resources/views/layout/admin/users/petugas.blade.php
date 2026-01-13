@extends('layout.admin.master')

@section('title', 'Management User - Petugas')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-user-tie mr-2"></i>👨‍💼 Management Petugas
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.petugas') }}"><i class="fas fa-user-tie"></i> Petugas</a></li>
                        <li class="breadcrumb-item active">Management Petugas</li>
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
                            <h3>{{ $petugas->count() }}</h3>
                            <p>Total Petugas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <a href="#" class="small-box-footer">Lihat semua <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-success">
                        <div class="inner">
                            <h3>{{ $activeCount }}</h3>
                            <p>Petugas Aktif</p>
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
                            <p>Petugas Terblokir</p>
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
                    <!-- Petugas Table -->
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list-ul mr-2"></i>
                                Daftar Petugas
                            </h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 300px;">
                                    <input type="text" id="searchTable" class="form-control float-right"
                                        placeholder="Cari petugas...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    <div class="ml-2">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addUserModal">
                                            <i class="fas fa-plus mr-1"></i> Tambah Petugas
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="petugasTable">
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
                                        @forelse($petugas as $user)
                                        <tr>
                                            <td class="align-middle">
                                                <span class="badge badge-secondary">{{ $loop->iteration }}</span>
                                            </td>

                                            <!-- Kolom Foto -->
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    @if($user->foto)
                                                        @php
                                                            $imageUrl = Storage::url($user->foto);
                                                            $imageExists = Storage::disk('public')->exists($user->foto);
                                                        @endphp
                                                        
                                                        @if($imageExists)
                                                            <div class="position-relative">
                                                                <img src="{{ $imageUrl }}" 
                                                                     alt="{{ $user->nama }}"
                                                                     class="img-thumbnail rounded-circle shadow-sm"
                                                                     style="width: 50px; height: 50px; object-fit: cover;"
                                                                     onclick="showImageModal('{{ $imageUrl }}')">
                                                                
                                                                <span class="badge badge-light position-absolute" style="top: -5px; right: -5px; font-size: 8px;">
                                                                    <i class="fas fa-user-tie text-info"></i>
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
                                                            <i class="fas fa-user-tie text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Kolom Nama -->
                                            <td class="align-middle">
                                                <div>
                                                    <strong class="d-block">{{ $user->nama }}</strong>
                                                    <small class="text-muted">
                                                        <i class="far fa-calendar-alt mr-1"></i>
                                                        {{ $user->created_at->format('d/m/Y') }}
                                                    </small>
                                                </div>
                                            </td>

                                            <!-- Kolom Email -->
                                            <td class="align-middle">
                                                <a href="mailto:{{ $user->email }}" class="text-primary">
                                                    <i class="fas fa-envelope mr-1"></i>
                                                    {{ $user->email }}
                                                </a>
                                            </td>

                                            <!-- Kolom NIM/NIP -->
                                            <td class="align-middle">
                                                <span class="badge badge-light text-dark p-2">
                                                    <i class="fas fa-id-card mr-1 text-primary"></i>
                                                    {{ $user->nim_nip }}
                                                </span>
                                            </td>

                                            <!-- Kolom Status -->
                                            <td class="align-middle">
                                                @if($user->status == 'active')
                                                <span class="badge badge-success badge-pill px-3 py-2">
                                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                                </span>
                                                @elseif($user->status == 'banned')
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
                                                        data-id="{{ $user->id }}"
                                                        data-nama="{{ $user->nama }}"
                                                        data-email="{{ $user->email }}"
                                                        data-nim="{{ $user->nim_nip }}"
                                                        data-role="{{ $user->role }}"
                                                        data-status="{{ $user->status }}"
                                                        data-created="{{ $user->created_at->format('d/m/Y H:i') }}"
                                                        title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @if($user->status == 'active')
                                                    <button type="button" class="btn btn-sm btn-outline-warning btn-suspend"
                                                        data-id="{{ $user->id }}"
                                                        data-nama="{{ $user->nama }}"
                                                        title="Blokir">
                                                        <i class="fas fa-user-slash"></i>
                                                    </button>
                                                    @else
                                                    <button type="button" class="btn btn-sm btn-outline-success btn-activate"
                                                        data-id="{{ $user->id }}"
                                                        data-nama="{{ $user->nama }}"
                                                        title="Aktifkan">
                                                        <i class="fas fa-user-check"></i>
                                                    </button>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-outline-primary btn-role"
                                                        data-id="{{ $user->id }}"
                                                        data-nama="{{ $user->nama }}"
                                                        data-current-role="{{ $user->role }}"
                                                        title="Ubah Role">
                                                        <i class="fas fa-user-tag"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete"
                                                        data-id="{{ $user->id }}"
                                                        data-nama="{{ $user->nama }}"
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
                                                    <i class="fas fa-user-tie fa-4x text-muted mb-4"></i>
                                                    <h4 class="text-muted">Belum ada petugas</h4>
                                                    <p class="text-muted mb-4">Tambahkan petugas pertama Anda</p>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                                                        <i class="fas fa-plus mr-2"></i>Tambah Petugas Pertama
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($petugas->count() > 0)
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Menampilkan <strong>{{ $petugas->count() }}</strong> dari <strong>{{ $petugas->count() }}</strong> petugas
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
                    <!-- Performance Stats -->
                    <div class="card card-outline card-gradient-indigo">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-2"></i>
                                Performa Petugas
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="performance-stats">
                                <div class="performance-item mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Customer Service</span>
                                        <span>85%</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-success" style="width: 85%"></div>
                                    </div>
                                </div>
                                <div class="performance-item mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Response Time</span>
                                        <span>92%</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-info" style="width: 92%"></div>
                                    </div>
                                </div>
                                <div class="performance-item mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Task Completion</span>
                                        <span>78%</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-warning" style="width: 78%"></div>
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
                                Statistik Petugas
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-number text-primary">{{ $petugas->count() }}</div>
                                        <div class="stat-label">Total Petugas</div>
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
                                    <a href="{{ route('admin.users.customer') }}" class="btn btn-outline-info btn-block btn-action">
                                        <i class="fas fa-users mr-2"></i> Customer
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

<!-- Add User Modal - Same as customer page -->
<!-- View Detail Modal - Same as customer page -->
<!-- Change Role Modal - Same as customer page -->
<!-- Delete Confirmation Modal - Same as customer page -->
<!-- Image Modal - Same as customer page -->
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Table Search
        $('#searchTable').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $('#petugasTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // JavaScript lainnya sama dengan halaman customer
        // ... (copy semua JavaScript dari customer page)
    });
</script>
@endsection