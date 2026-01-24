@extends('layout.admin.master')

@section('title', 'Customer Terhapus')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-trash-restore mr-2"></i>🗑️ Customer Terhapus
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}"><i class="fas fa-users"></i> Customer</a></li>
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
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="small-box bg-gradient-warning">
                        <div class="inner">
                            <h3>{{ $totalDeleted }}</h3>
                            <p>Customer Terhapus</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-trash"></i>
                        </div>
                        <a href="#" class="small-box-footer">Total soft deleted</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="small-box bg-gradient-info">
                        <div class="inner">
                            <h3>{{ $deletedCustomers->count() }}</h3>
                            <p>Ditampilkan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <a href="#" class="small-box-footer">Dapat dipulihkan</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="small-box bg-gradient-danger">
                        <div class="inner">
                            <h3>0</h3>
                            <p>Dihapus Permanen</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-skull-crossbones"></i>
                        </div>
                        <a href="#" class="small-box-footer">Tidak dapat dipulihkan</a>
                    </div>
                </div>
            </div>

            <!-- Deleted Customers Table -->
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Daftar Customer Terhapus
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.customer.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover" id="deletedCustomersTable">
                            <thead class="bg-gradient-warning text-white">
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 15%">Foto</th>
                                    <th style="width: 20%">Nama</th>
                                    <th style="width: 20%">Email</th>
                                    <th style="width: 15%">Status Terakhir</th>
                                    <th style="width: 15%">Tanggal Dihapus</th>
                                    <th style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deletedCustomers as $customer)
                                <tr>
                                    <td class="align-middle">
                                        <span class="badge badge-secondary">{{ $loop->iteration }}</span>
                                    </td>

                                    <!-- Kolom Foto -->
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            @if($customer->foto)
                                                <img src="{{ asset('storage/' . $customer->foto) }}" 
                                                     alt="{{ $customer->nama }}" 
                                                     class="img-thumbnail rounded-circle"
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width: 50px; height: 50px; background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Kolom Nama -->
                                    <td class="align-middle">
                                        <strong>{{ $customer->nama }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ $customer->nim_nip ?? '-' }}
                                        </small>
                                    </td>

                                    <!-- Kolom Email -->
                                    <td class="align-middle">
                                        {{ $customer->email }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $customer->telepon ?? '-' }}
                                        </small>
                                    </td>

                                    <!-- Kolom Status Terakhir -->
                                    <td class="align-middle">
                                        <span class="badge badge-{{ $customer->status == 'active' ? 'success' : ($customer->status == 'verify' ? 'warning' : 'danger') }} badge-pill">
                                            {{ ucfirst($customer->status) }}
                                        </span>
                                    </td>

                                    <!-- Kolom Tanggal Dihapus -->
                                    <td class="align-middle">
                                        <div>
                                            <small class="text-primary d-block">
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                {{ $customer->deleted_at->format('d/m/Y') }}
                                            </small>
                                            <small class="text-muted d-block">
                                                <i class="far fa-clock mr-1"></i>
                                                {{ $customer->deleted_at->timezone('Asia/Jakarta')->format('H:i') }}
                                            </small>
                                            <small class="text-info">
                                                ({{ $customer->deleted_at->diffForHumans() }})
                                            </small>
                                        </div>
                                    </td>

                                    <!-- Kolom Aksi -->
                                    <td class="align-middle">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.customer.restore', $customer->id) }}" 
                                               class="btn btn-sm btn-outline-success btn-restore"
                                               title="Pulihkan"
                                               onclick="return confirm('Pulihkan customer ini?')">
                                                <i class="fas fa-trash-restore"></i> Pulihkan
                                            </a>
                                            
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-permanent-delete"
                                                data-id="{{ $customer->id }}"
                                                data-nama="{{ $customer->nama }}"
                                                data-url="{{ route('admin.customer.forceDelete', $customer->id) }}"
                                                title="Hapus Permanen">
                                                <i class="fas fa-skull-crossbones"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-trash-alt fa-4x text-muted mb-4"></i>
                                            <h4 class="text-muted">Tidak ada customer terhapus</h4>
                                            <p class="text-muted mb-4">Semua customer dalam keadaan aktif</p>
                                            <a href="{{ route('admin.customer.index') }}" class="btn btn-primary">
                                                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Customer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($deletedCustomers->count() > 0)
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Menampilkan <strong>{{ $deletedCustomers->count() }}</strong> customer terhapus
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-warning" id="restoreAllBtn">
                                <i class="fas fa-trash-restore mr-1"></i> Pulihkan Semua
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" id="deleteAllBtn">
                                <i class="fas fa-skull-crossbones mr-1"></i> Hapus Semua
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Warning Alert -->
            <div class="alert alert-warning">
                <h5><i class="fas fa-exclamation-triangle mr-2"></i>Informasi Penting</h5>
                <p class="mb-2">Customer yang terhapus (soft delete) masih tersimpan di database dan dapat dipulihkan kapan saja.</p>
                <p class="mb-0">Hanya customer yang dihapus permanen (force delete) yang benar-benar hilang dari database.</p>
            </div>
        </div>
    </div>
</div>

<!-- Permanent Delete Modal -->
<div class="modal fade" id="permanentDeleteModal" tabindex="-1" role="dialog" aria-labelledby="permanentDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger text-white">
                <h5 class="modal-title" id="permanentDeleteModalLabel">
                    <i class="fas fa-skull-crossbones mr-2"></i> Hapus Permanen
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus <strong id="permanentDeleteCustomerName"></strong> secara permanen?</p>
                <div class="alert alert-danger">
                    <i class="fas fa-radiation-alt mr-2"></i>
                    <strong>PERINGATAN:</strong> Tindakan ini akan menghapus customer dari database secara permanen. Data tidak dapat dipulihkan!
                </div>
                <p class="text-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Pastikan Anda telah membackup data penting sebelum melanjutkan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Batal
                </button>
                <form id="permanentDeleteForm" method="POST" style="display: inline;">
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
    .small-box .inner h3 {
        font-size: 2.2rem;
    }
    
    .table-hover tbody tr:hover {
        background: linear-gradient(90deg, rgba(255, 193, 7, 0.05) 0%, rgba(255, 152, 0, 0.05) 100%);
        border-left: 3px solid #ffc107;
    }
    
    .btn-restore {
        border: 2px solid #28a745;
        color: #28a745;
        background: transparent;
    }
    
    .btn-restore:hover {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
        border-color: transparent;
    }
    
    .btn-permanent-delete {
        border: 2px solid #dc3545;
        color: #dc3545;
        background: transparent;
    }
    
    .btn-permanent-delete:hover {
        background: linear-gradient(135deg, #ff0844 0%, #ffb199 100%);
        color: white;
        border-color: transparent;
    }
    
    .avatar-placeholder {
        transition: all 0.3s ease;
    }
    
    .avatar-placeholder:hover {
        transform: scale(1.05);
    }
    
    .empty-state {
        padding: 50px 30px;
        text-align: center;
        color: #6c757d;
    }
    
    .empty-state i {
        opacity: 0.3;
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Permanent Delete
        $('.btn-permanent-delete').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const url = $(this).data('url');

            $('#permanentDeleteCustomerName').text(nama);
            $('#permanentDeleteForm').attr('action', url);
            $('#permanentDeleteModal').modal('show');
        });

        // Permanent Delete Form Submission
        $('#permanentDeleteForm').on('submit', function(e) {
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
                    $('#permanentDeleteModal').modal('hide');
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message || 'Customer berhasil dihapus permanen',
                        icon: 'success',
                        confirmButtonColor: '#667eea'
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    button.prop('disabled', false).html('<i class="fas fa-skull-crossbones mr-1"></i> Hapus');
                    $('#permanentDeleteModal').modal('hide');
                    
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menghapus customer',
                        icon: 'error',
                        confirmButtonColor: '#ff0844'
                    });
                }
            });
        });

        // Restore All Button
        $('#restoreAllBtn').click(function() {
            Swal.fire({
                title: 'Pulihkan Semua',
                text: 'Apakah Anda yakin ingin memulihkan semua customer terhapus?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash-restore mr-2"></i>Ya, Pulihkan Semua!',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route("admin.customer.index") }}?restore_all=1';
                }
            });
        });

        // Delete All Button
        $('#deleteAllBtn').click(function() {
            Swal.fire({
                title: 'Hapus Semua Permanen',
                text: 'Apakah Anda yakin ingin menghapus semua customer terhapus secara permanen?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-skull-crossbones mr-2"></i>Ya, Hapus Semua!',
                cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
                showDenyButton: true,
                denyButtonText: '<i class="fas fa-download mr-2"></i>Backup Dulu',
                denyButtonColor: '#17a2b8'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route("admin.customer.deleted") }}?delete_all=1';
                } else if (result.isDenied) {
                    // Export backup
                    window.open('{{ route("admin.customer.statistics") }}?export=excel&deleted=1', '_blank');
                }
            });
        });

        // Initialize tooltips
        $('[title]').tooltip();
    });
</script>
@endsection