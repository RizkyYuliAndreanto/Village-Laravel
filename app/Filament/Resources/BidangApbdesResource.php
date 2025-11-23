<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BidangApbdes\Pages;
use App\Models\BidangApbdes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class BidangApbdesResource extends Resource
{
    protected static ?string $model = BidangApbdes::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationLabel = 'Bidang APBDes';

    protected static ?string $navigationGroup = 'APBDes';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_bidang')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true)
                    ->label('Kode Bidang')
                    ->placeholder('Contoh: BPD01')
                    ->helperText('Kode unik untuk bidang (max 10 karakter)'),

                Forms\Components\TextInput::make('nama_bidang')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Bidang')
                    ->placeholder('Contoh: Bidang Penyelenggaraan Pemerintahan Desa')
                    ->columnSpanFull(),

                Forms\Components\Select::make('kategori')
                    ->required()
                    ->options([
                        'pendapatan' => 'Pendapatan',
                        'belanja' => 'Belanja/Pengeluaran',
                    ])
                    ->native(false)
                    ->label('Kategori')
                    ->helperText('Pilih kategori bidang ini'),

                Forms\Components\Textarea::make('deskripsi')
                    ->maxLength(65535)
                    ->rows(3)
                    ->columnSpanFull()
                    ->label('Deskripsi')
                    ->placeholder('Deskripsi detail bidang (opsional)'),

                Forms\Components\TextInput::make('urutan')
                    ->numeric()
                    ->default(0)
                    ->label('Urutan')
                    ->helperText('Urutan tampil (angka kecil muncul pertama)'),

                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->label('Status Aktif')
                    ->helperText('Centang untuk mengaktifkan bidang ini'),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_bidang')
                    ->searchable()
                    ->sortable()
                    ->label('Kode'),

                Tables\Columns\TextColumn::make('nama_bidang')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Bidang')
                    ->limit(50),

                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pendapatan' => 'success',
                        'belanja' => 'warning',
                        default => 'gray',
                    })
                    ->label('Kategori'),

                Tables\Columns\TextColumn::make('total_anggaran')
                    ->money('IDR')
                    ->label('Total Anggaran')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('total_realisasi')
                    ->money('IDR')
                    ->label('Total Realisasi')
                    ->alignEnd(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif'),

                Tables\Columns\TextColumn::make('urutan')
                    ->sortable()
                    ->label('Urutan'),
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->options([
                        'pendapatan' => 'Pendapatan',
                        'belanja' => 'Belanja',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->boolean()
                    ->trueLabel('Hanya Aktif')
                    ->falseLabel('Hanya Non-Aktif')
                    ->native(false),
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
            ->defaultSort('urutan');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBidangApbdes::route('/'),
            'create' => Pages\CreateBidangApbdes::route('/create'),
            'edit' => Pages\EditBidangApbdes::route('/{record}/edit'),
        ];
    }
}
