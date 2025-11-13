<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StrukturOrganisasiResource\Pages;
use App\Models\StrukturOrganisasi;
use App\Services\MediaStorageService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StrukturOrganisasiResource extends Resource
{
    protected static ?string $model = StrukturOrganisasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Struktur Organisasi';

    protected static ?string $modelLabel = 'Struktur Organisasi';

    protected static ?string $pluralModelLabel = 'Struktur Organisasi';

    protected static ?string $navigationGroup = 'Manajemen Organisasi';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Personal')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan nama lengkap...')
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan jabatan...')
                            ->helperText('Contoh: Kepala Desa, Sekretaris Desa, Kaur Umum, dll.')
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Foto Profil')
                    ->schema([
                        Forms\Components\FileUpload::make('foto_url')
                            ->label('Foto Profil')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '3:4',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048) // 2MB
                            ->directory('struktur-organisasi')
                            ->visibility('public')
                            ->disk(config('media.default_disk', 'local'))
                            ->helperText('Upload foto profil (JPG, PNG). Maksimal 2MB. Rasio yang disarankan 3:4.')
                            ->columnSpanFull()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $mediaService = app(MediaStorageService::class);
                                    $url = $mediaService->url($state);
                                    $set('foto_url', $url);
                                }
                            }),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Informasi Tambahan')
                    ->schema([
                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder('Masukkan keterangan tambahan (opsional)...')
                            ->helperText('Informasi tambahan seperti masa jabatan, tugas khusus, dll.')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Preview')
                    ->schema([
                        Forms\Components\Placeholder::make('preview_info')
                            ->label('Preview Informasi')
                            ->content(function (Forms\Get $get): string {
                                $nama = $get('nama');
                                $jabatan = $get('jabatan');
                                $foto = $get('foto_url');
                                $keterangan = $get('keterangan');

                                $info = "👤 Nama: " . ($nama ?: 'Belum diisi') . "\n";
                                $info .= "💼 Jabatan: " . ($jabatan ?: 'Belum diisi') . "\n";
                                $info .= "📷 Foto: " . ($foto ? 'Sudah diupload' : 'Belum diupload') . "\n";
                                $info .= "📝 Keterangan: " . ($keterangan ? 'Ada' : 'Tidak ada');

                                return $info;
                            })
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto_url')
                    ->label('Foto')
                    ->circular()
                    ->size(60)
                    ->defaultImageUrl(asset('images/default-avatar.png')),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('jabatan')
                    ->label('Jabatan')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

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
                Tables\Filters\Filter::make('has_photo')
                    ->label('Memiliki Foto')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('foto_url')),

                Tables\Filters\Filter::make('has_keterangan')
                    ->label('Memiliki Keterangan')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('keterangan')),
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
            ->defaultSort('create_at', 'desc')
            ->reorderable('id_struktur');
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
            'index' => Pages\ListStrukturOrganisasis::route('/'),
            'create' => Pages\CreateStrukturOrganisasi::route('/create'),
            'view' => Pages\ViewStrukturOrganisasi::route('/{record}'),
            'edit' => Pages\EditStrukturOrganisasi::route('/{record}/edit'),
        ];
    }
}
