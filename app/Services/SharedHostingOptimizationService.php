<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Shared Hosting Performance Optimization Service
 * Optimized untuk environment shared hosting tanpa Redis/background workers
 */
class SharedHostingOptimizationService
{
    /**
     * Setup shared hosting optimizations
     */
    public function setupSharedHostingOptimizations(): void
    {
        // Configure untuk file-based caching
        Config::set('cache.default', 'file');
        Config::set('session.driver', 'file');
        Config::set('queue.default', 'sync');

        // Setup optimized file cache
        $this->setupFileCaching();
    }

    /**
     * Setup file-based caching strategy
     */
    protected function setupFileCaching(): void
    {
        // Ensure cache directories exist
        $cacheDirectories = [
            storage_path('framework/cache/data'),
            storage_path('framework/cache/static'),
            storage_path('framework/cache/views'),
            storage_path('framework/sessions'),
        ];

        foreach ($cacheDirectories as $dir) {
            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
        }

        // Static data caching (long TTL)
        $this->cacheStaticData();
    }

    /**
     * Cache static data yang jarang berubah
     */
    protected function cacheStaticData(): void
    {
        // Cache aplikasi settings dengan TTL 24 jam
        Cache::store('static')->remember('app_settings', 86400, function () {
            return [
                'site_name' => config('app.name'),
                'timezone' => config('app.timezone'),
                'locale' => config('app.locale'),
                'version' => '1.0.0',
            ];
        });

        // Cache kategori UMKM (update setiap 6 jam)
        Cache::store('static')->remember('kategori_umkm_list', 21600, function () {
            try {
                return DB::table('kategori_umkm')
                    ->select('id', 'nama_kategori', 'deskripsi')
                    ->orderBy('nama_kategori')
                    ->get()
                    ->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });

        // Cache tahun data tersedia (update setiap 12 jam)
        Cache::store('static')->remember('tahun_data_list', 43200, function () {
            try {
                return DB::table('tahun_data')
                    ->select('id', 'tahun', 'is_active')
                    ->orderBy('tahun', 'desc')
                    ->get()
                    ->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });
    }

    /**
     * Cache data dengan optimized file storage
     */
    public function cacheOptimizedData(string $key, $data, int $ttl = 3600): bool
    {
        try {
            // Use file cache dengan compression
            return Cache::store('file')->put($key, $data, $ttl);
        } catch (\Exception $e) {
            Log::warning('Cache storage failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get cached data dengan fallback
     */
    public function getCachedData(string $key, ?callable $fallback = null, int $ttl = 3600)
    {
        try {
            $cached = Cache::store('file')->get($key);

            if ($cached !== null) {
                return $cached;
            }

            if ($fallback && is_callable($fallback)) {
                $data = $fallback();
                $this->cacheOptimizedData($key, $data, $ttl);
                return $data;
            }

            return null;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Cache retrieval failed: ' . $e->getMessage());
            return $fallback ? $fallback() : null;
        }
    }

    /**
     * Cache UMKM data dengan pagination optimized
     */
    public function cacheUmkmData(array $filters = [], int $page = 1): array
    {
        $cacheKey = 'umkm_page_' . $page . '_' . md5(serialize($filters));

        return $this->getCachedData($cacheKey, function () use ($filters, $page) {
            $query = DB::table('umkms')
                ->leftJoin('kategori_umkm', 'umkms.kategori_id', '=', 'kategori_umkm.id')
                ->select(
                    'umkms.id',
                    'umkms.nama',
                    'umkms.slug',
                    'umkms.deskripsi',
                    'umkms.alamat',
                    'umkms.telepon',
                    'umkms.logo_path',
                    'kategori_umkm.nama_kategori'
                );

            // Apply filters
            if (!empty($filters['kategori_id'])) {
                $query->where('umkms.kategori_id', $filters['kategori_id']);
            }

            if (!empty($filters['search'])) {
                $search = $filters['search'];
                $query->where(function ($q) use ($search) {
                    $q->where('umkms.nama', 'LIKE', "%{$search}%")
                        ->orWhere('umkms.deskripsi', 'LIKE', "%{$search}%")
                        ->orWhere('umkms.alamat', 'LIKE', "%{$search}%");
                });
            }

            if (!empty($filters['dusun'])) {
                $query->where('umkms.dusun', $filters['dusun']);
            }

            // Pagination manual (lebih efisien untuk shared hosting)
            $perPage = 12;
            $offset = ($page - 1) * $perPage;

            $total = $query->count();
            $items = $query->offset($offset)->limit($perPage)->get()->toArray();

            return [
                'data' => $items,
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
            ];
        }, 1800); // Cache 30 menit
    }

    /**
     * Cache berita data
     */
    public function cacheBeritaData(array $filters = [], int $page = 1): array
    {
        $cacheKey = 'berita_page_' . $page . '_' . md5(serialize($filters));

        return $this->getCachedData($cacheKey, function () use ($filters, $page) {
            $query = DB::table('berita')
                ->select(
                    'id',
                    'judul',
                    'isi',
                    'gambar_url',
                    'kategori',
                    'penulis',
                    'created_at'
                );

            // Apply filters
            if (!empty($filters['kategori'])) {
                $query->where('kategori', $filters['kategori']);
            }

            if (!empty($filters['tahun'])) {
                $query->whereYear('created_at', $filters['tahun']);
            }

            if (!empty($filters['bulan'])) {
                $query->whereMonth('created_at', $filters['bulan']);
            }

            // Manual pagination
            $perPage = 10;
            $offset = ($page - 1) * $perPage;

            $total = $query->count();
            $items = $query->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($perPage)
                ->get()
                ->toArray();

            return [
                'data' => $items,
                'total' => $total,
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
            ];
        }, 900); // Cache 15 menit
    }

    /**
     * Monitor performance untuk shared hosting
     */
    public function monitorSharedHostingPerformance(): array
    {
        $metrics = [];

        // Database performance
        try {
            $dbStart = microtime(true);
            DB::select('SELECT 1');
            $metrics['db_response_time'] = round((microtime(true) - $dbStart) * 1000, 2);
            $metrics['db_status'] = 'healthy';
        } catch (\Exception $e) {
            $metrics['db_response_time'] = null;
            $metrics['db_status'] = 'error';
        }

        // File cache status
        $cacheDir = storage_path('framework/cache/data');
        $metrics['cache_status'] = is_writable($cacheDir) ? 'writable' : 'read-only';

        // Cache file count
        $cacheFiles = File::glob($cacheDir . '/*');
        $metrics['cache_files_count'] = count($cacheFiles);

        // Storage usage
        $storageSize = 0;
        $storageDirectories = [
            storage_path('framework/cache'),
            storage_path('framework/sessions'),
            storage_path('logs'),
        ];

        foreach ($storageDirectories as $dir) {
            if (File::isDirectory($dir)) {
                $storageSize += $this->getDirectorySize($dir);
            }
        }

        $metrics['storage_usage_mb'] = round($storageSize / 1024 / 1024, 2);

        // Memory usage
        $metrics['memory_usage'] = [
            'current' => round(memory_get_usage(true) / 1024 / 1024, 2),
            'peak' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
            'limit' => ini_get('memory_limit'),
        ];

        return $metrics;
    }

    /**
     * Get directory size recursively
     */
    protected function getDirectorySize(string $directory): int
    {
        $size = 0;

        try {
            foreach (File::allFiles($directory) as $file) {
                $size += $file->getSize();
            }
        } catch (\Exception $e) {
            // Ignore errors
        }

        return $size;
    }

    /**
     * Clean up old cache files untuk shared hosting
     */
    public function cleanupCache(): void
    {
        try {
            // Clean cache files older than 24 hours
            $cacheDir = storage_path('framework/cache/data');
            $files = File::glob($cacheDir . '/*');

            foreach ($files as $file) {
                if (File::lastModified($file) < (time() - 86400)) {
                    File::delete($file);
                }
            }

            // Clean session files older than session lifetime
            $sessionDir = storage_path('framework/sessions');
            $sessionFiles = File::glob($sessionDir . '/*');
            $sessionLifetime = config('session.lifetime', 120) * 60; // Convert to seconds

            foreach ($sessionFiles as $file) {
                if (File::lastModified($file) < (time() - $sessionLifetime)) {
                    File::delete($file);
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('Cache cleanup failed: ' . $e->getMessage());
        }
    }

    /**
     * Warm up cache untuk shared hosting
     */
    public function warmupSharedHostingCache(): void
    {
        // Warm up static data
        $this->cacheStaticData();

        // Warm up first page data
        $this->cacheUmkmData([], 1);
        $this->cacheBeritaData([], 1);

        // Warm up popular categories
        try {
            $popularCategories = DB::table('kategori_umkm')
                ->leftJoin('umkms', 'kategori_umkm.id', '=', 'umkms.kategori_id')
                ->select('kategori_umkm.id')
                ->groupBy('kategori_umkm.id')
                ->orderByRaw('COUNT(umkms.id) DESC')
                ->limit(3)
                ->get();

            foreach ($popularCategories as $category) {
                $this->cacheUmkmData(['kategori_id' => $category->id], 1);
            }
        } catch (\Exception $e) {
            // Ignore errors during warmup
        }
    }
}
