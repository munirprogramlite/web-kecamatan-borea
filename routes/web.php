<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UmkmController as AdminUmkmController;
use App\Http\Controllers\Admin\WisataController as AdminWisataController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\WisataController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\WargaController;
use App\Http\Controllers\Admin\KomentarController as AdminKomentarController;


// =====================
// PUBLIK
// =====================

Route::get('/', fn () => redirect('/borea'));

Route::get('/borea', [KecamatanController::class, 'index'])->name('kecamatan.index');

// Dashboard: redirect sesuai peran
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->peran === 'admin') {
        return redirect('/admin');
    }
    return redirect('/borea');
})->middleware(['auth'])->name('dashboard');

// Halaman desa
Route::prefix('/borea/{desa}')->group(function () {
    Route::get('/', [DesaController::class, 'show'])->name('desa.beranda');
    Route::get('/profil', [DesaController::class, 'profil'])->name('desa.profil');
    Route::get('/kontak', [DesaController::class, 'kontak'])->name('desa.kontak');
    Route::get('/laporan', [DesaController::class, 'laporan'])->name('desa.laporan');
    Route::get('/berita', [DesaController::class, 'berita'])->name('desa.berita');
    Route::get('/berita/{slug}', [DesaController::class, 'beritaDetail'])->name('desa.berita.detail');

    Route::get('/umkm', [UmkmController::class, 'index'])->name('desa.umkm');
    Route::get('/umkm/{slug}', [UmkmController::class, 'show'])->name('desa.umkm.detail');

    Route::get('/wisata', [WisataController::class, 'index'])->name('desa.wisata');
    Route::get('/wisata/{slug}', [WisataController::class, 'show'])->name('desa.wisata.detail');
});

// Komentar (harus login)
Route::middleware('auth')->group(function () {
    Route::post('/komentar', [KomentarController::class, 'store'])->name('komentar.store');
    Route::delete('/komentar/{komentar}', [KomentarController::class, 'destroy'])->name('komentar.destroy');
});

// =====================
// PANEL ADMIN
// =====================

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // =====================
    // UMKM
    // =====================
    Route::get('/umkm', [AdminUmkmController::class, 'index'])->name('admin.umkm.index');
    Route::get('/umkm/create', [AdminUmkmController::class, 'create'])->name('admin.umkm.create');
    Route::post('/umkm', [AdminUmkmController::class, 'store'])->name('admin.umkm.store');
    Route::get('/umkm/{umkm}/edit', [AdminUmkmController::class, 'edit'])->name('admin.umkm.edit');
    Route::put('/umkm/{umkm}', [AdminUmkmController::class, 'update'])->name('admin.umkm.update');
    Route::patch('/umkm/{umkm}/toggle', [AdminUmkmController::class, 'toggle'])->name('admin.umkm.toggle');

    // =====================
    // WISATA
    // =====================
    Route::get('/wisata', [AdminWisataController::class, 'index'])->name('admin.wisata.index');
    Route::get('/wisata/create', [AdminWisataController::class, 'create'])->name('admin.wisata.create');
    Route::post('/wisata', [AdminWisataController::class, 'store'])->name('admin.wisata.store');
    Route::get('/wisata/{wisata}/edit', [AdminWisataController::class, 'edit'])->name('admin.wisata.edit');
    Route::put('/wisata/{wisata}', [AdminWisataController::class, 'update'])->name('admin.wisata.update');
    Route::patch('/wisata/{wisata}/toggle', [AdminWisataController::class, 'toggle'])->name('admin.wisata.toggle');

        // Berita
    Route::get('/berita', [BeritaController::class, 'index'])->name('admin.berita.index');
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('admin.berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('admin.berita.store');
    Route::get('/berita/{berita}/edit', [BeritaController::class, 'edit'])->name('admin.berita.edit');
    Route::put('/berita/{berita}', [BeritaController::class, 'update'])->name('admin.berita.update');
    Route::delete('/berita/{berita}', [BeritaController::class, 'destroy'])->name('admin.berita.destroy');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/laporan/create', [LaporanController::class, 'create'])->name('admin.laporan.create');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('admin.laporan.store');
    Route::get('/laporan/{laporan}/edit', [LaporanController::class, 'edit'])->name('admin.laporan.edit');
    Route::put('/laporan/{laporan}', [LaporanController::class, 'update'])->name('admin.laporan.update');
    Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy'])->name('admin.laporan.destroy');

    Route::get('/warga', [WargaController::class, 'index'])->name('admin.warga.index');
    Route::get('/warga/create', [WargaController::class, 'create'])->name('admin.warga.create');
    Route::post('/warga', [WargaController::class, 'store'])->name('admin.warga.store');
    Route::get('/warga/{warga}/edit', [WargaController::class, 'edit'])->name('admin.warga.edit');
    Route::put('/warga/{warga}', [WargaController::class, 'update'])->name('admin.warga.update');
    Route::delete('/warga/{warga}', [WargaController::class, 'destroy'])->name('admin.warga.destroy');

    Route::get('/komentar', [AdminKomentarController::class, 'index'])->name('admin.komentar.index');
    Route::delete('/komentar/{komentar}', [AdminKomentarController::class, 'destroy'])->name('admin.komentar.destroy');
});

require __DIR__ . '/auth.php';