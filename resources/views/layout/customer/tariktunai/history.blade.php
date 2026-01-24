@extends('layout.customer.customer')

@section('title', 'History Tarik Tunai')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
            <!-- Left Section: Title & Breadcrumb -->
            <div class="col-md-8">
                <div class="d-flex align-items-center">
                    <!-- Icon -->
                    <div class="header-icon bg-gradient-primary">
                        <i class="fas fa-history"></i>
                    </div>
                    
                    <!-- Title & Breadcrumb -->
                    <div class="ml-3 ml-md-4">
                        <h3 class="page-title mb-1"> History</h3>
                    </div>
                </div>
            </div>

            <!-- Right Section: Stats -->
            <div class="col-md-4 mt-3 mt-md-0">
                <div class="d-flex justify-content-md-end">
                    <div class="header-badge">
                        <div class="badge-content">
                            <i class="fas fa-receipt mr-2"></i>
                            <span>{{ $history->count() }} Transaksi</span>
                        </div>
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
                                <i class="fas fa-history fa-4x text-muted mb-4"></i>
                                <h4 class="mb-3">Belum ada riwayat transaksi</h4>
                                <p class="text-muted mb-4">Mulai transaksi tarik tunai pertama kamu!</p>
                                <a href="{{ route('customer.tariktunai.index') }}" class="btn btn-primary">
                                    <i class="fas fa-money-bill-wave mr-2"></i>Tarik Tunai Sekarang
                                </a>
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
                                                        <span class="badge badge-pill {{ $transaction->status == 'selesai' ? 'bg-success' : ($transaction->status == 'dibatalkan' ? 'bg-danger' : 'bg-warning') }}">
                                                            {{ ucwords(str_replace('_', ' ', $transaction->status)) }}
                                                        </span>
                                                        @if($transaction->lokasiCod)
                                                        <span class="badge badge-pill bg-info">
                                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                                            {{ $transaction->lokasiCod->nama_lokasi }}
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Info -->
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="quick-info">
                                                <div class="d-flex flex-wrap justify-content-between">
                                                    <div class="info-item">
                                                        <small class="text-muted d-block">Petugas</small>
                                                        @if($transaction->petugas)
                                                        <div class="d-flex align-items-center mt-1">
                                                            <div class="avatar-sm mr-2">
                                                                @if($transaction->petugas->foto)
                                                                <img src="{{ asset('storage/' . $transaction->petugas->foto) }}" 
                                                                     alt="{{ $transaction->petugas->nama }}"
                                                                     class="rounded-circle"
                                                                     style="width: 24px; height: 24px; object-fit: cover;">
                                                                @else
                                                                <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center"
                                                                     style="width: 24px; height: 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                                    <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <span class="font-weight-semibold">{{ $transaction->petugas->nama }}</span>
                                                        </div>
                                                        @else
                                                        <span class="font-weight-semibold">-</span>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="info-item">
                                                        <small class="text-muted d-block">Metode Bayar</small>
                                                        <span class="font-weight-semibold">{{ $transaction->paymentMethod->nama ?? '-' }}</span>
                                                    </div>
                                                    
                                                    <div class="info-item">
                                                        <small class="text-muted d-block">Biaya Admin</small>
                                                        <span class="font-weight-semibold text-warning">Rp {{ number_format($transaction->biaya_admin, 0, ',', '.') }}</span>
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
    /* Modern Gen Z Styling */
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

    /* Stat Cards */
    .stat-card {
        border-radius: 16px;
        padding: 1.5rem;
        color: white;
        display: flex;
        align-items: center;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    .stat-icon {
        font-size: 2rem;
        margin-right: 1rem;
        opacity: 0.9;
    }

    .stat-number {
        font-size: 1.75rem;
        font-weight: 700;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-top: 0.25rem;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, var(--success) 0%, #34d399 100%);
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, var(--warning) 0%, #fbbf24 100%);
    }

    .bg-gradient-danger {
        background: linear-gradient(135deg, var(--danger) 0%, #f87171 100%);
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, var(--info) 0%, #60a5fa 100%);
    }

    /* Transaction Cards */
    .transaction-card {
        transition: all 0.3s ease;
    }

    .transaction-card:hover {
        transform: translateY(-2px);
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

    /* Quick Info */
    .quick-info {
        background: var(--bg-light);
        border-radius: 12px;
        padding: 1rem;
    }

    .info-item {
        margin: 0.5rem 0;
        min-width: 150px;
    }

    /* Empty State */
    .empty-state {
        padding: 3rem 0;
    }

    .empty-state i {
        color: var(--border);
    }

    /* Badges */
    .badge {
        border-radius: 20px;
        padding: 6px 12px;
        font-weight: 500;
    }

    .badge-pill {
        border-radius: 20px;
    }

    /* Buttons */
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

    /* Filter Buttons */
    .btn-group .btn {
        border-radius: 20px !important;
        margin: 0 4px;
    }

    /* Cards */
    .card {
        border-radius: 16px;
        border: none;
        overflow: hidden;
    }

    .shadow-sm {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    }

    /* Typography */
    .font-weight-semibold {
        font-weight: 600;
    }

    .h4 {
        font-weight: 700;
    }

    .small {
        font-size: 0.875rem;
    }

    /* Gap Utility */
    .gap-2 {
        gap: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stat-card {
            padding: 1rem;
        }
        
        .stat-icon {
            font-size: 1.5rem;
        }
        
        .stat-number {
            font-size: 1.5rem;
        }
        
        .info-item {
            min-width: 100%;
        }
        
        .quick-info .d-flex {
            flex-direction: column;
        }
        
        .btn-group {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }
        
        .btn-group .btn {
            flex: 1;
            margin: 2px;
        }
    }
    /* Header Styling */
    .content-header {
        padding: 1.5rem 0;
        background: transparent;
    }
    
    /* Header Icon */
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
    
    /* Page Title */
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
        line-height: 1.2;
    }
    
    /* Breadcrumb */
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }
    
    .breadcrumb-item {
        font-size: 0.875rem;
        color: #64748b;
    }
    
    .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .breadcrumb-item a:hover {
        color: #764ba2;
    }
    
    .breadcrumb-item.active {
        color: #2d3748;
        font-weight: 500;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: #cbd5e0;
        padding: 0 8px;
    }
    
    /* Header Badge */
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
    
    /* Responsive Design */
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
    }
</style>

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
        // Filter transactions
        const filterBtns = document.querySelectorAll('.filter-btn');
        const transactionCards = document.querySelectorAll('.transaction-card');
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                filterBtns.forEach(b => b.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                
                // Show/hide transactions based on filter
                transactionCards.forEach(card => {
                    if (filter === 'all') {
                        card.style.display = 'block';
                    } else if (filter === 'proses') {
                        const status = card.getAttribute('data-status');
                        card.style.display = !['selesai', 'dibatalkan'].includes(status) ? 'block' : 'none';
                    } else {
                        const status = card.getAttribute('data-status');
                        card.style.display = status === filter ? 'block' : 'none';
                    }
                });
            });
        });

        // Set initial active filter
        document.querySelector('.filter-btn[data-filter="all"]').classList.add('active');

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
                        title: 'No more transactions to load'
                    });
                }, 1500);
            });
        }

        // Add animation to cards on load
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
    });
</script>

<!-- SweetAlert2 for notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection