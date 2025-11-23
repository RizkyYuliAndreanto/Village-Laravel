<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DetailApbdesInput\Pages;
use App\Models\DetailApbdes;
use App\Models\BidangApbdes;
use App\Models\LaporanApbdes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Get;
use Filament\Forms\Set;

class DetailApbdesInputResource extends Resource
{
    protected static ?string $model = DetailApbdes::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $recordTitleAttribute = 'uraian';

    protected static ?string $navigationLabel = 'Input Anggaran';

    protected static ?string $navigationGroup = 'APBDes';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section Header Laporan
                Forms\Components\Section::make('Informasi Laporan')
                    ->description('Pilih laporan dan bidang untuk input anggaran')
                    ->schema([
                        Forms\Components\Select::make('laporan_apbdes_id')
                            ->relationship('laporanApbdes', 'nama_laporan')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->label('Laporan APBDes')
                            ->placeholder('Pilih Laporan')
                            ->helperText('Pilih laporan APBDes tahun berapa'),

                        Forms\Components\Select::make('bidang_apbdes_id')
                            ->relationship('bidangApbdes', 'nama_bidang')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->label('Bidang APBDes')
                            ->placeholder('Pilih Bidang')
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                // Auto set tipe berdasarkan bidang yang dipilih
                                if ($state) {
                                    $bidang = BidangApbdes::find($state);
                                    if ($bidang) {
                                        $set('tipe', $bidang->kategori);
                                    }
                                }
                            }),

                        Forms\Components\Select::make('sub_bidang_apbdes_id')
                            ->relationship(
                                name: 'subBidangApbdes',
                                titleAttribute: 'nama_sub_bidang',
                                modifyQueryUsing: fn($query, Get $get) =>
                                $query->where('bidang_apbdes_id', $get('bidang_apbdes_id'))
                            )
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->label('Sub Bidang (Opsional)')
                            ->placeholder('Pilih Sub Bidang')
                            ->helperText('Pilih sub bidang jika ada'),
                    ])
                    ->columns(2),

                // Section Detail Anggaran
                Forms\Components\Section::make('Detail Anggaran')
                    ->description('Input detail uraian dan nominal anggaran')
                    ->schema([
                        Forms\Components\Select::make('tipe')
                            ->options([
                                'pendapatan' => 'Pendapatan',
                                'belanja' => 'Belanja',
                                'pembiayaan' => 'Pembiayaan',
                            ])
                            ->required()
                            ->native(false)
                            ->label('Tipe')
                            ->disabled() // Auto-filled dari bidang
                            ->helperText('Otomatis terisi berdasarkan bidang yang dipilih'),

                        Forms\Components\TextInput::make('uraian')
                            ->required()
                            ->maxLength(255)
                            ->label('Uraian/Nama Item')
                            ->placeholder('Contoh: Pendapatan Asli Desa')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('anggaran')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Anggaran')
                            ->placeholder('0')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                // Auto calculate persentase jika realisasi sudah ada
                                $realisasi = $get('realisasi') ?? 0;
                                if ($state > 0 && $realisasi > 0) {
                                    $persentase = ($realisasi / $state) * 100;
                                    $set('persentase_realisasi', round($persentase, 2));
                                }
                            }),

                        Forms\Components\TextInput::make('realisasi')
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Realisasi')
                            ->placeholder('0')
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                // Auto calculate persentase
                                $anggaran = $get('anggaran') ?? 0;
                                if ($anggaran > 0) {
                                    $persentase = ($state / $anggaran) * 100;
                                    $set('persentase_realisasi', round($persentase, 2));
                                }
                            }),

                        Forms\Components\TextInput::make('persentase_realisasi')
                            ->numeric()
                            ->suffix('%')
                            ->label('Persentase Realisasi')
                            ->disabled()
                            ->helperText('Otomatis dihitung dari anggaran dan realisasi'),

                        Forms\Components\Select::make('bulan_realisasi')
                            ->options([
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember',
                            ])
                            ->native(false)
                            ->label('Bulan Data Realisasi')
                            ->placeholder('Pilih Bulan')
                            ->helperText('Bulan data realisasi ini diambil'),

                        Forms\Components\Textarea::make('keterangan')
                            ->maxLength(65535)
                            ->rows(3)
                            ->columnSpanFull()
                            ->label('Keterangan')
                            ->placeholder('Keterangan tambahan (opsional)'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('laporanApbdes.nama_laporan')
                    ->label('Laporan')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('bidangApbdes.nama_bidang')
                    ->label('Bidang')
                    ->limit(30)
                    ->tooltip(function (DetailApbdes $record): string {
                        return $record->bidangApbdes?->nama_bidang ?? '';
                    }),

                Tables\Columns\TextColumn::make('tipe')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pendapatan' => 'success',
                        'belanja' => 'warning',
                        'pembiayaan' => 'info',
                        default => 'gray',
                    })
                    ->label('Tipe'),

                Tables\Columns\TextColumn::make('uraian')
                    ->searchable()
                    ->limit(40)
                    ->tooltip(function (DetailApbdes $record): string {
                        return $record->uraian;
                    }),

                Tables\Columns\TextColumn::make('anggaran')
                    ->money('IDR')
                    ->sortable()
                    ->alignEnd()
                    ->label('Anggaran'),

                Tables\Columns\TextColumn::make('realisasi')
                    ->money('IDR')
                    ->sortable()
                    ->alignEnd()
                    ->label('Realisasi'),

                Tables\Columns\TextColumn::make('persentase_realisasi')
                    ->suffix('%')
                    ->sortable()
                    ->alignEnd()
                    ->color(fn($state) => match (true) {
                        $state >= 90 => 'success',
                        $state >= 70 => 'warning',
                        default => 'danger',
                    })
                    ->label('% Realisasi'),

                Tables\Columns\TextColumn::make('bulan_realisasi')
                    ->formatStateUsing(function ($state) {
                        $bulan = [
                            1 => 'Jan',
                            2 => 'Feb',
                            3 => 'Mar',
                            4 => 'Apr',
                            5 => 'Mei',
                            6 => 'Jun',
                            7 => 'Jul',
                            8 => 'Agu',
                            9 => 'Sep',
                            10 => 'Okt',
                            11 => 'Nov',
                            12 => 'Des',
                        ];
                        return $bulan[$state] ?? '';
                    })
                    ->label('Bulan'),
            ])
            ->filters([
                SelectFilter::make('laporan_apbdes_id')
                    ->relationship('laporanApbdes', 'nama_laporan')
                    ->label('Laporan'),

                SelectFilter::make('bidang_apbdes_id')
                    ->relationship('bidangApbdes', 'nama_bidang')
                    ->label('Bidang'),

                SelectFilter::make('tipe')
                    ->options([
                        'pendapatan' => 'Pendapatan',
                        'belanja' => 'Belanja',
                        'pembiayaan' => 'Pembiayaan',
                    ])
                    ->label('Tipe'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDetailApbdesInput::route('/'),
            'create' => Pages\CreateDetailApbdesInput::route('/create'),
            'edit' => Pages\EditDetailApbdesInput::route('/{record}/edit'),
        ];
    }
}
