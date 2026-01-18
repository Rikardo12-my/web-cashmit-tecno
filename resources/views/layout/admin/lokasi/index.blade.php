@extends('layout.admin.master')

@section('title', 'Management Lokasi COD')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-map-marker-alt mr-2"></i> Management Lokasi COD
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-location-dot"></i> Lokasi COD</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <!-- Left Column: Form & Table -->
                <div class="col-lg-8">
                    <!-- Add Location Card -->
                    <div class="card card-outline card-primary">
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
                            <form action="{{ route('admin.lokasi.store') }}" method="POST" id="addLocationForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_lokasi" class="form-label">
                                                <i class="fas fa-store mr-1"></i> Nama Lokasi
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('nama_lokasi') is-invalid @enderror"
                                                    id="nama_lokasi" name="nama_lokasi"
                                                    placeholder="Contoh: Alfamart Jl. Sudirman" required>
                                            </div>
                                            @error('nama_lokasi')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="area_detail" class="form-label">
                                                <i class="fas fa-map-pin mr-1"></i> Detail Area
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('area_detail') is-invalid @enderror"
                                                    id="area_detail" name="area_detail"
                                                    placeholder="Contoh: Depan Sekolah, Dekat ATM">
                                            </div>
                                            @error('area_detail')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="latitude" class="form-label">
                                                <i class="fas fa-globe-asia mr-1"></i> Latitude
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-map-location-dot"></i></span>
                                                </div>
                                                <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror"
                                                    id="latitude" name="latitude"
                                                    placeholder="Contoh: -6.200000">
                                            </div>
                                            @error('latitude')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="longitude" class="form-label">
                                                <i class="fas fa-globe-asia mr-1"></i> Longitude
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-location-dot"></i></span>
                                                </div>
                                                <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror"
                                                    id="longitude" name="longitude"
                                                    placeholder="Contoh: 106.816666">
                                            </div>
                                            @error('longitude')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- Input Gambar -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="gambar" class="form-label">
                                                <i class="fas fa-image mr-1"></i> Gambar Lokasi
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('gambar') is-invalid @enderror"
                                                    id="gambar" name="gambar" accept="image/*">
                                                <label class="custom-file-label" for="gambar" id="gambarLabel">
                                                    <i class="fas fa-upload mr-1"></i> Pilih gambar (max: 2MB)
                                                </label>
                                                @error('gambar')
                                                <div class="invalid-feedback d-block">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle mr-1"></i>Format: JPG, PNG, GIF. Ukuran maksimal 2MB.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <!-- Preview Gambar -->
                                <div class="row" id="imagePreviewContainer" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><i class="fas fa-eye mr-1"></i> Preview Gambar:</label>
                                            <div class="image-preview-wrapper">
                                                <img id="imagePreview" src="" alt="Preview Gambar"
                                                    class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        <i class="fas fa-save mr-1"></i> Simpan Lokasi
                                    </button>
                                    <button type="button" class="btn btn-outline-info btn-block mt-2" id="getLocationBtn">
                                        <i class="fas fa-location-arrow mr-1"></i> Dapatkan Lokasi Saat Ini
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Locations Table -->
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list-ul mr-2"></i>
                                Daftar Lokasi COD
                            </h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <input type="text" id="searchTable" class="form-control float-right"
                                        placeholder="Cari lokasi...">
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
                                <table class="table table-hover" id="locationsTable">
                                    <thead class="bg-gradient-info text-white">
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 20%">Gambar</th>
                                            <th style="width: 20%">Nama Lokasi</th>
                                            <th style="width: 15%">Area Detail</th>
                                            <th style="width: 15%">Koordinat</th>
                                            <th style="width: 10%">Status</th>
                                            <th style="width: 15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($lokasi as $item)
                                        <tr>
                                            <td class="align-middle">
                                                <span class="badge badge-secondary">{{ $loop->iteration }}</span>
                                            </td>

                                            <!-- Kolom Gambar -->
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    @if($item->gambar)
                                                    @php
                                                    $imageUrl = Storage::url($item->gambar);
                                                    $imageExists = Storage::disk('public')->exists($item->gambar);
                                                    @endphp

                                                    @if($imageExists)
                                                    <div class="position-relative">
                                                        <img src="{{ $imageUrl }}"
                                                            alt="{{ $item->nama_lokasi }}"
                                                            class="img-thumbnail rounded-lg shadow-sm"
                                                            style="width: 60px; height: 60px; object-fit: cover;"
                                                            onclick="showImageModal('{{ $imageUrl }}')">

                                                        <span class="badge badge-light position-absolute" style="top: -5px; right: -5px; font-size: 8px;">
                                                            <i class="fas fa-image text-info"></i>
                                                        </span>
                                                    </div>
                                                    @else
                                                    <div class="image-error-placeholder rounded-lg d-flex flex-column align-items-center justify-content-center text-center"
                                                        style="width: 60px; height: 60px; background: linear-gradient(45deg, #ffeaa7, #fab1a0); border: 2px dashed #e17055;"
                                                        title="Gambar tidak ditemukan di server">
                                                        <i class="fas fa-exclamation-circle text-danger mb-1"></i>
                                                        <small class="text-danger" style="font-size: 8px;">Error</small>
                                                    </div>
                                                    @endif
                                                    @else
                                                    <div class="image-placeholder rounded-lg d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px; background: linear-gradient(45deg, #dfe6e9, #b2bec3);">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Kolom Nama Lokasi -->
                                            <td class="align-middle">
                                                <div>
                                                    <strong class="d-block">{{ $item->nama_lokasi }}</strong>
                                                    <small class="text-muted">
                                                        <i class="far fa-calendar-alt mr-1"></i>
                                                        {{ $item->created_at->format('d/m/Y') }}
                                                    </small>
                                                </div>
                                            </td>

                                            <!-- Kolom Area Detail -->
                                            <td class="align-middle">
                                                @if($item->area_detail)
                                                <span class="badge badge-light text-dark p-2">
                                                    <i class="fas fa-map-marker-alt mr-1 text-primary"></i>
                                                    {{ Str::limit($item->area_detail, 20) }}
                                                </span>
                                                @else
                                                <span class="text-muted">
                                                    <i class="fas fa-minus-circle mr-1"></i>Tidak ada
                                                </span>
                                                @endif
                                            </td>

                                            <!-- Kolom Koordinat -->
                                            <td class="align-middle">
                                                @if($item->latitude && $item->longitude)
                                                <div>
                                                    <small class="text-primary d-block">
                                                        <i class="fas fa-latitude mr-1"></i>{{ $item->latitude }}
                                                    </small>
                                                    <small class="text-primary d-block">
                                                        <i class="fas fa-longitude mr-1"></i>{{ $item->longitude }}
                                                    </small>
                                                </div>
                                                @else
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>Belum diatur
                                                </span>
                                                @endif
                                            </td>

                                            <!-- Kolom Status -->
                                            <td class="align-middle">
                                                @if($item->status)
                                                <span class="badge badge-success badge-pill px-3 py-2">
                                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                                </span>
                                                @else
                                                <span class="badge badge-danger badge-pill px-3 py-2">
                                                    <i class="fas fa-times-circle mr-1"></i> Nonaktif
                                                </span>
                                                @endif
                                            </td>

                                            <!-- Kolom Aksi -->
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-outline-info btn-edit"
                                                        data-id="{{ $item->id }}"
                                                        data-nama="{{ $item->nama_lokasi }}"
                                                        data-area="{{ $item->area_detail }}"
                                                        data-lat="{{ $item->latitude }}"
                                                        data-lng="{{ $item->longitude }}"
                                                        data-gambar="{{ $item->gambar }}"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-{{ $item->status ? 'warning' : 'success' }} btn-toggle-status"
                                                        data-id="{{ $item->id }}"
                                                        title="{{ $item->status ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                        @if($item->status)
                                                        <i class="fas fa-pause"></i>
                                                        @else
                                                        <i class="fas fa-play"></i>
                                                        @endif
                                                    </button>
                                                    @if($item->gambar)
                                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-gambar"
                                                        data-id="{{ $item->id }}"
                                                        data-gambar="{{ Storage::url($item->gambar) }}"
                                                        title="Lihat Gambar">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete"
                                                        data-id="{{ $item->id }}"
                                                        data-nama="{{ $item->nama_lokasi }}"
                                                        data-url="{{ route('admin.lokasi.destroy', $item->id) }}"
                                                        title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-map-marker-alt fa-4x text-muted mb-4"></i>
                                                    <h4 class="text-muted">Belum ada lokasi COD</h4>
                                                    <p class="text-muted mb-4">Tambahkan lokasi pertama Anda untuk memulai</p>
                                                    <button type="button" class="btn btn-primary" onclick="$('.card-primary .btn-tool').click()">
                                                        <i class="fas fa-plus mr-2"></i>Tambah Lokasi Pertama
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($lokasi->count() > 0)
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Menampilkan <strong>{{ $lokasi->count() }}</strong> dari <strong>{{ $lokasi->count() }}</strong> lokasi
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
                </div>

                <!-- Right Column: Statistics & Actions -->
                <div class="col-lg-4">
                    <!-- Popular Locations -->
                    <div class="card card-outline card-gradient-indigo">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-line mr-2"></i>
                                Lokasi Terpopuler
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($statistik->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($statistik as $index => $populer)
                                <div class="list-group-item d-flex align-items-center px-0 py-3 border-bottom">
                                    <div class="mr-3">
                                        <span class="badge badge-{{ $index < 3 ? 'primary' : 'secondary' }} badge-pill" style="width: 30px; height: 30px; line-height: 30px;">
                                            {{ $index + 1 }}
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ $populer->nama_lokasi }}</h6>
                                        <small class="text-muted">
                                            {{ $populer->tarik_tunai_count ?? 0 }} transaksi
                                        </small>
                                    </div>
                                    <div class="progress flex-grow-1 mx-3" style="height: 8px;">
                                        @php
                                        $percentage = min(($populer->tarik_tunai_count ?? 0) * 20, 100);
                                        @endphp
                                        <div class="progress-bar bg-gradient-{{ $index < 3 ? 'primary' : 'info' }}"
                                            style="width: {{ $percentage }}%"
                                            role="progressbar"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data statistik</h5>
                                <p class="text-muted mb-0">Transaksi akan muncul di sini</p>
                            </div>
                            @endif
                        </div>
                        @if($statistik->count() > 0)
                        <div class="card-footer text-center">
                            <a href="{{ route('admin.lokasi.statistik') }}" class="btn btn-sm btn-outline-indigo">
                                <i class="fas fa-chart-simple mr-1"></i> Lihat Detail Statistik
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Quick Stats -->
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-2"></i>
                                Statistik Lokasi
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-number text-primary">{{ $lokasi->count() }}</div>
                                        <div class="stat-label">Total Lokasi</div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="stat-card">
                                        <div class="stat-number text-success">{{ $lokasi->where('status', true)->count() }}</div>
                                        <div class="stat-label">Aktif</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card">
                                        <div class="stat-number text-warning">{{ $lokasi->where('status', false)->count() }}</div>
                                        <div class="stat-label">Nonaktif</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-card">
                                        <div class="stat-number text-info">{{ $lokasi->whereNotNull('latitude')->count() }}</div>
                                        <div class="stat-label">Berkoordinat</div>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit mr-2"></i> Edit Lokasi COD
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_nama_lokasi" class="form-label">Nama Lokasi</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="edit_nama_lokasi" name="nama_lokasi" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_area_detail" class="form-label">Area Detail</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="edit_area_detail" name="area_detail">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_latitude" class="form-label">Latitude</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-latitude"></i></span>
                                    </div>
                                    <input type="number" step="any" class="form-control" id="edit_latitude" name="latitude">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_longitude" class="form-label">Longitude</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-longitude"></i></span>
                                    </div>
                                    <input type="number" step="any" class="form-control" id="edit_longitude" name="longitude">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Input Gambar untuk Edit -->
                    <div class="form-group">
                        <label for="edit_gambar" class="form-label">Gambar Lokasi (Opsional)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input"
                                id="edit_gambar" name="gambar" accept="image/*">
                            <label class="custom-file-label" for="edit_gambar" id="edit_gambarLabel">
                                <i class="fas fa-upload mr-1"></i> Pilih gambar baru
                            </label>
                        </div>
                        <small class="form-text text-muted">
                            Kosongkan jika tidak ingin mengubah gambar.
                        </small>
                    </div>
                    <!-- Preview Gambar Saat Ini -->
                    <div class="form-group" id="currentImageContainer" style="display: none;">
                        <label class="form-label">Gambar Saat Ini:</label>
                        <div class="current-image-wrapper text-center p-3 rounded bg-light">
                            <img id="currentImage" src="" alt="Gambar saat ini"
                                class="img-fluid rounded shadow-sm mb-3" style="max-height: 150px;">
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-danger" id="removeImageBtn">
                                    <i class="fas fa-trash mr-1"></i> Hapus Gambar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
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
                <p>Apakah Anda yakin ingin menghapus lokasi <strong id="deleteItemName"></strong>?</p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle mr-2"></i>Tindakan ini tidak dapat dibatalkan!</p>
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

<!-- Modal Preview Gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info text-white">
                <h5 class="modal-title" id="imageModalLabel">
                    <i class="fas fa-image mr-2"></i> Preview Gambar Lokasi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Gambar Lokasi" class="img-fluid rounded shadow">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
                <a id="downloadImage" href="#" class="btn btn-primary" download>
                    <i class="fas fa-download mr-1"></i> Download
                </a>
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

    .card-outline.card-info {
        border-top-color: #4facfe;
    }

    .card-outline.card-success {
        border-top-color: #43e97b;
    }

    .card-outline.card-warning {
        border-top-color: #fa709a;
    }

    .card-outline.card-gradient-indigo {
        border-top-color: #6a11cb;
        background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);
    }

    /* Small Box Styles */
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

    .bg-gradient-purple {
        background: var(--purple-gradient);
    }

    .bg-gradient-indigo {
        background: var(--indigo-gradient);
    }

    .bg-gradient-primary {
        background: var(--primary-gradient);
    }

    .bg-gradient-info {
        background: var(--info-gradient);
    }

    /* Table Styles */
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

    .bg-gradient-info {
        background: var(--info-gradient);
    }

    /* Badge Styles */
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

    .badge-info {
        background: var(--info-gradient);
        color: white;
    }

    /* Button Styles */
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

    .btn-primary {
        background: var(--primary-gradient);
        color: white;
    }

    .btn-info {
        background: var(--info-gradient);
        color: white;
    }

    .btn-success {
        background: var(--success-gradient);
        color: white;
    }

    .btn-warning {
        background: var(--warning-gradient);
        color: white;
    }

    .btn-danger {
        background: var(--danger-gradient);
        color: white;
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

    .btn-outline-indigo {
        border: 2px solid #6a11cb;
        color: #6a11cb;
        background: transparent;
    }

    .btn-outline-indigo:hover {
        background: var(--indigo-gradient);
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

    /* Form Styles */
    .form-control,
    .custom-file-input {
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
        padding: 12px 15px;
    }

    .form-control:focus,
    .custom-file-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.3rem rgba(102, 126, 234, 0.25);
        transform: translateY(-2px);
    }

    .input-group-text {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 8px 0 0 8px;
    }

    .custom-file-label {
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        padding: 12px 15px;
    }

    .custom-file-label::after {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 0 6px 6px 0;
        height: calc(100% + 4px);
        top: -2px;
        right: -2px;
    }

    /* Image Preview */
    .image-preview-wrapper {
        border: 3px dashed #667eea;
        border-radius: 12px;
        padding: 20px;
        background: linear-gradient(45deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        text-align: center;
        transition: all 0.3s ease;
    }

    .image-preview-wrapper:hover {
        border-color: #9b51e0;
        background: linear-gradient(45deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    }

    .image-placeholder {
        transition: all 0.3s ease;
    }

    .image-placeholder:hover {
        background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);
        transform: scale(1.05);
    }

    /* Stat Cards */
    .stat-card {
        padding: 15px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }

    /* Empty State */
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

    /* Progress Bar */
    .progress {
        border-radius: 10px;
        height: 10px;
        overflow: hidden;
    }

    .progress-bar {
        border-radius: 10px;
        background: var(--primary-gradient);
    }

    /* Modal Styles */
    .modal-content {
        border-radius: 16px;
        overflow: hidden;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        padding: 20px 30px;
    }

    .modal-body {
        padding: 30px;
    }

    .modal-footer {
        padding: 20px 30px;
        border-top: 1px solid #e0e0e0;
    }

    /* Toast Notification */
    .toast {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        border: none;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-gradient);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #9b51e0 0%, #3081ed 100%);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .card-outline {
            border-radius: 8px;
        }

        .stat-number {
            font-size: 1.5rem;
        }

        .btn {
            padding: 8px 16px;
        }
    }

    /* Animation */
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

    /* Loader Animation */
    .btn-loading {
        position: relative;
        color: transparent !important;
    }

    .btn-loading:after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin: -10px 0 0 -10px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Get Current Location
        $('#getLocationBtn').click(function() {
            const btn = $(this);
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Mendapatkan lokasi...');

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    $('#latitude').val(position.coords.latitude.toFixed(6));
                    $('#longitude').val(position.coords.longitude.toFixed(6));
                    showNotification('success', 'Lokasi berhasil didapatkan!');
                    btn.prop('disabled', false).html('<i class="fas fa-location-arrow mr-1"></i> Dapatkan Lokasi Saat Ini');
                }, function(error) {
                    showNotification('error', 'Gagal mendapatkan lokasi: ' + error.message);
                    btn.prop('disabled', false).html('<i class="fas fa-location-arrow mr-1"></i> Dapatkan Lokasi Saat Ini');
                });
            } else {
                showNotification('error', 'Geolocation tidak didukung oleh browser Anda');
                btn.prop('disabled', false).html('<i class="fas fa-location-arrow mr-1"></i> Dapatkan Lokasi Saat Ini');
            }
        });

        // Preview Gambar saat Upload
        $('#gambar').on('change', function(e) {
            const file = e.target.files[0];
            const label = $('#gambarLabel');

            if (file) {
                label.html(`<i class="fas fa-check-circle mr-1"></i>${file.name}`);

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreviewContainer').slideDown();
                }
                reader.readAsDataURL(file);
            } else {
                label.html('<i class="fas fa-upload mr-1"></i> Pilih gambar (max: 2MB)');
                $('#imagePreviewContainer').slideUp();
            }
        });

        // Edit Location Modal
        $('.btn-edit').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            const area = $(this).data('area');
            const lat = $(this).data('lat');
            const lng = $(this).data('lng');
            const gambar = $(this).data('gambar');

            $('#edit_nama_lokasi').val(nama);
            $('#edit_area_detail').val(area || '');
            $('#edit_latitude').val(lat || '');
            $('#edit_longitude').val(lng || '');

            // Handle gambar - FIX THIS:
            if (gambar) {
                const imageUrl = '{{ Storage::url("") }}' + gambar; // Fix the image URL
                $('#currentImage').attr('src', imageUrl);
                $('#currentImageContainer').show();
            } else {
                $('#currentImageContainer').hide();
            }

            // FIX: Use Laravel's route helper or correct URL
            $('#editForm').attr('action', '{{ route("admin.lokasi.update", ["id" => ":id"]) }}'.replace(':id', id));
            $('#editModal').modal('show');
        });

        // Toggle Status - FIX THIS
        $('.btn-toggle-status').click(function() {
            const id = $(this).data('id');
            const button = $(this);

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin mengubah status lokasi ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#667eea',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, ubah status!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.addClass('btn-loading');

                    // FIX: Use correct route
                    $.ajax({
                        url: '{{ route("admin.lokasi.toggle-status", ["id" => ":id"]) }}'.replace(':id', id),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT'
                        },
                        success: function(response) {
                            showNotification('success', response.message || 'Status berhasil diubah');
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        },
                        error: function(xhr) {
                            button.removeClass('btn-loading');
                            showNotification('error', 'Terjadi kesalahan saat mengubah status');
                        }
                    });
                }
            });
        });

        // Delete Location
        $('.btn-delete').click(function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');

            $('#deleteItemName').text(nama);
            $('#deleteForm').attr('action', '/admin/lokasi-cod/' + id);
            $('#deleteModal').modal('show');
        });

        // Delete Form Submission - FIX THIS
        $('#deleteForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const url = form.attr('action');
            const button = form.find('button[type="submit"]');

            button.prop('disabled', true).addClass('btn-loading');

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    showNotification('success', response.message || 'Lokasi berhasil dihapus');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    button.prop('disabled', false).removeClass('btn-loading');
                    $('#deleteModal').modal('hide');

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        showNotification('error', xhr.responseJSON.message);
                    } else {
                        showNotification('error', 'Terjadi kesalahan saat menghapus lokasi');
                    }
                }
            });
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
            Swal.fire({
                title: 'Ekspor Data',
                text: 'Fitur export akan segera tersedia!',
                icon: 'info',
                confirmButtonColor: '#667eea'
            });
        });

        $('#printBtn').click(function() {
            window.print();
        });

        $('#refreshBtn').click(function() {
            const btn = $(this);
            btn.addClass('btn-loading');
            setTimeout(() => {
                location.reload();
            }, 1000);
        });

        // Form Submit Loading
        $('#addLocationForm, #editForm').on('submit', function(e) {
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');

            submitBtn.prop('disabled', true).addClass('btn-loading');
        });

        // Preview gambar untuk edit
        $('#edit_gambar').on('change', function(e) {
            const file = e.target.files[0];
            const label = $('#edit_gambarLabel');

            if (file) {
                label.html(`<i class="fas fa-check-circle mr-1"></i>${file.name}`);
            } else {
                label.html('<i class="fas fa-upload mr-1"></i> Pilih gambar baru (opsional)');
            }
        });

        // Tombol hapus gambar
        $('#removeImageBtn').click(function() {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus gambar ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff0844',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const id = $('#editForm').attr('action').split('/').pop();

                    $.ajax({
                        url: '/admin/lokasi/' + id + '/hapus-gambar',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            showNotification('success', response.message || 'Gambar berhasil dihapus');
                            $('#currentImageContainer').hide();
                            $('#editModal').modal('hide');
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(xhr) {
                            showNotification('error', 'Terjadi kesalahan saat menghapus gambar');
                        }
                    });
                }
            });
        });

        // Preview Gambar Modal
        $('.btn-gambar').click(function() {
            const gambarUrl = $(this).data('gambar');

            $('#modalImage').attr('src', gambarUrl);
            $('#downloadImage').attr('href', gambarUrl);
            $('#imageModal').modal('show');
        });

        // Fungsi global untuk show image modal
        window.showImageModal = function(imageUrl) {
            $('#modalImage').attr('src', imageUrl);
            $('#downloadImage').attr('href', imageUrl);
            $('#imageModal').modal('show');
        };

        // Initialize custom file input
        bsCustomFileInput.init();

        // Notification Function
        function showNotification(type, message) {
            const toast = $(`
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
                    <div class="toast-header bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} text-white">
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

        // Initialize tooltips
        $('[title]').tooltip();
    });
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Initialize SweetAlert2
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
</script>
@endsection