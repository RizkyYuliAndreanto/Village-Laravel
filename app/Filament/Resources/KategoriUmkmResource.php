<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriUmkmResource\Pages;
use App\Filament\Resources\KategoriUmkmResource\RelationManagers;
use App\Models\KategoriUmkm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class KategoriUmkmResource extends Resource
{
    protected static ?string $model = KategoriUmkm::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Kategori UMKM';

    protected static ?string $modelLabel = 'Kategori UMKM';

    protected static ?string $pluralModelLabel = 'Kategori UMKM';

    protected static ?string $navigationGroup = 'UMKM Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kategori')
                    ->schema([
                        Forms\Components\TextInput::make('nama_kategori')
                            ->label('Nama Kategori')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Kuliner, Perdagangan, Jasa')
                            ->helperText('Nama kategori yang akan digunakan untuk klasifikasi UMKM'),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->placeholder('Deskripsi singkat tentang kategori ini...')
                            ->helperText('Penjelasan tentang jenis usaha yang termasuk dalam kategori ini')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('icon')
                            ->label('Icon/Emoji')
                            ->maxLength(255)
                            ->placeholder('🍽️, 🛒, 🔧, 🌾, 👗')
                            ->helperText('Emoji atau kelas icon yang akan ditampilkan (opsional)'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->helperText('Aktifkan kategori ini untuk dapat digunakan')
                            ->default(true)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('icon')
                    ->label('Icon')
                    ->alignCenter()
                    ->size('lg')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn($record) => $record->deskripsi ? Str::limit($record->deskripsi, 50) : null),

                Tables\Columns\TextColumn::make('umkms_count')
                    ->label('Jumlah UMKM')
                    ->counts('umkms')
                    ->badge()
                    ->color('primary')
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('nama_kategori', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggle_status')
                    ->label(fn($record) => $record->is_active ? 'Nonaktifkan' : 'Aktifkan')
                    ->icon(fn($record) => $record->is_active ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn($record) => $record->is_active ? 'warning' : 'success')
                    ->action(fn($record) => $record->update(['is_active' => !$record->is_active]))
                    ->requiresConfirmation()
                    ->modalDescription('Apakah Anda yakin ingin mengubah status kategori ini?'),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record, $action) {
                        if ($record->umkms()->count() > 0) {
                            \Filament\Notifications\Notification::make()
                                ->warning()
                                ->title('Tidak dapat menghapus!')
                                ->body('Kategori ini masih digunakan oleh ' . $record->umkms()->count() . ' UMKM. Pindahkan UMKM ke kategori lain terlebih dahulu.')
                                ->send();
                            $action->cancel();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn($records) => $records->each->update(['is_active' => true]))
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->action(fn($records) => $records->each->update(['is_active' => false]))
                        ->requiresConfirmation(),
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records, $action) {
                            $hasUmkms = $records->some(fn($record) => $record->umkms()->count() > 0);
                            if ($hasUmkms) {
                                \Filament\Notifications\Notification::make()
                                    ->warning()
                                    ->title('Tidak dapat menghapus!')
                                    ->body('Beberapa kategori masih digunakan oleh UMKM. Pindahkan UMKM ke kategori lain terlebih dahulu.')
                                    ->send();
                                $action->cancel();
                            }
                        }),
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
            'index' => Pages\ListKategoriUmkms::route('/'),
            'create' => Pages\CreateKategoriUmkm::route('/create'),
            'edit' => Pages\EditKategoriUmkm::route('/{record}/edit'),
        ];
    }
}
