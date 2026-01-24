@extends('layout.petugas.petugas')

@section('title', 'History Tugas')

@section('content')

    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <!-- Left Section: Title & Breadcrumb -->
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <!-- Icon -->
                        <div class="header-icon bg-gradient-primary">
                            <i class="fas fa-tasks"></i>
                        </div>
                        
                        <!-- Title & Breadcrumb -->
                        <div class="ml-3 ml-md-4">
                            <h3 class="page-title mb-1">History Tugas</h3>
                        </div>
                    </div>
                </div>

                <!-- Right Section: Stats -->
                <div class="col-md-4 mt-3 mt-md-0">
                    <div class="d-flex justify-content-md-end">
                        <div class="header-badge">
                            <div class="badge-content">
                                <i class="fas fa-clipboard-list mr-2"></i>
                                <span>{{ $history->count() }} Tugas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">

            <!-- Transaction List -->
            <div class="row">
                <div class="col-12">
                    @if($history->isEmpty())
                    <!-- Empty State -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="empty-state">
                                <i class="fas fa-tasks fa-4x text-muted mb-4"></i>
                                <h4 class="mb-3">Belum ada riwayat tugas</h4>
                                <p class="text-muted mb-4">Tunggu tugas baru dari admin</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Transaction Cards -->
                    <div class="transaction-list">
                        @foreach($history as $transaction)
                        <div class="transaction-card mb-3" data-status="{{ $transaction->status }}">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="row align-items-center">
                                        <!-- Transaction Info -->
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <div class="d-flex align-items-start">
                                                <div class="transaction-icon mr-3">
                                                    @php
                                                        $icon = match($transaction->status) {
                                                            'selesai' => 'check-circle text-success',
                                                            'dibatalkan' => 'times-circle text-danger',
                                                            'dalam_perjalanan' => 'shipping-fast text-info',
                                                            'menunggu_serah_terima' => 'handshake text-warning',
                                                            default => 'clock text-warning'
                                                        };
                                                    @endphp
                                                    <i class="fas fa-{{ $icon }} fa-2x"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 font-weight-semibold">{{ $transaction->kode_transaksi }}</h6>
                                                    <div class="text-muted small mb-2">
                                                        <i class="fas fa-calendar-alt mr-1"></i>
                                                        {{ $transaction->created_at->format('d M Y, H:i') }}
                                                    </div>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <span class="badge badge-pill {{ 
                                                            $transaction->status == 'selesai' ? 'bg-success' : 
                                                            ($transaction->status == 'dibatalkan' ? 'bg-danger' : 
                                                            ($transaction->status == 'dalam_perjalanan' ? 'bg-info' : 
                                                            ($transaction->status == 'menunggu_serah_terima' ? 'bg-warning' : 'bg-secondary'))) 
                                                        }}">
                                                            {{ ucwords(str_replace('_', ' ', $transaction->status)) }}
                                                        </span>
                                                        @if($transaction->lokasiCod)
                                                        <span class="badge badge-pill bg-primary">
                                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                                            {{ $transaction->lokasiCod->nama_lokasi }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Amount & Actions -->
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="text-right">
                                                    <div class="h4 mb-1 text-primary">Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}</div>
                                                    <div class="text-muted small">
                                                        Total: Rp {{ number_format($transaction->total_dibayar, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Info - Petugas Version -->
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="quick-info">
                                                <div class="d-flex flex-wrap justify-content-between">
                                                    <!-- Customer Info -->
                                                    <div class="info-item">
                                                        <small class="text-muted d-block">Customer</small>
                                                        @if($transaction->user)
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="avatar-sm mr-2">
                                                                @if($transaction->user->foto)
                                                                <img src="{{ asset('storage/' . $transaction->user->foto) }}" 
                                                                     alt="{{ $transaction->user->nama }}"
                                                                     class="rounded-circle"
                                                                     style="width: 24px; height: 24px; object-fit: cover;">
                                                                @else
                                                                <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center"
                                                                     style="width: 24px; height: 24px; background: linear-gradient(135deg, #10b981 0%, #34d399 100%);">
                                                                    <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <span class="font-weight-semibold d-block">{{ $transaction->user->nama }}</span>
                                                                <small class="text-muted">{{ $transaction->user->telepon ?? '-' }}</small>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <span class="font-weight-semibold">-</span>
                                                        @endif
                                                    </div>
                                                    
                                                    <!-- Lokasi & Estimasi -->
                                                    <div class="info-item">
                                                        <small class="text-muted d-block">Lokasi COD</small>
                                                        <span class="font-weight-semibold">{{ $transaction->lokasiCod->nama_lokasi ?? '-' }}</span>
                                                        <div class="text-muted small">
                                                            {{ $transaction->lokasiCod->alamat ?? '' }}
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Payment Method -->
                                                    <div class="info-item">
                                                        <small class="text-muted d-block">Metode Bayar</small>
                                                        <span class="font-weight-semibold">{{ $transaction->paymentMethod->nama ?? '-' }}</span>
                                                    </div>
                                                    
                                                    <!-- Status Timeline -->
                                                    <div class="info-item">
                                                        <small class="text-muted d-block">Timeline</small>
                                                        <div class="timeline-dots mt-1">
                                                            @php
                                                                $steps = [
                                                                    'diproses' => $transaction->waktu_diproses,
                                                                    'dalam_perjalanan' => $transaction->waktu_dalam_perjalanan,
                                                                    'menunggu_serah_terima' => $transaction->waktu_diserahkan,
                                                                    'selesai' => $transaction->waktu_selesai,
                                                                ];
                                                                
                                                                $currentStep = 0;
                                                                switch($transaction->status) {
                                                                    case 'diproses': $currentStep = 1; break;
                                                                    case 'dalam_perjalanan': $currentStep = 2; break;
                                                                    case 'menunggu_serah_terima': $currentStep = 3; break;
                                                                    case 'selesai': $currentStep = 4; break;
                                                                    default: $currentStep = 0; break;
                                                                }
                                                            @endphp
                                                            
                                                            <div class="d-flex">
                                                                @foreach($steps as $step => $time)
                                                                <div class="timeline-dot {{ $loop->index < $currentStep ? 'completed' : ($loop->index == $currentStep ? 'active' : 'pending') }}"
                                                                     data-toggle="tooltip" 
                                                                     title="{{ ucwords(str_replace('_', ' ', $step)) }}">
                                                                </div>
                                                                @endforeach
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
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Load More Button -->
            @if($history->count() >= 10)
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button class="btn btn-outline-primary px-4" id="loadMoreBtn">
                        <i class="fas fa-sync-alt mr-2"></i>Load More
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    /* Modern Gen Z Styling - Sama dengan customer */
    :root {
        --primary: #667eea;
        --primary-light: #764ba2;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
        --bg-light: #f8fafc;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --border: #e2e8f0;
    }

    /* Transaction Cards - Sama dengan customer */
    .transaction-card {
        transition: all 0.3s ease;
    }

    .transaction-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12) !important;
    }

    .transaction-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: var(--bg-light);
    }

    /* Quick Info - Sama dengan customer */
    .quick-info {
        background: var(--bg-light);
        border-radius: 12px;
        padding: 1rem;
    }

    .info-item {
        margin: 0.5rem 0;
        min-width: 180px;
    }

    /* Empty State - Sama dengan customer */
    .empty-state {
        padding: 3rem 0;
    }

    .empty-state i {
        color: var(--border);
    }

    /* Badges - Sama dengan customer */
    .badge {
        border-radius: 20px;
        padding: 6px 12px;
        font-weight: 500;
    }

    .badge-pill {
        border-radius: 20px;
    }

    /* Buttons - Sama dengan customer */
    .btn {
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-outline-primary {
        border-color: var(--primary);
        color: var(--primary);
    }

    .btn-outline-primary:hover {
        background: var(--primary);
        border-color: var(--primary);
    }

    /* Cards - Sama dengan customer */
    .card {
        border-radius: 16px;
        border: none;
        overflow: hidden;
    }

    .shadow-sm {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    }

    /* Typography - Sama dengan customer */
    .font-weight-semibold {
        font-weight: 600;
    }

    .h4 {
        font-weight: 700;
    }

    .small {
        font-size: 0.875rem;
    }

    /* Gap Utility - Sama dengan customer */
    .gap-2 {
        gap: 0.5rem;
    }

    /* Timeline Dots (Khusus Petugas) */
    .timeline-dots {
        position: relative;
    }
    
    .timeline-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--border);
        margin-right: 20px;
        position: relative;
    }
    
    .timeline-dot:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 12px;
        right: -20px;
        height: 2px;
        background: var(--border);
        transform: translateY(-50%);
    }
    
    .timeline-dot.completed {
        background: var(--success);
    }
    
    .timeline-dot.completed::after {
        background: var(--success);
    }
    
    .timeline-dot.active {
        background: var(--primary);
        transform: scale(1.3);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
    }
    
    .timeline-dot.pending {
        background: var(--border);
    }

    /* Avatar Styling */
    .avatar-sm {
        flex-shrink: 0;
    }
    
    .avatar-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Header Styling - Sama dengan customer */
    .content-header {
        padding: 1.5rem 0;
        background: transparent;
    }
    
    .header-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
    }
    
    .header-icon i {
        font-size: 1.5rem;
        color: white;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
        line-height: 1.2;
    }
    
    .header-badge {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }
    
    .badge-content {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: #2d3748;
        font-size: 0.95rem;
    }
    
    .badge-content i {
        color: #667eea;
        font-size: 1rem;
    }

    /* Responsive - Sama dengan customer dengan penyesuaian */
    @media (max-width: 768px) {
        .content-header {
            padding: 1rem 0;
        }
        
        .header-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
        }
        
        .header-icon i {
            font-size: 1.25rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .header-badge {
            padding: 8px 12px;
            width: 100%;
            justify-content: center;
        }
        
        .ml-3.ml-md-4 {
            margin-left: 1rem !important;
        }
        
        .info-item {
            min-width: 100%;
        }
        
        .quick-info .d-flex {
            flex-direction: column;
        }
        
        .timeline-dots .d-flex {
            justify-content: center;
        }
        
        .timeline-dot {
            margin-right: 12px;
        }
        
        .timeline-dot:not(:last-child)::after {
            right: -12px;
        }
    }
    
    @media (max-width: 576px) {
        .row.align-items-center {
            flex-direction: column;
            align-items: stretch;
        }
        
        .col-md-8, .col-md-4 {
            width: 100%;
        }
        
        .header-badge {
            margin-top: 1rem;
        }
        
        .d-flex.justify-content-md-end {
            justify-content: flex-start;
        }
        
        .transaction-card .row {
            flex-direction: column;
        }
        
        .transaction-card .col-md-6:last-child {
            margin-top: 1rem;
        }
    }

    /* Smooth transitions */
    * {
        transition: background-color 0.2s ease, 
                    color 0.2s ease, 
                    transform 0.2s ease, 
                    box-shadow 0.2s ease;
    }
</style>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load more functionality (simulated)
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
                this.disabled = true;
                
                // Simulate API call
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>Load More';
                    this.disabled = false;
                    
                    // Show success message
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    
                    Toast.fire({
                        icon: 'info',
                        title: 'No more tasks to load'
                    });
                }, 1500);
            });
        }

        // Add animation to cards on load
        const transactionCards = document.querySelectorAll('.transaction-card');
        transactionCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.display = 'block';
                
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            }, index * 100);
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Initialize dropdowns
        $('.dropdown-toggle').dropdown();
    });
</script>

<!-- SweetAlert2 for notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection