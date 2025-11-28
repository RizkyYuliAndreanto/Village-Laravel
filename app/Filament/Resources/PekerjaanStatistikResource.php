<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PekerjaanStatistikResource\Pages;
use App\Models\PekerjaanStatistik;
use App\Models\TahunData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PekerjaanStatistikResource extends Resource
{
    protected static ?string $model = PekerjaanStatistik::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Statistik Pekerjaan';

    protected static ?string $modelLabel = 'Statistik Pekerjaan';

    protected static ?string $pluralModelLabel = 'Statistik Pekerjaan';

    protected static ?string $navigationGroup = 'Data Statistik';

    protected static ?int $navigationSort = 5;

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
                                    $existing = PekerjaanStatistik::where('tahun_id', $state)->exists();
                                    if ($existing) {
                                        \Filament\Notifications\Notification::make()
                                            ->warning()
                                            ->title('Perhatian!')
                                            ->body('Tahun yang dipilih sudah memiliki data statistik pekerjaan.')
                                            ->duration(3000)
                                            ->send();
                                    }
                                }
                            })
                            ->helperText(function ($state) {
                                if (!$state) {
                                    return 'Pilih tahun untuk data statistik pekerjaan. Sistem akan mengecek ketersediaan data.';
                                }

                                $existing = PekerjaanStatistik::where('tahun_id', $state)->exists();
                                if ($existing) {
                                    return '⚠️ Data statistik pekerjaan untuk tahun ini sudah ada. Jika Anda melanjutkan, akan ada error duplikasi.';
                                }

                                return '✅ Tahun ini belum memiliki data statistik pekerjaan. Aman untuk membuat data baru.';
                            }),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Data Statistik Pekerjaan')
                    ->description('Masukkan jumlah penduduk berdasarkan jenis pekerjaan')
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

                        Forms\Components\TextInput::make('petani')
                            ->label('Petani')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('pelajar_mahasiswa')
                            ->label('Pelajar/Mahasiswa')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('pegawai_swasta')
                            ->label('Pegawai Swasta')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('wiraswasta')
                            ->label('Wiraswasta')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('ibu_rumah_tangga')
                            ->label('Ibu Rumah Tangga')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('belum_bekerja')
                            ->label('Belum Bekerja')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('lainnya')
                            ->label('Lainnya')
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
                                    'petani',
                                    'pelajar_mahasiswa',
                                    'pegawai_swasta',
                                    'wiraswasta',
                                    'ibu_rumah_tangga',
                                    'belum_bekerja',
                                    'lainnya',
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

                Tables\Columns\TextColumn::make('petani')
                    ->label('Petani')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pelajar_mahasiswa')
                    ->label('Pelajar/Mahasiswa')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pegawai_swasta')
                    ->label('Pegawai Swasta')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('wiraswasta')
                    ->label('Wiraswasta')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('ibu_rumah_tangga')
                    ->label('Ibu RT')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('belum_bekerja')
                    ->label('Belum Bekerja')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('lainnya')
                    ->label('Lainnya')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->state(function (PekerjaanStatistik $record): int {
                        return $record->tidak_sekolah + $record->petani +
                            $record->pelajar_mahasiswa + $record->pegawai_swasta +
                            $record->wiraswasta + $record->ibu_rumah_tangga +
                            $record->belum_bekerja + $record->lainnya;
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
            'index' => Pages\ListPekerjaanStatistiks::route('/'),
            'create' => Pages\CreatePekerjaanStatistik::route('/create'),
            'view' => Pages\ViewPekerjaanStatistik::route('/{record}'),
            'edit' => Pages\EditPekerjaanStatistik::route('/{record}/edit'),
        ];
    }

    private static function updateTotal(Forms\Set $set, Forms\Get $get): void
    {
        // This method is called to trigger reactive updates
        // The total is calculated in the Placeholder component
    }
}
