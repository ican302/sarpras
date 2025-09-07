<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TanahController;
use App\Http\Controllers\SaranaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BangunanController;
use App\Http\Controllers\StrukturController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PrasaranaController;
use App\Http\Controllers\TransaksiController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/pengguna', [AdminController::class, 'pengguna'])->name('admin.pengguna');
    Route::post('/admin/pengguna', [AdminController::class, 'simpanPengguna'])->name('admin.pengguna.tambah');
    Route::post('/admin/pengguna/{id}', [AdminController::class, 'editPengguna'])->name('admin.pengguna.edit');
    Route::delete('/admin/pengguna/{id}', [AdminController::class, 'hapusPengguna'])->name('admin.pengguna.hapus');
    // Route::get('/admin/struktur', [StrukturController::class, 'index'])->name('struktur.index');
    // Route::post('/admin/struktur', [StrukturController::class, 'store'])->name('struktur.store');
    // Route::post('/admin/struktur/{id}', [StrukturController::class, 'update'])->name('struktur.update');
    // Route::delete('/admin/struktur/{id}', [StrukturController::class, 'destroy'])->name('struktur.destroy');
    Route::get('/admin/visimisi', [AdminController::class, 'visimisi'])->name('admin.visimisi');
    Route::post('/admin/visimisi/update', [AdminController::class, 'updateVisiMisi'])->name('admin.visimisi.update');
});

Route::middleware(['auth', 'role:User'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});

Route::get('/sarana', [SaranaController::class, 'index'])->name('sarana.index');
Route::post('/sarana', [SaranaController::class, 'store'])->name('sarana.store');
Route::put('/sarana/{sarana}', [SaranaController::class, 'update'])->name('sarana.update');
Route::delete('/sarana/{sarana}', [SaranaController::class, 'destroy'])->name('sarana.destroy');
Route::get('sarana/download-all', [SaranaController::class, 'downloadAllSarana'])->name('sarana.download.all');

Route::get('/prasarana', [PrasaranaController::class, 'index'])->name('prasarana.index');
Route::post('/bangunan', [BangunanController::class, 'store'])->name('bangunan.store');
Route::put('/bangunan/{bangunan}', [BangunanController::class, 'update'])->name('bangunan.update');
Route::delete('/bangunan/{bangunan}', [BangunanController::class, 'destroy'])->name('bangunan.destroy');
Route::get('bangunan/download-all', [BangunanController::class, 'downloadAllBangunan'])->name('bangunan.download.all');
Route::post('/tanah', [TanahController::class, 'store'])->name('tanah.store');
Route::put('/tanah/{tanah}', [TanahController::class, 'update'])->name('tanah.update');
Route::delete('/tanah/{tanah}', [TanahController::class, 'destroy'])->name('tanah.destroy');
Route::get('tanah/download-all', [TanahController::class, 'downloadAllTanah'])->name('tanah.download.all');

// Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
// Route::post('/get-snap-token', [TransaksiController::class, 'getSnapToken'])->name('get.snap.token');
// Route::post('/simpan-transaksi', [TransaksiController::class, 'simpanTransaksi'])->name('simpan.transaksi');
// Route::get('/pembayaran/sukses', [TransaksiController::class, 'sukses'])->name('pembayaran.sukses');
// Route::get('/transaksi/download/{id}', [TransaksiController::class, 'downloadTransaksi'])->name('transaksi.download');
// Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
// Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
// Route::get('transaksi/download-all', [TransaksiController::class, 'downloadAllTransaksi'])->name('transaksi.download.all');

// Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
// Route::get('laporan/download-all', [LaporanController::class, 'downloadAllLaporan'])->name('laporan.download.all');
// Route::get('/laporan/cetak-pdf', [LaporanController::class, 'cetakPdf'])->name('laporan.cetak.pdf');

// Route::get('/penyewaan', [PenyewaanController::class, 'index'])->name('penyewaan.index');
// Route::post('/penyewaan', [PenyewaanController::class, 'store'])->name('penyewaan.store');
// Route::put('/penyewaan/{penyewaan}', [PenyewaanController::class, 'update'])->name('penyewaan.update');
// Route::delete('/penyewaan/{penyewaan}', [PenyewaanController::class, 'destroy'])->name('penyewaan.destroy');

require __DIR__ . '/auth.php';
