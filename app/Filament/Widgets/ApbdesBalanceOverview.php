<?php

namespace App\Filament\Widgets;

use App\Models\DetailApbdes;
use App\Models\LaporanApbdes;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;
use Livewire\Attributes\On;

class ApbdesBalanceOverview extends BaseWidget
{
    public ?string $selectedYear = null;
    public int $refreshKey = 0;

    protected static ?int $sort = 1;

    #[On('yearChanged')]
    public function refreshData($year = null)
    {
        $this->selectedYear = $year;
        $this->refreshKey++;
    }

    public function mount(array $parameters = []): void
    {
        if (isset($parameters['selectedYear'])) {
            $this->selectedYear = $parameters['selectedYear'];
        }

        if (isset($parameters['refreshKey'])) {
            $this->refreshKey = $parameters['refreshKey'];
        }
    }

    protected function getStats(): array
    {
        // Gunakan selectedYear yang diteruskan dari page
        $selectedYear = $this->selectedYear;

        // Query laporan berdasarkan tahun yang dipilih
        $query = LaporanApbdes::whereIn('status', ['selesai', 'diterbitkan']);

        if ($selectedYear) {
            $query->whereHas('tahunData', function ($q) use ($selectedYear) {
                $q->where('tahun', $selectedYear);
            });
        }

        $laporan = $query->latest()->first();

        if (!$laporan) {
            return [
                Stat::make('Total Pendapatan', 'Rp 0')
                    ->description('Belum ada data')
                    ->color('success'),
                Stat::make('Total Belanja', 'Rp 0')
                    ->description('Belum ada data')
                    ->color('warning'),
                Stat::make('Balance', 'Rp 0')
                    ->description('Surplus/Defisit')
                    ->color('info'),
            ];
        }

        // Gunakan logika yang sama persis dengan getStatistikProperty di ApbdesDashboard
        $totalPendapatan = DetailApbdes::where('laporan_apbdes_id', $laporan->id)
            ->where('tipe', 'pendapatan')
            ->sum('anggaran');

        $totalBelanja = DetailApbdes::where('laporan_apbdes_id', $laporan->id)
            ->where('tipe', 'belanja')
            ->sum('realisasi');

        $balance = $totalPendapatan - $totalBelanja;

        return [
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.'))
                ->description("Target anggaran pendapatan")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->extraAttributes([
                    'class' => 'bg-gradient-to-r from-green-50 to-green-100 border border-green-200'
                ])
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Belanja', 'Rp ' . number_format($totalBelanja, 0, ',', '.'))
                ->description("Realisasi belanja")
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('warning')
                ->extraAttributes([
                    'class' => 'bg-gradient-to-r from-orange-50 to-orange-100 border border-orange-200'
                ])
                ->chart([17, 16, 14, 15, 14, 13, 12]),

            Stat::make(
                $balance >= 0 ? 'Surplus' : 'Defisit',
                'Rp ' . number_format(abs($balance), 0, ',', '.')
            )
                ->description($balance >= 0 ? 'Pendapatan > Belanja' : 'Belanja > Pendapatan')
                ->descriptionIcon($balance >= 0 ? 'heroicon-m-arrow-up' : 'heroicon-m-arrow-down')
                ->color($balance >= 0 ? 'success' : 'danger')
                ->extraAttributes([
                    'class' => $balance >= 0
                        ? 'bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200'
                        : 'bg-gradient-to-r from-red-50 to-red-100 border border-red-200'
                ]),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
