<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Umkm;
use App\Models\KategoriUmkm;
use Illuminate\Support\Facades\DB;

class UmkmDistributionChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Distribusi UMKM';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public ?string $filter = 'kategori';

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        switch ($activeFilter) {
            case 'kategori':
                return $this->getKategoriData();
            case 'skala':
                return $this->getSkalaData();
            case 'status':
                return $this->getStatusData();
            case 'omset':
                return $this->getOmsetData();
            default:
                return $this->getKategoriData();
        }
    }

    private function getKategoriData(): array
    {
        $data = Umkm::select('kategori_id', DB::raw('count(*) as total'))
            ->with('kategori')
            ->groupBy('kategori_id')
            ->orderBy('total', 'desc')
            ->get();

        $labels = [];
        $values = [];
        $colors = [
            '#3B82F6',
            '#EF4444',
            '#10B981',
            '#F59E0B',
            '#8B5CF6',
            '#EC4899',
            '#06B6D4',
            '#84CC16',
            '#F97316',
            '#6366F1'
        ];

        foreach ($data as $index => $item) {
            $labels[] = $item->kategori->nama ?? 'Tidak berkategori';
            $values[] = $item->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah UMKM',
                    'data' => $values,
                    'backgroundColor' => array_slice($colors, 0, count($values)),
                ],
            ],
            'labels' => $labels,
        ];
    }

    private function getSkalaData(): array
    {
        $mikro = Umkm::where('skala_usaha', Umkm::SKALA_MIKRO)->count();
        $kecil = Umkm::where('skala_usaha', Umkm::SKALA_KECIL)->count();
        $menengah = Umkm::where('skala_usaha', Umkm::SKALA_MENENGAH)->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah UMKM',
                    'data' => [$mikro, $kecil, $menengah],
                    'backgroundColor' => ['#6B7280', '#3B82F6', '#10B981'],
                ],
            ],
            'labels' => ['Mikro', 'Kecil', 'Menengah'],
        ];
    }

    private function getStatusData(): array
    {
        $aktif = Umkm::where('status_usaha', Umkm::STATUS_AKTIF)->count();
        $nonAktif = Umkm::where('status_usaha', Umkm::STATUS_NON_AKTIF)->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah UMKM',
                    'data' => [$aktif, $nonAktif],
                    'backgroundColor' => ['#10B981', '#EF4444'],
                ],
            ],
            'labels' => ['Aktif', 'Non-Aktif'],
        ];
    }

    private function getOmsetData(): array
    {
        // Group by omset ranges
        $ranges = [
            '0-1jt' => Umkm::whereBetween('omset_per_bulan', [0, 1000000])->count(),
            '1-5jt' => Umkm::whereBetween('omset_per_bulan', [1000001, 5000000])->count(),
            '5-10jt' => Umkm::whereBetween('omset_per_bulan', [5000001, 10000000])->count(),
            '10-25jt' => Umkm::whereBetween('omset_per_bulan', [10000001, 25000000])->count(),
            '>25jt' => Umkm::where('omset_per_bulan', '>', 25000000)->count(),
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah UMKM',
                    'data' => array_values($ranges),
                    'backgroundColor' => [
                        '#EF4444',
                        '#F59E0B',
                        '#10B981',
                        '#3B82F6',
                        '#8B5CF6'
                    ],
                ],
            ],
            'labels' => array_keys($ranges),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'kategori' => 'Berdasarkan Kategori',
            'skala' => 'Berdasarkan Skala Usaha',
            'status' => 'Berdasarkan Status',
            'omset' => 'Berdasarkan Omset',
        ];
    }
}
