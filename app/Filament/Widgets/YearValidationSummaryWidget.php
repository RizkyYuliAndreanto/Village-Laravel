<?php

namespace App\Filament\Widgets;

use App\Models\TahunData;
use App\Models\DemografiPenduduk;
use App\Services\PopulationValidationService;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;

class YearValidationSummaryWidget extends BaseWidget
{
    protected static ?string $heading = 'Ringkasan Validasi Per Tahun';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TahunData::query()
                    ->whereHas('demografiPenduduk')
                    ->orderBy('tahun', 'desc')
            )
            ->columns([
                TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('demografiPenduduk.total_populasi')
                    ->label('Total Populasi')
                    ->getStateUsing(function ($record) {
                        $demografi = $record->demografiPenduduk->first();
                        if (!$demografi) return 'Tidak ada data';
                        return number_format($demografi->laki_laki + $demografi->perempuan);
                    })
                    ->badge()
                    ->color('primary'),

                TextColumn::make('umur_status')
                    ->label('Umur')
                    ->getStateUsing(function ($record) {
                        return $this->getValidationStatus($record->id_tahun, 'umur');
                    })
                    ->badge()
                    ->color(fn(string $state): string => $this->getStatusColor($state)),

                TextColumn::make('pekerjaan_status')
                    ->label('Pekerjaan')
                    ->getStateUsing(function ($record) {
                        return $this->getValidationStatus($record->id_tahun, 'pekerjaan');
                    })
                    ->badge()
                    ->color(fn(string $state): string => $this->getStatusColor($state)),

                TextColumn::make('pendidikan_status')
                    ->label('Pendidikan')
                    ->getStateUsing(function ($record) {
                        return $this->getValidationStatus($record->id_tahun, 'pendidikan');
                    })
                    ->badge()
                    ->color(fn(string $state): string => $this->getStatusColor($state)),

                TextColumn::make('agama_status')
                    ->label('Agama')
                    ->getStateUsing(function ($record) {
                        return $this->getValidationStatus($record->id_tahun, 'agama');
                    })
                    ->badge()
                    ->color(fn(string $state): string => $this->getStatusColor($state)),

                TextColumn::make('perkawinan_status')
                    ->label('Perkawinan')
                    ->getStateUsing(function ($record) {
                        return $this->getValidationStatus($record->id_tahun, 'perkawinan');
                    })
                    ->badge()
                    ->color(fn(string $state): string => $this->getStatusColor($state)),

                TextColumn::make('wajib_pilih_status')
                    ->label('Wajib Pilih')
                    ->getStateUsing(function ($record) {
                        return $this->getValidationStatus($record->id_tahun, 'wajib_pilih');
                    })
                    ->badge()
                    ->color(fn(string $state): string => $this->getStatusColor($state)),

                TextColumn::make('overall_status')
                    ->label('Status Keseluruhan')
                    ->getStateUsing(function ($record) {
                        return $this->getOverallStatus($record->id_tahun);
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Semua Valid' => 'success',
                        'Ada Masalah' => 'warning',
                        'Banyak Masalah' => 'danger',
                        'Belum Ada Data' => 'gray',
                        default => 'gray'
                    }),
            ])
            ->defaultSort('tahun', 'desc')
            ->striped()
            ->paginated([10, 25, 50]);
    }

    private function getValidationStatus(int $tahunId, string $type): string
    {
        $validationService = new PopulationValidationService();
        $result = $validationService->getExistingDataValidation($tahunId, $type);

        if ($result['totalCount'] === 0) {
            return 'Belum Ada Data';
        }

        if ($result['isValid']) {
            return 'Valid (' . number_format($result['totalCount']) . ')';
        } else {
            $diff = abs($result['difference']);
            return 'Tidak Valid (±' . number_format($diff) . ')';
        }
    }

    private function getStatusColor(string $status): string
    {
        if (str_contains($status, 'Valid (')) {
            return 'success';
        } elseif (str_contains($status, 'Tidak Valid')) {
            return 'danger';
        } else {
            return 'gray';
        }
    }

    private function getOverallStatus(int $tahunId): string
    {
        $validationService = new PopulationValidationService();
        $types = ['umur', 'pekerjaan', 'pendidikan', 'agama', 'perkawinan', 'wajib_pilih'];

        $totalWithData = 0;
        $validCount = 0;
        $invalidCount = 0;

        foreach ($types as $type) {
            $result = $validationService->getExistingDataValidation($tahunId, $type);
            if ($result['totalCount'] > 0) {
                $totalWithData++;
                if ($result['isValid']) {
                    $validCount++;
                } else {
                    $invalidCount++;
                }
            }
        }

        if ($totalWithData === 0) {
            return 'Belum Ada Data';
        }

        if ($invalidCount === 0) {
            return 'Semua Valid';
        } elseif ($invalidCount >= 3) {
            return 'Banyak Masalah';
        } else {
            return 'Ada Masalah';
        }
    }
}
