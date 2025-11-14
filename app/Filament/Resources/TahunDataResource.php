<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TahunDataResource\Pages;
use App\Filament\Resources\TahunDataResource\RelationManagers;
use App\Models\TahunData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TahunDataResource extends Resource
{
    protected static ?string $model = TahunData::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Tahun Data';

    protected static ?string $modelLabel = 'Tahun Data';

    protected static ?string $pluralModelLabel = 'Data Tahun';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tahun Data')
                    ->description('Masukkan informasi tahun data untuk statistik desa')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('tahun')
                                    ->label('Tahun')
                                    ->required()
                                    ->numeric()
                                    ->minValue(2000)
                                    ->maxValue((int) date('Y') + 5)
                                    ->default((int) date('Y'))
                                    ->helperText('Tahun data yang akan digunakan untuk statistik (2000 - ' . ((int) date('Y') + 5) . ')')
                                    ->unique(ignoreRecord: true)
                                    ->validationMessages([
                                        'required' => 'Tahun wajib diisi.',
                                        'numeric' => 'Tahun harus berupa angka.',
                                        'min' => 'Tahun minimal adalah 2000.',
                                        'max' => 'Tahun maksimal adalah ' . ((int) date('Y') + 5) . '.',
                                        'unique' => 'Tahun ini sudah ada, gunakan tahun yang berbeda.',
                                    ]),

                                Forms\Components\Placeholder::make('info_placeholder')
                                    ->label('Status')
                                    ->content(fn() => new \Illuminate\Support\HtmlString('
                                        <div class="text-sm text-gray-600">
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                Aktif untuk input data statistik
                                            </div>
                                        </div>
                                    ')),
                            ]),

                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(4)
                            ->maxLength(1000)
                            ->placeholder('Masukkan keterangan atau catatan khusus untuk tahun data ini...')
                            ->helperText('Keterangan tambahan untuk tahun data (opsional, maksimal 1000 karakter)')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Preview Data Terkait')
                    ->description('Informasi jumlah data yang terkait dengan tahun ini')
                    ->schema([
                        Forms\Components\Grid::make(4) // UBAH dari 3 jadi 4
                            ->schema([
                                Forms\Components\Placeholder::make('demografi_count')
                                    ->label('Data Demografi')
                                    ->content(function ($record) {
                                        if (!$record) return '0 record';
                                        return $record->demografiPenduduk()->count() . ' record';
                                    }),

                                Forms\Components\Placeholder::make('statistik_count')
                                    ->label('Data Statistik')
                                    ->content(function ($record) {
                                        if (!$record) return '0 record';
                                        $total = $record->umurStatistik()->count() +
                                            $record->agamaStatistik()->count() +
                                            $record->pekerjaanStatistik()->count();
                                        return $total . ' record';
                                    }),

                                // TAMBAHKAN INI
                                Forms\Components\Placeholder::make('apbdes_count')
                                    ->label('Laporan APBDes')
                                    ->content(function ($record) {
                                        if (!$record) return '0 laporan';
                                        return $record->laporanApbdes()->count() . ' laporan';
                                    }),

                                Forms\Components\Placeholder::make('dusun_count')
                                    ->label('Data Dusun')
                                    ->content(function ($record) {
                                        if (!$record) return '0 dusun';
                                        return $record->dusunStatistik()->count() . ' dusun';
                                    }),
                            ]),
                    ])
                    ->visibleOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->size('lg')
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    })
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('demografi_count')
                    ->label('Data Demografi')
                    ->getStateUsing(function ($record): string {
                        $count = $record->demografiPenduduk()->count();
                        return $count . ' record';
                    })
                    ->badge()
                    ->color(
                        fn(string $state): string =>
                        (int) explode(' ', $state)[0] > 0 ? 'success' : 'gray'
                    ),

                Tables\Columns\TextColumn::make('statistik_count')
                    ->label('Data Statistik')
                    ->getStateUsing(function ($record): string {
                        $total = $record->umurStatistik()->count() +
                            $record->agamaStatistik()->count() +
                            $record->pekerjaanStatistik()->count() +
                            $record->pendidikanStatistik()->count() +
                            $record->perkawinanStatistik()->count() +
                            $record->wajibPilihStatistik()->count();
                        return $total . ' record';
                    })
                    ->badge()
                    ->color(
                        fn(string $state): string =>
                        (int) explode(' ', $state)[0] > 0 ? 'success' : 'gray'
                    ),

                // TAMBAHKAN INI setelah statistik_count:
                Tables\Columns\TextColumn::make('apbdes_count')
                    ->label('Laporan APBDes')
                    ->getStateUsing(function ($record): string {
                        $count = $record->laporanApbdes()->count();
                        return $count . ' laporan';
                    })
                    ->badge()
                    ->color(
                        fn(string $state): string =>
                        (int) explode(' ', $state)[0] > 0 ? 'success' : 'gray'
                    ),

                Tables\Columns\TextColumn::make('dusun_count')
                    ->label('Data Dusun')
                    ->getStateUsing(function ($record): string {
                        $count = $record->dusunStatistik()->count();
                        return $count . ' dusun';
                    })
                    ->badge()
                    ->color(
                        fn(string $state): string =>
                        (int) explode(' ', $state)[0] > 0 ? 'success' : 'gray'
                    ),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('tahun_range')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('tahun_dari')
                                    ->label('Tahun Dari')
                                    ->numeric()
                                    ->placeholder('2000'),
                                Forms\Components\TextInput::make('tahun_sampai')
                                    ->label('Tahun Sampai')
                                    ->numeric()
                                    ->placeholder((string) date('Y')),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tahun_dari'],
                                fn(Builder $query, $value): Builder => $query->where('tahun', '>=', $value),
                            )
                            ->when(
                                $data['tahun_sampai'],
                                fn(Builder $query, $value): Builder => $query->where('tahun', '<=', $value),
                            );
                    }),

                Tables\Filters\Filter::make('has_demografi')
                    ->label('Memiliki Data Demografi')
                    ->query(fn(Builder $query): Builder => $query->whereHas('demografiPenduduk')),

                Tables\Filters\Filter::make('has_statistik')
                    ->label('Memiliki Data Statistik')
                    ->query(fn(Builder $query): Builder => $query->where(function ($query) {
                        $query->whereHas('umurStatistik')
                            ->orWhereHas('agamaStatistik')
                            ->orWhereHas('pekerjaanStatistik')
                            ->orWhereHas('pendidikanStatistik')
                            ->orWhereHas('perkawinanStatistik')
                            ->orWhereHas('wajibPilihStatistik');
                    })),

                // HAPUS BAGIAN INI (Line 267-271)
                // Tables\Filters\Filter::make('has_keuangan')
                //     ->label('Memiliki Data Keuangan')
                //     ->query(fn(Builder $query): Builder => $query->where(function ($query) {
                //         $query->whereHas('pendapatan')->orWhereHas('pengeluaran');
                //     })),
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
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->defaultSort('tahun', 'desc');
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
            'index' => Pages\ListTahunData::route('/'),
            'create' => Pages\CreateTahunData::route('/create'),
            'edit' => Pages\EditTahunData::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Master Data';
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        // Prevent deletion if there are related records
        if (
            $record->demografiPenduduk()->exists() ||
            $record->umurStatistik()->exists() ||
            $record->agamaStatistik()->exists() ||
            $record->pekerjaanStatistik()->exists() ||
            $record->pendidikanStatistik()->exists() ||
            $record->perkawinanStatistik()->exists() ||
            $record->wajibPilihStatistik()->exists() ||
            $record->laporanApbdes()->exists() // TAMBAHKAN INI
        ) {
            return false;
        }
        return true;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['tahun', 'keterangan'];
    }

    public static function getGlobalSearchResultDetails(\Illuminate\Database\Eloquent\Model $record): array
    {
        return [
            'Keterangan' => $record->keterangan,
            'Data Terkait' => $record->demografiPenduduk()->count() . ' demografi, ' .
                ($record->umurStatistik()->count() + $record->agamaStatistik()->count()) . ' statistik'
        ];
    }
}
