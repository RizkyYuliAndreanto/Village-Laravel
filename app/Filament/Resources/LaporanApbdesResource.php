<?php

// UBAH namespace ini
namespace App\Filament\Resources;

use App\Filament\Resources\LaporanApbdes\Pages;
use App\Models\LaporanApbdes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LaporanApbdesResource extends Resource
{
    protected static ?string $model = LaporanApbdes::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $recordTitleAttribute = 'nama_laporan';

    protected static ?string $navigationLabel = 'Laporan APBDes';

    protected static ?string $navigationGroup = 'APBDes';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tahun_id')
                    ->relationship('tahunData', 'tahun')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->label('Tahun')
                    ->placeholder('Pilih Tahun')
                    ->helperText('Pilih tahun untuk laporan APBDes'),

                Forms\Components\TextInput::make('nama_laporan')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Laporan')
                    ->placeholder('Contoh: APBDES 2024')
                    ->helperText('Nama laporan yang akan ditampilkan'),

                Forms\Components\Select::make('bulan_rilis')
                    ->required()
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
                    ->searchable()
                    ->label('Bulan Rilis')
                    ->placeholder('Pilih Bulan')
                    ->helperText('Bulan terbitnya laporan'),

                Forms\Components\Textarea::make('deskripsi')
                    ->maxLength(65535)
                    ->rows(4)
                    ->columnSpanFull()
                    ->label('Deskripsi')
                    ->placeholder('Deskripsi laporan (opsional)')
                    ->helperText('Keterangan tambahan tentang laporan ini'),

                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'diterbitkan' => 'Diterbitkan',
                    ])
                    ->default('draft')
                    ->required()
                    ->native(false)
                    ->label('Status')
                    ->helperText('Status publikasi laporan'),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahunData.tahun')
                    ->sortable()
                    ->searchable()
                    ->label('Tahun')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('nama_laporan')
                    ->searchable()
                    ->label('Nama Laporan')
                    ->weight('medium')
                    ->limit(50),

                Tables\Columns\TextColumn::make('bulan_rilis')
                    ->formatStateUsing(fn($state) => [
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
                    ][$state] ?? '-')
                    ->sortable()
                    ->label('Bulan Rilis')
                    ->icon('heroicon-m-calendar'),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'diterbitkan',
                    ])
                    ->label('Status'),

                Tables\Columns\TextColumn::make('detailApbdes_count')
                    ->counts('detailApbdes')
                    ->label('Jumlah Detail')
                    ->badge()
                    ->color('success'),

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
                Tables\Filters\SelectFilter::make('tahun_id')
                    ->relationship('tahunData', 'tahun') // UBAH DARI 'tahun_data' KE 'tahunData'
                    ->label('Filter Tahun')
                    ->placeholder('Semua Tahun'),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'diterbitkan' => 'Diterbitkan',
                    ])
                    ->label('Filter Status')
                    ->placeholder('Semua Status'),
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
            ->emptyStateHeading('Belum ada laporan APBDes')
            ->emptyStateDescription('Mulai dengan menambahkan laporan APBDes baru.')
            ->emptyStateIcon('heroicon-o-document-text');
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
            'index' => Pages\ListLaporanApbdes::route('/'),
            'create' => Pages\CreateLaporanApbdes::route('/create'),
            'edit' => Pages\EditLaporanApbdes::route('/{record}/edit'),
        ];
    }
}
