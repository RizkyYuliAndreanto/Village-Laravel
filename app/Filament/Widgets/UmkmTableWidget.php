<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use App\Models\Umkm;
use Illuminate\Database\Eloquent\Builder;

class UmkmTableWidget extends BaseWidget
{
    protected static ?string $heading = 'UMKM Terbaru & Teratas';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getFilteredQuery())
            ->columns([
                ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl('/images/default-logo.png'),

                TextColumn::make('nama')
                    ->label('Nama UMKM')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->copyable()
                    ->tooltip('Klik untuk copy'),

                TextColumn::make('kategori.nama')
                    ->label('Kategori')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('pemilik')
                    ->label('Pemilik')
                    ->searchable()
                    ->toggleable(),

                BadgeColumn::make('status_usaha')
                    ->label('Status')
                    ->colors([
                        'success' => Umkm::STATUS_AKTIF,
                        'danger' => Umkm::STATUS_NON_AKTIF,
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        Umkm::STATUS_AKTIF => 'Aktif',
                        Umkm::STATUS_NON_AKTIF => 'Non-Aktif',
                        default => $state,
                    }),

                BadgeColumn::make('skala_usaha')
                    ->label('Skala')
                    ->colors([
                        'gray' => Umkm::SKALA_MIKRO,
                        'info' => Umkm::SKALA_KECIL,
                        'success' => Umkm::SKALA_MENENGAH,
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        Umkm::SKALA_MIKRO => 'Mikro',
                        Umkm::SKALA_KECIL => 'Kecil',
                        Umkm::SKALA_MENENGAH => 'Menengah',
                        default => $state,
                    }),

                TextColumn::make('omset_per_bulan')
                    ->label('Omset/Bulan')
                    ->formatStateUsing(fn($state): string => 'Rp ' . number_format((float) $state, 0, ',', '.'))
                    ->sortable()
                    ->color('success')
                    ->weight('medium'),

                TextColumn::make('jumlah_karyawan')
                    ->label('Karyawan')
                    ->suffix(' orang')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('dusun')
                    ->label('Lokasi')
                    ->formatStateUsing(
                        fn($record): string =>
                        $record->dusun . ($record->rt && $record->rw ? " RT{$record->rt}/RW{$record->rw}" : '')
                    )
                    ->toggleable(),

                TextColumn::make('digital_presence')
                    ->label('Digital')
                    ->formatStateUsing(function ($record): string {
                        $platforms = [];
                        if ($record->website) $platforms[] = '🌐';
                        if ($record->shopee_url) $platforms[] = '🛒';
                        if ($record->tokopedia_url) $platforms[] = '🛍️';
                        if ($record->sosial_instagram) $platforms[] = '📷';
                        if ($record->sosial_facebook) $platforms[] = '📘';
                        if ($record->sosial_tiktok) $platforms[] = '🎵';

                        return empty($platforms) ? 'Tidak ada' : implode(' ', $platforms);
                    })
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50])
            ->poll('30s');
    }

    private function getFilteredQuery(): Builder
    {
        return Umkm::with(['kategori'])->latest();
    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('status_usaha')
                ->label('Status Usaha')
                ->options([
                    'aktif' => 'Aktif',
                    'non-aktif' => 'Non-Aktif',
                ]),
            Tables\Filters\SelectFilter::make('skala_usaha')
                ->label('Skala Usaha')
                ->options([
                    'mikro' => 'Mikro',
                    'kecil' => 'Kecil',
                    'menengah' => 'Menengah',
                ]),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('view')
                ->label('Lihat')
                ->icon('heroicon-o-eye')
                ->url(fn(Umkm $record): string => "/admin/umkms/{$record->id}")
                ->openUrlInNewTab(),
        ];
    }
}
