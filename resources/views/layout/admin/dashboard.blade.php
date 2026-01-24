@extends('layout.admin.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard Admin</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Statistik Utama -->
            <div class="row">
                <!-- Total Transaksi -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalTransaksi ?? 0 }}</h3>
                            <p>Total Transaksi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <a href="{{ route('admin.tariktunai.index') ?? '#' }}" class="small-box-footer">
                            Lihat Semua <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Total Pendapatan -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h3>
                            <p>Total Pendapatan Admin</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <a href="{{ route('admin.tariktunai.index') ?? '#' }}?status=selesai" class="small-box-footer">
                            Detail <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Total Customer -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalCustomer ?? 0 }}</h3>
                            <p>Total Customer</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('admin.customer.index') ?? '#' }}?role=customer" class="small-box-footer">
                            Kelola Customer <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Total Petugas -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalPetugas ?? 0 }}</h3>
                            <p>Total Petugas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <a href="{{ route('admin.petugas.index') ?? '#' }}?role=petugas" class="small-box-footer">
                            Kelola Petugas <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Row untuk chart dan data -->
            <div class="row">
                <!-- Left Column - Charts -->
                <section class="col-lg-8 connectedSortable">
                    <!-- Chart Transaksi 7 Hari -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-1"></i>
                                Statistik Transaksi 7 Hari Terakhir
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="transactionChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Status Transaksi -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Distribusi Status Transaksi
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($statusCounts ?? [] as $status => $count)
                                @if($count > 0)
                                <div class="col-md-4 col-sm-6 mb-3">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-{{ $statusColors[$status] ?? 'secondary' }}">
                                            <i class="fas fa-tasks"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                                            <span class="info-box-number">{{ $count }}</span>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: {{ $statusPercentages[$status] ?? 0 }}%"></div>
                                            </div>
                                            <span class="progress-description">
                                                {{ $statusPercentages[$status] ?? 0 }}% dari total
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @if(empty($statusCounts))
                                <div class="col-12 text-center">
                                    <p class="text-muted">Belum ada data transaksi</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Transaksi Terbaru -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-1"></i>
                                Transaksi Terbaru
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.tariktunai.index') ?? '#' }}" class="btn btn-sm btn-primary">
                                    Lihat Semua
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Customer</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentTransactions ?? [] as $transaction)
                                        <tr>
                                            <td>{{ $transaction->kode_transaksi }}</td>
                                            <td>{{ $transaction->user->nama ?? 'N/A' }}</td>
                                            <td>Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $statusColors[$transaction->status] ?? 'secondary' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $transaction->status)) }}
                                                </span>
                                                @if($transaction->is_qris_cod)
                                                <span class="badge bg-orange">QRIS COD</span>
                                                @endif
                                            </td>
                                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada transaksi</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Right Column - Info Boxes -->
                <section class="col-lg-4 connectedSortable">
                    <!-- Petugas Teraktif -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-check mr-1"></i>
                                Petugas Teraktif
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                @forelse($topPetugas ?? [] as $petugas)
                                <li class="item">
                                    <div class="product-img">
                                        @if($petugas->foto && file_exists(storage_path('app/public/' . $petugas->foto)))
                                        <img src="{{ asset('storage/' . $petugas->foto) }}" alt="Foto" class="img-size-50">
                                        @else
                                        <img src="{{ asset('adminlte/dist/img/user-default.jpg') }}" alt="Foto" class="img-size-50">
                                        @endif
                                    </div>
                                    <div class="product-info">
                                        <a href="#" class="product-title">
                                            {{ $petugas->nama }}
                                            <span class="badge badge-warning float-right">
                                                {{ $petugas->completed_transactions ?? 0 }} transaksi
                                            </span>
                                        </a>
                                        <span class="product-description">
                                            {{ $petugas->email }}
                                        </span>
                                    </div>
                                </li>
                                @empty
                                <li class="item text-center p-3">
                                    Belum ada data petugas
                                </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Tindakan Menunggu -->
                    <div class="card bg-gradient-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-clock mr-1"></i>
                                Tindakan Menunggu
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 text-center">
                                    <div class="info-box bg-transparent">
                                        <div class="info-box-content">
                                            <span class="info-box-text">Menunggu Admin</span>
                                            <span class="info-box-number">{{ $pendingActions['menunggu_admin'] ?? 0 }}</span>
                                            <a href="{{ route('admin.tariktunai.index') ?? '#' }}?status=menunggu_admin" class="small-box-footer">
                                                Proses <i class="fas fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <div class="info-box bg-transparent">
                                        <div class="info-box-content">
                                            <span class="info-box-text">Verifikasi Admin</span>
                                            <span class="info-box-number">{{ $pendingActions['menunggu_verifikasi_admin'] ?? 0 }}</span>
                                            <a href="{{ route('admin.tariktunai.index') ?? '#' }}?status=menunggu_verifikasi_admin" class="small-box-footer">
                                                Verifikasi <i class="fas fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <div class="info-box bg-transparent">
                                        <div class="info-box-content">
                                            <span class="info-box-text">Verifikasi QRIS</span>
                                            <span class="info-box-number">{{ $pendingActions['menunggu_verifikasi_qris'] ?? 0 }}</span>
                                            <a href="{{ route('admin.tariktunai.index') ?? '#' }}?status=menunggu_verifikasi_qris" class="small-box-footer">
                                                Verifikasi <i class="fas fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <div class="info-box bg-transparent">
                                        <div class="info-box-content">
                                            <span class="info-box-text">Diproses</span>
                                            <span class="info-box-number">{{ $pendingActions['diproses'] ?? 0 }}</span>
                                            <a href="{{ route('admin.tariktunai.index') ?? '#' }}?status=diproses" class="small-box-footer">
                                                Lihat <i class="fas fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lokasi COD Populer -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                Lokasi COD Populer
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column">
                                @forelse($topLocations ?? [] as $location)
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-map-pin mr-2"></i> {{ $location->nama_lokasi }}
                                        <span class="float-right badge bg-primary">
                                            {{ $location->transaction_count ?? 0 }} transaksi
                                        </span>
                                    </a>
                                </li>
                                @empty
                                <li class="nav-item p-3 text-center">
                                    Belum ada data lokasi
                                </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Statistik Tipe Transaksi -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Tipe Transaksi
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 text-center">
                                    <div class="info-box bg-gradient-orange">
                                        <div class="info-box-content">
                                            <span class="info-box-text">QRIS COD</span>
                                            <span class="info-box-number">{{ $transactionTypeStats['qris_cod'] ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-center">
                                    <div class="info-box bg-gradient-blue">
                                        <div class="info-box-content">
                                            <span class="info-box-text">Regular</span>
                                            <span class="info-box-number">{{ $transactionTypeStats['regular'] ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
<!-- ChartJS -->
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<script>
$(function () {
    'use strict'
    
    // Chart Transaksi 7 Hari
    var transactionChartCanvas = $('#transactionChart').get(0).getContext('2d')
    
    @if(isset($chartData))
    var transactionChartData = {
        labels: {!! json_encode($chartData['labels']) !!},
        datasets: [
            {
                label: 'Total Transaksi',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: {!! json_encode($chartData['datasets']['transactions']) !!}
            },
            {
                label: 'Transaksi Selesai',
                backgroundColor: 'rgba(0,230,118,0.9)',
                borderColor: 'rgba(0,230,118,0.8)',
                pointRadius: false,
                pointColor: '#00e676',
                pointStrokeColor: '#00e676',
                pointHighlightFill: '#fff',
                pointHighlightStroke: '#00e676',
                data: {!! json_encode($chartData['datasets']['completed']) !!}
            },
            {
                label: 'Pendapatan',
                backgroundColor: 'rgba(255,193,7,0.9)',
                borderColor: 'rgba(255,193,7,0.8)',
                pointRadius: false,
                pointColor: '#ffc107',
                pointStrokeColor: '#ffc107',
                pointHighlightFill: '#fff',
                pointHighlightStroke: '#ffc107',
                data: {!! json_encode($chartData['datasets']['revenue']) !!}
            }
        ]
    }
    
    var transactionChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: true
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                }
            }],
            yAxes: [{
                gridLines: {
                    display: true,
                },
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
    
    // This will get the first returned node in the jQuery collection.
    new Chart(transactionChartCanvas, {
        type: 'line',
        data: transactionChartData,
        options: transactionChartOptions
    })
    @else
    // Jika tidak ada data, tampilkan pesan
    $('#transactionChart').parent().html('<div class="text-center p-5"><p class="text-muted">Belum ada data untuk ditampilkan</p></div>');
    @endif
    
    // Auto-refresh data setiap 5 menit
    setTimeout(function() {
        location.reload();
    }, 5 * 60 * 1000);
    
    // Tooltip untuk status
    $('[data-toggle="tooltip"]').tooltip();
    
    // Inisialisasi semua tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
})
</script>
@endsection