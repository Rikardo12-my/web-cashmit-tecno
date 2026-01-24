<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LokasiCodController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TarikTunaiController;
use App\Http\Controllers\CustomerTarikTunaiController;
use App\Http\Controllers\CustomerHistoryTarikTunaiController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PetugasTarikTunaiController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminTarikTunaiController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\PetugasHistoryTarikTunaiController;

// Landing page route
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/home', function () {
    return redirect()->route('landing');
});

//untuk login
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);

//untuk register
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [AuthController::class, 'register']);

//untuk google auth
Route::get('/auth-google-redirect', [AuthController::class, 'google_redirect']);
Route::get('/auth-google-callback', [AuthController::class, 'google_callback']);

//untuk verifikasi akun
Route::group(['middleware' => ['auth', 'check_role:customer']], function () {
    Route::get('/verify', [VerificationController::class, 'index']);
    Route::post('/verify', [VerificationController::class, 'store']);
    Route::get('/verify/{unique_id}', [VerificationController::class, 'show']);
    Route::put('/verify/{unique_id}', [VerificationController::class, 'update']);
});

// Admin Routes dengan middleware check_role:admin
Route::group(['middleware' => ['auth', 'check_role:admin']], function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    // Redirect customers to admin/users/customers
    Route::redirect('/customers', '/admin/users/customers')->name('customers');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        // Customer Management Routes
        Route::prefix('customer')->name('customer.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
            Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
            Route::get('/{customer}/activate', [CustomerController::class, 'activate'])->name('activate');
            Route::get('/{customer}/ban', [CustomerController::class, 'ban'])->name('ban');
            Route::get('/deleted/list', [CustomerController::class, 'deleted'])->name('deleted');
            Route::get('/{customer}/restore', [CustomerController::class, 'restore'])->name('restore');
            Route::delete('/{customer}/force-delete', [CustomerController::class, 'forceDelete'])->name('forceDelete');
            Route::get('/statistics', [CustomerController::class, 'statistics'])->name('statistics');
        });
        Route::prefix('petugas')->name('petugas.')->group(function () {
            // GET Routes
            Route::get('/', [PetugasController::class, 'index'])->name('index');
            Route::get('/create', [PetugasController::class, 'create'])->name('create');
            Route::get('/{id}/edit', [PetugasController::class, 'edit'])->name('edit');
            Route::get('/deleted/list', [PetugasController::class, 'deleted'])->name('deleted');

            // POST Routes
            Route::post('/', [PetugasController::class, 'store'])->name('store');

            // PUT/PATCH Routes
            Route::put('/{id}', [PetugasController::class, 'update'])->name('update');
            Route::put('/{id}/activate', [PetugasController::class, 'activate'])->name('activate');
            Route::put('/{id}/ban', [PetugasController::class, 'ban'])->name('ban');
            Route::put('/{petugas}/restore', [PetugasController::class, 'restore'])->name('restore'); // INI


            // DELETE Routes
            Route::delete('/{id}', [PetugasController::class, 'destroy'])->name('destroy');
            Route::delete('/{petugas}/force-delete', [PetugasController::class, 'forceDelete'])->name('forceDelete'); // INI

            // GET Routes lainnya
            Route::get('/{id}', [PetugasController::class, 'show'])->name('show');
            Route::get('/statistics', [PetugasController::class, 'statistics'])->name('statistics');
        });
        // Lokasi COD
        Route::prefix('lokasi-cod')->name('lokasi.')->group(function () {
            Route::get('/', [LokasiCodController::class, 'index'])->name('index');
            Route::post('/', [LokasiCodController::class, 'store'])->name('store');
            Route::put('/{id}', [LokasiCodController::class, 'update'])->name('update');
            Route::delete('/{id}', [LokasiCodController::class, 'destroy'])->name('destroy');
            Route::put('/toggle-status/{id}', [LokasiCodController::class, 'toggleStatus'])->name('toggle-status');
            Route::get('/statistik', [LokasiCodController::class, 'statistik'])->name('statistik');
        });

        // Payment Methods
        Route::prefix('payment')->name('payment.')->group(function () {
            Route::get('/', [PaymentMethodController::class, 'index'])->name('index');
            Route::post('/', [PaymentMethodController::class, 'store'])->name('store');
            Route::put('/{id}', [PaymentMethodController::class, 'update'])->name('update');
            Route::put('/toggle-status/{id}', [PaymentMethodController::class, 'toggleStatus'])->name('toggle-status');
            Route::delete('/{id}', [PaymentMethodController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('tarik-tunai')->name('tariktunai.')->group(function () {
    Route::get('/', [AdminTarikTunaiController::class, 'index'])->name('index');
    Route::get('/{tarikTunai}', [AdminTarikTunaiController::class, 'show'])->name('show');
    
    // Assign Petugas
    Route::post('/{tarikTunai}/assign', [AdminTarikTunaiController::class, 'assignPetugas'])->name('assign');
    Route::post('/bulk-assign', [AdminTarikTunaiController::class, 'bulkAssign'])->name('bulk-assign');
    
    // Status Management
    Route::post('/{tarikTunai}/status', [AdminTarikTunaiController::class, 'updateStatus'])->name('update-status');
    
    // Verifikasi Bukti Bayar
    Route::post('/{tarikTunai}/verifikasi-bukti', [AdminTarikTunaiController::class, 'verifikasiBuktiBayar'])
        ->name('verifikasi-bukti');
    
    // Biaya Admin
    Route::get('/{tarikTunai}/set-biaya', [AdminTarikTunaiController::class, 'setBiayaForm'])
        ->name('set-biaya-form');
    Route::post('/{tarikTunai}/set-biaya', [AdminTarikTunaiController::class, 'setBiayaAdmin'])
        ->name('set-biaya');
    
    // Export
    Route::get('/export/csv', [AdminTarikTunaiController::class, 'exportCsv'])->name('export');
    
    // View Bukti Bayar
    Route::get('/{tarikTunai}/view-bukti', [AdminTarikTunaiController::class, 'viewBukti'])
        ->name('view-bukti');
    
    // Delete
    Route::delete('/{tarikTunai}', [AdminTarikTunaiController::class, 'destroy'])->name('destroy');
});
    });
});

Route::group(['middleware' => ['auth', 'check_role:petugas']], function () {
    Route::get('/petugas/dashboard', [DashboardController::class, 'petugasDashboard'])->name('petugas/dashboard');

    Route::prefix('petugas/tariktunai')->name('petugas.tariktunai.')->group(function () {
    Route::get('/', [PetugasTarikTunaiController::class, 'index'])->name('index');
    Route::get('/{tarikTunai}', [PetugasTarikTunaiController::class, 'show'])->name('show');
    Route::put('/{tarikTunai}/status', [PetugasTarikTunaiController::class, 'updateStatus'])->name('update-status');
    Route::post('/{tarikTunai}/upload-bukti', [PetugasTarikTunaiController::class, 'uploadBukti'])->name('upload-bukti');
    Route::post('/{tarikTunai}/catatan', [PetugasTarikTunaiController::class, 'updateCatatan'])->name('update-catatan');
    Route::post('/{tarikTunai}/selesai', [PetugasTarikTunaiController::class, 'markAsSelesai'])->name('mark-selesai');
    Route::get('/{tarikTunai}/location-detail', [PetugasTarikTunaiController::class, 'getLocationDetail'])->name('location-detail');
    Route::get('/{tarikTunai}/download-qris', [PetugasTarikTunaiController::class, 'downloadQris'])->name('download-qris');
});
Route::prefix('petugas/history')->name('petugas.history.')->group(function () {
    Route::get('/', [PetugasHistoryTarikTunaiController::class, 'index'])->name('index');
});
});

//route yang hanya bisa diakses oleh customer
Route::group(['middleware' => ['auth', 'check_role:customer', 'check_status']], function () {
    Route::get('/customer/dashboard', [DashboardController::class, 'customerDashboard'])->name('customer/dashboard');
    Route::prefix('customer/tariktunai')->name('customer.tariktunai.')->group(function () {
        Route::get('/', [CustomerTarikTunaiController::class, 'index'])->name('index');
        Route::get('/create', [CustomerTarikTunaiController::class, 'create'])->name('create');
        Route::post('/', [CustomerTarikTunaiController::class, 'store'])->name('store');
        Route::get('/{tarikTunai}', [CustomerTarikTunaiController::class, 'show'])->name('show');
        Route::put('/{tarikTunai}/upload-bukti', [CustomerTarikTunaiController::class, 'uploadBukti'])->name('upload-bukti');
        Route::delete('/{tarikTunai}/cancel', [CustomerTarikTunaiController::class, 'cancel'])->name('cancel');
        Route::get('/qris/{id}', [CustomerTarikTunaiController::class, 'getQrisImage'])->name('get-qris');
        Route::get('/location/{id}', [CustomerTarikTunaiController::class, 'getLocationImage'])->name('get-location');
        Route::get('/{tarikTunai}/detail', [CustomerTarikTunaiController::class, 'getDetail'])->name('detail');
        Route::get('/api/qris/all', [CustomerTarikTunaiController::class, 'getAllQrisImages'])->name('api.qris.all');
    });
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [CustomerProfileController::class, 'index'])->name('index');
        Route::get('/edit', [CustomerProfileController::class, 'edit'])->name('edit');
        Route::post('/update-nama', [CustomerProfileController::class, 'updateNama'])->name('update-nama');
        Route::post('/upload-foto', [CustomerProfileController::class, 'uploadFoto'])->name('upload-foto');
        Route::post('/hapus-foto', [CustomerProfileController::class, 'hapusFoto'])->name('hapus-foto');
        Route::post('/update-password', [CustomerProfileController::class, 'updatePassword'])->name('update-password');
    });
    Route::prefix('history')->name('history.')->group(function () {
        // Main history page
        Route::get('/', [CustomerHistoryTarikTunaiController::class, 'index'])->name('index');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.post');
});
