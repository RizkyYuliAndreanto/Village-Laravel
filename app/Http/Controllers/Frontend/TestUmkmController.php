<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\KategoriUmkm;

class TestUmkmController extends Controller
{
    /**
     * Test all UMKM functionality untuk debugging
     * URL: /test-umkm
     */
    public function testAll()
    {
        echo "<h1>🧪 Test UMKM System</h1>";

        // Test 1: Cek koneksi database
        try {
            $umkmCount = Umkm::count();
            $kategoriCount = KategoriUmkm::count();
            echo "<p>✅ Database connected successfully!</p>";
            echo "<p>📊 Total UMKM: <strong>{$umkmCount}</strong></p>";
            echo "<p>🏷️ Total Kategori: <strong>{$kategoriCount}</strong></p>";
        } catch (\Exception $e) {
            echo "<p>❌ Database error: " . $e->getMessage() . "</p>";
            return;
        }

        // Test 2: Cek model relationships
        echo "<h2>🔗 Testing Relationships</h2>";
        $umkm = Umkm::with('kategori')->first();
        if ($umkm) {
            echo "<p>✅ UMKM: {$umkm->nama}</p>";
            $kategoriNama = $umkm->kategori ? $umkm->kategori->nama_kategori : 'No category';
            echo "<p>✅ Kategori: {$kategoriNama}</p>";
        } else {
            echo "<p>⚠️ No UMKM data found. Run seeders first!</p>";
        }

        // Test 3: Cek routes
        echo "<h2>🛣️ Available Routes</h2>";
        echo "<ul>";
        echo "<li><a href='" . route('umkm.index') . "'>UMKM Index</a></li>";

        if ($umkm) {
            echo "<li><a href='" . route('umkm.show', $umkm->slug) . "'>UMKM Detail</a></li>";
        }

        $kategori = KategoriUmkm::first();
        if ($kategori) {
            echo "<li><a href='" . route('umkm.kategori', $kategori->slug) . "'>Kategori Page</a></li>";
        }
        echo "</ul>";

        // Test 4: Sample queries
        echo "<h2>📝 Sample Queries</h2>";

        // Active UMKM
        $activeUmkm = Umkm::where('status_aktif', true)->count();
        echo "<p>🟢 Active UMKM: {$activeUmkm}</p>";

        // UMKM by category
        $categories = KategoriUmkm::withCount('umkms')->get();
        echo "<p>📊 UMKM per Category:</p>";
        echo "<ul>";
        foreach ($categories as $cat) {
            echo "<li>{$cat->icon} {$cat->nama_kategori}: {$cat->umkms_count} UMKM</li>";
        }
        echo "</ul>";

        // Unique dusuns
        $dusuns = Umkm::distinct()->pluck('dusun')->filter()->sort();
        echo "<p>🏘️ Available Dusuns: " . $dusuns->implode(', ') . "</p>";

        echo "<h2>🎉 All tests completed!</h2>";
        echo "<p><a href='" . route('umkm.index') . "' class='btn btn-primary'>Go to UMKM Index</a></p>";
    }

    /**
     * Test specific data for debugging
     */
    public function testData()
    {
        $data = [
            'umkms' => Umkm::with('kategori')->limit(5)->get(),
            'kategoris' => KategoriUmkm::all(),
            'stats' => [
                'total_umkm' => Umkm::count(),
                'active_umkm' => Umkm::where('status_aktif', true)->count(),
                'with_whatsapp' => Umkm::whereNotNull('whatsapp')->count(),
            ]
        ];

        dd($data); // Laravel's dump and die
    }
}
