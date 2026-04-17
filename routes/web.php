<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Peminjam\PeminjamController;
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Middleware\EnsurePetugas;
use App\Http\Middleware\EnsurePeminjam;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin routes protected by EnsureAdmin middleware
Route::prefix('admin')->middleware([EnsureAdmin::class])->name('admin.')->group(function(){
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('devices', DeviceController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('loans', LoanController::class);
    Route::resource('returns', ReturnController::class);
    Route::post('loans/{loan}/approve', [LoanController::class,'approve'])->name('loans.approve');
    Route::post('loans/{loan}/reject', [LoanController::class,'reject'])->name('loans.reject');
    Route::post('loans/{loan}/return', [LoanController::class,'markReturned'])->name('loans.return');
    Route::get('logs', [ActivityLogController::class,'index'])->name('activity_logs.index');
    Route::get('logs/export/pdf', [ActivityLogController::class,'exportPdf'])->name('activity_logs.export.pdf');
});

Route::prefix('petugas')->middleware([EnsurePetugas::class])->name('petugas.')->group(function () {
    Route::get('/', [PetugasController::class, 'dashboard'])->name('dashboard');
    Route::get('/persetujuan-peminjaman', [PetugasController::class, 'approvals'])->name('approvals');
    Route::get('/pantau-pengembalian', [PetugasController::class, 'returns'])->name('returns');
    Route::get('/pantau-pengembalian/{loan}', [LoanController::class, 'returnForm'])->name('returns.form');
    Route::get('/pantau-pengembalian/{loan}/pelunasan', [LoanController::class, 'paymentForm'])->name('returns.payment.form');
    Route::get('/cetak-laporan', [PetugasController::class, 'report'])->name('report');
});

Route::prefix('peminjam')->middleware([EnsurePeminjam::class])->name('peminjam.')->group(function () {
    Route::get('/', [PeminjamController::class, 'dashboard'])->name('dashboard');
    Route::get('/daftar-alat', [PeminjamController::class, 'devices'])->name('devices');
    Route::get('/ajukan-peminjaman', [PeminjamController::class, 'createLoan'])->name('loans.create');
    Route::get('/riwayat-peminjaman', [PeminjamController::class, 'loanHistory'])->name('loans.history');
    Route::get('/pengembalian-alat', [PeminjamController::class, 'returns'])->name('returns');
    Route::get('/pengembalian-alat/{loan}', [LoanController::class, 'returnForm'])->name('returns.form');
});

// Public/Authenticated loan routes (for peminjam and petugas)
Route::middleware(['auth'])->group(function(){
    Route::get('/devices', [DeviceController::class,'index'])->name('devices.list');
    Route::get('/loans', [LoanController::class,'index'])->name('loans.index');
    Route::get('/loans/create', [LoanController::class,'create'])->name('loans.create');
    Route::post('/loans', [LoanController::class,'store'])->name('loans.store');
    Route::post('/loans/{loan}/approve', [LoanController::class,'approve'])->name('loans.approve');
    Route::post('/loans/{loan}/reject', [LoanController::class,'reject'])->name('loans.reject');
    Route::post('/loans/{loan}/return', [LoanController::class,'markReturned'])->name('loans.return');
    Route::post('/loans/{loan}/settle-payment', [LoanController::class,'settlePayment'])->name('loans.settle-payment');
});
