<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UmurStatistikResource\Pages;
use App\Filament\Resources\UmurStatistikResource\RelationManagers;
use App\Models\UmurStatistik;
use App\Models\TahunData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UmurStatistikResource extends Resource
{
    protected static ?string $model = UmurStatistik::class;

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
                    ->description('Masukkan jumlah penduduk berdasarkan kelompok umur')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('umur_0_4')
                                    ->label('Umur 0-4 Tahun')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->suffix('orang')
                                    ->helperText('Jumlah penduduk usia 0-4 tahun'),

                                Forms\Components\TextInput::make('umur_5_9')
                                    ->label('Umur 5-9 Tahun')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->suffix('orang')
                                    ->helperText('Jumlah penduduk usia 5-9 tahun'),

                                Forms\Components\TextInput::make('umur_10_14')
                                    ->label('Umur 10-14 Tahun')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->suffix('orang')
                                    ->helperText('Jumlah penduduk usia 10-14 tahun'),

                                Forms\Components\TextInput::make('umur_15_19')
                                    ->label('Umur 15-19 Tahun')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->suffix('orang')
                                    ->helperText('Jumlah penduduk usia 15-19 tahun'),

                                Forms\Components\TextInput::make('umur_20_24')
                                    ->label('Umur 20-24 Tahun')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->suffix('orang')
                                    ->helperText('Jumlah penduduk usia 20-24 tahun'),

                                Forms\Components\TextInput::make('umur_25_29')
                                    ->label('Umur 25-29 Tahun')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->suffix('orang')
                                    ->helperText('Jumlah penduduk usia 25-29 tahun'),

                                Forms\Components\TextInput::make('umur_30_34')
                                    ->label('Umur 30-34 Tahun')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->suffix('orang')
                                    ->helperText('Jumlah penduduk usia 30-34 tahun'),

                                Forms\Components\TextInput::make('umur_35_39')
                                    ->label('Umur 35-39 Tahun')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->suffix('orang')
                                    ->helperText('Jumlah penduduk usia 35-39 tahun'),

                                Forms\Components\TextInput::make('umur_40_44')
                                    ->label('Umur 40-44 Tahun')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->suffix('orang')
                                    ->helperText('Jumlah penduduk usia 40-44 tahun'),

                                Forms\Components\TextInput::make('umur_45_49')
                                    ->label('Umur 45-49 Tahun')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->suffix('orang')
                                    ->helperText('Jumlah penduduk usia 45-49 tahun'),

                                Forms\Components\TextInput::make('umur_50_plus')
                                    ->label('Umur 50+ Tahun')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->suffix('orang')
                                    ->helperText('Jumlah penduduk usia 50 tahun ke atas'),
                            ]),
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
