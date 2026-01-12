@extends('layout.admin.master')

@section('title', 'Manajemen Pembayaran')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">💳 Manajemen Pembayaran</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Pembayaran</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    Terjadi kesalahan! Silakan periksa form di bawah.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $payments->count() }}</h3>
                            <p>Total Metode</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <a href="#" class="small-box-footer">Lihat semua <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $payments->where('is_active', true)->count() }}</h3>
                            <p>Aktif</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gradient-indigo">
                        <div class="inner">
                            <h3>{{ $payments->where('kategori', 'bank_qris')->count() }}</h3>
                            <p>Bank/QRIS</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $payments->where('kategori', 'e_wallet')->count() }}</h3>
                            <p>E-Wallet</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <a href="#" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column: Form & Table -->
                <div class="col-lg-8">
                    <!-- Add Payment Method Card -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-plus-circle mr-2"></i>
                                Tambah Metode Pembayaran Baru
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.payment.store') }}" method="POST" id="addPaymentForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama" class="required">Nama Metode</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                                   id="nama" name="nama" 
                                                   placeholder="Contoh: BCA, OVO, QRIS Cash" 
                                                   value="{{ old('nama') }}" required>
                                            @error('nama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kategori" class="required">Kategori</label>
                                            <select class="form-control @error('kategori') is-invalid @enderror" 
                                                    id="kategori" name="kategori" required onchange="toggleQrisFields()">
                                                <option value="">Pilih Kategori</option>
                                                <option value="bank_qris" {{ old('kategori') == 'bank_qris' ? 'selected' : '' }}>Bank/QRIS</option>
                                                <option value="qris_cod" {{ old('kategori') == 'qris_cod' ? 'selected' : '' }}>QRIS COD</option>
                                                <option value="e_wallet" {{ old('kategori') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                                            </select>
                                            @error('kategori')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- QRIS & Bank Fields -->
                                <div id="qrisFields" style="display: '{{ old('kategori') == 'bank_qris' || old('kategori') == 'qris_cod' ? 'block' : 'none' }}';">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="account_name">Nama Pemilik Rekening</label>
                                                <input type="text" class="form-control @error('account_name') is-invalid @enderror" 
                                                       id="account_name" name="account_name" 
                                                       placeholder="Nama pemilik rekening/akun"
                                                       value="{{ old('account_name') }}">
                                                @error('account_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="account_number">Nomor Rekening/QRIS</label>
                                                <input type="text" class="form-control @error('account_number') is-invalid @enderror" 
                                                       id="account_number" name="account_number" 
                                                       placeholder="Nomor rekening/QRIS"
                                                       value="{{ old('account_number') }}">
                                                @error('account_number')
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
                                                <label for="provider">Provider/Bank</label>
                                                <input type="text" class="form-control @error('provider') is-invalid @enderror" 
                                                       id="provider" name="provider" 
                                                       placeholder="Contoh: BCA, BRI, OVO, Gopay"
                                                       value="{{ old('provider') }}">
                                                @error('provider')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="qris_image">Gambar QRIS</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input @error('qris_image') is-invalid @enderror" 
                                                           id="qris_image" name="qris_image" 
                                                           accept="image/png,image/jpeg,image/jpg"
                                                           onchange="previewImage(this, 'qrisPreview')">
                                                    <label class="custom-file-label" for="qris_image">Pilih file QRIS...</label>
                                                </div>
                                                @error('qris_image')
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <small class="text-muted">Format: PNG, JPG, JPEG (Maks 2MB)</small>
                                                
                                                <!-- Image Preview -->
                                                <div class="mt-2" id="qrisPreviewContainer" style="display: none;">
                                                    <img id="qrisPreview" src="" alt="Preview QRIS" class="img-thumbnail" style="max-height: 150px;">
                                                    <button type="button" class="btn btn-sm btn-danger mt-1" onclick="removeImage('qrisPreview')">
                                                        <i class="fas fa-times mr-1"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                              id="deskripsi" name="deskripsi" 
                                              rows="2" 
                                              placeholder="Contoh: Transfer bank BCA, QRIS untuk COD, dll...">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i> Simpan Metode
                                    </button>
                                    <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">
                                        <i class="fas fa-redo mr-1"></i> Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Methods Table -->
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list mr-2"></i>
                                Daftar Metode Pembayaran
                            </h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <input type="text" id="searchTable" class="form-control float-right" 
                                           placeholder="Cari metode...">
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
                                <table class="table table-hover" id="paymentsTable">
                                    <thead class="bg-light-blue">
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 20%">Nama Metode</th>
                                            <th style="width: 15%">Kategori</th>
                                            <th style="width: 25%">Informasi</th>
                                            <th style="width: 15%">QRIS</th>
                                            <th style="width: 10%">Status</th>
                                            <th style="width: 10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($payments as $payment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <strong>{{ $payment->nama }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    Dibuat: {{ $payment->created_at->format('d/m/Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                @switch($payment->kategori)
                                                    @case('bank_qris')
                                                        <span class="badge bg-primary">
                                                            <i class="fas fa-university mr-1"></i> Bank/QRIS
                                                        </span>
                                                        @break
                                                    @case('qris_cod')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-qrcode mr-1"></i> QRIS COD
                                                        </span>
                                                        @break
                                                    @case('e_wallet')
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-wallet mr-1"></i> E-Wallet
                                                        </span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="payment-info">
                                                    @if($payment->provider)
                                                        <div class="mb-1">
                                                            <i class="fas fa-building text-primary mr-1"></i>
                                                            <small><strong>{{ $payment->provider }}</strong></small>
                                                        </div>
                                                    @endif
                                                    @if($payment->account_name)
                                                        <div class="mb-1">
                                                            <i class="fas fa-user text-success mr-1"></i>
                                                            <small>{{ $payment->account_name }}</small>
                                                        </div>
                                                    @endif
                                                    @if($payment->account_number)
                                                        <div class="mb-1">
                                                            <i class="fas fa-hashtag text-info mr-1"></i>
                                                            <small>{{ $payment->account_number }}</small>
                                                        </div>
                                                    @endif
                                                    @if($payment->deskripsi)
                                                        <div class="mt-2">
                                                            <small class="text-muted">
                                                                <i class="fas fa-align-left mr-1"></i>
                                                                {{ Str::limit($payment->deskripsi, 40) }}
                                                            </small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($payment->qris_image)
                                                    <div class="d-flex flex-column align-items-center">
                                                        <img src="{{ asset('storage/' . $payment->qris_image) }}" 
                                                             alt="QRIS {{ $payment->nama }}" 
                                                             class="img-thumbnail mb-1" 
                                                             style="width: 60px; height: 60px; object-fit: cover; cursor: pointer;"
                                                             onclick="viewQRIS('{{ asset('storage/' . $payment->qris_image) }}', '{{ $payment->nama }}')">
                                                        <button type="button" class="btn btn-sm btn-outline-info btn-sm" 
                                                                onclick="viewQRIS('{{ asset('storage/' . $payment->qris_image) }}', '{{ $payment->nama }}')">
                                                            <i class="fas fa-eye mr-1"></i> Lihat
                                                        </button>
                                                    </div>
                                                @else
                                                    <span class="text-muted"><i class="fas fa-times-circle mr-1"></i> Tidak ada</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($payment->is_active)
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
                                                            data-id="{{ $payment->id }}"
                                                            data-nama="{{ $payment->nama }}"
                                                            data-kategori="{{ $payment->kategori }}"
                                                            data-deskripsi="{{ $payment->deskripsi }}"
                                                            data-account_name="{{ $payment->account_name }}"
                                                            data-account_number="{{ $payment->account_number }}"
                                                            data-provider="{{ $payment->provider }}"
                                                            data-qris_image="{{ $payment->qris_image ? asset('storage/' . $payment->qris_image) : '' }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-{{ $payment->is_active ? 'warning' : 'success' }} btn-toggle-status" 
                                                            data-id="{{ $payment->id }}"
                                                            data-nama="{{ $payment->nama }}">
                                                        @if($payment->is_active)
                                                            <i class="fas fa-pause"></i>
                                                        @else
                                                            <i class="fas fa-play"></i>
                                                        @endif
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-delete" 
                                                            data-id="{{ $payment->id }}"
                                                            data-nama="{{ $payment->nama }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="empty-state">
                                                    <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                                                    <h5>Belum ada metode pembayaran</h5>
                                                    <p class="text-muted">Tambahkan metode pembayaran pertama Anda!</p>
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

                <!-- Right Column: Statistics & Info -->
                <div class="col-lg-4">
                    <!-- Categories Distribution -->
                <!-- Ganti seluruh bagian card dengan ini -->
<div class="card card-gradient-indigo card-outline">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-pie mr-2"></i>
            Distribusi Kategori
        </h3>
    </div>
    <div class="card-body">
        @php
            $categories = [
                'bank_qris' => [
                    'count' => $payments->where('kategori', 'bank_qris')->count(),
                    'label' => 'Bank/QRIS',
                    'color' => 'primary',
                    'icon' => 'fa-university'
                ],
                'qris_cod' => [
                    'count' => $payments->where('kategori', 'qris_cod')->count(),
                    'label' => 'QRIS COD',
                    'color' => 'success',
                    'icon' => 'fa-qrcode'
                ],
                'e_wallet' => [
                    'count' => $payments->where('kategori', 'e_wallet')->count(),
                    'label' => 'E-Wallet',
                    'color' => 'warning',
                    'icon' => 'fa-wallet'
                ],
            ];
            $totalCount = $payments->count();
        @endphp
        
        <div class="row text-center mb-4">
            @foreach($categories as $key => $cat)
            @php
                $percentage = $totalCount > 0 ? round(($cat['count'] / $totalCount) * 100) : 0;
            @endphp
            <div class="col-4">
                <div class="d-flex flex-column align-items-center">
                    <div class="rounded-circle bg-{{ $cat['color'] }} p-3 mb-2">
                        <i class="fas {{ $cat['icon'] }} fa-2x text-white"></i>
                    </div>
                    <h4 class="mb-1">{{ $cat['count'] }}</h4>
                    <small class="text-muted">{{ $cat['label'] }}</small>
                    <span class="badge bg-{{ $cat['color'] }} mt-1">{{ $percentage }}%</span>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-3">
            @foreach($categories as $key => $cat)
            @php
                $percentage = $totalCount > 0 ? round(($cat['count'] / $totalCount) * 100) : 0;
            @endphp
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span>
                        <i class="fas {{ $cat['icon'] }} text-{{ $cat['color'] }} mr-2"></i>
                        {{ $cat['label'] }}
                    </span>
                    <span class="font-weight-bold">{{ $cat['count'] }} ({{ $percentage }}%)</span>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-{{ $cat['color'] }} progress-bar-striped" 
                         role="progressbar" 
                         style="width: {{ $percentage }}%"
                         aria-valuenow="{{ $percentage }}" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($totalCount === 0)
        <div class="text-center py-4">
            <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada data</h5>
            <p class="text-muted">Tambahkan metode pembayaran untuk melihat distribusi kategori</p>
        </div>
        @endif
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
                                        <i class="fas fa-credit-card text-primary mr-2"></i>
                                        Total Metode
                                    </span>
                                    <span class="badge bg-primary badge-pill">{{ $payments->count() }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>
                                        <i class="fas fa-check-circle text-success mr-2"></i>
                                        Aktif
                                    </span>
                                    <span class="badge bg-success badge-pill">{{ $payments->where('is_active', true)->count() }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>
                                        <i class="fas fa-times-circle text-danger mr-2"></i>
                                        Nonaktif
                                    </span>
                                    <span class="badge bg-danger badge-pill">{{ $payments->where('is_active', false)->count() }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>
                                        <i class="fas fa-qrcode text-info mr-2"></i>
                                        Dengan QRIS
                                    </span>
                                    <span class="badge bg-info badge-pill">{{ $payments->whereNotNull('qris_image')->count() }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- QRIS Preview -->
                    <div class="card card-warning card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-qrcode mr-2"></i>
                                Preview QRIS
                            </h3>
                        </div>
                        <div class="card-body text-center">
                            <div id="qrisViewContainer">
                                <p class="text-muted mb-0">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Klik "Lihat" pada tabel untuk melihat QRIS
                                </p>
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
                    <i class="fas fa-edit mr-2"></i> Edit Metode Pembayaran
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nama" class="required">Nama Metode</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_kategori" class="required">Kategori</label>
                        <select class="form-control" id="edit_kategori" name="kategori" required onchange="toggleEditQrisFields()">
                            <option value="bank_qris">Bank/QRIS</option>
                            <option value="qris_cod">QRIS COD</option>
                            <option value="e_wallet">E-Wallet</option>
                        </select>
                    </div>

                    <!-- QRIS & Bank Fields -->
                    <div id="editQrisFields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_account_name">Nama Pemilik Rekening</label>
                                    <input type="text" class="form-control" 
                                           id="edit_account_name" name="account_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_account_number">Nomor Rekening/QRIS</label>
                                    <input type="text" class="form-control" 
                                           id="edit_account_number" name="account_number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_provider">Provider/Bank</label>
                                    <input type="text" class="form-control" 
                                           id="edit_provider" name="provider">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_qris_image">Gambar QRIS Baru</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" 
                                               id="edit_qris_image" name="qris_image" 
                                               accept="image/png,image/jpeg,image/jpg"
                                               onchange="previewImage(this, 'editQrisPreview')">
                                        <label class="custom-file-label" for="edit_qris_image">Pilih file baru...</label>
                                    </div>
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                                    
                                    <!-- Current QRIS Preview -->
                                    <div id="currentQrisContainer" class="mt-2">
                                        <p class="mb-1"><small>QRIS Saat Ini:</small></p>
                                        <img id="currentQrisImage" src="" alt="Current QRIS" 
                                             class="img-thumbnail" style="max-height: 100px;">
                                        <div class="mt-1">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeCurrentQRIS()">
                                                <i class="fas fa-trash mr-1"></i> Hapus QRIS
                                            </button>
                                            <input type="hidden" id="remove_qris" name="remove_qris" value="0">
                                        </div>
                                    </div>
                                    
                                    <!-- New QRIS Preview -->
                                    <div class="mt-2" id="editQrisPreviewContainer" style="display: none;">
                                        <p class="mb-1"><small>Preview QRIS Baru:</small></p>
                                        <img id="editQrisPreview" src="" alt="New QRIS Preview" 
                                             class="img-thumbnail" style="max-height: 100px;">
                                        <button type="button" class="btn btn-sm btn-danger mt-1" onclick="removeImage('editQrisPreview')">
                                            <i class="fas fa-times mr-1"></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_deskripsi">Deskripsi</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center py-3">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <h5 id="deletePaymentName" class="font-weight-bold"></h5>
                    <p class="text-muted">Apakah Anda yakin ingin menghapus metode pembayaran ini?</p>
                    <p class="text-danger">
                        <small>
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            Tindakan ini tidak dapat dibatalkan!
                        </small>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Batal
                </button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- QRIS View Modal -->
<div class="modal fade" id="qrisModal" tabindex="-1" role="dialog" aria-labelledby="qrisModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="qrisModalLabel">
                    <i class="fas fa-qrcode mr-2"></i> QRIS
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalQrisImage" src="" alt="QRIS" class="img-fluid mb-3" style="max-height: 250px;">
                <h6 id="modalQrisTitle" class="mb-0"></h6>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="downloadQRIS()">
                    <i class="fas fa-download mr-1"></i> Download
                </button>
            </div>
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

    /* Payment info styling */
    .payment-info {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
        border-left: 3px solid var(--primary-blue);
    }

    /* Required field label */
    .required::after {
        content: " *";
        color: #dc3545;
    }

    /* File input styling */
    .custom-file-label::after {
        content: "Browse";
    }

    /* Image hover effect */
    .img-thumbnail {
        transition: transform 0.3s ease;
    }

    .img-thumbnail:hover {
        transform: scale(1.05);
    }

    /* Toast Notification Styles */
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
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize custom file input
    bsCustomFileInput.init();
    
    // Toggle QRIS fields based on category in add form
    window.toggleQrisFields = function() {
        const kategori = $('#kategori').val();
        const qrisFields = $('#qrisFields');
        
        if (kategori === 'bank_qris' || kategori === 'qris_cod') {
            qrisFields.slideDown(300);
            // Make QRIS fields required
            $('#account_name, #account_number, #provider').prop('required', true);
        } else {
            qrisFields.slideUp(300);
            // Remove required from QRIS fields
            $('#account_name, #account_number, #provider').prop('required', false);
        }
    }
    
    // Initialize based on old input
    toggleQrisFields();

    // Toggle QRIS fields in edit modal
    window.toggleEditQrisFields = function() {
        const kategori = $('#edit_kategori').val();
        const qrisFields = $('#editQrisFields');
        
        if (kategori === 'bank_qris' || kategori === 'qris_cod') {
            qrisFields.slideDown(300);
        } else {
            qrisFields.slideUp(300);
        }
    }

    // Image preview function
    window.previewImage = function(input, previewId) {
        const file = input.files[0];
        const previewContainer = $('#' + previewId + 'Container');
        const preview = $('#' + previewId);
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result);
                previewContainer.show();
            }
            reader.readAsDataURL(file);
            
            // Update file label
            $(input).next('.custom-file-label').html(file.name);
        }
    }

    // Remove image preview
    window.removeImage = function(previewId) {
        $('#' + previewId).attr('src', '');
        $('#' + previewId + 'Container').hide();
        $('#' + previewId.replace('Preview', '')).val('');
        $('#' + previewId.replace('Preview', '')).next('.custom-file-label').html('Pilih file...');
    }

    // Remove current QRIS in edit modal
    window.removeCurrentQRIS = function() {
        if (confirm('Apakah Anda yakin ingin menghapus QRIS ini?')) {
            $('#currentQrisImage').attr('src', '');
            $('#currentQrisContainer').hide();
            $('#remove_qris').val('1');
        }
    }

    // Reset form
    window.resetForm = function() {
        $('#addPaymentForm')[0].reset();
        $('#qrisFields').hide();
        $('#qrisPreviewContainer').hide();
        bsCustomFileInput.init();
    }

    // Edit Payment Method Modal
    $('.btn-edit').click(function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const kategori = $(this).data('kategori');
        const deskripsi = $(this).data('deskripsi') || '';
        const accountName = $(this).data('account_name') || '';
        const accountNumber = $(this).data('account_number') || '';
        const provider = $(this).data('provider') || '';
        const qrisImage = $(this).data('qris_image') || '';
        
        // Set form values
        $('#edit_nama').val(nama);
        $('#edit_kategori').val(kategori);
        $('#edit_deskripsi').val(deskripsi);
        $('#edit_account_name').val(accountName);
        $('#edit_account_number').val(accountNumber);
        $('#edit_provider').val(provider);
        
        // Set current QRIS image
        const currentQrisImage = $('#currentQrisImage');
        const currentQrisContainer = $('#currentQrisContainer');
        if (qrisImage) {
            currentQrisImage.attr('src', qrisImage);
            currentQrisContainer.show();
            $('#remove_qris').val('0');
        } else {
            currentQrisContainer.hide();
        }
        
        // Hide new QRIS preview
        $('#editQrisPreviewContainer').hide();
        
        // Toggle QRIS fields based on category
        toggleEditQrisFields();
        
        // Set form action
        $('#editForm').attr('action', '/admin/payment/' + id);
        
        // Show modal
        $('#editModal').modal('show');
    });

    // Toggle Status
    $('.btn-toggle-status').click(function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const isCurrentlyActive = $(this).hasClass('btn-warning');
        const action = isCurrentlyActive ? 'menonaktifkan' : 'mengaktifkan';
        
        if (confirm(`Apakah Anda yakin ingin ${action} metode pembayaran "${nama}"?`)) {
            $.ajax({
                url: '/admin/payment/toggle-status/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT'
                },
                success: function(response) {
                    showToast('success', response.message || 'Status berhasil diubah');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    showToast('error', 'Terjadi kesalahan saat mengubah status');
                }
            });
        }
    });
    // Delete Payment Method
    $('.btn-delete').click(function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const button = $(this);
        
        if (confirm(`Apakah Anda yakin ingin menghapus metode pembayaran "${nama}"?\nTindakan ini tidak dapat dibatalkan!`)) {
            // Show loading state
            button.html('<i class="fas fa-spinner fa-spin"></i>');
            button.prop('disabled', true);
            
            $.ajax({
                url: '/admin/payment/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    if (response.success) {
                        showToast('success', response.message || 'Metode pembayaran berhasil dihapus');
                        
                        // Remove the row from table with animation
                        const row = button.closest('tr');
                        row.fadeOut(500, function() {
                            $(this).remove();
                            
                            // Update row numbers
                            $('#paymentsTable tbody tr').each(function(index) {
                                $(this).find('td:first').text(index + 1);
                            });
                            
                            // Show empty state if no rows
                            if ($('#paymentsTable tbody tr').length === 0) {
                                $('#paymentsTable tbody').html(`
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                                                <h5>Belum ada metode pembayaran</h5>
                                                <p class="text-muted">Tambahkan metode pembayaran pertama Anda!</p>
                                            </div>
                                        </td>
                                    </tr>
                                `);
                            }
                        });
                    } else {
                        showToast('error', response.message || 'Gagal menghapus metode pembayaran');
                        button.html('<i class="fas fa-trash"></i>');
                        button.prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Delete error:', error);
                    showToast('error', 'Terjadi kesalahan saat menghapus metode pembayaran');
                    button.html('<i class="fas fa-trash"></i>');
                    button.prop('disabled', false);
                }
            });
        }
    });

    // View QRIS in modal
    window.viewQRIS = function(imageUrl, title) {
        $('#modalQrisImage').attr('src', imageUrl);
        $('#modalQrisTitle').text(title);
        $('#qrisModal').modal('show');
        
        // Store for download
        window.currentQRIS = { url: imageUrl, title: title };
    }

    // Download QRIS
    window.downloadQRIS = function() {
        if (window.currentQRIS) {
            const link = document.createElement('a');
            link.href = window.currentQRIS.url;
            link.download = window.currentQRIS.title.replace(/\s+/g, '_') + '_QRIS.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    // Table Search
    $('#searchTable').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('#paymentsTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Category Chart
    const categoryChart = document.getElementById('categoryChart');
    
    if (categoryChart) {
        // Data dari PHP
        const bankQrisCount = "{{ $payments->where('kategori', 'bank_qris')->count() }}";
        const qrisCodCount = "{{ $payments->where('kategori', 'qris_cod')->count() }}";
        const eWalletCount = "{{ $payments->where('kategori', 'e_wallet')->count() }}";
        const totalData = parseInt(bankQrisCount) + parseInt(qrisCodCount) + parseInt(eWalletCount);
        
        // Hanya tampilkan chart jika ada data
        if (totalData > 0) {
            try {
                const ctx = categoryChart.getContext('2d');
                
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Bank/QRIS', 'QRIS COD', 'E-Wallet'],
                        datasets: [{
                            data: [bankQrisCount, qrisCodCount, eWalletCount],
                            backgroundColor: [
                                'rgba(74, 144, 226, 0.8)',    // Bank/QRIS - biru
                                'rgba(40, 167, 69, 0.8)',     // QRIS COD - hijau
                                'rgba(255, 193, 7, 0.8)'      // E-Wallet - kuning
                            ],
                            borderColor: [
                                'rgba(74, 144, 226, 1)',
                                'rgba(40, 167, 69, 1)',
                                'rgba(255, 193, 7, 1)'
                            ],
                            borderWidth: 2,
                            hoverOffset: 15
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    font: {
                                        size: 12,
                                        family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                                    },
                                    color: '#495057'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        cutout: '65%',
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }
                });
                
            } catch (error) {
                console.error('Chart error:', error);
                // Fallback: Tampilkan pesan jika chart gagal
                categoryChart.style.display = 'none';
                $(categoryChart).parent().append(`
                    <div class="text-center py-4">
                        <i class="fas fa-chart-pie fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Tidak dapat menampilkan chart</p>
                    </div>
                `);
            }
        } else {
            // Jika tidak ada data
            categoryChart.style.display = 'none';
            $(categoryChart).parent().append(`
                <div class="text-center py-4">
                    <i class="fas fa-chart-pie fa-2x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data</h5>
                    <p class="text-muted">Tambahkan metode pembayaran untuk melihat distribusi kategori</p>
                </div>
            `);
        }
    }

    // Form Validation
    $('#addPaymentForm, #editForm').on('submit', function(e) {
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        
        // Show loading state
        submitBtn.prop('disabled', true);
        submitBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...');
        
        // Validate file size
        const fileInput = form.find('input[type="file"]')[0];
        if (fileInput && fileInput.files[0]) {
            const fileSize = fileInput.files[0].size / 1024 / 1024; // in MB
            if (fileSize > 2) {
                e.preventDefault();
                submitBtn.prop('disabled', false);
                submitBtn.html('<i class="fas fa-save mr-1"></i> Simpan');
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                return false;
            }
        }
    });

    // Toast notification function
    function showToast(type, message) {
        const toast = $(`
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                <div class="toast-header bg-${type} text-white">
                    <strong class="mr-auto">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>
                        ${type === 'success' ? 'Sukses!' : 'Error!'}
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
        $('body').append('<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>');
        $('.toast-container').append(toast);
        
        toast.toast({ delay: 3000 });
        toast.toast('show');
        
        toast.on('hidden.bs.toast', function() {
            $(this).remove();
        });
    }
});
</script>
@endsection