<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendidikanStatistikResource\Pages;
use App\Models\PendidikanStatistik;
use App\Models\TahunData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendidikanStatistikResource extends Resource
{
    protected static ?string $model = PendidikanStatistik::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Statistik Pendidikan';

    protected static ?string $modelLabel = 'Statistik Pendidikan';

    protected static ?string $pluralModelLabel = 'Statistik Pendidikan';

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
                                    $existing = PendidikanStatistik::where('tahun_id', $state)->exists();
                                    if ($existing) {
                                        \Filament\Notifications\Notification::make()
                                            ->warning()
                                            ->title('Perhatian!')
                                            ->body('Tahun yang dipilih sudah memiliki data statistik pendidikan.')
                                            ->duration(3000)
                                            ->send();
                                    }
                                }
                            })
                            ->helperText(function ($state) {
                                if (!$state) {
                                    return 'Pilih tahun untuk data statistik pendidikan. Sistem akan mengecek ketersediaan data.';
                                }

                                $existing = PendidikanStatistik::where('tahun_id', $state)->exists();
                                if ($existing) {
                                    return '⚠️ Data statistik pendidikan untuk tahun ini sudah ada. Jika Anda melanjutkan, akan ada error duplikasi.';
                                }

                                return '✅ Tahun ini belum memiliki data statistik pendidikan. Aman untuk membuat data baru.';
                            }),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Data Statistik Pendidikan')
                    ->description('Masukkan jumlah penduduk berdasarkan tingkat pendidikan')
                    ->schema([
                        Forms\Components\TextInput::make('tidak_sekolah')
                            ->label('Tidak Sekolah')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('sd')
                            ->label('SD/Sederajat')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('smp')
                            ->label('SMP/Sederajat')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('sma')
                            ->label('SMA/Sederajat')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('d1_d4')
                            ->label('D1-D4/Diploma')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('s1')
                            ->label('S1/Sarjana')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('s2')
                            ->label('S2/Magister')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('s3')
                            ->label('S3/Doktor')
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
                                    'tidak_sekolah',
                                    'sd',
                                    'smp',
                                    'sma',
                                    'd1_d4',
                                    's1',
                                    's2',
                                    's3',
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

                Tables\Columns\TextColumn::make('tidak_sekolah')
                    ->label('Tidak Sekolah')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sd')
                    ->label('SD')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('smp')
                    ->label('SMP')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sma')
                    ->label('SMA')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('d1_d4')
                    ->label('D1-D4')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('s1')
                    ->label('S1')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('s2')
                    ->label('S2')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('s3')
                    ->label('S3')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->state(function (PendidikanStatistik $record): int {
                        return $record->tidak_sekolah + $record->sd +
                            $record->smp + $record->sma +
                            $record->d1_d4 + $record->s1 +
                            $record->s2 + $record->s3;
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
            'index' => Pages\ListPendidikanStatistiks::route('/'),
            'create' => Pages\CreatePendidikanStatistik::route('/create'),
            'view' => Pages\ViewPendidikanStatistik::route('/{record}'),
            'edit' => Pages\EditPendidikanStatistik::route('/{record}/edit'),
        ];
    }

    private static function updateTotal(Forms\Set $set, Forms\Get $get): void
    {
        // This method is called to trigger reactive updates
        // The total is calculated in the Placeholder component
    }
}
