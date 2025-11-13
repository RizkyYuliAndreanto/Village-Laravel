<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DusunStatistikResource\Pages;
use App\Filament\Resources\DusunStatistikResource\RelationManagers;
use App\Models\DusunStatistik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DusunStatistikResource extends Resource
{
    protected static ?string $model = DusunStatistik::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationLabel = 'Statistik Dusun';

    protected static ?string $modelLabel = 'Statistik Dusun';

    protected static ?string $pluralModelLabel = 'Data Statistik Dusun';

    protected static ?string $navigationGroup = 'Statistik Penduduk';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dusun')
                    ->description('Data statistik penduduk per dusun')
                    ->schema([
                        Forms\Components\Select::make('tahun_id')
                            ->label('Tahun Data')
                            ->relationship('tahunData', 'tahun')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $namaDusun = $get('nama_dusun');
                                if ($state && $namaDusun) {
                                    $existing = DusunStatistik::where('tahun_id', $state)
                                        ->where('nama_dusun', $namaDusun)
                                        ->exists();
                                    if ($existing) {
                                        \Filament\Notifications\Notification::make()
                                            ->warning()
                                            ->title('Perhatian!')
                                            ->body("Dusun '{$namaDusun}' untuk tahun yang dipilih sudah ada.")
                                            ->duration(3000)
                                            ->send();
                                    }
                                }
                            })
                            ->helperText('Pilih tahun untuk data statistik dusun'),

                        Forms\Components\TextInput::make('nama_dusun')
                            ->label('Nama Dusun')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Contoh: Dusun Mawar, Dusun Melati')
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $tahunId = $get('tahun_id');
                                if ($state && $tahunId) {
                                    $existing = DusunStatistik::where('tahun_id', $tahunId)
                                        ->where('nama_dusun', $state)
                                        ->exists();
                                    if ($existing) {
                                        \Filament\Notifications\Notification::make()
                                            ->warning()
                                            ->title('Perhatian!')
                                            ->body("Dusun '{$state}' untuk tahun yang dipilih sudah ada.")
                                            ->duration(3000)
                                            ->send();
                                    }
                                }
                            })
                            ->helperText(function ($state, Forms\Get $get) {
                                if (!$state || !$get('tahun_id')) {
                                    return 'Masukkan nama dusun (maksimal 100 karakter). Sistem akan mengecek duplikasi.';
                                }

                                $existing = DusunStatistik::where('tahun_id', $get('tahun_id'))
                                    ->where('nama_dusun', $state)
                                    ->exists();
                                if ($existing) {
                                    return "⚠️ Dusun '{$state}' untuk tahun ini sudah ada. Jika Anda melanjutkan, akan ada error duplikasi.";
                                }

                                return "✅ Nama dusun '{$state}' untuk tahun ini belum ada. Aman untuk membuat data baru.";
                            }),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('jumlah_penduduk')
                                    ->label('Jumlah Penduduk')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->helperText('Total penduduk di dusun ini'),

                                Forms\Components\TextInput::make('jumlah_kk')
                                    ->label('Jumlah Kepala Keluarga')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->helperText('Total Kepala Keluarga di dusun ini'),
                            ]),

                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(3)
                            ->maxLength(1000)
                            ->placeholder('Catatan tambahan tentang dusun ini (opsional)')
                            ->helperText('Informasi tambahan seperti batas wilayah, fasilitas, dll (maksimal 1000 karakter)')
                            ->columnSpanFull(),
                    ]),
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

                Tables\Columns\TextColumn::make('nama_dusun')
                    ->label('Nama Dusun')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('jumlah_penduduk')
                    ->label('Jumlah Penduduk')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => number_format($state))
                    ->alignEnd()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('jumlah_kk')
                    ->label('Jumlah KK')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => number_format($state))
                    ->alignEnd()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('rata_rata_per_kk')
                    ->label('Rata-rata per KK')
                    ->getStateUsing(function ($record): string {
                        if ($record->jumlah_kk > 0) {
                            $average = round($record->jumlah_penduduk / $record->jumlah_kk, 1);
                            return $average . ' orang/KK';
                        }
                        return '0 orang/KK';
                    })
                    ->alignCenter()
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    })
                    ->toggleable(),

                Tables\Columns\TextColumn::make('create_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tahun_id')
                    ->label('Filter Tahun')
                    ->relationship('tahunData', 'tahun')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('jumlah_penduduk_range')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('penduduk_dari')
                                    ->label('Jumlah Penduduk Dari')
                                    ->numeric(),
                                Forms\Components\TextInput::make('penduduk_sampai')
                                    ->label('Jumlah Penduduk Sampai')
                                    ->numeric(),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['penduduk_dari'],
                                fn(Builder $query, $value): Builder => $query->where('jumlah_penduduk', '>=', $value),
                            )
                            ->when(
                                $data['penduduk_sampai'],
                                fn(Builder $query, $value): Builder => $query->where('jumlah_penduduk', '<=', $value),
                            );
                    }),
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
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('create_at', 'desc');
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
            'index' => Pages\ListDusunStatistiks::route('/'),
            'create' => Pages\CreateDusunStatistik::route('/create'),
            'edit' => Pages\EditDusunStatistik::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function canEdit($record): bool
    {
        return true;
    }

    public static function canDelete($record): bool
    {
        return true;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nama_dusun', 'keterangan'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Tahun' => $record->tahunData->tahun,
            'Penduduk' => number_format($record->jumlah_penduduk) . ' orang',
            'KK' => number_format($record->jumlah_kk) . ' KK',
        ];
    }
}
