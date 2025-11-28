<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

/**
 * Production Performance Optimization Service
 * Handles caching, optimization, dan monitoring
 */
class PerformanceOptimizationService
{
    /**
     * Setup production caching strategy
     */
    public function setupProductionCache(): void
    {
        // Configure Redis connections
        Config::set('cache.default', 'redis');
        Config::set('session.driver', 'redis');
        Config::set('queue.default', 'redis');

        // Setup cache tags untuk selective clearing
        $this->setupCacheTags();
    }

    /**
     * Setup specialized cache tags
     */
    protected function setupCacheTags(): void
    {
        // Static data yang jarang berubah
        Cache::tags(['static', 'config'])->remember('app_settings', 86400, function () {
            return [
                'site_name' => config('app.name'),
                'timezone' => config('app.timezone'),
                'locale' => config('app.locale'),
            ];
        });

        // Kategori UMKM (jarang berubah)
        Cache::tags(['static', 'umkm'])->remember('kategori_umkm', 3600, function () {
            return \App\Models\KategoriUmkm::select('id', 'nama_kategori')
                ->orderBy('nama_kategori')
                ->get();
        });
    }

    /**
     * Cache demografi data dengan optimized queries
     */
    public function cacheDemografiData(int $tahunId): array
    {
        return Cache::tags(['demografi', "tahun_{$tahunId}"])->remember(
            "demografi_data_{$tahunId}",
            1800, // 30 minutes
            function () use ($tahunId) {
                return [
                    'penduduk' => DB::table('demografi_penduduk')
                        ->where('tahun_id', $tahunId)
                        ->first(),
                    'umur' => DB::table('umur_statistik')
                        ->where('tahun_id', $tahunId)
                        ->get(),
                    'agama' => DB::table('agama_statistik')
                        ->where('tahun_id', $tahunId)
                        ->get(),
                    'pekerjaan' => DB::table('pekerjaan_statistik')
                        ->where('tahun_id', $tahunId)
                        ->get(),
                    'pendidikan' => DB::table('pendidikan_statistik')
                        ->where('tahun_id', $tahunId)
                        ->get(),
                ];
            }
        );
    }

    /**
     * Cache UMKM data dengan pagination optimization
     */
    public function cacheUmkmData(array $filters = []): array
    {
        $cacheKey = 'umkm_data_' . md5(serialize($filters));

        return Cache::tags(['umkm', 'listings'])->remember(
            $cacheKey,
            900, // 15 minutes
            function () use ($filters) {
                $query = DB::table('umkms')
                    ->join('kategori_umkm', 'umkms.kategori_id', '=', 'kategori_umkm.id')
                    ->select(
                        'umkms.*',
                        'kategori_umkm.nama_kategori'
                    );

                // Apply filters
                if (!empty($filters['kategori_id'])) {
                    $query->where('umkms.kategori_id', $filters['kategori_id']);
                }

                if (!empty($filters['search'])) {
                    $query->where(function ($q) use ($filters) {
                        $q->where('umkms.nama', 'LIKE', "%{$filters['search']}%")
                            ->orWhere('umkms.deskripsi', 'LIKE', "%{$filters['search']}%");
                    });
                }

                return $query->orderBy('umkms.created_at', 'desc')
                    ->paginate(12)
                    ->toArray();
            }
        );
    }

    /**
     * Cache berita dengan optimized queries
     */
    public function cacheBeritaData(array $filters = []): array
    {
        $cacheKey = 'berita_data_' . md5(serialize($filters));

        return Cache::tags(['berita', 'news'])->remember(
            $cacheKey,
            600, // 10 minutes (frequent updates)
            function () use ($filters) {
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

                return $query->orderBy('created_at', 'desc')
                    ->paginate(10)
                    ->toArray();
            }
        );
    }

    /**
     * Performance monitoring dan alerts
     */
    public function monitorPerformance(): array
    {
        $metrics = [];

        // Database connections
        try {
            $dbStart = microtime(true);
            DB::select('SELECT 1');
            $metrics['db_response_time'] = round((microtime(true) - $dbStart) * 1000, 2);
            $metrics['db_status'] = 'healthy';
        } catch (\Exception $e) {
            $metrics['db_response_time'] = null;
            $metrics['db_status'] = 'error';
        }

        // Redis connection
        try {
            $redisStart = microtime(true);
            Redis::ping();
            $metrics['redis_response_time'] = round((microtime(true) - $redisStart) * 1000, 2);
            $metrics['redis_status'] = 'healthy';
        } catch (\Exception $e) {
            $metrics['redis_response_time'] = null;
            $metrics['redis_status'] = 'error';
        }

        // Memory usage
        $metrics['memory_usage'] = [
            'current' => round(memory_get_usage(true) / 1024 / 1024, 2),
            'peak' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
        ];

        // Cache hit ratio (Redis)
        if ($metrics['redis_status'] === 'healthy') {
            try {
                $info = Redis::info();
                $metrics['cache_hit_ratio'] = isset($info['keyspace_hits'])
                    ? round($info['keyspace_hits'] / ($info['keyspace_hits'] + $info['keyspace_misses']) * 100, 2)
                    : null;
            } catch (\Exception $e) {
                $metrics['cache_hit_ratio'] = null;
            }
        }

        return $metrics;
    }

    /**
     * Clear specific cache tags
     */
    public function clearCache(array $tags = []): bool
    {
        try {
            if (empty($tags)) {
                // Clear all application cache
                Cache::flush();
            } else {
                // Clear specific tags
                Cache::tags($tags)->flush();
            }

            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Cache clear failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Warm up critical caches
     */
    public function warmupCache(): void
    {
        // Warm up static data
        $this->setupCacheTags();

        // Warm up latest year demografi
        $latestYear = \App\Models\TahunData::latest('tahun')->first();
        if ($latestYear) {
            $this->cacheDemografiData($latestYear->id);
        }

        // Warm up popular UMKM categories
        $popularCategories = \App\Models\KategoriUmkm::withCount('umkms')
            ->orderBy('umkms_count', 'desc')
            ->limit(5)
            ->get();

        foreach ($popularCategories as $category) {
            $this->cacheUmkmData(['kategori_id' => $category->id]);
        }

        // Warm up recent berita
        $this->cacheBeritaData();
    }
}
