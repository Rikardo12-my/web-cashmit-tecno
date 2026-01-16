@extends('layout.admin.master')

@section('title', 'Petugas Terhapus')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-trash-restore mr-2"></i> Petugas Terhapus
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.petugas.index') }}"><i class="fas fa-user-tie"></i> Petugas</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-trash"></i> Terhapus</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Stats Card -->
            <div class="row mb-4">
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="small-box bg-gradient-warning shadow-sm">
                        <div class="inner">
                            <h3>{{ $totalDeleted }}</h3>
                            <p>Petugas Terhapus</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-trash"></i>
                        </div>
                        <div class="small-box-footer bg-warning">
                            Total soft deleted
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="small-box bg-gradient-info shadow-sm">
                        <div class="inner">
                            <h3>{{ $deletedPetugas->count() }}</h3>
                            <p>Ditampilkan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="small-box-footer bg-info">
                            Dapat dipulihkan
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 mb-3">
                    <div class="small-box bg-gradient-danger shadow-sm">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Dihapus Permanen</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-skull-crossbones"></i>
                        </div>
                        <div class="small-box-footer bg-danger">
                            Tidak dapat dipulihkan
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deleted Petugas Table -->
            <div class="card card-warning card-outline shadow">
                <div class="card-header border-bottom-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Daftar Petugas Terhapus
                        </h3>
                        <div>
                            <a href="{{ route('admin.petugas.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Petugas
                            </a>
                        </div>
                    </div>
                </div>
                
                @if($deletedPetugas->count() > 0)
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="deletedPetugasTable">
                            <thead class="bg-warning text-white">
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 15%">Foto</th>
                                    <th style="width: 20%">Nama</th>
                                    <th style="width: 20%">Kontak</th>
                                    <th style="width: 15%">Status</th>
                                    <th style="width: 15%">Terhapus</th>
                                    <th style="width: 20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deletedPetugas as $petugas)
                                <tr class="align-middle">
                                    <td>
                                        <span class="badge badge-secondary">{{ $loop->iteration }}</span>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($petugas->foto)
                                                @php
                                                    $imageUrl = Storage::url($petugas->foto);
                                                    $imageExists = Storage::disk('public')->exists($petugas->foto);
                                                @endphp
                                                
                                                @if($imageExists)
                                                    <img src="{{ $imageUrl }}" 
                                                         alt="{{ $petugas->nama }}" 
                                                         class="img-thumbnail rounded-circle"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center"
                                                         style="width: 50px; height: 50px; background: linear-gradient(45deg, #ffeaa7, #fab1a0); border: 2px dashed #e17055;">
                                                        <i class="fas fa-exclamation-circle text-danger"></i>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width: 50px; height: 50px; background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);">
                                                    <i class="fas fa-user-tie text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <strong>{{ $petugas->nama }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $petugas->nim_nip ?? '-' }}
                                        </small>
                                    </td>
                                    
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;">
                                            {{ $petugas->email }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $petugas->telepon ?? '-' }}
                                        </small>
                                    </td>
                                    
                                    <td>
                                        <span class="badge badge-{{ $petugas->status == 'active' ? 'success' : ($petugas->status == 'verify' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($petugas->status) }}
                                        </span>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex flex-column">
                                            <small class="text-primary">
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                {{ $petugas->deleted_at->format('d/m/Y') }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="far fa-clock mr-1"></i>
                                                {{ $petugas->deleted_at->format('H:i') }}
                                            </small>
                                            <small class="text-info">
                                                {{ $petugas->deleted_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!-- Form untuk Restore -->
                                            <form action="{{ route('admin.petugas.restore', $petugas->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="btn btn-success btn-flat"
                                                    title="Pulihkan Petugas"
                                                    onclick="return confirm('Pulihkan petugas {{ $petugas->nama }}?')">
                                                    <i class="fas fa-trash-restore"></i>
                                                </button>
                                            </form>
                                            
                                            <!-- Tombol untuk Force Delete -->
                                            <button type="button"
                                                class="btn btn-danger btn-flat btn-permanent-delete"
                                                title="Hapus Permanen"
                                                data-id="{{ $petugas->id }}"
                                                data-nama="{{ $petugas->nama }}"
                                                data-url="{{ route('admin.petugas.forceDelete', $petugas->id) }}">
                                                <i class="fas fa-skull-crossbones"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            <i class="fas fa-info-circle mr-1"></i>
                            Menampilkan <strong>{{ $deletedPetugas->count() }}</strong> dari <strong>{{ $totalDeleted }}</strong> petugas terhapus
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-warning" id="restoreAllBtn">
                                <i class="fas fa-trash-restore mr-1"></i> Pulihkan Semua
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" id="deleteAllBtn">
                                <i class="fas fa-skull-crossbones mr-1"></i> Hapus Semua Permanen
                            </button>
                        </div>
                    </div>
                </div>
                @else
                <div class="card-body text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-trash-alt fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted mb-3">Tidak ada petugas terhapus</h4>
                        <p class="text-muted mb-4">Semua petugas dalam keadaan aktif</p>
                        <a href="{{ route('admin.petugas.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Petugas
                        </a>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Warning Alert -->
            <div class="alert alert-warning alert-dismissible fade show shadow-sm mt-4" role="alert">
                <h5 class="alert-heading mb-2">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Informasi Penting
                </h5>
                <p class="mb-2">
                    <i class="fas fa-info-circle mr-2"></i>
                    Petugas yang terhapus (soft delete) masih tersimpan di database dan dapat dipulihkan kapan saja.
                </p>
                <p class="mb-0">
                    <i class="fas fa-radiation-alt mr-2"></i>
                    Hanya petugas yang dihapus permanen (force delete) yang benar-benar hilang dari database.
                </p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Permanent Delete Modal -->
<div class="modal fade" id="permanentDeleteModal" tabindex="-1" role="dialog" aria-labelledby="permanentDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="permanentDeleteModalLabel">
                    <i class="fas fa-skull-crossbones mr-2"></i> Hapus Permanen
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-exclamation-triangle fa-4x text-danger mb-3"></i>
                    <h5 class="font-weight-bold">Apakah Anda yakin?</h5>
                </div>
                <p>Anda akan menghapus petugas <strong id="permanentDeletePetugasName" class="text-danger"></strong> secara permanen.</p>
                <div class="alert alert-danger">
                    <i class="fas fa-radiation-alt mr-2"></i>
                    <strong>PERINGATAN:</strong> Tindakan ini tidak dapat dibatalkan! Data akan hilang selamanya.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Batal
                </button>
                <form id="permanentDeleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-skull-crossbones mr-1"></i> Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    /* Card Stats */
    .small-box {
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .small-box:hover {
        transform: translateY(-5px);
    }
    
    .small-box .inner {
        padding: 20px;
    }
    
    .small-box .icon {
        font-size: 70px;
        position: absolute;
        top: 10px;
        right: 10px;
        opacity: 0.3;
        transition: opacity 0.3s ease;
    }
    
    .small-box:hover .icon {
        opacity: 0.5;
    }
    
    .small-box-footer {
        padding: 8px 0;
        text-align: center;
        font-weight: bold;
    }
    
    /* Table Styling */
    .table thead th {
        border-top: none;
        font-weight: 600;
        padding: 15px;
    }
    
    .table tbody tr {
        transition: background-color 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: rgba(255, 193, 7, 0.08);
    }
    
    /* Button Styling */
    .btn-group .btn {
        border-radius: 4px !important;
        margin: 0 2px;
    }
    
    .btn-flat {
        border: 1px solid #dee2e6;
    }
    
    .btn-success.btn-flat:hover {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
    }
    
    .btn-danger.btn-flat:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }
    
    /* Avatar Styling */
    .avatar-placeholder {
        transition: all 0.3s ease;
    }
    
    .avatar-placeholder:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    /* Empty State */
    .empty-state {
        padding: 60px 30px;
    }
    
    .empty-state i {
        opacity: 0.3;
    }
    
    /* Badge Styling */
    .badge {
        padding: 5px 10px;
        font-size: 0.85em;
    }
    
    /* Alert Styling */
    .alert-warning {
        border-left: 4px solid #ffc107;
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[title]').tooltip({
            trigger: 'hover',
            placement: 'top'
        });
        
        // Permanent Delete Button
        $('.btn-permanent-delete').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const url = $(this).data('url');
            
            $('#permanentDeletePetugasName').text(nama);
            $('#permanentDeleteForm').attr('action', url);
            $('#permanentDeleteModal').modal('show');
        });
        
        // Permanent Delete Form Submission
        $('#permanentDeleteForm').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Terakhir',
                text: 'Data akan dihapus permanen dari sistem. Lanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-skull-crossbones mr-2"></i>Ya, Hapus Permanen!',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
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
                            $('#permanentDeleteModal').modal('hide');
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message || 'Petugas berhasil dihapus permanen',
                                icon: 'success',
                                confirmButtonColor: '#28a745',
                                timer: 2000
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            button.prop('disabled', false).html('<i class="fas fa-skull-crossbones mr-1"></i> Hapus');
                            $('#permanentDeleteModal').modal('hide');
                            
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus petugas',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    });
                }
            });
        });
        
        // Restore All Button
        $('#restoreAllBtn').click(function() {
            Swal.fire({
                title: 'Pulihkan Semua Petugas',
                text: 'Apakah Anda yakin ingin memulihkan semua petugas terhapus?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash-restore mr-2"></i>Ya, Pulihkan Semua!',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                reverseButtons: true
            }).then((result) => {
                
            });
        });
        
        // Delete All Button
        $('#deleteAllBtn').click(function() {
            Swal.fire({
                title: 'Hapus Semua Permanen',
                html: `
                    <div class="text-left">
                        <p>Anda akan menghapus <strong>SEMUA</strong> petugas terhapus secara permanen!</p>
                        <div class="alert alert-danger small mt-2">
                            <i class="fas fa-radiation-alt mr-1"></i>
                            <strong>TIDAK DAPAT DIBATALKAN!</strong> Semua data akan hilang selamanya.
                        </div>
                        <p class="mt-2">Apakah Anda yakin ingin melanjutkan?</p>
                    </div>
                `,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-skull-crossbones mr-2"></i>Ya, Hapus Semua!',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                showDenyButton: true,
                denyButtonText: '<i class="fas fa-download mr-2"></i>Backup Dulu',
                denyButtonColor: '#17a2b8',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                } else if (result.isDenied) {
                }
            });
        });
        
        // Table row hover effect
        $('tbody tr').hover(
            function() {
                $(this).css('transform', 'scale(1.002)');
            },
            function() {
                $(this).css('transform', 'scale(1)');
            }
        );
    });
</script>

@if(session('success'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session("success") }}',
        icon: 'success',
        confirmButtonColor: '#28a745',
        timer: 3000
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        title: 'Error!',
        text: '{{ session("error") }}',
        icon: 'error',
        confirmButtonColor: '#dc3545'
    });
</script>
@endif
@endsection