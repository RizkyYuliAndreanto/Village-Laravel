<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WajibPilihStatistikResource\Pages;
use App\Models\WajibPilihStatistik;
use App\Models\TahunData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WajibPilihStatistikResource extends Resource
{
    protected static ?string $model = WajibPilihStatistik::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'Statistik Wajib Pilih';

    protected static ?string $modelLabel = 'Statistik Wajib Pilih';

    protected static ?string $pluralModelLabel = 'Statistik Wajib Pilih';

    protected static ?string $navigationGroup = 'Data Statistik';

    protected static ?int $navigationSort = 8;

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
                                    $existing = WajibPilihStatistik::where('tahun_id', $state)->exists();
                                    if ($existing) {
                                        \Filament\Notifications\Notification::make()
                                            ->warning()
                                            ->title('Perhatian!')
                                            ->body('Tahun yang dipilih sudah memiliki data statistik wajib pilih.')
                                            ->duration(3000)
                                            ->send();
                                    }
                                }
                            })
                            ->helperText(function ($state) {
                                if (!$state) {
                                    return 'Pilih tahun untuk data statistik wajib pilih. Sistem akan mengecek ketersediaan data.';
                                }

                                $existing = WajibPilihStatistik::where('tahun_id', $state)->exists();
                                if ($existing) {
                                    return '⚠️ Data statistik wajib pilih untuk tahun ini sudah ada. Jika Anda melanjutkan, akan ada error duplikasi.';
                                }

                                return '✅ Tahun ini belum memiliki data statistik wajib pilih. Aman untuk membuat data baru.';
                            }),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Data Statistik Wajib Pilih')
                    ->description('Masukkan jumlah penduduk yang memiliki hak pilih berdasarkan jenis kelamin')
                    ->schema([
                        Forms\Components\TextInput::make('laki_laki')
                            ->label('Laki-laki')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('perempuan')
                            ->label('Perempuan')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                self::updateTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('total')
                            ->label('Total')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->readOnly()
                            ->helperText('Total akan otomatis terisi berdasarkan penjumlahan laki-laki dan perempuan')
                            ->live(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Ringkasan')
                    ->schema([
                        Forms\Components\Placeholder::make('ringkasan')
                            ->label('Total Wajib Pilih')
                            ->content(function (Forms\Get $get): string {
                                $lakiLaki = (int) $get('laki_laki');
                                $perempuan = (int) $get('perempuan');
                                $total = $lakiLaki + $perempuan;

                                return "Laki-laki: " . number_format($lakiLaki) . " | " .
                                    "Perempuan: " . number_format($perempuan) . " | " .
                                    "Total: " . number_format($total) . " orang";
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

                Tables\Columns\TextColumn::make('laki_laki')
                    ->label('Laki-laki')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('perempuan')
                    ->label('Perempuan')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
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
            'index' => Pages\ListWajibPilihStatistiks::route('/'),
            'create' => Pages\CreateWajibPilihStatistik::route('/create'),
            'view' => Pages\ViewWajibPilihStatistik::route('/{record}'),
            'edit' => Pages\EditWajibPilihStatistik::route('/{record}/edit'),
        ];
    }

    private static function updateTotal(Forms\Set $set, Forms\Get $get): void
    {
        // Calculate total automatically
        $lakiLaki = (int) $get('laki_laki');
        $perempuan = (int) $get('perempuan');
        $total = $lakiLaki + $perempuan;

        $set('total', $total);
    }
}
