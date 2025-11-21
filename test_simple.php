<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing InfografisController with tahun 2024...\n";

$controller = new App\Http\Controllers\Frontend\InfografisController();
$request = new Illuminate\Http\Request(['tahun' => '2024']);

try {
    $result = $controller->index($request);
    $data = $result->getData();

    echo "SUCCESS! Controller worked.\n";
    echo "Tahun used: " . $data['tahun'] . "\n";
    echo "Has pekerjaan: " . (isset($data['pekerjaan']) ? 'YES' : 'NO') . "\n";
    echo "Has perkawinan: " . (isset($data['perkawinan']) ? 'YES' : 'NO') . "\n";
    echo "Has belumKawin: " . (isset($data['belumKawin']) ? 'YES' : 'NO') . "\n";

    // Test default (tanpa parameter)
    echo "\nTesting default (no tahun parameter)...\n";
    $request2 = new Illuminate\Http\Request();
    $result2 = $controller->index($request2);
    $data2 = $result2->getData();
    echo "Default tahun: " . $data2['tahun'] . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
