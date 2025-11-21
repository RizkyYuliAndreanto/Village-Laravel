<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Services\PopulationValidationService;
use App\Models\TahunData;

$service = new PopulationValidationService();

// Get 2024 data
$tahun2024 = TahunData::where('tahun', 2024)->first();

if ($tahun2024) {
    echo "Testing validation for tahun 2024 (ID: {$tahun2024->id_tahun})\n";
    echo "Total population: " . $service->getTotalPopulation($tahun2024->id_tahun) . "\n";

    // Test with invalid umur data (total = 101 when should be 9200)
    $testData = [
        'tahun_id' => $tahun2024->id_tahun,
        'umur_0_4' => 50,
        'umur_5_9' => 51,
        'umur_10_14' => 0,
        'umur_15_19' => 0,
        'umur_20_24' => 0,
        'umur_25_29' => 0,
        'umur_30_34' => 0,
        'umur_35_39' => 0,
        'umur_40_44' => 0,
        'umur_45_49' => 0,
        'umur_50_plus' => 0,
    ];

    $validation = $service->validatePopulationConsistency(
        $tahun2024->id_tahun,
        $testData,
        'umur'
    );

    echo "\nValidation Result:\n";
    echo "Valid: " . ($validation['valid'] ? 'Yes' : 'No') . "\n";
    echo "Expected: " . $validation['expected'] . "\n";
    echo "Actual: " . $validation['actual'] . "\n";
    echo "Difference: " . $validation['difference'] . "\n";
    echo "Message: " . $validation['message'] . "\n";
} else {
    echo "Tahun 2024 not found\n";
}
