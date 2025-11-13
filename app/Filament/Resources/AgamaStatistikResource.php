<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgamaStatistikResource\Pages;
use App\Models\AgamaStatistik;
use App\Models\TahunData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgamaStatistikResource extends Resource
{
    protected static ?string $model = AgamaStatistik::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Statistik Agama';

    protected static ?string $modelLabel = 'Statistik Agama';

    protected static ?string $pluralModelLabel = 'Statistik Agama';

    protected static ?string $navigationGroup = 'Data Statistik';

    protected static ?int $navigationSort = 6;

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
                                    $existing = AgamaStatistik::where('tahun_id', $state)->exists();
                                    if ($existing) {
                                        \Filament\Notifications\Notification::make()
                                            ->warning()
                                            ->title('Perhatian!')
                                            ->body('Tahun yang dipilih sudah memiliki data statistik agama.')
                                            ->duration(3000)
                                            ->send();
                                    }
                                }
                            })
                            ->helperText(function ($state) {
                                if (!$state) {
                                    return 'Pilih tahun untuk data statistik agama. Sistem akan mengecek ketersediaan data.';
                                }

                                $existing = AgamaStatistik::where('tahun_id', $state)->exists();
                                if ($existing) {
                                    return '⚠️ Data statistik agama untuk tahun ini sudah ada. Jika Anda melanjutkan, akan ada error duplikasi.';
                                }

                                return '✅ Tahun ini belum memiliki data statistik agama. Aman untuk membuat data baru.';
                            }),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Data Statistik Agama')
                    ->description('Masukkan jumlah penduduk berdasarkan agama yang dianut')
                    ->schema([
                        Forms\Components\TextInput::make('islam')
                            ->label('Islam')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('katolik')
                            ->label('Katolik')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('kristen')
                            ->label('Kristen')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('hindu')
                            ->label('Hindu')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('buddha')
                            ->label('Buddha')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('konghucu')
                            ->label('Konghucu')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('kepercayaan_lain')
                            ->label('Kepercayaan Lain')
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
                        Forms\Components\Placeholder::make('total_penduduk')
                            ->label('Total Penduduk')
                            ->content(function (Forms\Get $get): string {
                                $total = collect([
                                    'islam',
                                    'katolik',
                                    'kristen',
                                    'hindu',
                                    'buddha',
                                    'konghucu',
                                    'kepercayaan_lain',
                                ])->sum(fn($field) => (int) $get($field));

                                return number_format($total) . ' orang';
                            }),
                    ])
                    ->columns(1),
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

                Tables\Columns\TextColumn::make('islam')
                    ->label('Islam')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('katolik')
                    ->label('Katolik')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kristen')
                    ->label('Kristen')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('hindu')
                    ->label('Hindu')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('buddha')
                    ->label('Buddha')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('konghucu')
                    ->label('Konghucu')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kepercayaan_lain')
                    ->label('Kepercayaan Lain')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->state(function (AgamaStatistik $record): int {
                        return $record->islam + $record->katolik +
                            $record->kristen + $record->hindu +
                            $record->buddha + $record->konghucu +
                            $record->kepercayaan_lain;
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
            'index' => Pages\ListAgamaStatistiks::route('/'),
            'create' => Pages\CreateAgamaStatistik::route('/create'),
            'view' => Pages\ViewAgamaStatistik::route('/{record}'),
            'edit' => Pages\EditAgamaStatistik::route('/{record}/edit'),
        ];
    }

    private static function updateTotal(Forms\Set $set, Forms\Get $get): void
    {
        // This method is called to trigger reactive updates
        // The total is calculated in the Placeholder component
    }
}
