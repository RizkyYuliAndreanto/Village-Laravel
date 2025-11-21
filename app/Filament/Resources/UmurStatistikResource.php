<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UmurStatistikResource\Pages;
use App\Filament\Resources\UmurStatistikResource\RelationManagers;
use App\Models\UmurStatistik;
use App\Models\TahunData;
use App\Traits\HasPopulationValidation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UmurStatistikResource extends Resource
{
    use HasPopulationValidation;

    protected static ?string $model = UmurStatistik::class;

    /**
     * Create a numeric input field for umur data
     */
    protected static function createUmurField(string $fieldName, string $label, string $helperText): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make($fieldName)
            ->label($label)
            ->numeric()
            ->default(0)
            ->minValue(0)
            ->suffix('orang')
            ->helperText($helperText)
            ->live(onBlur: true)
            ->afterStateUpdated(function () {
                // Trigger validation placeholder update
            });
    }

    /**
     * Get form data for validation
     */
    protected static function getFormDataForValidation(Forms\Get $get, string $type): array
    {
        if ($type === 'umur') {
            return [
                'umur_0_4' => (int) $get('umur_0_4') ?? 0,
                'umur_5_9' => (int) $get('umur_5_9') ?? 0,
                'umur_10_14' => (int) $get('umur_10_14') ?? 0,
                'umur_15_19' => (int) $get('umur_15_19') ?? 0,
                'umur_20_24' => (int) $get('umur_20_24') ?? 0,
                'umur_25_29' => (int) $get('umur_25_29') ?? 0,
                'umur_30_34' => (int) $get('umur_30_34') ?? 0,
                'umur_35_39' => (int) $get('umur_35_39') ?? 0,
                'umur_40_44' => (int) $get('umur_40_44') ?? 0,
                'umur_45_49' => (int) $get('umur_45_49') ?? 0,
                'umur_50_plus' => (int) $get('umur_50_plus') ?? 0,
            ];
        }
        return [];
    }

    /**
     * Calculate current total from form data
     */
    protected static function calculateCurrentTotal(array $data, string $type): int
    {
        if ($type === 'umur') {
            return array_sum($data);
        }
        return 0;
    }

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Umur Statistik';

    protected static ?string $modelLabel = 'Umur Statistik';

    protected static ?string $pluralModelLabel = 'Umur Statistik';

    protected static ?string $navigationGroup = 'Statistik Desa';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tahun')
                    ->description('Pilih tahun untuk data statistik umur')
                    ->schema([
                        Forms\Components\Select::make('tahun_id')
                            ->label('Tahun')
                            ->options(TahunData::pluck('tahun', 'id_tahun'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih tahun...')
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                if ($state) {
                                    $existing = UmurStatistik::where('tahun_id', $state)->exists();
                                    if ($existing) {
                                        \Filament\Notifications\Notification::make()
                                            ->warning()
                                            ->title('Perhatian!')
                                            ->body('Tahun yang dipilih sudah memiliki data statistik umur.')
                                            ->duration(3000)
                                            ->send();
                                    }
                                }
                            })
                            ->helperText(function ($state) {
                                if (!$state) {
                                    return 'Pilih tahun untuk data statistik umur. Sistem akan mengecek ketersediaan data.';
                                }

                                $existing = UmurStatistik::where('tahun_id', $state)->exists();
                                if ($existing) {
                                    return '⚠️ Data statistik umur untuk tahun ini sudah ada. Jika Anda melanjutkan, akan ada error duplikasi.';
                                }

                                return '✅ Tahun ini belum memiliki data statistik umur. Aman untuk membuat data baru.';
                            }),
                    ])->columns(1),

                Forms\Components\Section::make('Data Statistik Umur')
                    ->description('Masukkan jumlah penduduk berdasarkan kelompok umur. Total harus sama dengan data Demografi Penduduk.')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                static::createUmurField('umur_0_4', 'Umur 0-4 Tahun', 'Jumlah penduduk usia 0-4 tahun'),
                                static::createUmurField('umur_5_9', 'Umur 5-9 Tahun', 'Jumlah penduduk usia 5-9 tahun'),
                                static::createUmurField('umur_10_14', 'Umur 10-14 Tahun', 'Jumlah penduduk usia 10-14 tahun'),
                                static::createUmurField('umur_15_19', 'Umur 15-19 Tahun', 'Jumlah penduduk usia 15-19 tahun'),
                                static::createUmurField('umur_20_24', 'Umur 20-24 Tahun', 'Jumlah penduduk usia 20-24 tahun'),
                                static::createUmurField('umur_25_29', 'Umur 25-29 Tahun', 'Jumlah penduduk usia 25-29 tahun'),
                                static::createUmurField('umur_30_34', 'Umur 30-34 Tahun', 'Jumlah penduduk usia 30-34 tahun'),
                                static::createUmurField('umur_35_39', 'Umur 35-39 Tahun', 'Jumlah penduduk usia 35-39 tahun'),
                                static::createUmurField('umur_40_44', 'Umur 40-44 Tahun', 'Jumlah penduduk usia 40-44 tahun'),
                                static::createUmurField('umur_45_49', 'Umur 45-49 Tahun', 'Jumlah penduduk usia 45-49 tahun'),
                                static::createUmurField('umur_50_plus', 'Umur 50+ Tahun', 'Jumlah penduduk usia 50 tahun ke atas'),
                            ]),

                        // Validasi total real-time
                        Forms\Components\Placeholder::make('total_validation')
                            ->label('📊 Validasi Total Populasi')
                            ->live()
                            ->content(function (Forms\Get $get): string {
                                $tahunId = $get('tahun_id');
                                if (!$tahunId) {
                                    return 'Pilih tahun terlebih dahulu untuk melihat validasi populasi.';
                                }

                                $validationService = app(\App\Services\PopulationValidationService::class);
                                $expectedPopulation = $validationService->getTotalPopulation($tahunId);

                                if ($expectedPopulation === null) {
                                    return '⚠️ Data Demografi Penduduk belum tersedia untuk tahun ini.';
                                }

                                $data = static::getFormDataForValidation($get, 'umur');
                                $currentTotal = static::calculateCurrentTotal($data, 'umur');

                                if ($currentTotal === 0) {
                                    return "🎯 Target total populasi: " . number_format($expectedPopulation) . " orang. Saat ini: 0 orang.";
                                }

                                $difference = $currentTotal - $expectedPopulation;

                                if ($difference === 0) {
                                    return "✅ SESUAI - Target: " . number_format($expectedPopulation) . " | Saat ini: " . number_format($currentTotal) . " orang";
                                } elseif ($difference > 0) {
                                    return "⚠️ BERLEBIH - Target: " . number_format($expectedPopulation) . " | Saat ini: " . number_format($currentTotal) . " | Kelebihan: " . number_format($difference) . " orang";
                                } else {
                                    return "⚠️ KURANG - Target: " . number_format($expectedPopulation) . " | Saat ini: " . number_format($currentTotal) . " | Kekurangan: " . number_format(abs($difference)) . " orang";
                                }
                            }),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahunData.tahun')
                    ->label('Tahun')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('umur_0_4')
                    ->label('0-4 Tahun')
                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('umur_5_9')
                    ->label('5-9 Tahun')
                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('umur_10_14')
                    ->label('10-14 Tahun')
                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('umur_15_19')
                    ->label('15-19 Tahun')
                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('umur_20_24')
                    ->label('20-24 Tahun')
                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('umur_25_29')
                    ->label('25-29 Tahun')
                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('umur_30_34')
                    ->label('30-34 Tahun')
                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('umur_35_39')
                    ->label('35-39 Tahun')
                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('umur_40_44')
                    ->label('40-44 Tahun')
                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('umur_45_49')
                    ->label('45-49 Tahun')
                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang')
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('umur_50_plus')
                    ->label('50+ Tahun')
                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('total_penduduk')
                    ->label('Total')
                    ->formatStateUsing(function (UmurStatistik $record): string {
                        $total = $record->umur_0_4 + $record->umur_5_9 + $record->umur_10_14 +
                            $record->umur_15_19 + $record->umur_20_24 + $record->umur_25_29 +
                            $record->umur_30_34 + $record->umur_35_39 + $record->umur_40_44 +
                            $record->umur_45_49 + $record->umur_50_plus;
                        return number_format($total) . ' orang';
                    })
                    ->badge()
                    ->color('success')
                    ->alignEnd(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tahun_id')
                    ->label('Tahun')
                    ->options(TahunData::pluck('tahun', 'id_tahun'))
                    ->placeholder('Semua Tahun'),

                Tables\Filters\Filter::make('total_range')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('total_min')
                                    ->label('Total Minimum')
                                    ->numeric()
                                    ->placeholder('0'),
                                Forms\Components\TextInput::make('total_max')
                                    ->label('Total Maksimum')
                                    ->numeric()
                                    ->placeholder('10000'),
                            ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['total_min'],
                                fn(Builder $query, $min): Builder => $query->havingRaw(
                                    '(umur_0_4 + umur_5_9 + umur_10_14 + umur_15_19 + umur_20_24 + umur_25_29 + umur_30_34 + umur_35_39 + umur_40_44 + umur_45_49 + umur_50_plus) >= ?',
                                    [$min]
                                )
                            )
                            ->when(
                                $data['total_max'],
                                fn(Builder $query, $max): Builder => $query->havingRaw(
                                    '(umur_0_4 + umur_5_9 + umur_10_14 + umur_15_19 + umur_20_24 + umur_25_29 + umur_30_34 + umur_35_39 + umur_40_44 + umur_45_49 + umur_50_plus) <= ?',
                                    [$max]
                                )
                            );
                    })
                    ->label('Filter Total Penduduk'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tahun_id', 'desc')
            ->striped()
            ->emptyStateHeading('Belum ada data statistik umur')
            ->emptyStateDescription('Mulai dengan menambahkan data statistik umur pertama.')
            ->emptyStateIcon('heroicon-o-users');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUmurStatistiks::route('/'),
            'create' => Pages\CreateUmurStatistik::route('/create'),
            'view' => Pages\ViewUmurStatistik::route('/{record}'),
            'edit' => Pages\EditUmurStatistik::route('/{record}/edit'),
        ];
    }
}
