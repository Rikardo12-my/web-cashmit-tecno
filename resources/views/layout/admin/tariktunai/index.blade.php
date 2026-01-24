@extends('layout.admin.master')

@section('title', 'Manajemen Tarik Tunai')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-money-bill-wave mr-2"></i>Manajemen Tarik Tunai
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-money-bill-transfer"></i> Tarik Tunai</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">

            <!-- Action Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <!-- Header Section -->
                <div class="d-md-flex align-items-center justify-content-between mb-4">
                    <!-- Title -->
                    <div class="mb-3 mb-md-0">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-gradient-primary rounded-circle p-2 mr-3">
                                <i class="fas fa-exchange-alt text-white fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 font-weight-semibold">Kelola Transaksi</h5>
                                <p class="text-muted mb-0 small">Filter dan kelola transaksi tarik tunai</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-primary btn-icon" id="bulkAssignBtn">
                            <i class="fas fa-users mr-2"></i>
                            Bulk Assign
                        </button>
                        
                        <a href="{{ route('admin.tariktunai.export') }}" 
                           class="btn btn-success btn-icon">
                            <i class="fas fa-file-export mr-2"></i>
                            Export CSV
                        </a>
                        
                        <button class="btn btn-outline-secondary btn-icon" id="filterToggleBtn">
                            <i class="fas fa-filter mr-2"></i>
                            Filter
                            <span class="badge bg-primary ms-2" id="activeFilterCount">0</span>
                        </button>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="filter-section mt-4" id="filterSection" style="display: none;">
                    <div class="border-top pt-4">
                        <h6 class="mb-3 font-weight-semibold text-primary">
                            <i class="fas fa-sliders-h mr-2"></i>Filter Transaksi
                        </h6>
                        
                        <form method="GET" class="row g-3">
                            <!-- Row 1: Status & Pencarian -->
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Status Transaksi</label>
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="menunggu_admin" {{ request('status') == 'menunggu_admin' ? 'selected' : '' }}>Menunggu Admin</option>
                                    <option value="menunggu_pembayaran" {{ request('status') == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                    <option value="menunggu_verifikasi_admin" {{ request('status') == 'menunggu_verifikasi_admin' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="dalam_perjalanan" {{ request('status') == 'dalam_perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                                    <option value="menunggu_serah_terima" {{ request('status') == 'menunggu_serah_terima' ? 'selected' : '' }}>Menunggu Serah Terima</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan_customer" {{ request('status') == 'dibatalkan_customer' ? 'selected' : '' }}>Dibatalkan (Customer)</option>
                                    <option value="dibatalkan_admin" {{ request('status') == 'dibatalkan_admin' ? 'selected' : '' }}>Dibatalkan (Admin)</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Pencarian</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-right-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control" 
                                           value="{{ request('search') }}" 
                                           placeholder="Cari kode transaksi atau nama...">
                                </div>
                            </div>

                            <!-- Row 2: Tanggal Mulai & Akhir -->
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Tanggal Mulai</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-right-0">
                                        <i class="fas fa-calendar-alt text-muted"></i>
                                    </span>
                                    <input type="date" name="start_date" class="form-control" 
                                           value="{{ request('start_date') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Tanggal Akhir</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bg-light border-right-0">
                                        <i class="fas fa-calendar-alt text-muted"></i>
                                    </span>
                                    <input type="date" name="end_date" class="form-control" 
                                           value="{{ request('end_date') }}">
                                </div>
                            </div>

                            <!-- Row 3: Lokasi -->
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Lokasi COD</label>
                                <select name="lokasi_id" class="form-control form-control-sm">
                                    <option value="">Semua Lokasi</option>
                                    @foreach($lokasiList ?? [] as $lokasi)
                                    <option value="{{ $lokasi->id }}" {{ request('lokasi_id') == $lokasi->id ? 'selected' : '' }}>
                                        {{ $lokasi->nama_lokasi }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.tariktunai.index') }}" 
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-sync-alt mr-2"></i> Reset
                                    </a>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-filter mr-2"></i> Terapkan Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            <!-- Tarik Tunai Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-list-ul mr-2"></i>
                                Daftar Transaksi Tarik Tunai
                                <span class="badge badge-pill badge-light ml-2">{{ $tarikTunais->count() }} transaksi</span>
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="tarikTunaiTable">
                                    <thead class="bg-gradient-info text-white">
                                        <tr>
                                            <th style="width: 3%">
                                                <input type="checkbox" id="selectAll">
                                            </th>
                                            <th style="width: 8%">Kode</th>
                                            <th style="width: 10%">Customer</th>
                                            <th style="width: 8%">Jumlah</th>
                                            <th style="width: 8%">Biaya Admin</th>
                                            <th style="width: 8%">Total</th>
                                            <th style="width: 8%">Bukti Bayar</th> <!-- KOLOM BARU -->
                                            <th style="width: 8%">Bukti Serah Terima</th> <!-- KOLOM BARU -->
                                            <th style="width: 12%">Lokasi</th>
                                            <th style="width: 10%">Petugas</th>
                                            <th style="width: 8%">Status</th>
                                            <th style="width: 6%">Tanggal</th>
                                            <th style="width: 8%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tarikTunais as $item)
                                        <tr data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                                            <td class="align-middle">
                                                <input type="checkbox" class="select-checkbox" value="{{ $item->id }}" 
                                                       {{ !in_array($item->status, ['menunggu_admin', 'menunggu_verifikasi_admin']) ? 'disabled' : '' }}>
                                            </td>
                                            <td class="align-middle">
                                                <strong class="d-block">{{ $item->kode_transaksi }}</strong>
                                                <small class="text-muted">
                                                    <i class="fas fa-money-bill-wave mr-1"></i>Tarik Tunai
                                                </small>
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-placeholder rounded-circle mr-2 d-flex align-items-center justify-content-center"
                                                         style="width: 40px; height: 40px; background: linear-gradient(45deg, #667eea, #764ba2);">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                    <div>
                                                        <strong class="d-block">{{ $item->user->nama ?? 'N/A' }}</strong>
                                                        <small class="text-muted">
                                                            <i class="fas fa-phone mr-1"></i>{{ $item->user->telepon ?? '-' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span class="badge badge-light text-dark p-2">
                                                    <i class="fas fa-money-bill-wave mr-1 text-success"></i>
                                                    Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                @if($item->biaya_admin > 0)
                                                <span class="badge badge-warning p-2">
                                                    Rp {{ number_format($item->biaya_admin, 0, ',', '.') }}
                                                </span>
                                                @else
                                                <span class="badge badge-light text-muted p-2" title="Klik tombol set biaya untuk mengatur">
                                                    <i class="fas fa-calculator mr-1"></i>Belum di-set
                                                </span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                @if($item->total_dibayar > 0)
                                                <span class="badge badge-success p-2">
                                                    Rp {{ number_format($item->total_dibayar, 0, ',', '.') }}
                                                </span>
                                                @else
                                                <span class="badge badge-light text-muted p-2">
                                                    <i class="fas fa-clock mr-1"></i>Menunggu
                                                </span>
                                                @endif
                                            </td>
                                            
                                            <!-- KOLOM BUKTI BAYAR CUSTOMER -->
                                            <td class="align-middle">
                                                @if($item->bukti_bayar_customer)
                                                    <div class="text-center">
                                                        <!-- Thumbnail gambar bukti -->
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-info view-bukti-customer-btn p-0 border-0 bg-transparent"
                                                                data-url="{{ Storage::url($item->bukti_bayar_customer) }}"
                                                                data-waktu="{{ $item->waktu_upload_bukti_customer ? $item->waktu_upload_bukti_customer->timezone('Asia/Jakarta')->format('d/m/Y H:i') : '' }}"
                                                                data-judul="Bukti Bayar {{ $item->kode_transaksi }}"
                                                                title="Lihat Bukti Pembayaran">
                                                            <div style="width: 40px; height: 40px; overflow: hidden; border-radius: 5px; border: 2px solid #17a2b8; margin: 0 auto;">
                                                                <img src="{{ Storage::url($item->bukti_bayar_customer) }}" 
                                                                     alt="Bukti Pembayaran"
                                                                     style="width: 100%; height: 100%; object-fit: cover;"
                                                                     onerror="this.src='{{ asset('images/no-image.png') }}'">
                                                            </div>
                                                            <small class="text-info d-block mt-1">Lihat</small>
                                                        </button>
                                                        @if($item->status == 'menunggu_verifikasi_admin')
                                                        <button type="button" 
                                                                class="btn btn-xs btn-warning verify-bukti-btn mt-1"
                                                                data-id="{{ $item->id }}"
                                                                data-kode="{{ $item->kode_transaksi }}"
                                                                title="Verifikasi Bukti">
                                                            <i class="fas fa-check-circle"></i> Verifikasi
                                                        </button>
                                                        @endif
                                                    </div>
                                                @elseif(in_array($item->status, ['menunggu_pembayaran']))
                                                    <!-- Menunggu pembayaran -->
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-clock"></i> Menunggu
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <!-- END KOLOM BUKTI BAYAR -->
                                            
                                            <!-- KOLOM BUKTI SERAH TERIMA PETUGAS -->
                                            <td class="align-middle">
                                                @if($item->bukti_serah_terima_petugas)
                                                    <div class="text-center">
                                                        <!-- Thumbnail gambar bukti serah terima -->
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-success view-bukti-petugas-btn p-0 border-0 bg-transparent"
                                                                data-url="{{ Storage::url($item->bukti_serah_terima_petugas) }}"
                                                                data-waktu="{{ $item->waktu_upload_bukti_petugas ? $item->waktu_upload_bukti_petugas->timezone('Asia/Jakarta')->format('d/m/Y H:i') : '' }}"
                                                                data-judul="Bukti Serah Terima {{ $item->kode_transaksi }}"
                                                                title="Lihat Bukti Serah Terima">
                                                            <div style="width: 40px; height: 40px; overflow: hidden; border-radius: 5px; border: 2px solid #28a745; margin: 0 auto;">
                                                                <img src="{{ Storage::url($item->bukti_serah_terima_petugas) }}" 
                                                                     alt="Bukti Serah Terima"
                                                                     style="width: 100%; height: 100%; object-fit: cover;"
                                                                     onerror="this.src='{{ asset('images/no-image.png') }}'">
                                                            </div>
                                                            <small class="text-success d-block mt-1">Lihat</small>
                                                        </button>
                                                    </div>
                                                @elseif(in_array($item->status, ['selesai']))
                                                    <!-- Status selesai tapi belum ada bukti -->
                                                    <span class="badge badge-light text-muted">
                                                        <i class="fas fa-times-circle"></i> Belum ada
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <!-- END KOLOM BUKTI SERAH TERIMA -->
                                            
                                            <td class="align-middle">
                                                @if($item->lokasiCod)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-placeholder rounded-circle mr-2 d-flex align-items-center justify-content-center"
                                                         style="width: 40px; height: 40px; background: linear-gradient(45deg, #ff9a9e, #fad0c4);">
                                                        <i class="fas fa-map-marker-alt text-white"></i>
                                                    </div>
                                                    <div>
                                                        <strong class="d-block">{{ $item->lokasiCod->nama_lokasi }}</strong>
                                                        <small class="text-muted">
                                                            <i class="fas fa-map-pin mr-1"></i>{{ Str::limit($item->lokasiCod->alamat ?? 'Alamat tidak tersedia', 25) }}
                                                        </small>
                                                    </div>
                                                </div>
                                                @else
                                                <span class="badge badge-light text-muted p-2">
                                                    <i class="fas fa-map-marker-slash mr-1"></i>Tidak ada lokasi
                                                </span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                @if($item->petugas)
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-placeholder rounded-circle mr-2 d-flex align-items-center justify-content-center"
                                                         style="width: 40px; height: 40px; background: linear-gradient(45deg, #43e97b, #38f9d7);">
                                                        <i class="fas fa-user-tie text-white"></i>
                                                    </div>
                                                    <div>
                                                        <strong class="d-block">{{ $item->petugas->nama }}</strong>
                                                        <small class="text-muted">
                                                            <i class="fas fa-check-circle mr-1 text-success"></i>Ditugaskan
                                                        </small>
                                                    </div>
                                                </div>
                                                @else
                                                <span class="badge badge-light text-muted p-2">
                                                    <i class="fas fa-user-slash mr-1"></i>Belum ada
                                                </span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'secondary',
                                                        'menunggu_admin' => 'warning',
                                                        'menunggu_pembayaran' => 'info',
                                                        'menunggu_verifikasi_admin' => 'primary',
                                                        'diproses' => 'info',
                                                        'dalam_perjalanan' => 'primary',
                                                        'menunggu_serah_terima' => 'purple',
                                                        'selesai' => 'success',
                                                        'dibatalkan_customer' => 'danger',
                                                        'dibatalkan_admin' => 'danger'
                                                    ];
                                                    $statusIcons = [
                                                        'pending' => 'clock',
                                                        'menunggu_admin' => 'user-clock',
                                                        'menunggu_pembayaran' => 'money-bill-wave',
                                                        'menunggu_verifikasi_admin' => 'check-circle',
                                                        'diproses' => 'cog',
                                                        'dalam_perjalanan' => 'walking',
                                                        'menunggu_serah_terima' => 'handshake',
                                                        'selesai' => 'check-double',
                                                        'dibatalkan_customer' => 'user-slash',
                                                        'dibatalkan_admin' => 'user-shield'
                                                    ];
                                                    $statusText = [
                                                        'pending' => 'Pending',
                                                        'menunggu_admin' => 'Menunggu Admin',
                                                        'menunggu_pembayaran' => 'Menunggu Bayar',
                                                        'menunggu_verifikasi_admin' => 'Menunggu Verifikasi',
                                                        'diproses' => 'Diproses',
                                                        'dalam_perjalanan' => 'Dalam Perjalanan',
                                                        'menunggu_serah_terima' => 'Serah Terima',
                                                        'selesai' => 'Selesai',
                                                        'dibatalkan_customer' => 'Dibatalkan (Cust)',
                                                        'dibatalkan_admin' => 'Dibatalkan (Admin)'
                                                    ];
                                                @endphp
                                                <span class="badge badge-{{ $statusColors[$item->status] ?? 'secondary' }} badge-pill px-2 py-1">
                                                    <i class="fas fa-{{ $statusIcons[$item->status] ?? 'clock' }} mr-1"></i>
                                                    {{ $statusText[$item->status] ?? $item->status }}
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <div>
                                                    <small class="text-primary d-block">
                                                        <i class="far fa-calendar-alt mr-1"></i>
                                                        {{ $item->created_at->timezone('Asia/Jakarta')->format('d/m/Y') }}
                                                    </small>
                                                    <small class="text-muted d-block">
                                                        <i class="far fa-clock mr-1"></i>
                                                        {{ $item->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.tariktunai.show', $item->id) }}" 
                                                       class="btn btn-sm btn-outline-primary"
                                                       title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    <!-- Tombol Set Biaya Admin -->
                                                    @if(in_array($item->status, ['pending', 'menunggu_admin']) && $item->biaya_admin <= 0)
                                                    <a href="{{ route('admin.tariktunai.set-biaya-form', $item->id) }}" 
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Set Biaya Admin">
                                                        <i class="fas fa-calculator"></i>
                                                    </a>
                                                    @endif
                                                    
                                                    <!-- Tombol Assign Petugas (hanya jika sudah ada bukti dan status menunggu verifikasi) -->
                                                    @if($item->status == 'menunggu_verifikasi_admin' && $item->bukti_bayar_customer)
                                                    <button class="btn btn-sm btn-outline-info assign-single-btn"
                                                            data-id="{{ $item->id }}"
                                                            data-kode="{{ $item->kode_transaksi }}"
                                                            data-lokasi="{{ $item->lokasiCod->nama_lokasi ?? 'Tidak ada lokasi' }}"
                                                            data-alamat="{{ $item->lokasiCod->alamat ?? '' }}"
                                                            title="Assign Petugas">
                                                        <i class="fas fa-user-tie"></i>
                                                    </button>
                                                    @endif
                                                    
                                                    <button class="btn btn-sm btn-outline-danger delete-btn"
                                                            data-id="{{ $item->id }}"
                                                            data-kode="{{ $item->kode_transaksi }}"
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="13" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-money-bill-wave fa-4x text-muted mb-4"></i>
                                                    <h4 class="text-muted">Belum ada transaksi tarik tunai</h4>
                                                    <p class="text-muted mb-4">Transaksi tarik tunai akan muncul di sini</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($tarikTunais->count() > 0)
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div class="text-muted">
                                    Menampilkan <strong>{{ $tarikTunais->count() }}</strong> transaksi
                                </div>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mr-1" disabled>
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" disabled>
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Assign Petugas Single -->
<div class="modal fade" id="assignSingleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-tie mr-2"></i> Assign Petugas
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="assignSingleForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="assign_tarik_tunai_id" name="tarik_tunai_id">
                    
                    <!-- Informasi Transaksi -->
                    <div class="alert alert-light border mb-3">
                        <h6 class="mb-2"><i class="fas fa-receipt mr-2 text-primary"></i>Detail Transaksi</h6>
                        <p class="mb-1"><strong>Kode:</strong> <span id="assignKode"></span></p>
                        <p class="mb-0"><strong>Jumlah:</strong> <span id="assignJumlah"></span></p>
                    </div>
                    
                    <!-- Informasi Lokasi -->
                    <div class="alert alert-light border mb-3">
                        <h6 class="mb-2"><i class="fas fa-map-marker-alt mr-2 text-danger"></i>Lokasi Penyerahan</h6>
                        <p class="mb-1"><strong>Lokasi:</strong> <span id="assignLokasi"></span></p>
                        <p class="mb-0"><small class="text-muted" id="assignAlamat"></small></p>
                    </div>
                    
                    <!-- Form Assign -->
                    <div class="form-group">
                        <label><i class="fas fa-user-tie mr-1"></i> Pilih Petugas:</label>
                        <select name="petugas_id" class="form-control" required>
                            <option value="">-- Pilih Petugas --</option>
                            @foreach($petugasList ?? [] as $petugas)
                            <option value="{{ $petugas->id }}">{{ $petugas->nama }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Petugas akan melakukan penyerahan uang di lokasi yang ditentukan</small>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        Status transaksi akan berubah menjadi "Diproses" setelah petugas ditugaskan
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Assign Petugas</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Bulk Assign -->
<div class="modal fade" id="bulkAssignModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-users mr-2"></i> Bulk Assign Petugas
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="bulkAssignForm" method="POST" action="{{ route('admin.tariktunai.bulk-assign') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Petugas:</label>
                        <select name="petugas_id" class="form-control" required>
                            <option value="">-- Pilih Petugas --</option>
                            @foreach($petugasList ?? [] as $petugas)
                            <option value="{{ $petugas->id }}">{{ $petugas->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Hanya transaksi dengan status "Menunggu Verifikasi" dan sudah ada bukti pembayaran yang akan di-assign
                    </div>
                    <div id="selectedTransactions" class="mt-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Assign Semua</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-trash mr-2"></i> Hapus Transaksi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus transaksi <strong id="deleteKode"></strong>?</p>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Aksi ini tidak dapat dibatalkan!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
</div>
</div>

<!-- Modal View Bukti Bayar -->
<div class="modal fade" id="viewBuktiModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewBuktiModalLabel">
                    <i class="fas fa-file-invoice-dollar mr-2"></i>Bukti Pembayaran
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="viewBuktiImage" src="" alt="Bukti Pembayaran" 
                     class="img-fluid rounded" style="max-height: 500px;">
                <div id="viewBuktiInfo" class="mt-3 text-left">
                    <h6 id="viewBuktiTitle" class="font-weight-bold text-primary"></h6>
                    <p class="text-muted mb-0">
                        <i class="far fa-clock mr-2"></i>
                        Diupload pada: <span id="viewBuktiTimestamp"></span>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <a href="#" id="downloadBuktiLink" class="btn btn-success" download>
                    <i class="fas fa-download mr-1"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Verifikasi Bukti -->
<div class="modal fade" id="verifyBuktiModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle mr-2"></i> Verifikasi Bukti Pembayaran
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="verifyBuktiForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="verify_tarik_tunai_id" name="tarik_tunai_id">
                    
                    <div class="text-center mb-3">
                        <img id="previewBukti" src="" alt="Bukti Pembayaran" 
                             class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                    
                    <div class="form-group">
                        <label>Status Verifikasi:</label>
                        <select name="status_verifikasi" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Catatan Verifikasi:</label>
                        <textarea name="catatan_verifikasi" class="form-control" rows="3" 
                                  placeholder="Masukkan catatan verifikasi..." id="catatanVerifikasi" required></textarea>
                        <small class="text-muted">Wajib diisi untuk semua status</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
                </div>
            </form>
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
        --location-gradient: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
    }

    .card-outline {
        border-top: 4px solid;
        border-radius: 12px;
        box-shadow: 0 6px 25px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        margin-bottom: 25px;
        overflow: hidden;
    }

    .card-outline.card-primary { border-top-color: #667eea; }
    .card-outline.card-info { border-top-color: #4facfe; }
    
/* Card Styling */
.card {
    border-radius: 12px;
    overflow: hidden;
}

.card-body {
    padding: 1.5rem;
}

/* Icon Styling */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.rounded-circle {
    border-radius: 50% !important;
}

/* Button Styling */
.btn {
    border-radius: 8px;
    font-weight: 500;
    padding: 8px 16px;
    font-size: 14px;
    transition: all 0.2s ease;
    border: none;
}

.btn-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
}

.btn-success {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    border: none;
}

.btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(67, 233, 123, 0.25);
}

.btn-outline-secondary {
    border: 1px solid #e2e8f0;
    color: #64748b;
    background: transparent;
}

.btn-outline-secondary:hover {
    background-color: #f8fafc;
    border-color: #cbd5e1;
}

/* Badge on Filter Button */
.badge {
    font-size: 11px;
    padding: 2px 6px;
    margin-left: 4px;
}

/* Filter Section */
.filter-section {
    transition: all 0.3s ease;
}

.border-top {
    border-top: 1px solid #e2e8f0 !important;
}

/* Form Controls */
.form-label {
    font-weight: 500;
    margin-bottom: 6px;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 8px 12px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
}

.form-control-sm {
    padding: 6px 10px;
    font-size: 13px;
}

/* Input Groups */
.input-group-text {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-right: 0;
    color: #64748b;
}

.input-group .form-control {
    border-left: 0;
}

.input-group .form-control:focus {
    border-color: #667eea;
}

/* Text Styling */
.font-weight-semibold {
    font-weight: 600;
}

.small {
    font-size: 13px;
}

.text-muted {
    color: #64748b !important;
}

/* Spacing Utilities */
.mb-4 {
    margin-bottom: 1.5rem !important;
}

.mt-4 {
    margin-top: 1.5rem !important;
}

.mt-3 {
    margin-top: 1rem !important;
}

.pt-4 {
    padding-top: 1.5rem !important;
}

/* Gap Utilities */
.gap-2 {
    gap: 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 8px;
    }
    
    .gap-2 {
        gap: 6px;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
    }
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
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }

    .bg-gradient-primary { background: var(--primary-gradient); }
    .bg-gradient-success { background: var(--success-gradient); }
    .bg-gradient-warning { background: var(--warning-gradient); }
    .bg-gradient-danger { background: var(--danger-gradient); }
    .bg-gradient-info { background: var(--info-gradient); }

    .table-hover tbody tr {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .table-hover tbody tr:hover {
        background: linear-gradient(90deg, rgba(102,126,234,0.05) 0%, rgba(118,75,162,0.05) 100%);
        transform: translateX(5px);
        border-left: 3px solid #667eea;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .badge-purple {
        background: linear-gradient(135deg, #8a2be2 0%, #da70d6 100%);
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
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .btn-outline-primary {
        border: 2px solid #667eea;
        color: #667eea;
        background: transparent;
    }

    .btn-outline-primary:hover {
        background: var(--primary-gradient);
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

    .avatar-placeholder {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .empty-state {
        padding: 50px 30px;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        opacity: 0.3;
        transition: all 0.3s ease;
    }

    .empty-state:hover i {
        opacity: 0.5;
        transform: scale(1.1);
    }

    /* Custom checkbox */
    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .form-check-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    /* Status badge animation */
    .badge-pill {
        animation: badgePulse 2s infinite;
    }

    @keyframes badgePulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    /* Thumbnail style */
    .thumbnail-container {
        width: 40px;
        height: 40px;
        overflow: hidden;
        border-radius: 5px;
        border: 2px solid;
        margin: 0 auto;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .thumbnail-container:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .thumbnail-container.border-info { border-color: #17a2b8; }
    .thumbnail-container.border-success { border-color: #28a745; }

    /* Responsive */
    @media (max-width: 768px) {
        .btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .btn-group .btn {
            margin: 2px;
            min-width: 40px;
        }
        
        .table td, .table th {
            padding: 6px;
            font-size: 12px;
        }
        
        #tarikTunaiTable {
            display: block;
            overflow-x: auto;
        }
        
        .badge-pill {
            font-size: 10px;
            padding: 4px 8px;
        }
        
        .thumbnail-container {
            width: 30px;
            height: 30px;
        }
    }
</style>

@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Toggle Filter Section
        $('#filterBtn').click(function() {
            $('#filterSection').slideToggle();
        });

        // Select All Checkbox
        $('#selectAll').change(function() {
            $('.select-checkbox:not(:disabled)').prop('checked', this.checked);
            updateBulkButton();
        });

        // Individual Checkbox
        $('.select-checkbox').change(function() {
            updateBulkButton();
            if (!this.checked) {
                $('#selectAll').prop('checked', false);
            }
        });

        // Update Bulk Assign Button
        function updateBulkButton() {
            const checkedCount = $('.select-checkbox:checked').length;
            const bulkBtn = $('#bulkAssignBtn');
            
            if (checkedCount > 0) {
                bulkBtn.removeClass('btn-info').addClass('btn-primary');
                bulkBtn.html(`<i class="fas fa-users mr-2"></i>Bulk Assign (${checkedCount})`);
            } else {
                bulkBtn.removeClass('btn-primary').addClass('btn-info');
                bulkBtn.html(`<i class="fas fa-users mr-2"></i>Bulk Assign`);
            }
        }

        // View Bukti Bayar
        $(document).on('click', '.view-bukti-customer-btn', function() {
            const url = $(this).data('url');
            const waktu = $(this).data('waktu');
            const judul = $(this).data('judul');
            
            $('#viewBuktiImage').attr('src', url);
            $('#viewBuktiTitle').text(judul);
            $('#viewBuktiTimestamp').text(waktu);
            $('#downloadBuktiLink').attr('href', url);
            $('#viewBuktiModalLabel').html(`<i class="fas fa-file-invoice-dollar mr-2"></i>${judul}`);
            
            $('#viewBuktiModal').modal('show');
        });

        // View Bukti Serah Terima
        $(document).on('click', '.view-bukti-petugas-btn', function() {
            const url = $(this).data('url');
            const waktu = $(this).data('waktu');
            const judul = $(this).data('judul');
            
            $('#viewBuktiImage').attr('src', url);
            $('#viewBuktiTitle').text(judul);
            $('#viewBuktiTimestamp').text(waktu);
            $('#downloadBuktiLink').attr('href', url);
            $('#viewBuktiModalLabel').html(`<i class="fas fa-handshake mr-2"></i>${judul}`);
            
            $('#viewBuktiModal').modal('show');
        });

        // Verifikasi Bukti
        $(document).on('click', '.verify-bukti-btn', function() {
            const id = $(this).data('id');
            const kode = $(this).data('kode');
            const row = $(`tr[data-id="${id}"]`);
            const thumbnail = row.find('.view-bukti-customer-btn img');
            const imageUrl = thumbnail.attr('src');
            
            $('#verify_tarik_tunai_id').val(id);
            $('#previewBukti').attr('src', imageUrl);
            $('#verifyBuktiForm').attr('action', `/admin/tarik-tunai/${id}/verifikasi-bukti`);
            $('#catatanVerifikasi').val('');
            
            $('#verifyBuktiModal').modal('show');
        });

        // Validasi form verifikasi
        $('#verifyBuktiForm').submit(function(e) {
            const status = $('select[name="status_verifikasi"]').val();
            const catatan = $('#catatanVerifikasi').val();
            
            if (!status || !catatan.trim()) {
                e.preventDefault();
                Swal.fire({
                    title: 'Peringatan!',
                    text: 'Harap isi semua field yang diperlukan',
                    icon: 'warning',
                    confirmButtonColor: '#667eea'
                });
            }
        });

        // Single Assign Button
        $('.assign-single-btn').click(function() {
            const id = $(this).data('id');
            const kode = $(this).data('kode');
            const lokasi = $(this).data('lokasi');
            const alamat = $(this).data('alamat');
            const row = $(`tr[data-id="${id}"]`);
            const jumlah = row.find('td:nth-child(4) .badge').text().trim();
            
            $('#assign_tarik_tunai_id').val(id);
            $('#assignKode').text(kode);
            $('#assignJumlah').text(jumlah);
            $('#assignLokasi').text(lokasi);
            $('#assignAlamat').text(alamat);
            
            // Update form action
            $('#assignSingleForm').attr('action', `/admin/tarik-tunai/${id}/assign`);
            
            $('#assignSingleModal').modal('show');
        });

        // Bulk Assign Button
        $('#bulkAssignBtn').click(function() {
            const selectedIds = [];
            $('.select-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    title: 'Peringatan!',
                    text: 'Pilih setidaknya satu transaksi untuk di-assign',
                    icon: 'warning',
                    confirmButtonColor: '#667eea'
                });
                return;
            }

            // Filter hanya transaksi yang bisa di-assign
            const assignableIds = [];
            selectedIds.forEach(id => {
                const row = $(`tr[data-id="${id}"]`);
                const status = row.data('status');
                const hasBukti = row.find('.view-bukti-customer-btn').length > 0;
                
                if (status === 'menunggu_verifikasi_admin' && hasBukti) {
                    assignableIds.push(id);
                }
            });

            if (assignableIds.length === 0) {
                Swal.fire({
                    title: 'Tidak dapat di-assign!',
                    text: 'Tidak ada transaksi yang memenuhi syarat untuk di-assign',
                    icon: 'warning',
                    confirmButtonColor: '#667eea'
                });
                return;
            }

            // Update form
            const container = $('#selectedTransactions');
            
            container.html(`
                <label>Transaksi Terpilih (${assignableIds.length}):</label>
                <div class="selected-list">
                    ${assignableIds.map(id => {
                        const row = $(`tr[data-id="${id}"]`);
                        const kode = row.find('td:nth-child(2) strong').text();
                        const status = row.data('status');
                        const lokasi = row.find('td:nth-child(9) strong').text();
                        return `
                            <div class="alert alert-light d-flex justify-content-between align-items-center mb-2">
                                <span>
                                    <i class="fas fa-receipt mr-2 text-primary"></i>
                                    ${kode}
                                    <span class="badge badge-primary ml-2">${status}</span>
                                    <small class="d-block text-muted">
                                        <i class="fas fa-map-marker-alt mr-1"></i>${lokasi}
                                    </small>
                                </span>
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        `;
                    }).join('')}
                </div>
                <input type="hidden" name="tarik_tunai_ids[]" value="${assignableIds.join(',')}">
            `);

            $('#bulkAssignModal').modal('show');
        });

        // Delete Button
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            const kode = $(this).data('kode');
            
            $('#deleteKode').text(kode);
            $('#deleteForm').attr('action', `/admin/tarik-tunai/${id}`);
            $('#deleteModal').modal('show');
        });

        // Form Submit Handler
        $('#assignSingleForm').submit(function(e) {
            e.preventDefault();
            const form = $(this);
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                beforeSend: function() {
                    form.find('button[type="submit"]').prop('disabled', true).html(`
                        <span class="spinner-border spinner-border-sm mr-1"></span>
                        Processing...
                    `);
                },
                success: function(response) {
                    showNotification('success', response.success || 'Petugas berhasil ditugaskan');
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr) {
                    form.find('button[type="submit"]').prop('disabled', false).html('Assign Petugas');
                    showNotification('error', xhr.responseJSON?.message || 'Terjadi kesalahan');
                }
            });
        });

        // Search Functionality
        $('#searchTable').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $('#tarikTunaiTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Initialize tooltips
        $('[title]').tooltip();

        // Notification Function
        window.showNotification = function(type, message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({ icon: type, title: message });
        };
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterToggleBtn = document.getElementById('filterToggleBtn');
    const filterSection = document.getElementById('filterSection');
    const activeFilterCount = document.getElementById('activeFilterCount');
    const formInputs = document.querySelectorAll('#filterSection input, #filterSection select');
    
    // Count active filters
    function countActiveFilters() {
        let count = 0;
        formInputs.forEach(input => {
            if (input.type === 'text' && input.value.trim() !== '') {
                count++;
            } else if (input.type === 'date' && input.value !== '') {
                count++;
            } else if (input.type === 'select-one' && input.value !== '') {
                count++;
            }
        });
        return count;
    }
    
    // Update filter count badge
    function updateFilterCount() {
        const count = countActiveFilters();
        activeFilterCount.textContent = count;
        if (count > 0) {
            activeFilterCount.style.display = 'inline-block';
        } else {
            activeFilterCount.style.display = 'none';
        }
    }
    
    // Toggle filter section
    filterToggleBtn.addEventListener('click', function() {
        const isVisible = filterSection.style.display === 'block';
        filterSection.style.display = isVisible ? 'none' : 'block';
        
        // Change button icon
        const icon = this.querySelector('i');
        if (isVisible) {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-filter');
        } else {
            icon.classList.remove('fa-filter');
            icon.classList.add('fa-times');
        }
    });
    
    // Update filter count on page load
    updateFilterCount();
    
    // Update filter count when inputs change
    formInputs.forEach(input => {
        input.addEventListener('change', updateFilterCount);
        input.addEventListener('input', updateFilterCount);
    });
    
    // Bulk Assign functionality
    const bulkAssignBtn = document.getElementById('bulkAssignBtn');
    if (bulkAssignBtn) {
        bulkAssignBtn.addEventListener('click', function() {
            // Implement bulk assign logic here
            alert('Bulk assign functionality would be implemented here');
        });
    }
});
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection