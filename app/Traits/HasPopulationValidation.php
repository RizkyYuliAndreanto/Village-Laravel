<?php

namespace App\Traits;

use App\Services\PopulationValidationService;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

trait HasPopulationValidation
{
    /**
     * Validate population consistency before creating record
     */
    protected function validatePopulationData(array $data, string $resourceType): void
    {
        if (!isset($data['tahun_id'])) {
            return;
        }

        $validationService = app(PopulationValidationService::class);
        $validation = $validationService->validatePopulationConsistency(
            $data['tahun_id'],
            $data,
            $resourceType
        );

        if (!$validation['valid']) {
            // Show detailed notification
            $this->showPopulationValidationNotification($validation, $resourceType);

            // Throw validation exception to prevent form submission
            throw ValidationException::withMessages([
                'tahun_id' => $validation['message']
            ]);
        } else {
            // Show success notification for consistent data
            Notification::make()
                ->success()
                ->title('✅ Validasi Berhasil!')
                ->body($validation['message'])
                ->duration(5000)
                ->send();
        }
    }

    /**
     * Show detailed population validation notification
     */
    private function showPopulationValidationNotification(array $validation, string $resourceType): void
    {
        $expected = number_format($validation['expected']);
        $actual = number_format($validation['actual']);
        $difference = abs($validation['difference']);
        $differenceFormatted = number_format($difference);

        $color = 'danger';
        $icon = '❌';
        $title = 'Validasi Populasi Gagal!';

        if ($validation['difference'] > 0) {
            $detailMessage = "Data yang Anda input ({$actual} orang) melebihi total penduduk dari Demografi Penduduk ({$expected} orang) sebanyak {$differenceFormatted} orang.";
        } else {
            $detailMessage = "Data yang Anda input ({$actual} orang) kurang dari total penduduk dari Demografi Penduduk ({$expected} orang) sebanyak {$differenceFormatted} orang.";
        }

        Notification::make()
            ->title($title)
            ->body($validation['message'])
            ->color($color)
            ->icon($icon)
            ->persistent()
            ->actions([
                \Filament\Notifications\Actions\Action::make('lihat_demografi')
                    ->label('Lihat Data Demografi')
                    ->button()
                    ->url(route('filament.admin.resources.demografi-penduduks.index'))
                    ->openUrlInNewTab(),

                \Filament\Notifications\Actions\Action::make('validasi_detail')
                    ->label('Detail Validasi')
                    ->button()
                    ->color('gray')
                    ->action(function () use ($validation, $expected, $actual, $detailMessage) {
                        Notification::make()
                            ->title('📊 Detail Validasi Populasi')
                            ->body(
                                "**Total Demografi Penduduk:** {$expected} orang\n" .
                                    "**Total Input Anda:** {$actual} orang\n" .
                                    "**Selisih:** " . number_format(abs($validation['difference'])) . " orang\n\n" .
                                    "**Penjelasan:** {$detailMessage}\n\n" .
                                    "**Solusi:** Pastikan total semua field yang Anda input sama dengan total penduduk dari data Demografi Penduduk."
                            )
                            ->color('info')
                            ->duration(10000)
                            ->send();
                    }),
            ])
            ->send();
    }

    /**
     * Show population validation summary
     */
    protected function showPopulationSummary(int $tahunId): void
    {
        $validationService = app(PopulationValidationService::class);
        $summary = $validationService->getPopulationValidationSummary($tahunId);

        if ($summary['total_population'] === 0) {
            Notification::make()
                ->warning()
                ->title('⚠️ Data Demografi Belum Tersedia')
                ->body('Data Demografi Penduduk untuk tahun ini belum tersedia. Harap input data Demografi Penduduk terlebih dahulu untuk memastikan konsistensi data.')
                ->duration(5000)
                ->actions([
                    \Filament\Notifications\Actions\Action::make('input_demografi')
                        ->label('Input Data Demografi')
                        ->button()
                        ->url(route('filament.admin.resources.demografi-penduduks.create'))
                        ->openUrlInNewTab(),
                ])
                ->send();
            return;
        }

        $totalPopulation = number_format($summary['total_population']);
        $consistentCount = collect($summary['validations'])->where('valid', true)->count();
        $totalStatistics = count($summary['validations']);

        $bodyMessage = "**Total Penduduk:** {$totalPopulation} orang\n";
        $bodyMessage .= "**Statistik Konsisten:** {$consistentCount}/{$totalStatistics}\n\n";

        foreach ($summary['validations'] as $type => $validation) {
            $typeName = $this->getStatisticTypeName($type);
            $status = $validation['valid'] === true ? '✅' : ($validation['valid'] === false ? '❌' : '⏳');
            $bodyMessage .= "**{$typeName}:** {$status}\n";
        }

        Notification::make()
            ->title('📊 Ringkasan Validasi Populasi')
            ->body($bodyMessage)
            ->color($summary['all_consistent'] ? 'success' : 'warning')
            ->duration(8000)
            ->send();
    }

    /**
     * Get human readable statistic type name
     */
    private function getStatisticTypeName(string $type): string
    {
        $names = [
            'umur' => 'Statistik Umur',
            'pekerjaan' => 'Statistik Pekerjaan',
            'pendidikan' => 'Statistik Pendidikan',
            'agama' => 'Statistik Agama',
            'perkawinan' => 'Statistik Perkawinan',
            'wajib_pilih' => 'Statistik Wajib Pilih'
        ];

        return $names[$type] ?? ucfirst($type);
    }
}
