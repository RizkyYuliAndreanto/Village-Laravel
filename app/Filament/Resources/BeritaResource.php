<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BeritaResource\Pages;
use App\Models\Berita;
use App\Services\MediaStorageService;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Forms;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Berita';

    protected static ?string $modelLabel = 'Berita';

    protected static ?string $pluralModelLabel = 'Berita';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Berita')
                    ->description('Masukkan detail informasi berita')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Berita')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan judul berita...')
                            ->helperText('Judul berita yang akan ditampilkan (maksimal 255 karakter)'),

                        Forms\Components\Select::make('kategori')
                            ->label('Kategori')
                            ->options(Berita::getKategoriOptions())
                            ->required()
                            ->placeholder('Pilih kategori berita...')
                            ->helperText('Kategori berita untuk pengelompokan'),

                        Forms\Components\TextInput::make('penulis')
                            ->label('Penulis')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Masukkan nama penulis...')
                            ->helperText('Nama penulis berita (maksimal 100 karakter)'),
                    ])->columns(1),

                Forms\Components\Section::make('Konten Berita')
                    ->description('Masukkan konten dan media berita')
                    ->schema([
                        Forms\Components\RichEditor::make('isi')
                            ->label('Isi Berita')
                            ->required()
                            ->placeholder('Masukkan isi berita...')
                            ->helperText('Konten lengkap berita')
                            ->columnSpanFull(),

                        Forms\Components\Group::make([
                            Forms\Components\ViewField::make('current_image')
                                ->label('Gambar Saat Ini')
                                ->view('filament.components.image-preview')
                                ->viewData(function ($record) {
                                    return [
                                        'imageUrl' => $record ? $record->image_url : null,
                                        'alt' => $record ? $record->judul : 'Preview'
                                    ];
                                })
                                ->visible(fn($record) => $record && $record->gambar_url)
                                ->columnSpan(1),

                            Forms\Components\FileUpload::make('gambar_url')
                                ->label('Upload Gambar Baru')
                                ->image()
                                ->directory('berita/images')
                                ->disk('public')
                                ->maxFiles(1)
                                ->maxSize(2048)
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])
                                ->helperText('Upload gambar baru (maksimal 2MB) - akan mengganti gambar yang ada')
                                ->columnSpan(1),
                        ])->columns(2)->columnSpanFull(),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'umum' => 'primary',
                        'pengumuman' => 'warning',
                        'kegiatan' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => Berita::getKategoriOptions()[$state] ?? $state),

                Tables\Columns\TextColumn::make('penulis')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->circular()
                    ->defaultImageUrl(url('/images/no-image.png'))
                    ->size(40)
                    ->toggleable()
                    ->getStateUsing(function ($record) {
                        return $record->image_url; // Use accessor like frontend
                    }),

                Tables\Columns\TextColumn::make('isi')
                    ->label('Isi')
                    ->limit(100)
                    ->html()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options(Berita::getKategoriOptions())
                    ->placeholder('Semua Kategori'),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn($query, $date) => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn($query, $date) => $query->whereDate('created_at', '<=', $date));
                    })
                    ->label('Filter Tanggal'),
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
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->emptyStateHeading('Belum ada berita')
            ->emptyStateDescription('Mulai dengan menambahkan berita pertama.')
            ->emptyStateIcon('heroicon-o-newspaper');
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
            'index' => Pages\ListBeritas::route('/'),
            'create' => Pages\CreateBerita::route('/create'),
            'edit' => Pages\EditBerita::route('/{record}/edit'),
        ];
    }
}
