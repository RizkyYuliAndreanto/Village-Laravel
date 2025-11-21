<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DetailApbdes\pages;
use App\Models\DetailApbdes;
use BackedEnum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DetailApbdesResource extends Resource
{
    protected static ?string $model = DetailApbdes::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $recordTitleAttribute = 'uraian';

    protected static ?string $navigationLabel = 'Detail APBDes';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'APBDes';

    // Sembunyikan dari navigation menu
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('laporan_apbdes_id')
                    ->relationship('laporanApbdes', 'nama_laporan')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->label('Laporan APBDes')
                    ->placeholder('Pilih Laporan')
                    ->helperText('Pilih laporan APBDes yang akan didetailkan'),

                Forms\Components\Select::make('tipe')
                    ->options([
                        'pendapatan' => 'Pendapatan',
                        'belanja' => 'Belanja',
                        'pembiayaan' => 'Pembiayaan',
                    ])
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->label('Jenis')
                    ->placeholder('Pilih Jenis')
                    ->helperText('Jenis detail APBDes'),

                Forms\Components\TextInput::make('uraian')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->label('Uraian')
                    ->placeholder('Contoh: Hasil Usaha Desa')
                    ->helperText('Deskripsi item anggaran'),

                Forms\Components\TextInput::make('anggaran')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Anggaran')
                    ->placeholder('0')
                    ->helperText('Nilai anggaran yang direncanakan')
                    ->default(0),

                Forms\Components\TextInput::make('realisasi')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Realisasi')
                    ->placeholder('0')
                    ->helperText('Nilai realisasi anggaran')
                    ->default(0),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('laporanApbdes.nama_laporan')
                    ->searchable()
                    ->sortable()
                    ->label('Laporan APBDes')
                    ->wrap()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('laporanApbdes.tahunData.tahun')
                    ->sortable()
                    ->label('Tahun')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('tipe')
                    ->badge()
                    ->colors([
                        'success' => 'pendapatan',
                        'danger' => 'belanja',
                        'warning' => 'pembiayaan',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->sortable()
                    ->label('Jenis'),

                Tables\Columns\TextColumn::make('uraian')
                    ->searchable()
                    ->wrap()
                    ->limit(50)
                    ->label('Uraian')
                    ->tooltip(fn($record) => $record->uraian),

                Tables\Columns\TextColumn::make('anggaran')
                    ->money('IDR')
                    ->sortable()
                    ->label('Anggaran')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('realisasi')
                    ->money('IDR')
                    ->sortable()
                    ->label('Realisasi')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('selisih')
                    ->getStateUsing(fn($record) => $record->realisasi - $record->anggaran)
                    ->money('IDR')
                    ->color(fn($state) => $state < 0 ? 'danger' : 'success')
                    ->label('Selisih')
                    ->alignEnd()
                    ->tooltip(fn($state) => $state < 0 ? 'Kurang dari anggaran' : 'Melebihi anggaran'),

                Tables\Columns\TextColumn::make('persentase')
                    ->getStateUsing(fn($record) => $record->anggaran > 0
                        ? round(($record->realisasi / $record->anggaran) * 100, 2)
                        : 0)
                    ->suffix('%')
                    ->color(fn($state) => match (true) {
                        $state < 50 => 'danger',
                        $state < 80 => 'warning',
                        $state < 100 => 'info',
                        default => 'success',
                    })
                    ->label('% Realisasi')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Dibuat')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Diperbarui')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('laporan_apbdes_id')
                    ->relationship('laporanApbdes', 'nama_laporan')
                    ->label('Filter Laporan')
                    ->searchable()
                    ->preload()
                    ->placeholder('Semua Laporan'),

                Tables\Filters\SelectFilter::make('tipe')
                    ->options([
                        'pendapatan' => 'Pendapatan',
                        'belanja' => 'Belanja',
                        'pembiayaan' => 'Pembiayaan',
                    ])
                    ->label('Filter Jenis')
                    ->placeholder('Semua Jenis'),
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
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Belum ada detail APBDes')
            ->emptyStateDescription('Tambahkan detail APBDes dari menu Laporan APBDes.')
            ->emptyStateIcon('heroicon-o-document-text')
            ->striped();
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
            'index' => pages\ListDetailApbdes::route('/'),
            'create' => pages\CreateDetailApbdes::route('/create'),
            'edit' => pages\EditDetailApbdes::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'APBDes';
    }
}
