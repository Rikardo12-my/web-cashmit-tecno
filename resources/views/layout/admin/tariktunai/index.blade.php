@extends('layout.admin.master')

@section('title', 'Manajemen Tarik Tunai')

@section('css')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
<style>
    /* Custom Styles */
    :root {
        --primary-blue: #4a90e2;
        --primary-blue-light: #e8f4ff;
        --primary-blue-dark: #2c6bb3;
        --secondary-blue: #89c4f4;
    }
    
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-pending { background: #fff3cd; color: #856404; }
    .badge-diproses { background: #cce5ff; color: #004085; }
    .badge-menunggu_petugas { background: #d4edda; color: #155724; }
    .badge-dalam_perjalanan { background: #fff3cd; color: #856404; }
    .badge-selesai { background: #d1ecf1; color: #0c5460; }
    .badge-dibatalkan { background: #f8d7da; color: #721c24; }
    
    .table-hover tbody tr:hover {
        background-color: rgba(74, 144, 226, 0.05);
        transition: all 0.3s ease;
    }
    
    .card-gradient-primary {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
        color: white;
    }
    
    .card-gradient-primary .card-title {
        color: white;
    }
    
    .action-buttons .btn {
        min-width: 100px;
        margin: 2px;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-blue);
    }
    
    .amount-cell {
        font-weight: 600;
        color: var(--primary-blue-dark);
    }
    
    .stat-card-icon {
        font-size: 2.5rem;
        opacity: 0.8;
        color: var(--primary-blue);
    }
    
    .filter-card {
        border-left: 4px solid var(--primary-blue);
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-money-bill-wave mr-2 text-primary"></i>
                        Manajemen Tarik Tunai
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Flash Messages -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            <!-- Statistics Row -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-primary">
                        <div class="inner">
                            <h3>Rp {{ number_format($statistics['total_amount'], 0, ',', '.') }}</h3>
                            <p>Total Transaksi Selesai</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-check-alt"></i>
                        </div>
                        <a href="?status=selesai" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $statistics['total'] }}</h3>
                            <p>Total Transaksi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <a href="#" class="small-box-footer">Lihat Semua <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $statistics['pending'] + $statistics['diproses'] + $statistics['menunggu_petugas'] + $statistics['dalam_perjalanan'] }}</h3>
                            <p>Dalam Proses</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <a href="?status[]=pending&status[]=diproses&status[]=menunggu_petugas&status[]=dalam_perjalanan" class="small-box-footer">Lihat Proses <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $statistics['selesai'] }}</h3>
                            <p>Transaksi Selesai</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <a href="?status=selesai" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="card filter-card mb-4">
                <div class="card-header bg-white">
                    <h3 class="card-title">
                        <i class="fas fa-filter text-primary mr-2"></i>
                        Filter Transaksi
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.tariktunai.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control select2" style="width: 100%;">
                                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="menunggu_petugas" {{ request('status') == 'menunggu_petugas' ? 'selected' : '' }}>Menunggu Petugas</option>
                                        <option value="dalam_perjalanan" {{ request('status') == 'dalam_perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Metode Pembayaran</label>
                                    <select name="payment_method_id" class="form-control select2" style="width: 100%;">
                                        <option value="all">Semua Metode</option>
                                        @foreach($paymentMethods as $method)
                                            <option value="{{ $method->id }}" {{ request('payment_method_id') == $method->id ? 'selected' : '' }}>
                                                {{ $method->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Petugas</label>
                                    <select name="petugas_id" class="form-control select2" style="width: 100%;">
                                        <option value="all">Semua Petugas</option>
                                        @foreach($petugasList as $petugas)
                                            <option value="{{ $petugas->id }}" {{ request('petugas_id') == $petugas->id ? 'selected' : '' }}>
                                                {{ $petugas->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="date_range" class="form-control float-right" id="dateRangePicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search mr-2"></i> Terapkan Filter
                                    </button>
                                    <a href="{{ route('admin.tariktunai.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-redo mr-2"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.tariktunai.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle mr-2"></i> Transaksi Baru
                        </a>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exportModal">
                            <i class="fas fa-file-export mr-2"></i> Export
                        </button>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-user-tag mr-2"></i> Aksi Petugas
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#assignPetugasModal">
                                    <i class="fas fa-user-plus mr-2"></i> Assign Petugas
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#batchStatusModal">
                                    <i class="fas fa-sync-alt mr-2"></i> Ubah Status Massal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="card">
                <div class="card-header bg-white">
                    <h3 class="card-title">
                        <i class="fas fa-list mr-2 text-primary"></i>
                        Daftar Transaksi Tarik Tunai
                    </h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Cari transaksi...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Customer</th>
                                    <th>Jumlah</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Petugas</th>
                                    <th>Tanggal</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($transaction->user->name ?? 'User') }}&background=4a90e2&color=fff" 
                                                 class="user-avatar mr-3">
                                            <div>
                                                <strong>{{ $transaction->user->name ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $transaction->user->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="amount-cell">
                                        <strong>Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $transaction->paymentMethod->nama ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = 'badge-' . $transaction->status;
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $transaction->getStatusLabelAttribute()['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($transaction->petugas)
                                            <span class="badge badge-success">
                                                {{ $transaction->petugas->name }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">
                                                Belum ditugaskan
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>
                                            {{ $transaction->created_at->format('d M Y') }}
                                            <br>
                                            <span class="text-muted">{{ $transaction->created_at->format('H:i') }}</span>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.tariktunai.show', $transaction->id) }}" 
                                               class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(in_array($transaction->status, ['pending', 'menunggu_petugas']))
                                                <button type="button" class="btn btn-sm btn-success assign-petugas-btn" 
                                                        data-id="{{ $transaction->id }}"
                                                        data-toggle="modal" data-target="#quickAssignModal">
                                                    <i class="fas fa-user-tag"></i>
                                                </button>
                                            @endif
                                            @if($transaction->status == 'dalam_perjalanan')
                                                <button type="button" class="btn btn-sm btn-primary update-status-btn"
                                                        data-id="{{ $transaction->id }}"
                                                        data-status="selesai"
                                                        data-toggle="modal" data-target="#updateStatusModal">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                            <h5>Tidak ada transaksi</h5>
                                            <p class="text-muted">Belum ada transaksi tarik tunai yang tercatat.</p>
                                            <a href="{{ route('admin.tariktunai.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus mr-2"></i> Buat Transaksi Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {{ $transactions->links() }}
                    </div>
                    <div class="float-left">
                        <p class="mb-0 text-muted">
                            Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} dari {{ $transactions->total() }} transaksi
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modals -->

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-file-export mr-2"></i>
                    Export Data
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="exportForm" method="GET">
                    <div class="form-group">
                        <label>Format Export</label>
                        <select name="format" class="form-control">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Awal</label>
                        <input type="date" name="start_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="exportData()">Export</button>
            </div>
        </div>
    </div>
</div>

<!-- Quick Assign Petugas Modal -->
<div class="modal fade" id="quickAssignModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-tag mr-2"></i>
                    Assign Petugas
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="assignPetugasForm">
                    @csrf
                    <input type="hidden" name="transaction_id" id="assignTransactionId">
                    <div class="form-group">
                        <label>Pilih Petugas</label>
                        <select name="petugas_id" class="form-control select2" required>
                            <option value="">-- Pilih Petugas --</option>
                            @foreach($petugasList as $petugas)
                                <option value="{{ $petugas->id }}">{{ $petugas->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Catatan (Opsional)</label>
                        <textarea name="catatan_admin" class="form-control" rows="2" placeholder="Tambahkan catatan jika perlu..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="submitAssignPetugas()">Assign</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Perbarui Status
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateStatusForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="transaction_id" id="statusTransactionId">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="statusSelect" required>
                            <option value="pending">Pending</option>
                            <option value="diproses">Diproses</option>
                            <option value="menunggu_petugas">Menunggu Petugas</option>
                            <option value="dalam_perjalanan">Dalam Perjalanan</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="catatan_admin" class="form-control" rows="3" placeholder="Tambahkan catatan perubahan status..."></textarea>
                    </div>
                    <div class="form-group bukti-field" style="display: none;">
                        <label>Bukti Serah Terima (Opsional)</label>
                        <input type="file" name="bukti_serah_terima_petugas" class="form-control-file">
                        <small class="text-muted">Upload bukti serah terima dari petugas</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitUpdateStatus()">Perbarui</button>
            </div>
        </div>
    </div>
</div>

<!-- Batch Status Update Modal -->
<div class="modal fade" id="batchStatusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Ubah Status Massal
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="batchStatusForm">
                    @csrf
                    <div class="form-group">
                        <label>Transaksi yang Dipilih</label>
                        <select name="transaction_ids[]" class="form-control select2" multiple="multiple" data-placeholder="Pilih transaksi..." required>
                            @foreach($transactions as $transaction)
                                <option value="{{ $transaction->id }}">
                                    #{{ $transaction->id }} - {{ $transaction->user->name }} - Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status Baru</label>
                        <select name="status" class="form-control" required>
                            <option value="diproses">Diproses</option>
                            <option value="dalam_perjalanan">Dalam Perjalanan</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Catatan Umum</label>
                        <textarea name="catatan_admin" class="form-control" rows="3" placeholder="Catatan untuk semua transaksi terpilih..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" onclick="submitBatchStatus()">Terapkan ke Semua</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });
    
    // Date Range Picker
    $('#dateRangePicker').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD',
            separator: ' to ',
            applyLabel: 'Terapkan',
            cancelLabel: 'Batal',
            daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
            monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                         'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
        }
    });
    
    // Quick Assign Petugas Modal
    $('.assign-petugas-btn').click(function() {
        const transactionId = $(this).data('id');
        $('#assignTransactionId').val(transactionId);
    });
    
    // Update Status Modal
    $('.update-status-btn').click(function() {
        const transactionId = $(this).data('id');
        const status = $(this).data('status');
        
        $('#statusTransactionId').val(transactionId);
        $('#statusSelect').val(status);
        
        // Show/hide bukti field
        if (status === 'selesai') {
            $('.bukti-field').show();
        } else {
            $('.bukti-field').hide();
        }
    });
    
    // Show bukti field when status is changed to selesai
    $('#statusSelect').change(function() {
        if ($(this).val() === 'selesai') {
            $('.bukti-field').show();
        } else {
            $('.bukti-field').hide();
        }
    });
});

// Functions
function exportData() {
    const form = $('#exportForm');
    const format = form.find('select[name="format"]').val();
    const startDate = form.find('input[name="start_date"]').val();
    const endDate = form.find('input[name="end_date"]').val();
    
    let url = '' + format;
    
    if (startDate && endDate) {
        url += '?start_date=' + startDate + '&end_date=' + endDate;
    }
    
    window.open(url, '_blank');
    $('#exportModal').modal('hide');
}

function submitAssignPetugas() {
    const form = $('#assignPetugasForm');
    const transactionId = $('#assignTransactionId').val();
    const formData = new FormData(form[0]);
    
    $.ajax({
        url: '{{ url("admin/tariktunai") }}/' + transactionId + '/assign-petugas',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            // Show loading
            $('button[onclick="submitAssignPetugas()"]').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin mr-2"></i> Processing...');
        },
        success: function(response) {
            showNotification('success', 'Petugas berhasil ditugaskan!');
            $('#quickAssignModal').modal('hide');
            setTimeout(() => {
                location.reload();
            }, 1500);
        },
        error: function(xhr) {
            showNotification('error', xhr.responseJSON?.message || 'Terjadi kesalahan');
            $('button[onclick="submitAssignPetugas()"]').prop('disabled', false)
                .html('Assign');
        }
    });
}

function submitUpdateStatus() {
    const form = $('#updateStatusForm');
    const transactionId = $('#statusTransactionId').val();
    const formData = new FormData(form[0]);
    
    $.ajax({
        url: '{{ url("admin/tariktunai") }}/' + transactionId + '/update-status',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            // Show loading
            $('button[onclick="submitUpdateStatus()"]').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin mr-2"></i> Processing...');
        },
        success: function(response) {
            showNotification('success', 'Status berhasil diperbarui!');
            $('#updateStatusModal').modal('hide');
            setTimeout(() => {
                location.reload();
            }, 1500);
        },
        error: function(xhr) {
            showNotification('error', xhr.responseJSON?.message || 'Terjadi kesalahan');
            $('button[onclick="submitUpdateStatus()"]').prop('disabled', false)
                .html('Perbarui');
        }
    });
}

function submitBatchStatus() {
    const form = $('#batchStatusForm');
    const formData = new FormData(form[0]);
    
    $.ajax({
        url: '{{ route("admin.tariktunai.batch-status") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            // Show loading
            $('button[onclick="submitBatchStatus()"]').prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin mr-2"></i> Processing...');
        },
        success: function(response) {
            showNotification('success', 'Status berhasil diperbarui untuk ' + response.count + ' transaksi!');
            $('#batchStatusModal').modal('hide');
            setTimeout(() => {
                location.reload();
            }, 1500);
        },
        error: function(xhr) {
            showNotification('error', xhr.responseJSON?.message || 'Terjadi kesalahan');
            $('button[onclick="submitBatchStatus()"]').prop('disabled', false)
                .html('Terapkan ke Semua');
        }
    });
}

function showNotification(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    const notification = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
            <i class="fas ${icon} mr-2"></i>
            ${message}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    `;
    
    $('.notification-container').remove();
    $('body').append('<div class="notification-container"></div>');
    $('.notification-container').html(notification);
    
    setTimeout(() => {
        $('.notification-container').remove();
    }, 3000);
}

// Search functionality
$('input[name="table_search"]').on('keyup', function() {
    const value = $(this).val().toLowerCase();
    $('table tbody tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});
</script>
@endsection