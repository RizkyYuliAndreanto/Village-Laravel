<?php

namespace App\Services;

use App\Models\DemografiPenduduk;
use App\Models\UmurStatistik;
use App\Models\PekerjaanStatistik;
use App\Models\PendidikanStatistik;
use App\Models\AgamaStatistik;
use App\Models\PerkawinanStatistik;
use App\Models\WajibPilihStatistik;

class PopulationValidationService
{
    /**
     * Get total population from demografi penduduk for specific year
     */
    public function getTotalPopulation(int $tahunId): ?int
    {
        $demografi = DemografiPenduduk::where('tahun_id', $tahunId)->first();

        if (!$demografi) {
            return null;
        }

        return $demografi->laki_laki + $demografi->perempuan;
    }

    /**
     * Validate if total matches demografi penduduk
     */
    public function validatePopulationConsistency(int $tahunId, array $data, string $resourceType): array
    {
        $totalPopulation = $this->getTotalPopulation($tahunId);

        if ($totalPopulation === null) {
            return [
                'valid' => false,
                'message' => 'Data Demografi Penduduk untuk tahun ini belum tersedia. Harap input data Demografi Penduduk terlebih dahulu.',
                'expected' => 0,
                'actual' => 0,
                'difference' => 0
            ];
        }

        $inputTotal = $this->calculateTotalFromData($data, $resourceType);
        $difference = $inputTotal - $totalPopulation;

        $isValid = $inputTotal === $totalPopulation;

        return [
            'valid' => $isValid,
            'message' => $this->generateValidationMessage($resourceType, $totalPopulation, $inputTotal, $difference),
            'expected' => $totalPopulation,
            'actual' => $inputTotal,
            'difference' => $difference
        ];
    }

    /**
     * Get existing data validation for widget display
     */
    public function getExistingDataValidation(int $tahunId, string $resourceType): array
    {
        $totalPopulation = $this->getTotalPopulation($tahunId);

        if ($totalPopulation === null) {
            return [
                'isValid' => false,
                'totalCount' => 0,
                'expectedCount' => 0,
                'difference' => 0,
                'message' => 'Data Demografi Penduduk belum tersedia'
            ];
        }

        $existingTotal = $this->getExistingDataTotal($tahunId, $resourceType);
        $difference = $existingTotal - $totalPopulation;
        $isValid = $existingTotal === $totalPopulation;

        return [
            'isValid' => $isValid,
            'totalCount' => $existingTotal,
            'expectedCount' => $totalPopulation,
            'difference' => $difference,
            'message' => $isValid ? 'Data konsisten' : 'Data tidak konsisten'
        ];
    }

    /**
     * Get total from existing records in database
     */
    private function getExistingDataTotal(int $tahunId, string $resourceType): int
    {
        switch ($resourceType) {
            case 'umur':
                $record = UmurStatistik::where('tahun_id', $tahunId)->first();
                if (!$record) return 0;
                return $record->balita_0_4 + $record->anak_5_9 + $record->anak_10_14 +
                    $record->remaja_15_19 + $record->dewasa_20_39 + $record->dewasa_40_59 +
                    $record->lansia_60_plus;

            case 'pekerjaan':
                $record = PekerjaanStatistik::where('tahun_id', $tahunId)->first();
                if (!$record) return 0;
                return $record->tidak_sekolah + $record->petani + $record->pelajar_mahasiswa +
                    $record->pegawai_swasta + $record->wiraswasta + $record->ibu_rumah_tangga +
                    $record->belum_bekerja + $record->lainnya;

            case 'pendidikan':
                $record = PendidikanStatistik::where('tahun_id', $tahunId)->first();
                if (!$record) return 0;
                return $record->tidak_sekolah + $record->sd + $record->smp +
                    $record->sma + $record->d1_d4 + $record->s1 + $record->s2 + $record->s3;

            case 'agama':
                $record = AgamaStatistik::where('tahun_id', $tahunId)->first();
                if (!$record) return 0;
                return $record->islam + $record->kristen + $record->katholik +
                    $record->hindu + $record->buddha + $record->konghucu + $record->lainnya;

            case 'perkawinan':
                $record = PerkawinanStatistik::where('tahun_id', $tahunId)->first();
                if (!$record) return 0;
                return $record->belum_kawin + $record->kawin + $record->cerai_hidup + $record->cerai_mati;

            case 'wajib_pilih':
                $record = WajibPilihStatistik::where('tahun_id', $tahunId)->first();
                if (!$record) return 0;
                return $record->wajib_pilih + $record->tidak_wajib_pilih;

            default:
                return 0;
        }
    }

    /**
     * Calculate total from input data based on resource type
     */
    private function calculateTotalFromData(array $data, string $resourceType): int
    {
        switch ($resourceType) {
            case 'umur':
                return collect([
                    'balita_0_4',
                    'anak_5_9',
                    'anak_10_14',
                    'remaja_15_19',
                    'dewasa_20_39',
                    'dewasa_40_59',
                    'lansia_60_plus'
                ])->sum(fn($field) => (int) ($data[$field] ?? 0));

            case 'pekerjaan':
                return collect([
                    'tidak_sekolah',
                    'petani',
                    'pelajar_mahasiswa',
                    'pegawai_swasta',
                    'wiraswasta',
                    'ibu_rumah_tangga',
                    'belum_bekerja',
                    'lainnya'
                ])->sum(fn($field) => (int) ($data[$field] ?? 0));

            case 'pendidikan':
                return collect([
                    'tidak_sekolah',
                    'sd',
                    'smp',
                    'sma',
                    'd1_d4',
                    's1',
                    's2',
                    's3'
                ])->sum(fn($field) => (int) ($data[$field] ?? 0));

            case 'agama':
                return collect([
                    'islam',
                    'katolik',
                    'kristen',
                    'hindu',
                    'buddha',
                    'konghucu',
                    'kepercayaan_lain'
                ])->sum(fn($field) => (int) ($data[$field] ?? 0));

            case 'perkawinan':
                // For perkawinan, we validate status perkawinan total
                return collect([
                    'kawin',
                    'cerai_hidup',
                    'cerai_mati'
                ])->sum(fn($field) => (int) ($data[$field] ?? 0));

            case 'wajib_pilih':
                return (int) ($data['laki_laki'] ?? 0) + (int) ($data['perempuan'] ?? 0);

            default:
                return 0;
        }
    }

    /**
     * Generate appropriate validation message
     */
    private function generateValidationMessage(string $resourceType, int $expected, int $actual, int $difference): string
    {
        $resourceNames = [
            'umur' => 'Statistik Umur',
            'pekerjaan' => 'Statistik Pekerjaan',
            'pendidikan' => 'Statistik Pendidikan',
            'agama' => 'Statistik Agama',
            'perkawinan' => 'Statistik Perkawinan',
            'wajib_pilih' => 'Statistik Wajib Pilih'
        ];

        $resourceName = $resourceNames[$resourceType] ?? 'Data Statistik';

        if ($difference > 0) {
            return "❌ Total {$resourceName} ({$actual} orang) LEBIH BESAR dari data Demografi Penduduk ({$expected} orang). Kelebihan: {$difference} orang. Harap periksa kembali input data.";
        } elseif ($difference < 0) {
            $shortage = abs($difference);
            return "❌ Total {$resourceName} ({$actual} orang) KURANG dari data Demografi Penduduk ({$expected} orang). Kekurangan: {$shortage} orang. Harap lengkapi data yang hilang.";
        } else {
            return "✅ Total {$resourceName} ({$actual} orang) SESUAI dengan data Demografi Penduduk ({$expected} orang). Data konsisten!";
        }
    }

    /**
     * Get population validation summary for a year
     */
    public function getPopulationValidationSummary(int $tahunId): array
    {
        $totalPopulation = $this->getTotalPopulation($tahunId);

        if ($totalPopulation === null) {
            return [
                'total_population' => 0,
                'validations' => [],
                'all_consistent' => false
            ];
        }

        $validations = [];
        $allConsistent = true;

        // Check each statistics type
        $statisticsTypes = [
            'umur' => UmurStatistik::class,
            'pekerjaan' => PekerjaanStatistik::class,
            'pendidikan' => PendidikanStatistik::class,
            'agama' => AgamaStatistik::class,
            'perkawinan' => PerkawinanStatistik::class,
            'wajib_pilih' => WajibPilihStatistik::class
        ];

        foreach ($statisticsTypes as $type => $model) {
            $record = $model::where('tahun_id', $tahunId)->first();

            if ($record) {
                $data = $record->toArray();
                $validation = $this->validatePopulationConsistency($tahunId, $data, $type);
                $validations[$type] = $validation;

                if (!$validation['valid']) {
                    $allConsistent = false;
                }
            } else {
                $validations[$type] = [
                    'valid' => null,
                    'message' => "Data belum tersedia",
                    'expected' => $totalPopulation,
                    'actual' => 0,
                    'difference' => 0
                ];
            }
        }

        return [
            'total_population' => $totalPopulation,
            'validations' => $validations,
            'all_consistent' => $allConsistent
        ];
    }
}
