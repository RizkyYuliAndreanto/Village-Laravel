<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class SetupMinioStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:setup-minio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Minio storage - create bucket if not exists';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $config = config('filesystems.disks.s3');
            $bucket = $config['bucket'];

            // Buat S3Client langsung
            $client = new S3Client([
                'version' => 'latest',
                'region' => $config['region'],
                'endpoint' => $config['endpoint'],
                'use_path_style_endpoint' => $config['use_path_style_endpoint'],
                'credentials' => [
                    'key' => $config['key'],
                    'secret' => $config['secret'],
                ],
            ]);

            // Cek apakah bucket sudah ada
            if (!$client->doesBucketExist($bucket)) {
                $this->info("Bucket '{$bucket}' tidak ditemukan. Membuat bucket...");

                $client->createBucket([
                    'Bucket' => $bucket,
                ]);

                $this->info("Bucket '{$bucket}' berhasil dibuat!");

                // Set bucket policy agar public (opsional)
                $policy = json_encode([
                    'Version' => '2012-10-17',
                    'Statement' => [
                        [
                            'Effect' => 'Allow',
                            'Principal' => ['AWS' => ['*']],
                            'Action' => ['s3:GetObject'],
                            'Resource' => ["arn:aws:s3:::{$bucket}/*"]
                        ]
                    ]
                ]);

                $client->putBucketPolicy([
                    'Bucket' => $bucket,
                    'Policy' => $policy,
                ]);

                $this->info("Bucket policy set ke public.");
            } else {
                $this->info("Bucket '{$bucket}' sudah ada.");
            }

            // Test write menggunakan Storage facade
            $disk = Storage::disk('s3');
            $testFile = 'test-' . time() . '.txt';
            $disk->put($testFile, 'Test file from Laravel');

            if ($disk->exists($testFile)) {
                $this->info("✓ Test write berhasil!");
                $this->info("  URL: " . $disk->url($testFile));
                $disk->delete($testFile);
            }

            $this->info("\n✓ Minio storage setup selesai!");
            return Command::SUCCESS;
        } catch (AwsException $e) {
            $this->error("Error AWS: " . $e->getMessage());
            return Command::FAILURE;
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
