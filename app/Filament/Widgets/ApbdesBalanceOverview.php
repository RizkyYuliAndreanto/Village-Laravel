<?php

namespace App\Filament\Widgets;

use App\Models\DetailApbdes;
use App\Models\LaporanApbdes;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ApbdesBalanceOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Ambil laporan terbaru atau berdasarkan filter
        $laporanTerbaru = LaporanApbdes::latest()->first();

        if (!$laporanTerbaru) {
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

        // Hitung total pendapatan (realisasi)
        $totalPendapatan = DetailApbdes::where('laporan_apbdes_id', $laporanTerbaru->id)
            ->where('tipe', 'pendapatan')
            ->sum('realisasi');

        // Hitung total belanja (realisasi)
        $totalBelanja = DetailApbdes::where('laporan_apbdes_id', $laporanTerbaru->id)
            ->where('tipe', 'belanja')
            ->sum('realisasi');

        // Hitung balance (surplus/defisit)
        $balance = $totalPendapatan - $totalBelanja;

        // Hitung total anggaran pendapatan
        $anggaranPendapatan = DetailApbdes::where('laporan_apbdes_id', $laporanTerbaru->id)
            ->where('tipe', 'pendapatan')
            ->sum('anggaran');

        // Hitung total anggaran belanja
        $anggaranBelanja = DetailApbdes::where('laporan_apbdes_id', $laporanTerbaru->id)
            ->where('tipe', 'belanja')
            ->sum('anggaran');

        // Hitung persentase realisasi pendapatan
        $persentasePendapatan = $anggaranPendapatan > 0
            ? round(($totalPendapatan / $anggaranPendapatan) * 100, 1)
            : 0;

        // Hitung persentase realisasi belanja
        $persentaseBelanja = $anggaranBelanja > 0
            ? round(($totalBelanja / $anggaranBelanja) * 100, 1)
            : 0;

        return [
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.'))
                ->description("Realisasi {$persentasePendapatan}% dari anggaran")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Belanja', 'Rp ' . number_format($totalBelanja, 0, ',', '.'))
                ->description("Realisasi {$persentaseBelanja}% dari anggaran")
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('warning')
                ->chart([17, 16, 14, 15, 14, 13, 12]),

            Stat::make(
                $balance >= 0 ? 'Surplus' : 'Defisit',
                'Rp ' . number_format(abs($balance), 0, ',', '.')
            )
                ->description($balance >= 0 ? 'Pendapatan > Belanja' : 'Belanja > Pendapatan')
                ->descriptionIcon($balance >= 0 ? 'heroicon-m-arrow-up' : 'heroicon-m-arrow-down')
                ->color($balance >= 0 ? 'success' : 'danger'),

            Stat::make('Laporan Aktif', $laporanTerbaru->nama_laporan)
                ->description("Tahun {$laporanTerbaru->tahunData->tahun}")
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
