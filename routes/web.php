<?php

use App\Http\Controllers\DokterController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\JadwalPraktekController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PeralatanController;
use Illuminate\Support\Facades\Auth;




// Home Route
Route::get('/', function () {
    return view('dashboard');
});

// Authentication Routes
Auth::routes();

// Home route after login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Dashboard (accessible by admin only)
Route::get('/admin', function () {
    $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    $visits = [120, 150, 180, 130, 170, 200, 220, 210, 190, 230, 240, 250];

    return view('admin-home', compact('months', 'visits'));
})->middleware(['auth', 'role:admin'])->name('admin-home');



Route::get('/notifikasi', function () {
    $notifications = auth()->user()->notifications;
    return view('notifikasi.index', compact('notifications'));
})->name('notifikasi.index');
Route::get('/notifications/{id}', function() {

});

Route::get('/home-dokter', [KunjunganController::class, 'dashboard'])->middleware(['auth', 'role:dokter'])->name('home-dokter');

// Routes accessible by both admin and dokter
Route::middleware('auth')->group(function () {
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('rekam_medis', RekamMedisController::class);
    Route::resource('kunjungan', KunjunganController::class);
    Route::get('/rekam-medis/{id}/nota', [RekamMedisController::class, 'nota'])->name('rekam_medis.nota');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('dokter', DokterController::class);
    // Route::resource('pasien', PasienController::class);
    Route::resource('rekam_medis', RekamMedisController::class);
    Route::resource('obat', ObatController::class);
    Route::resource('peralatan', PeralatanController::class);
});

// Admin-only routes
Route::middleware(['auth', 'role:dokter|admin'])->group(function () {
    Route::resource('dokter', DokterController::class);
    Route::resource('jadwal_praktek', JadwalPraktekController::class);

});

// Dokter-only routes (accessible only by users with the 'dokter' role)
Route::middleware(['auth', 'role:dokter|admin'])->group(function () {
    Route::resource('resep', ResepController::class);
    // Route::resource('kunjungan', KunjunganController::class);
    Route::resource('jadwal_praktek', JadwalPraktekController::class);
    Route::resource('obat', ObatController::class);
    Route::resource('resep', ResepController::class);
    Route::resource('rekam_medis', RekamMedisController::class);


});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
