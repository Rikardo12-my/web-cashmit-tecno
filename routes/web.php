<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\LokasiCodController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\TarikTunaiController;
use App\Http\Controllers\VerificationController;

Route::get('/', function () {
    return view('welcome');
});

//untuk login
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);

//untuk register
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [AuthController::class, 'register']);

//untuk google auth
Route::get('/auth-google-redirect',[AuthController::class, 'google_redirect']);
Route::get('/auth-google-callback',[AuthController::class, 'google_callback']);

//untuk verifikasi akun
Route::group(['middleware' => ['auth','check_role:customer']], function () {
    Route::get('/verify', [VerificationController::class, 'index']);
    Route::post('/verify', [VerificationController::class, 'store']);
    Route::get('/verify/{unique_id}', [VerificationController::class, 'show']);
    Route::put('/verify/{unique_id}', [VerificationController::class, 'update']);
});

// Admin Routes dengan middleware check_role:admin
Route::group(['middleware' => ['auth', 'check_role:admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Redirect customers to admin/users/customers
    Route::redirect('/customers', '/admin/users/customers')->name('customers');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/customers', [UserManagementController::class, 'listCustomer'])->name('customers');
            Route::get('/petugas', [UserManagementController::class, 'listPetugas'])->name('petugas');
            Route::get('/create', [UserManagementController::class, 'create'])->name('create');
            Route::post('/store', [UserManagementController::class, 'store'])->name('store');
            Route::post('/{id}/suspend', [UserManagementController::class, 'suspend'])->name('suspend');
            Route::post('/{id}/activate', [UserManagementController::class, 'activate'])->name('activate');
            Route::post('/{id}/change-role', [UserManagementController::class, 'changeRole'])->name('changeRole');
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

        // Tarik Tunai Routes
        Route::prefix('tarik-tunai')->name('tariktunai.')->group(function () {
            // Main Routes
            Route::get('/', [TarikTunaiController::class, 'index'])->name('index');
            Route::get('/create', [TarikTunaiController::class, 'create'])->name('create');
            Route::post('/', [TarikTunaiController::class, 'store'])->name('store');
            Route::get('/{id}', [TarikTunaiController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [TarikTunaiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [TarikTunaiController::class, 'update'])->name('update');
            Route::delete('/{id}', [TarikTunaiController::class, 'destroy'])->name('destroy');

            // Export Routes
            Route::get('/export/pdf', [TarikTunaiController::class, 'exportPDF'])->name('export.pdf');
            Route::get('/export/excel', [TarikTunaiController::class, 'exportExcel'])->name('export.excel');

            // Action Routes
            Route::post('/{id}/assign-petugas', [TarikTunaiController::class, 'assignPetugas'])->name('assign-petugas');
            Route::put('/{id}/update-status', [TarikTunaiController::class, 'updateStatus'])->name('update-status');
            Route::post('/{id}/upload-bukti', [TarikTunaiController::class, 'uploadBuktiSerahTerima'])->name('upload-bukti');
            Route::post('/batch-status', [TarikTunaiController::class, 'batchStatusUpdate'])->name('batch-status');

            // API Routes for AJAX
            Route::get('/api/payment-methods', [TarikTunaiController::class, 'getPaymentMethodsByCategory'])->name('api.payment-methods');
            Route::get('/api/cod-locations/{paymentMethodId}', [TarikTunaiController::class, 'getCodLocations'])->name('api.cod-locations');
        });
    });
});
//route yang hanya bisa diakses oleh petugas
Route::group(['middleware' => ['auth', 'check_role:petugas']], function () {

});
//route yang hanya bisa diakses oleh customer
Route::group(['middleware' => ['auth', 'check_role:customer', 'check_status']], function () {

});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});