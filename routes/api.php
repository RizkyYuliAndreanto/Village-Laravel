<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UmkmController;
use App\Http\Controllers\Api\KategoriUmkmController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API Routes untuk Frontend
Route::prefix('v1')->group(function () {

    // Kategori UMKM Routes
    Route::prefix('kategori')->group(function () {
        Route::get('/', [KategoriUmkmController::class, 'index']); // GET /api/v1/kategori
        Route::get('/{id}', [KategoriUmkmController::class, 'show']); // GET /api/v1/kategori/{id}
        Route::get('/{id}/umkm', [KategoriUmkmController::class, 'getUmkmByKategori']); // GET /api/v1/kategori/{id}/umkm
    });

    // UMKM Routes
    Route::prefix('umkm')->group(function () {
        Route::get('/', [UmkmController::class, 'index']); // GET /api/v1/umkm
        Route::get('/{id}', [UmkmController::class, 'show']); // GET /api/v1/umkm/{id}
        Route::get('/search/{query}', [UmkmController::class, 'search']); // GET /api/v1/umkm/search/{query}
    });

    // Dashboard & Statistics Routes
    Route::prefix('dashboard')->group(function () {
        Route::get('/stats', [UmkmController::class, 'getStats']); // GET /api/v1/dashboard/stats
        Route::get('/chart-data', [UmkmController::class, 'getChartData']); // GET /api/v1/dashboard/chart-data
        Route::get('/trend-data', [UmkmController::class, 'getTrendData']); // GET /api/v1/dashboard/trend-data
    });

    // Location-based Routes
    Route::prefix('location')->group(function () {
        Route::get('/dusun', [UmkmController::class, 'getByDusun']); // GET /api/v1/location/dusun
        Route::get('/dusun/{dusun}', [UmkmController::class, 'getUmkmByDusun']); // GET /api/v1/location/dusun/{dusun}
    });
});
