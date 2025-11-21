<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\UmkmController;
use App\Http\Controllers\Frontend\BeritaController;
use App\Http\Controllers\Frontend\StrukturOrganisasiController;
use App\Http\Controllers\Frontend\DemografiController;
use App\Http\Controllers\Frontend\InfografisController;
use App\Http\Controllers\Frontend\PpidController;
use App\Http\Controllers\Frontend\ApbdesController;
use App\Http\Controllers\Frontend\ProfilDesaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Frontend\TestUmkmController;

/*
|--------------------------------------------------------------------------
| Web Routes - Frontend Public Website Desa
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard redirect to UMKM dashboard
Route::get('/dashboard', function () {
    return redirect()->route('umkm.dashboard');
})->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Test Bootstrap Route
Route::view('/test-bootstrap', 'test-bootstrap')->name('test.bootstrap');

/*
|--------------------------------------------------------------------------
| STATIC PAGES ROUTES - Halaman Statis
|--------------------------------------------------------------------------
*/
// Route::view('/profil-desa', 'frontend.profil-desa.index')->name('profil-desa.index'); // Commented out - conflict with ProfilDesaController
Route::get('/infografis', [InfografisController::class, 'index'])->name('infografis.index');
Route::get('/infografis/data', [InfografisController::class, 'getData'])->name('infografis.data');

/*
|--------------------------------------------------------------------------
| APBDes ROUTES - Anggaran Pendapatan dan Belanja Desa
|--------------------------------------------------------------------------
*/
Route::prefix('apbdes')->name('frontend.apbdes.')->group(function () {
    Route::get('/', [ApbdesController::class, 'index'])->name('index');
    Route::get('/{id}', [ApbdesController::class, 'show'])->name('show');
});

// Backward compatibility - redirect old route
Route::get('/belanja', function () {
    return redirect()->route('frontend.apbdes.index');
})->name('belanja.index');

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
| PROFIL DESA ROUTES - Informasi Profil Desa
|--------------------------------------------------------------------------
*/
Route::prefix('profil-desa')->name('profil-desa.')->group(function () {
    Route::get('/', [ProfilDesaController::class, 'index'])->name('index');
    Route::get('/visi-misi', [ProfilDesaController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/struktur-organisasi', [ProfilDesaController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
    Route::get('/potensi-desa', [ProfilDesaController::class, 'potensiDesa'])->name('potensi-desa');
    Route::get('/peta-desa', [ProfilDesaController::class, 'petaDesa'])->name('peta-desa');
});

/*
|--------------------------------------------------------------------------
| UMKM ROUTES - Usaha Mikro Kecil Menengah
|--------------------------------------------------------------------------
*/
Route::prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/', [UmkmController::class, 'index'])->name('index');
    Route::get('/dashboard', [UmkmController::class, 'dashboard'])->name('dashboard');
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

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
