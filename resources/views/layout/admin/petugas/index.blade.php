@extends('layout.admin.master')

@section('title', 'Manajemen Petugas')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-user-tie mr-2"></i>Manajemen Petugas
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-user-shield"></i> Petugas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Stats Cards -->
            

            <!-- Action Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <!-- Title Section -->
                    <div class="mb-3 mb-md-0">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-gradient-primary rounded-circle p-2 mr-3">
                                <i class="fas fa-users-cog text-white fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 font-weight-semibold">Kelola Petugas</h5>
                                <p class="text-muted mb-0 small">Kelola data petugas dan tugas-tugas terkait</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('admin.petugas.create') }}" 
                           class="btn btn-primary btn-icon">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Tambah Baru
                        </a>
                        
                        <a href="{{ route('admin.petugas.deleted') }}" 
                           class="btn btn-outline-warning btn-icon">
                            <i class="fas fa-trash-restore mr-2"></i>
                            Arsip
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            <!-- Petugas Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list-ul mr-2"></i>
                                Daftar Petugas
                            </h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <input type="text" id="searchTable" class="form-control float-right"
                                        placeholder="Cari petugas...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info">
                                            <i class="fas fa-search"></i>
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
                                            <th style="width: 15%">Foto</th>
                                            <th style="width: 20%">Nama</th>
                                            <th style="width: 20%">Email</th>
                                            <th style="width: 15%">Telepon</th>
                                            <th style="width: 10%">Status</th>
                                            <th style="width: 15%">Tanggal Bergabung</th>
                                            <th style="width: 20%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($petugas as $item)
                                        <tr>
                                            <td class="align-middle">
                                                <span class="badge badge-secondary">{{ $loop->iteration }}</span>
                                            </td>

                                            <!-- Kolom Foto -->
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    @if($item->foto)
                                                    @php
                                                    $imageUrl = Storage::url($item->foto);
                                                    $imageExists = Storage::disk('public')->exists($item->foto);
                                                    @endphp

                                                    @if($imageExists)
                                                    <div class="position-relative">
                                                        <img src="{{ $imageUrl }}"
                                                            alt="{{ $item->nama }}"
                                                            class="img-thumbnail rounded-circle shadow-sm"
                                                            style="width: 60px; height: 60px; object-fit: cover;"
                                                            data-toggle="tooltip" title="{{ $item->nama }}">

                                                        <span class="badge badge-light position-absolute" style="top: -5px; right: -5px; font-size: 8px;">
                                                            <i class="fas fa-user-tie text-info"></i>
                                                        </span>
                                                    </div>
                                                    @else
                                                    <div class="image-error-placeholder rounded-circle d-flex flex-column align-items-center justify-content-center text-center"
                                                        style="width: 60px; height: 60px; background: linear-gradient(45deg, #ffeaa7, #fab1a0); border: 2px dashed #e17055;"
                                                        title="Foto tidak ditemukan">
                                                        <i class="fas fa-exclamation-circle text-danger mb-1"></i>
                                                        <small class="text-danger" style="font-size: 8px;">Error</small>
                                                    </div>
                                                    @endif
                                                    @else
                                                    <div class="image-placeholder rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px; background: linear-gradient(45deg, #dfe6e9, #b2bec3);">
                                                        <i class="fas fa-user-tie text-muted fa-lg"></i>
                                                    </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Kolom Nama -->
                                            <td class="align-middle">
                                                <div>
                                                    <strong class="d-block">{{ $item->nama }}</strong>
                                                    <small class="text-muted">
                                                        <i class="fas fa-id-card mr-1"></i>
                                                        {{ $item->nim_nip ?? 'Tanpa NIM/NIP' }}
                                                    </small>
                                                </div>
                                            </td>

                                            <!-- Kolom Email -->
                                            <td class="align-middle">
                                                <div>
                                                    <span class="d-block">{{ $item->email }}</span>
                                                    @if($item->email_verified_at)
                                                    <small class="text-success">
                                                        <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                                                    </small>
                                                    @else
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Kolom Telepon -->
                                            <td class="align-middle">
                                                @if($item->telepon)
                                                <span class="badge badge-light text-dark p-2">
                                                    <i class="fas fa-phone mr-1 text-primary"></i>
                                                    {{ $item->telepon }}
                                                </span>
                                                @else
                                                <span class="text-muted">
                                                    <i class="fas fa-phone-slash mr-1"></i>Tidak ada
                                                </span>
                                                @endif
                                            </td>

                                            <!-- Kolom Status -->
                                            <td class="align-middle">
                                                @if($item->status == 'active')
                                                <span class="badge badge-success badge-pill px-3 py-2">
                                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                                </span>
                                                @elseif($item->status == 'verify')
                                                <span class="badge badge-warning badge-pill px-3 py-2">
                                                    <i class="fas fa-clock mr-1"></i> Verify
                                                </span>
                                                @elseif($item->status == 'banned')
                                                <span class="badge badge-danger badge-pill px-3 py-2">
                                                    <i class="fas fa-ban mr-1"></i> Banned
                                                </span>
                                                @endif
                                            </td>

                                            <!-- Kolom Tanggal Bergabung -->
                                            <td class="align-middle">
                                                <div>
                                                    <small class="text-primary d-block">
                                                        <i class="far fa-calendar-alt mr-1"></i>
                                                        {{ $item->created_at->format('d/m/Y') }}
                                                    </small>
                                                    <small class="text-muted d-block">
                                                        <i class="far fa-clock mr-1"></i>
                                                        {{ $item->created_at->timezone('Asia/Jakarta')->format('H:i')}}
                                                    </small>
                                                </div>
                                            </td>

                                            <!-- Kolom Aksi -->
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.petugas.edit', $item->id) }}"
                                                        class="btn btn-sm btn-outline-info"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    @if($item->status != 'active')
                                                    <form action="{{ route('admin.petugas.activate', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-success"
                                                            title="Aktifkan"
                                                            onclick="return confirm('Aktifkan petugas ini?')">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    @endif

                                                    @if($item->status != 'banned')
                                                    <form action="{{ route('admin.petugas.ban', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-warning"
                                                            title="Blokir"
                                                            onclick="return confirm('Blokir petugas ini?')">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    </form>
                                                    @endif

                                                    <form action="{{ route('admin.petugas.destroy', $item->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger"
                                                            title="Hapus"
                                                            onclick="return confirm('Hapus petugas ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-user-tie fa-4x text-muted mb-4"></i>
                                                    <h4 class="text-muted">Belum ada petugas</h4>
                                                    <p class="text-muted mb-4">Tambahkan petugas pertama Anda</p>
                                                    <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus-circle mr-2"></i>Tambah Petugas Pertama
                                                    </a>
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
                                    Menampilkan <strong>{{ $petugas->count() }}</strong> dari <strong>{{ $totalPetugas }}</strong> petugas
                                </div>
                                <div>
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
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deletePetugasModal" tabindex="-1" role="dialog" aria-labelledby="deletePetugasModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger text-white">
                <h5 class="modal-title" id="deletePetugasModalLabel">
                    <i class="fas fa-trash mr-2"></i> Konfirmasi Hapus Petugas
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus petugas <strong id="deletePetugasName"></strong>?</p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle mr-2"></i>Petugas akan dipindahkan ke daftar terhapus.</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    Petugas dapat dipulihkan kapan saja dari menu "Petugas Terhapus".
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Batal
                </button>
                <form id="deletePetugasForm" method="POST" style="display: inline;">
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
@endsection

@section('css')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --danger-gradient: linear-gradient(135deg, #ff0844 0%, #ffb199 100%);
        --cyan-gradient: linear-gradient(135deg, #17ead9 0%, #6078ea 100%);
    }

    .card-outline {
        border-top: 4px solid;
        border-radius: 12px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        margin-bottom: 25px;
        overflow: hidden;
    }

    .card-outline.card-primary {
        border-top-color: #667eea;
    }

    .card-outline.card-info {
        border-top-color: #4facfe;
    }

    .small-box {
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: none;
        color: white;
    }

    .small-box:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .bg-gradient-cyan {
        background: var(--cyan-gradient);
    }

    .bg-gradient-success {
        background: var(--success-gradient);
    }

    .bg-gradient-warning {
        background: var(--warning-gradient);
    }

    .bg-gradient-danger {
        background: var(--danger-gradient);
    }

    .bg-gradient-info {
        background: var(--info-gradient);
    }

    .table-hover tbody tr {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .table-hover tbody tr:hover {
        background: linear-gradient(90deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        transform: translateX(5px);
        border-left: 3px solid #667eea;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .badge {
        border-radius: 50px;
        padding: 6px 15px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }

    .badge-pill {
        padding: 8px 20px;
    }

    .btn {
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-outline-info {
        border: 2px solid #4facfe;
        color: #4facfe;
        background: transparent;
    }

    .btn-outline-info:hover {
        background: var(--info-gradient);
        color: white;
        border-color: transparent;
    }

    .btn-outline-success {
        border: 2px solid #43e97b;
        color: #43e97b;
        background: transparent;
    }

    .btn-outline-success:hover {
        background: var(--success-gradient);
        color: white;
        border-color: transparent;
    }

    .btn-outline-warning {
        border: 2px solid #fa709a;
        color: #fa709a;
        background: transparent;
    }

    .btn-outline-warning:hover {
        background: var(--warning-gradient);
        color: white;
        border-color: transparent;
    }

    .btn-outline-danger {
        border: 2px solid #ff0844;
        color: #ff0844;
        background: transparent;
    }

    .btn-outline-danger:hover {
        background: var(--danger-gradient);
        color: white;
        border-color: transparent;
    }

    .empty-state {
        padding: 50px 30px;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        opacity: 0.3;
        transition: all 0.3s ease;
    }

    .empty-state:hover i {
        opacity: 0.5;
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        .card-outline {
            border-radius: 8px;
        }

        .btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .btn-group .btn {
            margin: 2px;
            flex: 1;
            min-width: 40px;
        }
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Search Table
        $('#searchTable').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $('#petugasTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Delete Petugas
        $('.btn-delete-petugas').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const url = $(this).data('url');

            $('#deletePetugasName').text(nama);
            $('#deletePetugasForm').attr('action', url);
            $('#deletePetugasModal').modal('show');
        });

        // Delete Form Submission
        $('#deletePetugasForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const url = form.attr('action');
            const button = form.find('button[type="submit"]');

            button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menghapus...');

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    $('#deletePetugasModal').modal('hide');
                    showNotification('success', response.message || 'Petugas berhasil dihapus');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    button.prop('disabled', false).html('<i class="fas fa-trash mr-1"></i> Hapus');
                    $('#deletePetugasModal').modal('hide');

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        showNotification('error', xhr.responseJSON.message);
                    } else {
                        showNotification('error', 'Terjadi kesalahan saat menghapus petugas');
                    }
                }
            });
        });

        // Export Button
        $('#exportPetugasBtn').click(function() {
            Swal.fire({
                title: 'Ekspor Data Petugas',
                text: 'Pilih format untuk mengekspor data petugas',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-file-excel mr-2"></i> Excel',
                cancelButtonText: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                showDenyButton: true,
                denyButtonText: '<i class="fas fa-times mr-2"></i> Batal',
                denyButtonColor: '#ff0844'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Export Excel
                    window.location.href = '{{ route("admin.petugas.statistics") }}?export=excel';
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Export PDF
                    window.location.href = '{{ route("admin.petugas.statistics") }}?export=pdf';
                }
            });
        });

        // Notification Function
        function showNotification(type, message) {
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

            Toast.fire({
                icon: type,
                title: message
            });
        }

        // Initialize tooltips
        $('[title]').tooltip();
    });
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection