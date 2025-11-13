<?php

use App\Http\Controllers\BelanjaDesaController;
use App\Http\Controllers\BeritaDesaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IDMDesaController;
use App\Http\Controllers\InfografisController;
use App\Http\Controllers\ListingDesaController;
use App\Http\Controllers\PPIDDesaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileDesaController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil-desa', [ProfileDesaController::class, 'index'])->name('profil_desa');
Route::get('/Belanja', [BelanjaDesaController::class, 'index'])->name('Belanja');
Route::get('/Berita', [BeritaDesaController::class, 'index'])->name('Berita');
Route::get('/IDM', [IDMDesaController::class, 'index'])->name('IDM');
Route::get('/Listing', [ListingDesaController::class, 'index'])->name('Listing');
Route::get('/PPID', [PPIDDesaController::class, 'index'])->name('PPID');
Route::get('Infografis',[InfografisController::class, 'index'])->name('Infografis');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';