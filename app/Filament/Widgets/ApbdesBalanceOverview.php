<?php

namespace App\Filament\Widgets;

use App\Models\DetailApbdes;
use App\Models\LaporanApbdes;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ApbdesBalanceOverview extends BaseWidget
{
    // Mengatur polling agar data refresh otomatis jika ada perubahan (opsional)
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        // 1. Ambil tahun dari URL Query String (dikirim oleh filter di halaman Dashboard)
        $selectedYear = request()->query('selectedYear');

        // 2. Query Laporan APBDes
        $query = LaporanApbdes::query()->where('status', 'diterbitkan'); // Pastikan hanya yang diterbitkan

        if ($selectedYear) {
            // Filter berdasarkan tahun yang dipilih
            $query->whereHas('tahunData', function ($q) use ($selectedYear) {
                $q->where('tahun', $selectedYear);
            });
            // Ambil yang pertama ditemukan untuk tahun tersebut
            $laporanTerpilih = $query->first();
        } else {
            // Default: Ambil laporan paling baru berdasarkan ID atau Tahun
            $laporanTerpilih = $query->latest()->first();
        }

        // Jika tidak ada data laporan
        if (!$laporanTerpilih) {
            return [
                Stat::make('Status', 'Data Tidak Ditemukan')
                    ->description($selectedYear ? "Tahun $selectedYear" : 'Belum ada laporan')
                    ->color('gray'),
                Stat::make('Total Pendapatan', 'Rp 0'),
                Stat::make('Total Belanja', 'Rp 0'),
            ];
        }

        // 3. Hitung Statistik (Sama seperti logika sebelumnya, tapi dinamis)
        $idLaporan = $laporanTerpilih->id;

        $totalPendapatan = DetailApbdes::where('laporan_apbdes_id', $idLaporan)
            ->where('tipe', 'pendapatan')
            ->sum('realisasi');

        $totalBelanja = DetailApbdes::where('laporan_apbdes_id', $idLaporan)
            ->where('tipe', 'belanja')
            ->sum('realisasi');

        $balance = $totalPendapatan - $totalBelanja;

        $anggaranPendapatan = DetailApbdes::where('laporan_apbdes_id', $idLaporan)
            ->where('tipe', 'pendapatan')
            ->sum('anggaran');

        $anggaranBelanja = DetailApbdes::where('laporan_apbdes_id', $idLaporan)
            ->where('tipe', 'belanja')
            ->sum('anggaran');

        // Kalkulasi Persentase
        $persenPendapatan = $anggaranPendapatan > 0 ? round(($totalPendapatan / $anggaranPendapatan) * 100, 1) : 0;
        $persenBelanja = $anggaranBelanja > 0 ? round(($totalBelanja / $anggaranBelanja) * 100, 1) : 0;

        return [
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.'))
                ->description("Realisasi {$persenPendapatan}%")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Dummy chart visual

            Stat::make('Total Belanja', 'Rp ' . number_format($totalBelanja, 0, ',', '.'))
                ->description("Realisasi {$persenBelanja}%")
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger') // Belanja warna warning/danger agar kontras
                ->chart([17, 16, 14, 15, 14, 13, 12]),

            Stat::make(
                $balance >= 0 ? 'Surplus' : 'Defisit',
                'Rp ' . number_format(abs($balance), 0, ',', '.')
            )
                ->description($laporanTerpilih->nama_laporan) // Menampilkan nama laporan agar user tahu data mana yang aktif
                ->descriptionIcon($balance >= 0 ? 'heroicon-m-arrow-up' : 'heroicon-m-arrow-down')
                ->color($balance >= 0 ? 'primary' : 'danger'),
        ];
    }
}