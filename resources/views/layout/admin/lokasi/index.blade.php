@extends('layout.admin.master')

@section('title', 'Management Lokasi COD')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">📍 Management Lokasi COD</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Lokasi COD</li>
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
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $lokasi->count() }}</h3>
                            <p>Total Lokasi</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <a href="#" class="small-box-footer">Lihat semua <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $lokasi->where('status', true)->count() }}</h3>
                            <p>Aktif</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $lokasi->where('status', false)->count() }}</h3>
                            <p>Nonaktif</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-pause-circle"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-indigo">
                        <div class="inner">
                            <h3>{{ $statistik->count() }}</h3>
                            <p>Populer</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-fire"></i>
                        </div>
                        <a href="#" class="small-box-footer">Analytics <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column: Form & Table -->
                <div class="col-lg-8">
                    <!-- Add Location Card -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-plus-circle mr-2"></i>
                                Tambah Lokasi Baru
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.lokasi.store') }}" method="POST" id="addLocationForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_lokasi">
                                                <i class="fas fa-store mr-1"></i> Nama Lokasi
                                            </label>
                                            <input type="text" class="form-control @error('nama_lokasi') is-invalid @enderror" 
                                                   id="nama_lokasi" name="nama_lokasi" 
                                                   placeholder="Contoh: Alfamart Jl. Sudirman" required>
                                            @error('nama_lokasi')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="area_detail">
                                                <i class="fas fa-map-pin mr-1"></i> Detail Area
                                            </label>
                                            <input type="text" class="form-control @error('area_detail') is-invalid @enderror" 
                                                   id="area_detail" name="area_detail" 
                                                   placeholder="Contoh: Depan Sekolah, Dekat ATM">
                                            @error('area_detail')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="latitude">
                                                <i class="fas fa-globe-asia mr-1"></i> Latitude
                                            </label>
                                            <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" 
                                                   id="latitude" name="latitude" 
                                                   placeholder="Contoh: -6.200000">
                                            @error('latitude')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="longitude">
                                                <i class="fas fa-globe-asia mr-1"></i> Longitude
                                            </label>
                                            <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" 
                                                   id="longitude" name="longitude" 
                                                   placeholder="Contoh: 106.816666">
                                            @error('longitude')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i> Simpan Lokasi
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="getLocationBtn">
                                        <i class="fas fa-location-arrow mr-1"></i> Dapatkan Lokasi Saat Ini
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Locations Table -->
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list mr-2"></i>
                                Daftar Lokasi COD
                            </h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <input type="text" id="searchTable" class="form-control float-right" 
                                           placeholder="Cari lokasi...">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="locationsTable">
                                    <thead class="bg-light-blue">
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 25%">Nama Lokasi</th>
                                            <th style="width: 25%">Area Detail</th>
                                            <th style="width: 20%">Koordinat</th>
                                            <th style="width: 15%">Status</th>
                                            <th style="width: 10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($lokasi as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $item->nama_lokasi }}</strong>
                                            </td>
                                            <td>
                                                @if($item->area_detail)
                                                    <span class="badge bg-light text-dark">
                                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                                        {{ $item->area_detail }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->latitude && $item->longitude)
                                                    <small class="text-muted">
                                                        {{ $item->latitude }}, {{ $item->longitude }}
                                                    </small>
                                                @else
                                                    <span class="text-muted">Belum diatur</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->status)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle mr-1"></i> Aktif
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times-circle mr-1"></i> Nonaktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-info btn-edit" 
                                                            data-id="{{ $item->id }}"
                                                            data-nama="{{ $item->nama_lokasi }}"
                                                            data-area="{{ $item->area_detail }}"
                                                            data-lat="{{ $item->latitude }}"
                                                            data-lng="{{ $item->longitude }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-{{ $item->status ? 'warning' : 'success' }} btn-toggle-status" 
                                                            data-id="{{ $item->id }}">
                                                        @if($item->status)
                                                            <i class="fas fa-pause"></i>
                                                        @else
                                                            <i class="fas fa-play"></i>
                                                        @endif
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="empty-state">
                                                    <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                                                    <h5>Belum ada lokasi COD</h5>
                                                    <p class="text-muted">Tambahkan lokasi pertama Anda!</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Statistics & Map -->
                <div class="col-lg-4">
                    <!-- Popular Locations -->
                    <div class="card card-gradient-indigo card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-2"></i>
                                Lokasi Terpopuler
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                @if($statistik->count() > 0)
                                    @foreach($statistik as $populer)
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-sm">{{ $populer->nama_lokasi }}</span>
                                            <span class="text-sm font-weight-bold">
                                                {{ $populer->transaksi_count ?? 0 }} transaksi
                                            </span>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div class="progress-bar bg-primary" 
                                                 style="width: '{{ min(($populer->transaksi_count ?? 0) * 10, 100) }}%'"
                                                 role="progressbar"></div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-chart-bar fa-2x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">Belum ada data statistik</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle mr-2"></i>
                                Informasi Singkat
                            </h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>
                                        <i class="fas fa-store text-primary mr-2"></i>
                                        Total Lokasi
                                    </span>
                                    <span class="badge bg-primary badge-pill">{{ $lokasi->count() }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>
                                        <i class="fas fa-check-circle text-success mr-2"></i>
                                        Aktif
                                    </span>
                                    <span class="badge bg-success badge-pill">{{ $lokasi->where('status', true)->count() }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>
                                        <i class="fas fa-times-circle text-danger mr-2"></i>
                                        Nonaktif
                                    </span>
                                    <span class="badge bg-danger badge-pill">{{ $lokasi->where('status', false)->count() }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>
                                        <i class="fas fa-map-marked-alt text-warning mr-2"></i>
                                        Dengan Koordinat
                                    </span>
                                    <span class="badge bg-warning badge-pill">{{ $lokasi->whereNotNull('latitude')->count() }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card card-warning card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bolt mr-2"></i>
                                Aksi Cepat
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-outline-primary btn-block mb-2" id="exportBtn">
                                        <i class="fas fa-file-export mr-1"></i> Export
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-outline-success btn-block mb-2" id="printBtn">
                                        <i class="fas fa-print mr-1"></i> Print
                                    </button>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-outline-info btn-block" id="refreshBtn">
                                        <i class="fas fa-sync-alt mr-1"></i> Refresh Data
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit mr-2"></i> Edit Lokasi COD
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nama_lokasi">Nama Lokasi</label>
                        <input type="text" class="form-control" id="edit_nama_lokasi" name="nama_lokasi" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_area_detail">Area Detail</label>
                        <input type="text" class="form-control" id="edit_area_detail" name="area_detail">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_latitude">Latitude</label>
                                <input type="number" step="any" class="form-control" id="edit_latitude" name="latitude">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_longitude">Longitude</label>
                                <input type="number" step="any" class="form-control" id="edit_longitude" name="longitude">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    /* Modern Gen Z Style */
    :root {
        --primary-blue: #4A90E2;
        --light-blue: #87CEEB;
        --gradient-blue: linear-gradient(135deg, #4A90E2 0%, #87CEEB 100%);
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --info-color: #17a2b8;
        --indigo-color: #6610f2;
    }

    .card-outline {
        border-top: 3px solid;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 20px;
    }

    .card-outline:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 25px rgba(0,0,0,0.12);
    }

    .card-primary.card-outline {
        border-top-color: var(--primary-blue);
    }

    .card-info.card-outline {
        border-top-color: var(--info-color);
    }

    .card-success.card-outline {
        border-top-color: var(--success-color);
    }

    .card-warning.card-outline {
        border-top-color: var(--warning-color);
    }

    .card-gradient-indigo.card-outline {
        border-top-color: var(--indigo-color);
        background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .bg-light-blue {
        background: var(--gradient-blue) !important;
        color: white;
    }

    .small-box {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .small-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    .badge {
        border-radius: 50px;
        padding: 5px 12px;
        font-weight: 500;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(74, 144, 226, 0.05);
        transform: scale(1.002);
        transition: all 0.2s ease;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .btn-group-sm .btn {
        border-radius: 6px;
    }

    .empty-state {
        padding: 40px 20px;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        opacity: 0.5;
    }

    .progress {
        height: 6px;
        border-radius: 10px;
    }

    .progress-bar {
        border-radius: 10px;
    }

    .list-group-item {
        border: none;
        padding: 12px 0;
        background: transparent;
    }

    /* Search input styling */
    .input-group .form-control:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
    }

    /* Modal styling */
    .modal-content {
        border-radius: 15px;
        overflow: hidden;
        border: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }

    .modal-header {
        background: var(--gradient-blue);
        color: white;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-outline {
            border-radius: 10px;
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
    }

    /* Animation for empty state */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .empty-state {
        animation: fadeIn 0.6s ease;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-blue);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #357ae8;
    }
</style>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Get Current Location
    $('#getLocationBtn').click(function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                $('#latitude').val(position.coords.latitude.toFixed(6));
                $('#longitude').val(position.coords.longitude.toFixed(6));
                
                // Show success message
                showNotification('success', 'Lokasi berhasil didapatkan!');
            }, function(error) {
                showNotification('error', 'Gagal mendapatkan lokasi: ' + error.message);
            });
        } else {
            showNotification('error', 'Geolocation tidak didukung oleh browser Anda');
        }
    });

    // Edit Location Modal
    $('.btn-edit').click(function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const area = $(this).data('area');
        const lat = $(this).data('lat');
        const lng = $(this).data('lng');
        
        $('#edit_nama_lokasi').val(nama);
        $('#edit_area_detail').val(area || '');
        $('#edit_latitude').val(lat || '');
        $('#edit_longitude').val(lng || '');
        
        $('#editForm').attr('action', '/admin/lokasi/' + id);
        $('#editModal').modal('show');
    });

    // Toggle Status
    $('.btn-toggle-status').click(function() {
        const id = $(this).data('id');
        const button = $(this);
        
        if (confirm('Apakah Anda yakin ingin mengubah status lokasi ini?')) {
            $.ajax({
                url: '/admin/lokasi/toggle-status/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT'
                },
                success: function(response) {
                    showNotification('success', response.message || 'Status berhasil diubah');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    showNotification('error', 'Terjadi kesalahan saat mengubah status');
                }
            });
        }
    });

    // Table Search
    $('#searchTable').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('#locationsTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Quick Actions
    $('#exportBtn').click(function() {
        showNotification('info', 'Fitur export akan segera tersedia!');
    });

    $('#printBtn').click(function() {
        window.print();
    });

    $('#refreshBtn').click(function() {
        location.reload();
    });

    // Form Validation
    $('#addLocationForm, #editForm').on('submit', function(e) {
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        
        // Show loading state
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...');
    });

    // Notification Function
    function showNotification(type, message) {
        const toast = $(`
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                <div class="toast-header bg-${type} text-white">
                    <strong class="mr-auto">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
                        ${type === 'success' ? 'Sukses!' : type === 'error' ? 'Error!' : 'Info!'}
                    </strong>
                    <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `);
        
        $('.toast-container').remove();
        $('body').append('<div class="toast-container position-fixed bottom-0 end-0 p-3"></div>');
        $('.toast-container').append(toast);
        
        toast.toast('show');
        
        toast.on('hidden.bs.toast', function() {
            $(this).remove();
        });
    }

    // Toast Container CSS
    $('head').append(`
        <style>
            .toast-container {
                z-index: 9999;
            }
            
            .toast {
                min-width: 300px;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                border: none;
            }
            
            .bg-success {
                background: linear-gradient(45deg, #28a745, #20c997) !important;
            }
            
            .bg-error {
                background: linear-gradient(45deg, #dc3545, #e83e8c) !important;
            }
            
            .bg-info {
                background: linear-gradient(45deg, #17a2b8, #20c997) !important;
            }
            
            .toast-header {
                border-bottom: none;
            }
            
            .toast-body {
                padding: 15px;
            }
        </style>
    `);
});
</script>
@endsection