<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/**
 * SSD Optimized File Service
 * Optimized for SSD NVMe performance pada shared hosting
 */
class SSDOptimizedFileService
{
    protected $disk;
    protected $cacheTTL;
    protected $maxFileSize;

    public function __construct()
    {
        $this->disk = Storage::disk('public');
        $this->cacheTTL = env('IMAGE_CACHE_TTL', 2592000); // 30 days
        $this->maxFileSize = env('FILE_UPLOAD_MAX_SIZE', '10M');
    }

    /**
     * Upload dan optimasi file untuk SSD performance
     */
    public function uploadOptimized(UploadedFile $file, string $directory = 'uploads', array $options = []): array
    {
        try {
            // Generate unique filename
            $filename = $this->generateOptimizedFilename($file);
            $path = $directory . '/' . $filename;

            // Check if image and optimize
            if ($this->isImage($file)) {
                return $this->uploadOptimizedImage($file, $path, $options);
            }

            // Regular file upload
            return $this->uploadRegularFile($file, $path);
        } catch (\Exception $e) {
            Log::error('File upload failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);

            throw new \Exception('File upload failed: ' . $e->getMessage());
        }
    }

    /**
     * Upload dan optimasi image untuk SSD
     */
    protected function uploadOptimizedImage(UploadedFile $file, string $path, array $options = []): array
    {
        $sizes = $options['sizes'] ?? [
            'thumb' => ['width' => 300, 'height' => 300],
            'medium' => ['width' => 800, 'height' => 600],
            'large' => ['width' => 1200, 'height' => 900]
        ];

        $quality = $options['quality'] ?? 85;
        $results = [];

        // Original image
        $originalPath = $this->disk->putFile(dirname($path), $file);
        $results['original'] = $originalPath;

        // Create optimized versions untuk SSD performance
        if (env('IMAGE_OPTIMIZATION', true)) {
            foreach ($sizes as $size => $dimensions) {
                try {
                    $image = Image::make($file);

                    // Resize dengan mempertahankan aspect ratio
                    $image->resize($dimensions['width'], $dimensions['height'], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    // Optimize untuk SSD (reduce file size, maintain quality)
                    $image->encode('jpg', $quality);

                    // Save ke SSD
                    $resizedPath = dirname($path) . '/' . pathinfo($path, PATHINFO_FILENAME) . '_' . $size . '.jpg';
                    $this->disk->put($resizedPath, $image->stream());

                    $results[$size] = $resizedPath;

                    // Cache metadata untuk SSD optimization
                    $this->cacheImageMetadata($resizedPath, [
                        'size' => $size,
                        'width' => $image->width(),
                        'height' => $image->height(),
                        'filesize' => $image->filesize()
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Image resize failed for size: ' . $size, [
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        return $results;
    }

    /**
     * Upload regular file
     */
    protected function uploadRegularFile(UploadedFile $file, string $path): array
    {
        $filePath = $this->disk->putFile(dirname($path), $file);

        return [
            'original' => $filePath,
            'size' => $file->getSize(),
            'mime' => $file->getMimeType(),
            'name' => $file->getClientOriginalName()
        ];
    }

    /**
     * Generate filename yang optimized untuk SSD
     */
    protected function generateOptimizedFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Clean filename untuk SSD compatibility
        $cleanName = Str::slug($name);
        $timestamp = now()->format('YmdHis');
        $random = Str::random(6);

        return "{$cleanName}_{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Check if file is image
     */
    protected function isImage(UploadedFile $file): bool
    {
        $imageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        return in_array($file->getMimeType(), $imageTypes);
    }

    /**
     * Cache image metadata untuk SSD optimization
     */
    protected function cacheImageMetadata(string $path, array $metadata): void
    {
        $cacheKey = 'img_meta_' . md5($path);
        Cache::put($cacheKey, $metadata, $this->cacheTTL);
    }

    /**
     * Get cached image metadata
     */
    public function getCachedImageMetadata(string $path): ?array
    {
        $cacheKey = 'img_meta_' . md5($path);
        return Cache::get($cacheKey);
    }

    /**
     * Get optimized image URL
     */
    public function getOptimizedImageUrl(string $path, string $size = 'medium'): ?string
    {
        $sizePath = dirname($path) . '/' . pathinfo($path, PATHINFO_FILENAME) . '_' . $size . '.jpg';

        if ($this->disk->exists($sizePath)) {
            return $this->disk->url($sizePath);
        }

        // Fallback ke original
        return $this->disk->exists($path) ? $this->disk->url($path) : null;
    }

    /**
     * Delete file dan semua variants
     */
    public function deleteOptimized(string $path): bool
    {
        try {
            $deleted = [];

            // Delete original
            if ($this->disk->exists($path)) {
                $this->disk->delete($path);
                $deleted[] = $path;
            }

            // Delete variants
            $sizes = ['thumb', 'medium', 'large'];
            foreach ($sizes as $size) {
                $sizePath = dirname($path) . '/' . pathinfo($path, PATHINFO_FILENAME) . '_' . $size . '.jpg';
                if ($this->disk->exists($sizePath)) {
                    $this->disk->delete($sizePath);
                    $deleted[] = $sizePath;
                }
            }

            // Clear cache
            $cacheKey = 'img_meta_' . md5($path);
            Cache::forget($cacheKey);

            Log::info('Optimized file deleted', ['files' => $deleted]);
            return true;
        } catch (\Exception $e) {
            Log::error('File deletion failed', [
                'path' => $path,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Cleanup old files (untuk maintenance)
     */
    public function cleanupOldFiles(int $daysOld = 30): array
    {
        $cutoff = now()->subDays($daysOld);
        $cleaned = [];

        try {
            $files = $this->disk->allFiles();

            foreach ($files as $file) {
                $lastModified = $this->disk->lastModified($file);

                if ($lastModified && $lastModified < $cutoff->timestamp) {
                    $this->disk->delete($file);
                    $cleaned[] = $file;
                }
            }

            Log::info('Old files cleaned up', [
                'count' => count($cleaned),
                'cutoff_date' => $cutoff->toDateString()
            ]);
        } catch (\Exception $e) {
            Log::error('File cleanup failed', [
                'error' => $e->getMessage()
            ]);
        }

        return $cleaned;
    }

    /**
     * Get storage statistics untuk monitoring
     */
    public function getStorageStats(): array
    {
        try {
            $files = $this->disk->allFiles();
            $totalFiles = count($files);
            $totalSize = 0;

            foreach ($files as $file) {
                $totalSize += $this->disk->size($file);
            }

            return [
                'total_files' => $totalFiles,
                'total_size_bytes' => $totalSize,
                'total_size_mb' => round($totalSize / 1024 / 1024, 2),
                'disk_path' => $this->disk->path(''),
                'last_check' => now()->toISOString()
            ];
        } catch (\Exception $e) {
            Log::error('Storage stats failed', [
                'error' => $e->getMessage()
            ]);

            return [
                'error' => 'Unable to get storage statistics',
                'last_check' => now()->toISOString()
            ];
        }
    }
}
