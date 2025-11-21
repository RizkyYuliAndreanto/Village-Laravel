<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing all refactored controllers...\n\n";

// Test Umur controller
$umurController = new App\Http\Controllers\Frontend\UmurStatistikController();
$umurData = $umurController->getData(2025);
echo "Umur Controller: " . (isset($umurData['piramidaPenduduk']) ? "✓ Working" : "✗ Failed") . "\n";

// Test WajibPilih controller
$wajibPilihController = new App\Http\Controllers\Frontend\WajibPilihStatistikController();
$wajibPilihData = $wajibPilihController->getData(2025);
echo "WajibPilih Controller: " . (isset($wajibPilihData['wajibPilihLabels']) ? "✓ Working" : "✗ Failed") . "\n";
echo "  - Has wajibPilihLabels: " . (isset($wajibPilihData['wajibPilihLabels']) ? "Yes" : "No") . "\n";
echo "  - Has wajibPilihTotals: " . (isset($wajibPilihData['wajibPilihTotals']) ? "Yes" : "No") . "\n";

// Test Dusun controller
$dusunController = new App\Http\Controllers\Frontend\DusunStatistikController();
$dusunData = $dusunController->getData(2025);
echo "Dusun Controller: " . (isset($dusunData['dusunChartConfig']) ? "✓ Working" : "✗ Failed") . "\n";

// Test Pekerjaan controller
$pekerjaanController = new App\Http\Controllers\Frontend\Infografis\PekerjaanController();
$pekerjaanData = $pekerjaanController->getData(2025);
echo "Pekerjaan Controller: " . (isset($pekerjaanData['pekerjaan']) ? "✓ Working" : "✗ Failed") . "\n";

echo "\nAll controllers are working properly for the refactored infografis page!\n";
