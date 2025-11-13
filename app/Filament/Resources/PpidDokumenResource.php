<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PpidDokumenResource\Pages;
use App\Models\PpidDokumen;
use App\Services\MediaStorageService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PpidDokumenResource extends Resource
{
    protected static ?string $model = PpidDokumen::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'PPID Dokumen';

    protected static ?string $modelLabel = 'PPID Dokumen';

    protected static ?string $pluralModelLabel = 'PPID Dokumen';

    protected static ?string $navigationGroup = 'Manajemen Dokumen';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dokumen')
                    ->schema([
                        Forms\Components\TextInput::make('judul_dokumen')
                            ->label('Judul Dokumen')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan judul dokumen...')
                            ->columnSpanFull(),

                        Forms\Components\Select::make('kategori')
                            ->label('Kategori Informasi')
                            ->options(PpidDokumen::getKategoriOptions())
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih kategori informasi...')
                            ->helperText('Pilih kategori sesuai dengan jenis informasi publik'),

                        Forms\Components\TextInput::make('tahun')
                            ->label('Tahun')
                            ->numeric()
                            ->required()
                            ->minValue(2000)
                            ->maxValue(date('Y') + 1)
                            ->default(date('Y'))
                            ->placeholder('Masukkan tahun dokumen...'),

                        Forms\Components\DatePicker::make('tanggal_upload')
                            ->label('Tanggal Upload')
                            ->required()
                            ->default(now())
                            ->maxDate(now())
                            ->displayFormat('d/m/Y')
                            ->helperText('Tanggal dokumen diupload'),

                        Forms\Components\TextInput::make('uploader')
                            ->label('Uploader')
                            ->required()
                            ->maxLength(255)
                            ->default(\Illuminate\Support\Facades\Auth::user()->name ?? 'Admin')
                            ->placeholder('Nama yang mengupload dokumen...'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('File Dokumen')
                    ->schema([
                        Forms\Components\FileUpload::make('file_url')
                            ->label('File Dokumen')
                            ->required()
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg'])
                            ->maxSize(10240) // 10MB
                            ->directory('ppid-dokumen')
                            ->visibility('public')
                            ->disk(config('media.default_disk', 'local'))
                            ->helperText('Upload file dokumen (PDF, DOC, DOCX, JPG, PNG). Maksimal 10MB.')
                            ->columnSpanFull()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $mediaService = app(MediaStorageService::class);
                                    $url = $mediaService->url($state);
                                    $set('file_url', $url);
                                }
                            }),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Preview')
                    ->schema([
                        Forms\Components\Placeholder::make('preview_info')
                            ->label('Informasi File')
                            ->content(function (Forms\Get $get): string {
                                $fileUrl = $get('file_url');
                                $judul = $get('judul_dokumen');
                                $kategori = $get('kategori');
                                $tahun = $get('tahun');

                                if (!$fileUrl) {
                                    return 'Belum ada file yang diupload.';
                                }

                                $info = "📄 Judul: " . ($judul ?: 'Belum diisi') . "\n";
                                $info .= "📂 Kategori: " . ($kategori ? PpidDokumen::getKategoriOptions()[$kategori] : 'Belum dipilih') . "\n";
                                $info .= "📅 Tahun: " . ($tahun ?: 'Belum diisi') . "\n";
                                $info .= "🔗 File: " . basename($fileUrl);

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
                Tables\Columns\TextColumn::make('judul_dokumen')
                    ->label('Judul Dokumen')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    }),

                Tables\Columns\BadgeColumn::make('kategori')
                    ->label('Kategori')
                    ->formatStateUsing(fn(string $state): string => PpidDokumen::getKategoriOptions()[$state] ?? $state)
                    ->colors([
                        'success' => PpidDokumen::KATEGORI_BERKALA,
                        'warning' => PpidDokumen::KATEGORI_SERTAMERTA,
                        'primary' => PpidDokumen::KATEGORI_SETIAP_SAAT,
                        'danger' => PpidDokumen::KATEGORI_DIKECUALIKAN,
                    ])
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_upload')
                    ->label('Tanggal Upload')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('uploader')
                    ->label('Uploader')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('file_url')
                    ->label('File')
                    ->formatStateUsing(fn(string $state): string => basename($state))
                    ->url(fn(PpidDokumen $record): string => $record->file_url)
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document')
                    ->iconColor('primary')
                    ->limit(20),

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
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Filter Kategori')
                    ->options(PpidDokumen::getKategoriOptions())
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('tahun')
                    ->form([
                        Forms\Components\TextInput::make('tahun')
                            ->label('Tahun')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tahun'],
                                fn(Builder $query, $tahun): Builder => $query->where('tahun', $tahun),
                            );
                    }),

                Tables\Filters\Filter::make('tanggal_upload')
                    ->form([
                        Forms\Components\DatePicker::make('upload_from')
                            ->label('Upload Dari'),
                        Forms\Components\DatePicker::make('upload_until')
                            ->label('Upload Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['upload_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_upload', '>=', $date),
                            )
                            ->when(
                                $data['upload_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal_upload', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn(PpidDokumen $record): string => $record->file_url)
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListPpidDokumens::route('/'),
            'create' => Pages\CreatePpidDokumen::route('/create'),
            'view' => Pages\ViewPpidDokumen::route('/{record}'),
            'edit' => Pages\EditPpidDokumen::route('/{record}/edit'),
        ];
    }
}
