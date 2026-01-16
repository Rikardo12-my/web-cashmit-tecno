@php
    $customer = $customer ?? null;
@endphp

@if($customer)
<div class="customer-detail" data-customer-id="{{ $customer->id }}">
    <div class="row">
        <!-- Customer Profile -->
        <div class="col-md-4 text-center">
            <div class="mb-4">
                @if($customer->foto)
                    <img src="{{ asset('storage/' . $customer->foto) }}" 
                         alt="{{ $customer->nama }}" 
                         class="img-fluid rounded-circle shadow-lg mb-3"
                         style="width: 180px; height: 180px; object-fit: cover;">
                @else
                    <div class="avatar-placeholder rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 180px; height: 180px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-user fa-4x text-white"></i>
                    </div>
                @endif
                
                <h3 class="mb-2">{{ $customer->nama }}</h3>
                
                <div class="mb-3">
                    <span class="badge badge-{{ $customer->status == 'active' ? 'success' : ($customer->status == 'verify' ? 'warning' : 'danger') }} badge-pill px-4 py-2">
                        @if($customer->status == 'active')
                            <i class="fas fa-check-circle mr-1"></i> Aktif
                        @elseif($customer->status == 'verify')
                            <i class="fas fa-clock mr-1"></i> Menunggu Verifikasi
                        @elseif($customer->status == 'banned')
                            <i class="fas fa-ban mr-1"></i> Diblokir
                        @endif
                    </span>
                </div>
                
                <div class="btn-group mb-4">
                    @if($customer->status != 'active')
                    <a href="{{ route('admin.customer.activate', $customer->id) }}" 
                       class="btn btn-sm btn-success"
                       onclick="return confirm('Aktifkan customer ini?')">
                        <i class="fas fa-check"></i> Aktifkan
                    </a>
                    @endif
                    
                    @if($customer->status != 'banned')
                    <a href="{{ route('admin.customer.ban', $customer->id) }}" 
                       class="btn btn-sm btn-warning"
                       onclick="return confirm('Blokir customer ini?')">
                        <i class="fas fa-ban"></i> Blokir
                    </a>
                    @endif
                    
                    <button type="button" class="btn btn-sm btn-danger btn-delete-modal"
                            data-id="{{ $customer->id }}"
                            data-nama="{{ $customer->nama }}">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Customer Information -->
        <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle mr-2"></i>Informasi Customer
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small mb-1">
                                    <i class="fas fa-envelope mr-1"></i>Email
                                </label>
                                <p class="mb-0">
                                    {{ $customer->email }}
                                </p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="text-muted small mb-1">
                                    <i class="fas fa-phone mr-1"></i>Telepon
                                </label>
                                <p class="mb-0">{{ $customer->telepon ?? '-' }}</p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="text-muted small mb-1">
                                    <i class="fas fa-id-card mr-1"></i>NIM/NIP
                                </label>
                                <p class="mb-0">{{ $customer->nim_nip ?? '-' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="text-muted small mb-1">
                                    <i class="fas fa-birthday-cake mr-1"></i>Tanggal Lahir
                                </label>
                                <p class="mb-0">
                                    {{ $customer->tanggal_lahir ? \Carbon\Carbon::parse($customer->tanggal_lahir)->format('d/m/Y') : '-' }}
                                    @if($customer->tanggal_lahir)
                                        <br>
                                        <small class="text-muted">
                                            (Usia: {{ \Carbon\Carbon::parse($customer->tanggal_lahir)->age }} tahun)
                                        </small>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="text-muted small mb-1">
                                    <i class="fas fa-map-marker-alt mr-1"></i>Alamat
                                </label>
                                <p class="mb-0">{{ $customer->alamat ?? '-' }}</p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="text-muted small mb-1">
                                    <i class="fas fa-user-tag mr-1"></i>Role
                                </label>
                                <p class="mb-0">
                                    <span class="badge badge-info">
                                        {{ ucfirst($customer->role) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Account Timeline -->
            <div class="card card-outline card-success mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-history mr-2"></i>Timeline Akun
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon bg-primary">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Akun Dibuat</h6>
                                <p class="text-muted mb-0">
                                    {{ $customer->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                        
                        @if($customer->email_verified_at)
                        <div class="timeline-item">
                            <div class="timeline-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Email Terverifikasi</h6>
                                <p class="text-muted mb-0">
                                    {{ \Carbon\Carbon::parse($customer->email_verified_at)->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                        @endif
                        
                        <div class="timeline-item">
                            <div class="timeline-icon bg-info">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Terakhir Diperbarui</h6>
                                <p class="text-muted mb-0">
                                    {{ $customer->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .customer-detail .avatar-placeholder {
        transition: all 0.3s ease;
    }
    
    .customer-detail .avatar-placeholder:hover {
        transform: scale(1.05);
    }
    
    .info-item {
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }
    
    .timeline {
        position: relative;
        padding-left: 40px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }
    
    .timeline-icon {
        position: absolute;
        left: -40px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        z-index: 1;
    }
    
    .timeline-content {
        padding-left: 20px;
    }
    
    .stat-card-sm {
        padding: 10px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .stat-card-sm:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .stat-card-sm .stat-number {
        font-size: 1.5rem;
        margin-bottom: 5px;
    }
    
    .badge-sm {
        padding: 3px 8px;
        font-size: 0.75rem;
    }
    
    .btn-group .btn {
        margin: 0 2px;
    }
</style>

<script>
    // Delete button in modal
    $('.btn-delete-modal').click(function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: `Apakah Anda yakin ingin menghapus customer <strong>${nama}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff0844',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.customer.destroy", ":id") }}'.replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message || 'Customer berhasil dihapus',
                            icon: 'success',
                            confirmButtonColor: '#667eea'
                        }).then(() => {
                            $('#customerDetailModal').modal('hide');
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus customer',
                            icon: 'error',
                            confirmButtonColor: '#ff0844'
                        });
                    }
                });
            }
        });
    });
</script>
@else
<div class="alert alert-danger">
    <i class="fas fa-exclamation-triangle mr-2"></i>
    Data customer tidak ditemukan.
</div>
@endif