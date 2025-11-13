<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileDesaController;
use App\Http\Controllers\BelanjaDesaController;
use App\Http\Controllers\BeritaDesaController;
use App\Http\Controllers\IDMDesaController;
use App\Http\Controllers\ListingDesaController;
use App\Http\Controllers\PPIDDesaController;
use App\Http\Controllers\InfografisController;

// ======== Halaman utama ========
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil-desa', [ProfileDesaController::class, 'index'])->name('profil_desa');
Route::get('/Belanja', [BelanjaDesaController::class, 'index'])->name('Belanja');
Route::get('/Berita', [BeritaDesaController::class, 'index'])->name('Berita');
Route::get('/IDM', [IDMDesaController::class, 'index'])->name('IDM');
Route::get('/Listing', [ListingDesaController::class, 'index'])->name('Listing');
Route::get('/PPID', [PPIDDesaController::class, 'index'])->name('PPID');

// ======== Grup Infografis ========
Route::prefix('/Infografis')->name('Infografis.')->group(function () {
    Route::get('/', [InfografisController::class, 'index'])->name('index');
    Route::get('/apbdes', [InfografisController::class, 'apbdes'])->name('apbdes');
    Route::get('/stunting', [InfografisController::class, 'stunting'])->name('stunting');
    Route::get('/bansos', [InfografisController::class, 'bansos'])->name('bansos');
    Route::get('/sdgs', [InfografisController::class, 'sdg'])->name('sdg');
});

// ======== Dashboard & Auth ========
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
