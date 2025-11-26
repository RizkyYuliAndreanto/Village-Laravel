<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UmkmResource\Pages;
use App\Filament\Resources\UmkmResource\RelationManagers;
use App\Models\Umkm;
use App\Models\KategoriUmkm;
use Filament\Forms;
use Filament\Forms\Components\FileUpload; // Import FileUpload
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn; // Import ImageColumn
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class UmkmResource extends Resource
{
    protected static ?string $model = Umkm::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationLabel = 'UMKM';

    protected static ?string $modelLabel = 'UMKM';

    protected static ?string $pluralModelLabel = 'UMKM';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Manajemen UMKM';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\Select::make('kategori_id')
                            ->label('Kategori')
                            // Menggunakan relationship agar lebih dinamis
                            ->relationship('kategori', 'nama_kategori')
                            ->searchable()
                            ->preload()
                            ->required(),
                            
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama UMKM')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                            
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Umkm::class, 'slug', ignoreRecord: true),
                            
                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                            
                        Forms\Components\TextInput::make('pemilik')
                            ->label('Nama Pemilik')
                            ->maxLength(150),
                    ])
                    ->columns(2),

                // SECTION MEDIA (UPDATED)
                Forms\Components\Section::make('Media')
                    ->schema([
                        FileUpload::make('logo_url')
                            ->label('Logo UMKM')
                            ->image()
                            ->directory('umkm-logos') // Menyimpan di storage/app/public/umkm-logos
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(2048), // Maks 2MB

                        FileUpload::make('foto_galeri')
                            ->label('Galeri Foto')
                            ->image()
                            ->multiple() // Upload banyak foto
                            ->reorderable()
                            ->directory('umkm-gallery') // Menyimpan di storage/app/public/umkm-gallery
                            ->visibility('public')
                            ->maxSize(2048)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Alamat & Kontak')
                    ->schema([
                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->maxLength(500)
                            ->rows(2)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('dusun')
                            ->label('Dusun')
                            ->maxLength(150),
                        Forms\Components\TextInput::make('rt')
                            ->label('RT')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('rw')
                            ->label('RW')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('kecamatan')
                            ->label('Kecamatan')
                            ->maxLength(150),
                        Forms\Components\TextInput::make('kota')
                            ->label('Kota/Kabupaten')
                            ->maxLength(150),
                        Forms\Components\TextInput::make('provinsi')
                            ->label('Provinsi')
                            ->maxLength(150),
                        Forms\Components\TextInput::make('kode_pos')
                            ->label('Kode Pos')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('telepon')
                            ->label('No. Telepon')
                            ->tel()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('website')
                            ->label('Website')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Media Sosial & Marketplace')
                    ->schema([
                        Forms\Components\TextInput::make('sosial_facebook')
                            ->label('Facebook')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sosial_instagram')
                            ->label('Instagram')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('sosial_tiktok')
                            ->label('TikTok')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('shopee_url')
                            ->label('Shopee')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tokopedia_url')
                            ->label('Tokopedia')
                            ->url()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tiktokshop_url')
                            ->label('TikTok Shop')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Data Usaha')
                    ->schema([
                        Forms\Components\Select::make('jenis_usaha')
                            ->label('Jenis Usaha')
                            ->options([
                                'kuliner' => 'Kuliner',
                                'perdagangan' => 'Perdagangan',
                                'jasa' => 'Jasa',
                                'pertanian' => 'Pertanian',
                                'fashion' => 'Fashion',
                                'kerajinan' => 'Kerajinan',
                                'teknologi' => 'Teknologi',
                                'lainnya' => 'Lainnya',
                            ])
                            ->searchable(),
                        Forms\Components\Select::make('status_usaha')
                            ->label('Status Usaha')
                            ->options([
                                'aktif' => 'Aktif',
                                'tidak_aktif' => 'Tidak Aktif',
                                'tutup_sementara' => 'Tutup Sementara',
                            ])
                            ->default('aktif'),
                        Forms\Components\Select::make('skala_usaha')
                            ->label('Skala Usaha')
                            ->options([
                                'mikro' => 'Mikro',
                                'kecil' => 'Kecil',
                                'menengah' => 'Menengah',
                            ])
                            ->default('mikro'),
                        Forms\Components\TextInput::make('omset_per_bulan')
                            ->label('Omset Per Bulan (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->placeholder('Kosongkan jika tidak diketahui')
                            ->helperText('Opsional - dapat dikosongkan jika belum diketahui'),
                        Forms\Components\TextInput::make('jumlah_karyawan')
                            ->label('Jumlah Karyawan')
                            ->numeric()
                            ->minValue(0)
                            ->placeholder('0 jika tidak ada karyawan'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // IMAGE COLUMN (UPDATED)
                ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(url('/images/logo-placeholder.jpg')),

                Tables\Columns\TextColumn::make('kategori.nama_kategori')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama UMKM')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                Tables\Columns\TextColumn::make('pemilik')
                    ->label('Pemilik')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('dusun')
                    ->label('Dusun')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\BadgeColumn::make('jenis_usaha')
                    ->label('Jenis')
                    ->colors([
                        'primary' => 'kuliner',
                        'success' => 'perdagangan',
                        'warning' => 'jasa',
                        'info' => 'pertanian',
                        'danger' => 'fashion',
                        'secondary' => 'kerajinan',
                    ]),
                Tables\Columns\BadgeColumn::make('status_usaha')
                    ->label('Status')
                    ->colors([
                        'success' => 'aktif',
                        'danger' => 'tidak_aktif',
                        'warning' => 'tutup_sementara',
                    ]),
                Tables\Columns\BadgeColumn::make('skala_usaha')
                    ->label('Skala')
                    ->colors([
                        'primary' => 'mikro',
                        'success' => 'kecil',
                        'warning' => 'menengah',
                    ]),
                Tables\Columns\TextColumn::make('omset_per_bulan')
                    ->label('Omset/Bulan')
                    ->money('IDR')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('Tidak diisi'),
                Tables\Columns\TextColumn::make('jumlah_karyawan')
                    ->label('Karyawan')
                    ->suffix(' orang')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('0'),
                Tables\Columns\TextColumn::make('telepon')
                    ->label('Telepon')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama_kategori'),
                Tables\Filters\SelectFilter::make('jenis_usaha')
                    ->label('Jenis Usaha')
                    ->options([
                        'kuliner' => 'Kuliner',
                        'perdagangan' => 'Perdagangan',
                        'jasa' => 'Jasa',
                        'pertanian' => 'Pertanian',
                        'fashion' => 'Fashion',
                        'kerajinan' => 'Kerajinan',
                        'teknologi' => 'Teknologi',
                        'lainnya' => 'Lainnya',
                    ]),
                Tables\Filters\SelectFilter::make('status_usaha')
                    ->label('Status')
                    ->options([
                        'aktif' => 'Aktif',
                        'tidak_aktif' => 'Tidak Aktif',
                        'tutup_sementara' => 'Tutup Sementara',
                    ]),
                Tables\Filters\SelectFilter::make('skala_usaha')
                    ->label('Skala')
                    ->options([
                        'mikro' => 'Mikro',
                        'kecil' => 'Kecil',
                        'menengah' => 'Menengah',
                    ]),
                Tables\Filters\SelectFilter::make('dusun')
                    ->label('Dusun')
                    ->options(function () {
                        return Umkm::whereNotNull('dusun')
                            ->distinct()
                            ->pluck('dusun', 'dusun')
                            ->toArray();
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
            ]);
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
            'index' => Pages\ListUmkms::route('/'),
            'create' => Pages\CreateUmkm::route('/create'),
            'edit' => Pages\EditUmkm::route('/{record}/edit'),
        ];
    }
}