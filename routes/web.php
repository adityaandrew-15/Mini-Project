<?php
use App\Http\Controllers\detailController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalPraktekController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\ResepController;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Home Route
Route::get('/', function () {
    return view('dashboard');
});

// Authentication Routes
Auth::routes();

// Home route after login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/rekam-medis/{id}/detail', [RekamMedisController::class, 'detail'])->name('rekam_medis.detail');
Route::get('kunjungan/{id}/detail', [KunjunganController::class, 'showDetail']);

// Admin Dashboard (accessible by admin only)
Route::get('/admin', function () {
    $kunjunganPerBulan = DB::table('kunjungans')
        ->select(DB::raw('MONTH(tanggal_kunjungan) as bulan'), DB::raw('COUNT(*) as jumlah'))
        ->groupBy('bulan')
        ->get();
    
    // Filter out kunjungan without a dokter_id
    $dokterKunjungan = \App\Models\Kunjungan::select('dokter_id', DB::raw('count(*) as total'))
        ->whereNotNull('dokter_id')  // Exclude records where dokter_id is null
        ->groupBy('dokter_id')
        ->with('dokter')  // Load related dokter data
        ->get();

    // Prepare data for the chart
    $dokterNames = $dokterKunjungan->map(function ($item) {
        return $item->dokter ? $item->dokter->nama : 'Unknown Doctor';  // Safely access the doctor's name
    });
    $kunjunganCounts = $dokterKunjungan->pluck('total');

    return view('admin-home', compact('kunjunganPerBulan', 'dokterKunjungan', 'dokterNames', 'kunjunganCounts'));
})->middleware(['auth', 'role:admin'])->name('admin-home');


Route::get('/notifikasi', function () {
    $notifications = auth()->user()->notifications;
    return view('notifikasi.index', compact('notifications'));
})->name('notifikasi.index');
Route::get('/notifications/{id}', function () {});

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

Route::get('/detail', [App\Http\Controllers\detailController::class, 'index'])->name('detail');
Route::get('/cek-rekam-medis/{kunjunganId}', [RekamMedisController::class, 'cekRekamMedis']);
Route::put('/rekam-medis/update/{id}', [RekamMedisController::class, 'update'])->name('rekam_medis.update');
Route::get('/riwayat', [App\Http\Controllers\riwayatController::class, 'index'])->name('riwayat');

Route::get('/kunj-history', [KunjunganController::class, 'kunjhistory'])->name('kunjhistory');
Route::get('/kunj-historyshow/{id}', [KunjunganController::class, 'kunjhistoryshow'])->name('kunjhistoryshow');
Route::post('/kunjungan/update-status/{id}', [KunjunganController::class, 'updateStatus'])->name('kunjungan.updateStatus');
Route::get('/pendingdetails/{id}', [KunjunganController::class, 'pendingdetails'])->name('pendingdetails');
Route::get('/pendingnota/{id}', [RekamMedisController::class, 'pendingnota'])->name('pendingnota');
Route::get('/homedetails/{id}', [HomeController::class, 'details'])->name('homedetails');

Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
Route::get('/listpasien', [HomeController::class, 'listpasien'])->name('listpasien');

Route::get('/konfirmasi/{id}', [KunjunganController::class, 'konfirmasiPembayaran'])->name('kunjungan.konfirmasi');
Route::post('/update-status/{id}', [KunjunganController::class, 'updateStatus'])->name('kunjungan.updateStatus');

Route::patch('/kunjungan/{kunjungan}/reject', [KunjunganController::class, 'reject'])->name('kunjungan.reject');

// Halaman kedua (page2)
