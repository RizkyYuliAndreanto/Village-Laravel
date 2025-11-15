<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProfilDesaController;
use App\Http\Controllers\Frontend\UmkmController;
use App\Http\Controllers\Frontend\BeritaController;
use App\Http\Controllers\Frontend\StrukturOrganisasiController;
use App\Http\Controllers\Frontend\DemografiController;
use App\Http\Controllers\Frontend\PpidController;
use App\Http\Controllers\Frontend\TestUmkmController;

/*
|--------------------------------------------------------------------------
| Web Routes - Frontend Public Website Desa
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('Profil-desa', [ProfilDesaController::class, 'index'])->name('Profil-desa.index');
/*
|--------------------------------------------------------------------------
| BERITA ROUTES - Berita dan Informasi Desa
|--------------------------------------------------------------------------
*/
Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('index');
    Route::get('/kategori/{kategori}', [BeritaController::class, 'kategori'])->name('kategori');
    Route::get('/arsip/{tahun}/{bulan?}', [BeritaController::class, 'arsip'])->name('arsip');
    Route::get('/{id}', [BeritaController::class, 'show'])->name('show');
});

// Berita API Routes
Route::prefix('api/berita')->name('api.berita.')->group(function () {
    Route::get('/terbaru/{limit?}', [BeritaController::class, 'terbaru'])->name('terbaru');
    Route::get('/populer/{limit?}', [BeritaController::class, 'populer'])->name('populer');
    Route::get('/search', [BeritaController::class, 'searchAjax'])->name('search');
    Route::get('/widget', [BeritaController::class, 'widget'])->name('widget');
});

/*
|--------------------------------------------------------------------------
| STRUKTUR ORGANISASI ROUTES - Pemerintahan Desa
|--------------------------------------------------------------------------
*/
Route::prefix('struktur-organisasi')->name('struktur.')->group(function () {
    Route::get('/', [StrukturOrganisasiController::class, 'index'])->name('index');
    Route::get('/divisi/{divisi}', [StrukturOrganisasiController::class, 'divisi'])->name('divisi');
    Route::get('/search', [StrukturOrganisasiController::class, 'search'])->name('search');
    Route::get('/{id}', [StrukturOrganisasiController::class, 'show'])->name('show');
});

// Struktur Organisasi API Routes
Route::prefix('api/struktur-organisasi')->name('api.struktur.')->group(function () {
    Route::get('/widget', [StrukturOrganisasiController::class, 'widget'])->name('widget');
    Route::get('/bagan', [StrukturOrganisasiController::class, 'bagan'])->name('bagan');
    Route::get('/kontak', [StrukturOrganisasiController::class, 'kontak'])->name('kontak');
});

/*
|--------------------------------------------------------------------------
| DEMOGRAFI & STATISTIK ROUTES - Data Kependudukan
|--------------------------------------------------------------------------
*/
Route::prefix('demografi')->name('demografi.')->group(function () {
    Route::get('/', [DemografiController::class, 'index'])->name('index');
    Route::get('/umum', [DemografiController::class, 'umum'])->name('umum');
    Route::get('/umur', [DemografiController::class, 'umur'])->name('umur');
    Route::get('/agama', [DemografiController::class, 'agama'])->name('agama');
    Route::get('/pekerjaan', [DemografiController::class, 'pekerjaan'])->name('pekerjaan');
    Route::get('/pendidikan', [DemografiController::class, 'pendidikan'])->name('pendidikan');
    Route::get('/perbandingan', [DemografiController::class, 'perbandingan'])->name('perbandingan');
});

// Demografi API Routes
Route::prefix('api/demografi')->name('api.demografi.')->group(function () {
    Route::get('/widget', [DemografiController::class, 'widget'])->name('widget');
    Route::get('/chart/{type}', [DemografiController::class, 'chart'])->name('chart');
});

/*
|--------------------------------------------------------------------------
| PPID ROUTES - Layanan Informasi Publik
|--------------------------------------------------------------------------
*/
Route::prefix('ppid')->name('ppid.')->group(function () {
    Route::get('/', [PpidController::class, 'index'])->name('index');
    Route::get('/jenis/{jenis}', [PpidController::class, 'jenis'])->name('jenis');
    Route::get('/kategori/{kategori}', [PpidController::class, 'kategori'])->name('kategori');
    Route::get('/arsip/{tahun}', [PpidController::class, 'arsip'])->name('arsip');
    Route::get('/download/{id}', [PpidController::class, 'download'])->name('download');
    Route::get('/{id}', [PpidController::class, 'show'])->name('show');
});

// PPID API Routes
Route::prefix('api/ppid')->name('api.ppid.')->group(function () {
    Route::get('/search', [PpidController::class, 'searchAjax'])->name('search');
    Route::get('/widget', [PpidController::class, 'widget'])->name('widget');
    Route::get('/statistik', [PpidController::class, 'statistik'])->name('statistik');
});



/*
|--------------------------------------------------------------------------
| UMKM ROUTES - Usaha Mikro Kecil Menengah
|--------------------------------------------------------------------------
*/
Route::prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/', [UmkmController::class, 'index'])->name('index');
    Route::get('/kategori/{kategori:slug}', [UmkmController::class, 'kategori'])->name('kategori');
    Route::get('/search-ajax', [UmkmController::class, 'searchAjax'])->name('search.ajax');
    Route::get('/{umkm:slug}', [UmkmController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| TESTING ROUTES - Hapus di Production
|--------------------------------------------------------------------------
*/
Route::get('/test-umkm', [TestUmkmController::class, 'testAll'])->name('test.umkm');
Route::get('/test-umkm-data', [TestUmkmController::class, 'testData'])->name('test.umkm.data');
