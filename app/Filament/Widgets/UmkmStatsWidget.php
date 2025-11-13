<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Umkm;
use App\Models\KategoriUmkm;
use Illuminate\Support\Facades\DB;

class UmkmStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Total UMKM
        $totalUmkm = Umkm::count();
        $umkmAktif = Umkm::where('status_usaha', Umkm::STATUS_AKTIF)->count();
        $umkmNonAktif = Umkm::where('status_usaha', Umkm::STATUS_NON_AKTIF)->count();

        // Kategori terbanyak
        $kategoriTerbanyak = Umkm::select('kategori_id')
            ->with('kategori')
            ->groupBy('kategori_id')
            ->orderByRaw('COUNT(*) DESC')
            ->first();

        $kategoriName = $kategoriTerbanyak?->kategori?->nama ?? 'Belum ada';

        // Total omset per bulan
        $totalOmset = Umkm::where('status_usaha', Umkm::STATUS_AKTIF)
            ->sum('omset_per_bulan');

        // Rata-rata karyawan
        $rataKaryawan = Umkm::where('status_usaha', Umkm::STATUS_AKTIF)
            ->avg('jumlah_karyawan');

        // Skala usaha distribution
        $skalaMikro = Umkm::where('skala_usaha', Umkm::SKALA_MIKRO)->count();
        $skalaKecil = Umkm::where('skala_usaha', Umkm::SKALA_KECIL)->count();
        $skalaMenengah = Umkm::where('skala_usaha', Umkm::SKALA_MENENGAH)->count();

        // UMKM dengan platform online
        $denganWebsite = Umkm::whereNotNull('website')->count();
        $denganShopee = Umkm::whereNotNull('shopee_url')->count();
        $denganTokopedia = Umkm::whereNotNull('tokopedia_url')->count();

        return [
            // Total dan Status
            Stat::make('Total UMKM', number_format($totalUmkm))
                ->description('Total usaha terdaftar')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->color('primary'),

            Stat::make('UMKM Aktif', number_format($umkmAktif))
                ->description('Usaha yang beroperasi')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('UMKM Non-Aktif', number_format($umkmNonAktif))
                ->description('Usaha yang tidak beroperasi')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            // Ekonomi
            Stat::make('Total Omset/Bulan', 'Rp ' . number_format($totalOmset, 0, ',', '.'))
                ->description('Omset gabungan UMKM aktif')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Rata-rata Karyawan', number_format($rataKaryawan, 1))
                ->description('Per UMKM aktif')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            // Kategori
            Stat::make('Kategori Terbanyak', $kategoriName)
                ->description('Jenis usaha dominan')
                ->descriptionIcon('heroicon-m-tag')
                ->color('warning'),

            // Skala Usaha
            Stat::make('Usaha Mikro', number_format($skalaMikro))
                ->description('Skala mikro')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('gray'),

            Stat::make('Usaha Kecil', number_format($skalaKecil))
                ->description('Skala kecil')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('info'),

            Stat::make('Usaha Menengah', number_format($skalaMenengah))
                ->description('Skala menengah')
                ->descriptionIcon('heroicon-m-building-library')
                ->color('success'),

            // Digital Presence
            Stat::make('Memiliki Website', number_format($denganWebsite))
                ->description('UMKM dengan website')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('primary'),

            Stat::make('Di Shopee', number_format($denganShopee))
                ->description('Terdaftar marketplace')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),

            Stat::make('Di Tokopedia', number_format($denganTokopedia))
                ->description('Terdaftar marketplace')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),
        ];
    }

    protected function getColumns(): int
    {
        return 4; // Display in 4 columns
    }
}
