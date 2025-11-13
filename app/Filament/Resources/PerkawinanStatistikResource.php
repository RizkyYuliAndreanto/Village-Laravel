<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerkawinanStatistikResource\Pages;
use App\Models\PerkawinanStatistik;
use App\Models\TahunData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PerkawinanStatistikResource extends Resource
{
    protected static ?string $model = PerkawinanStatistik::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationLabel = 'Statistik Perkawinan';

    protected static ?string $modelLabel = 'Statistik Perkawinan';

    protected static ?string $pluralModelLabel = 'Statistik Perkawinan';

    protected static ?string $navigationGroup = 'Data Statistik';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tahun')
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
                                    $existing = PerkawinanStatistik::where('tahun_id', $state)->exists();
                                    if ($existing) {
                                        \Filament\Notifications\Notification::make()
                                            ->warning()
                                            ->title('Perhatian!')
                                            ->body('Tahun yang dipilih sudah memiliki data statistik perkawinan.')
                                            ->duration(3000)
                                            ->send();
                                    }
                                }
                            })
                            ->helperText(function ($state) {
                                if (!$state) {
                                    return 'Pilih tahun untuk data statistik perkawinan. Sistem akan mengecek ketersediaan data.';
                                }

                                $existing = PerkawinanStatistik::where('tahun_id', $state)->exists();
                                if ($existing) {
                                    return '⚠️ Data statistik perkawinan untuk tahun ini sudah ada. Jika Anda melanjutkan, akan ada error duplikasi.';
                                }

                                return '✅ Tahun ini belum memiliki data statistik perkawinan. Aman untuk membuat data baru.';
                            }),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Data Statistik Status Perkawinan')
                    ->description('Masukkan jumlah penduduk berdasarkan status perkawinan')
                    ->schema([
                        Forms\Components\TextInput::make('kawin')
                            ->label('Kawin')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('cerai_hidup')
                            ->label('Cerai Hidup')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('cerai_mati')
                            ->label('Cerai Mati')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Data Pencatatan Perkawinan')
                    ->description('Masukkan jumlah berdasarkan status pencatatan perkawinan')
                    ->schema([
                        Forms\Components\TextInput::make('kawin_tercatat')
                            ->label('Kawin Tercatat')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('kawin_tidak_tercatat')
                            ->label('Kawin Tidak Tercatat')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Total Penduduk')
                    ->schema([
                        Forms\Components\Placeholder::make('total_status_perkawinan')
                            ->label('Total Status Perkawinan')
                            ->content(function (Forms\Get $get): string {
                                $total = collect([
                                    'kawin',
                                    'cerai_hidup',
                                    'cerai_mati',
                                ])->sum(fn($field) => (int) $get($field));

                                return number_format($total) . ' orang';
                            }),

                        Forms\Components\Placeholder::make('total_pencatatan')
                            ->label('Total Pencatatan Perkawinan')
                            ->content(function (Forms\Get $get): string {
                                $total = collect([
                                    'kawin_tercatat',
                                    'kawin_tidak_tercatat',
                                ])->sum(fn($field) => (int) $get($field));

                                return number_format($total) . ' orang';
                            }),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahunData.tahun')
                    ->label('Tahun')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('kawin')
                    ->label('Kawin')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('cerai_hidup')
                    ->label('Cerai Hidup')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('cerai_mati')
                    ->label('Cerai Mati')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kawin_tercatat')
                    ->label('Kawin Tercatat')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kawin_tidak_tercatat')
                    ->label('Tidak Tercatat')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_status')
                    ->label('Total Status')
                    ->state(function (PerkawinanStatistik $record): int {
                        return $record->kawin + $record->cerai_hidup + $record->cerai_mati;
                    })
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_pencatatan')
                    ->label('Total Pencatatan')
                    ->state(function (PerkawinanStatistik $record): int {
                        return $record->kawin_tercatat + $record->kawin_tidak_tercatat;
                    })
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('create_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tahun_id')
                    ->label('Filter Tahun')
                    ->options(TahunData::pluck('tahun', 'id_tahun'))
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
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
            'index' => Pages\ListPerkawinanStatistiks::route('/'),
            'create' => Pages\CreatePerkawinanStatistik::route('/create'),
            'view' => Pages\ViewPerkawinanStatistik::route('/{record}'),
            'edit' => Pages\EditPerkawinanStatistik::route('/{record}/edit'),
        ];
    }

    private static function updateTotal(Forms\Set $set, Forms\Get $get): void
    {
        // This method is called to trigger reactive updates
        // The total is calculated in the Placeholder component
    }
}
