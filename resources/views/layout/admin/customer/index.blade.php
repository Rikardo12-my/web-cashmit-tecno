@extends('layout.admin.master')

@section('title', 'Manajemen Customer')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-users mr-2"></i>Manajemen Customer
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-user-friends"></i> Customer</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">

            <!-- Main Content Row -->
            <div class="row">
                <!-- Left Column: Table -->
                <div class="col-lg-12">
                    <!-- Customer Table Card -->
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list-ul mr-2"></i>
                                Daftar Customer
                            </h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <input type="text" id="searchTable" class="form-control float-right"
                                        placeholder="Cari customer...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="customersTable">
                                    <thead class="bg-gradient-primary text-white">
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 15%">Foto</th>
                                            <th style="width: 20%">Nama</th>
                                            <th style="width: 20%">Email</th>
                                            <th style="width: 15%">Telepon</th>
                                            <th style="width: 10%">Status</th>
                                            <th style="width: 15%">Tanggal Daftar</th>
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
                                                            class="img-thumbnail rounded-circle shadow-sm customer-avatar"
                                                            style="width: 60px; height: 60px; object-fit: cover;"
                                                            onclick="showCustomerModal('{{ $customer->id }}')"
                                                            data-toggle="tooltip" title="Klik untuk detail">

                                                        <span class="badge badge-light position-absolute" style="top: -5px; right: -5px; font-size: 8px;">
                                                            <i class="fas fa-user text-info"></i>
                                                        </span>
                                                    </div>
                                                    @else
                                                    <div class="image-error-placeholder rounded-circle d-flex flex-column align-items-center justify-content-center text-center"
                                                        style="width: 60px; height: 60px; background: linear-gradient(45deg, #ffeaa7, #fab1a0); border: 2px dashed #e17055;"
                                                        title="Foto tidak ditemukan di server">
                                                        <i class="fas fa-exclamation-circle text-danger mb-1"></i>
                                                        <small class="text-danger" style="font-size: 8px;">Error</small>
                                                    </div>
                                                    @endif
                                                    @else
                                                    <div class="image-placeholder rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px; background: linear-gradient(45deg, #dfe6e9, #b2bec3); cursor: pointer;"
                                                        onclick="showCustomerModal('{{ $customer->id }}')"
                                                        data-toggle="tooltip" title="Klik untuk detail">
                                                        <i class="fas fa-user text-muted fa-lg"></i>
                                                    </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Kolom Nama -->
                                            <td class="align-middle">
                                                <div>
                                                    <strong class="d-block">{{ $customer->nama }}</strong>
                                                    <small class="text-muted">
                                                        <i class="fas fa-id-card mr-1"></i>
                                                        {{ $customer->nim_nip ?? 'Tanpa NIM/NIP' }}
                                                    </small>
                                                </div>
                                            </td>

                                            <!-- Kolom Email -->
                                            <td class="align-middle">
                                                <div>
                                                    <span class="d-block">{{ $customer->email }}</span>
                                                </div>
                                            </td>

                                            <!-- Kolom Telepon -->
                                            <td class="align-middle">
                                                @if($customer->telepon)
                                                <span class="badge badge-light text-dark p-2">
                                                    <i class="fas fa-phone mr-1 text-primary"></i>
                                                    {{ $customer->telepon }}
                                                </span>
                                                @else
                                                <span class="text-muted">
                                                    <i class="fas fa-phone-slash mr-1"></i>Tidak ada
                                                </span>
                                                @endif
                                            </td>

                                            <!-- Kolom Status -->
                                            <td class="align-middle">
                                                @if($customer->status == 'active')
                                                <span class="badge badge-success badge-pill px-3 py-2">
                                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                                </span>
                                                @elseif($customer->status == 'verify')
                                                <span class="badge badge-warning badge-pill px-3 py-2">
                                                    <i class="fas fa-clock mr-1"></i> Verify
                                                </span>
                                                @elseif($customer->status == 'banned')
                                                <span class="badge badge-danger badge-pill px-3 py-2">
                                                    <i class="fas fa-ban mr-1"></i> Banned
                                                </span>
                                                @endif
                                            </td>

                                            <!-- Kolom Tanggal Daftar -->
                                            <td class="align-middle">
                                                <div>
                                                    <small class="text-primary d-block">
                                                        <i class="far fa-calendar-alt mr-1"></i>
                                                        {{ $customer->created_at->format('d/m/Y') }}
                                                    </small>
                                                    <small class="text-muted d-block">
                                                        <i class="far fa-clock mr-1"></i>
                                                        {{ $customer->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                                                    </small>
                                                </div>
                                            </td>

                                            <!-- Kolom Aksi -->
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-info btn-detail"
                                                        data-id="{{ $customer->id }}"
                                                        title="Detail Customer">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    
                                                    @if($customer->status != 'active')
                                                    <a href="{{ route('admin.customer.activate', $customer->id) }}" 
                                                       class="btn btn-sm btn-outline-success btn-activate"
                                                       title="Aktifkan"
                                                       onclick="return confirm('Aktifkan customer ini?')">
                                                        <i class="fas fa-check"></i>
                                                    </a>
                                                    @endif
                                                    
                                                    @if($customer->status != 'banned')
                                                    <a href="{{ route('admin.customer.ban', $customer->id) }}" 
                                                       class="btn btn-sm btn-outline-warning btn-ban"
                                                       title="Blokir Customer"
                                                       onclick="return confirm('Blokir customer ini?')">
                                                        <i class="fas fa-ban"></i>
                                                    </a>
                                                    @endif
                                                    
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete"
                                                        data-id="{{ $customer->id }}"
                                                        data-nama="{{ $customer->nama }}"
                                                        data-url="{{ route('admin.customer.destroy', $customer->id) }}"
                                                        title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-users fa-4x text-muted mb-4"></i>
                                                    <h4 class="text-muted">Belum ada customer</h4>
                                                    <p class="text-muted mb-4">Customer akan muncul setelah mendaftar</p>
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
                                    Menampilkan <strong>{{ $customers->count() }}</strong> dari <strong>{{ $totalCustomers }}</strong> customer
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

                    <!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-md-flex align-items-center justify-content-between">
                    <!-- Deleted Customers Info -->
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                        <div class="bg-gradient-info rounded-circle p-3 me-4">
                            <i class="fas fa-trash-restore text-white fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 font-weight-semibold">Customer Terhapus</h6>
                            <div class="d-flex align-items-center">
                                <span class="h4 mb-0 me-3">{{ $deletedCount ?? 0 }}</span>
                                <span class="text-muted small">data customer telah dihapus</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div>
                        <a href="{{ route('admin.customer.deleted') }}" 
                           class="btn btn-outline-info btn-icon">
                            <i class="fas fa-eye me-2"></i>
                            Lihat Arsip
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Customer Detail Modal -->
<div class="modal fade" id="customerDetailModal" tabindex="-1" role="dialog" aria-labelledby="customerDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="customerDetailModalLabel">
                    <i class="fas fa-user-circle mr-2"></i> Detail Customer
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="customerDetailContent">
                <!-- Content akan diisi via AJAX -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-3">Memuat data customer...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-info" id="printDetailBtn">
                        <i class="fas fa-print mr-1"></i> Print
                    </button>
                    <button type="button" class="btn btn-outline-success" id="exportDetailBtn">
                        <i class="fas fa-download mr-1"></i> Export
                    </button>
                </div>
            </div>
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
                <p>Apakah Anda yakin ingin menghapus customer <strong id="deleteCustomerName"></strong>?</p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle mr-2"></i>Tindakan ini tidak dapat dibatalkan!</p>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle mr-2"></i>
                    Customer akan dipindahkan ke daftar terhapus dan dapat dipulihkan kapan saja.
                </div>
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
@endsection

@section('css')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --danger-gradient: linear-gradient(135deg, #ff0844 0%, #ffb199 100%);
        --indigo-gradient: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        --cyan-gradient: linear-gradient(135deg, #17ead9 0%, #6078ea 100%);
        --purple-gradient: linear-gradient(135deg, #9b51e0 0%, #3081ed 100%);
    }

    .card-outline {
        border-top: 4px solid;
        border-radius: 12px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        margin-bottom: 25px;
        overflow: hidden;
    }

    .card-outline:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }

    .card-outline.card-primary {
        border-top-color: #667eea;
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

    .bg-gradient-primary {
        background: var(--primary-gradient);
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

    .customer-avatar {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .customer-avatar:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
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

    .badge-success {
        background: var(--success-gradient);
        color: white;
    }

    .badge-danger {
        background: var(--danger-gradient);
        color: white;
    }

    .badge-warning {
        background: var(--warning-gradient);
        color: white;
    }

    .badge-primary {
        background: var(--primary-gradient);
        color: white;
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
        transition: all 0.3s ease;
    }

    .empty-state i {
        opacity: 0.3;
        transition: all 0.3s ease;
    }

    .empty-state:hover i {
        opacity: 0.5;
        transform: scale(1.1);
    }

    .info-box {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .info-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .table-hover tbody tr {
        animation: fadeIn 0.5s ease;
    }

    /* Responsive Design */
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
            $('#customersTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Customer Detail Modal
        function showCustomerModal(customerId) {
            $('#customerDetailModal').modal('show');
            
            $.ajax({
                url: '{{ route("admin.customer.show", ":id") }}'.replace(':id', customerId),
                type: 'GET',
                beforeSend: function() {
                    $('#customerDetailContent').html(`
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-3">Memuat data customer...</p>
                        </div>
                    `);
                },
                success: function(response) {
                    $('#customerDetailContent').html(response);
                },
                error: function() {
                    $('#customerDetailContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Gagal memuat data customer. Silakan coba lagi.
                        </div>
                    `);
                }
            });
        }

        // Event untuk tombol detail
        $('.btn-detail').click(function() {
            const customerId = $(this).data('id');
            showCustomerModal(customerId);
        });

        // Event untuk klik avatar
        $('.customer-avatar, .image-placeholder').click(function() {
            const row = $(this).closest('tr');
            const customerId = row.find('.btn-detail').data('id');
            if (customerId) {
                showCustomerModal(customerId);
            }
        });

        // Delete Customer
        $('.btn-delete').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const url = $(this).data('url');

            $('#deleteCustomerName').text(nama);
            $('#deleteForm').attr('action', url);
            $('#deleteModal').modal('show');
        });

        // Delete Form Submission
        $('#deleteForm').on('submit', function(e) {
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
                    $('#deleteModal').modal('hide');
                    showNotification('success', response.message || 'Customer berhasil dihapus');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    button.prop('disabled', false).html('<i class="fas fa-trash mr-1"></i> Hapus');
                    $('#deleteModal').modal('hide');

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        showNotification('error', xhr.responseJSON.message);
                    } else {
                        showNotification('error', 'Terjadi kesalahan saat menghapus customer');
                    }
                }
            });
        });

        // Export Button
        $('#exportBtn').click(function() {
            Swal.fire({
                title: 'Ekspor Data Customer',
                text: 'Pilih format untuk mengekspor data customer',
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
                    window.location.href = '{{ route("admin.customer.statistics") }}?export=excel';
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Export PDF
                    window.location.href = '{{ route("admin.customer.statistics") }}?export=pdf';
                }
            });
        });

        // Print Detail
        $('#printDetailBtn').click(function() {
            window.print();
        });

        // Export Detail
        $('#exportDetailBtn').click(function() {
            const customerId = $('#customerDetailContent').data('customer-id');
            if (customerId) {
                window.open('{{ route("admin.customer.show", ":id") }}?export=pdf'.replace(':id', customerId), '_blank');
            }
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

        // Auto refresh setiap 30 detik
        setInterval(() => {
            // Tidak refresh otomatis, hanya jika diperlukan
            // location.reload();
        }, 30000);
    });
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection