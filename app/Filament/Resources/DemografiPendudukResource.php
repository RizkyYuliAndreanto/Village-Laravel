<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DemografiPendudukResource\Pages;
use App\Filament\Resources\DemografiPendudukResource\RelationManagers;
use App\Models\DemografiPenduduk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DemografiPendudukResource extends Resource
{
    protected static ?string $model = DemografiPenduduk::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Demografi Penduduk';

    protected static ?string $modelLabel = 'Demografi Penduduk';

    protected static ?string $pluralModelLabel = 'Data Demografi Penduduk';

    protected static ?string $navigationGroup = 'Data Statistik';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tahun_id')
                    ->label('Tahun Data')
                    ->relationship('tahunData', 'tahun')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                        if ($state) {
                            $existing = DemografiPenduduk::where('tahun_id', $state)->exists();
                            if ($existing) {
                                \Filament\Notifications\Notification::make()
                                    ->warning()
                                    ->title('Perhatian!')
                                    ->body('Tahun yang dipilih sudah memiliki data demografi penduduk.')
                                    ->duration(3000)
                                    ->send();
                            }
                        }
                    })
                    ->helperText(function ($state) {
                        if (!$state) {
                            return 'Pilih tahun untuk data demografi penduduk. Sistem akan mengecek ketersediaan data.';
                        }

                        $existing = DemografiPenduduk::where('tahun_id', $state)->exists();
                        if ($existing) {
                            return '⚠️ Data demografi penduduk untuk tahun ini sudah ada. Jika Anda melanjutkan, akan ada error duplikasi.';
                        }

                        return '✅ Tahun ini belum memiliki data demografi penduduk. Aman untuk membuat data baru.';
                    }),

                Forms\Components\Section::make('Data Penduduk')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('total_penduduk')
                                    ->label('Total Penduduk')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->helperText('Masukkan total penduduk atau kosongkan untuk auto-calculate')
                                    ->live()
                                    ->columnSpan(2),

                                Forms\Components\Actions::make([
                                    Forms\Components\Actions\Action::make('auto_calculate')
                                        ->label('Auto Calculate')
                                        ->icon('heroicon-o-calculator')
                                        ->color('primary')
                                        ->action(function (Forms\Set $set, Forms\Get $get) {
                                            $lakiLaki = (int) ($get('laki_laki') ?? 0);
                                            $perempuan = (int) ($get('perempuan') ?? 0);
                                            $set('total_penduduk', $lakiLaki + $perempuan);
                                        })
                                        ->size('sm'),
                                ])
                                    ->columnSpan(1)
                                    ->alignEnd(),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('laki_laki')
                                    ->label('Laki-laki')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Set $set, $state, Forms\Get $get) {
                                        // Only auto-calculate if total_penduduk is empty or 0
                                        $currentTotal = (int) ($get('total_penduduk') ?? 0);
                                        if ($currentTotal === 0) {
                                            $perempuan = (int) ($get('perempuan') ?? 0);
                                            $lakiLaki = (int) ($state ?? 0);
                                            $set('total_penduduk', $lakiLaki + $perempuan);
                                        }
                                    }),

                                Forms\Components\TextInput::make('perempuan')
                                    ->label('Perempuan')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Set $set, $state, Forms\Get $get) {
                                        // Only auto-calculate if total_penduduk is empty or 0
                                        $currentTotal = (int) ($get('total_penduduk') ?? 0);
                                        if ($currentTotal === 0) {
                                            $lakiLaki = (int) ($get('laki_laki') ?? 0);
                                            $perempuan = (int) ($state ?? 0);
                                            $set('total_penduduk', $lakiLaki + $perempuan);
                                        }
                                    }),
                            ]),
                    ]),

                Forms\Components\Section::make('Data Tambahan')
                    ->schema([
                        Forms\Components\TextInput::make('penduduk_sementara')
                            ->label('Penduduk Sementara')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0),

                        Forms\Components\TextInput::make('mutasi_penduduk')
                            ->label('Mutasi Penduduk')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tahunData.tahun')
                    ->label('Tahun')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('total_penduduk')
                    ->label('Total Penduduk')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => number_format($state))
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('laki_laki')
                    ->label('Laki-laki')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => number_format($state))
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('perempuan')
                    ->label('Perempuan')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => number_format($state))
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('penduduk_sementara')
                    ->label('Penduduk Sementara')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn(string $state): string => number_format($state))
                    ->alignEnd()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('mutasi_penduduk')
                    ->label('Mutasi Penduduk')
                    ->numeric()
                    ->sortable()
                    ->alignEnd()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('create_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tahun_id')
                    ->label('Filter Tahun')
                    ->relationship('tahunData', 'tahun')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('total_penduduk_range')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('total_from')
                                    ->label('Total Penduduk Dari')
                                    ->numeric(),
                                Forms\Components\TextInput::make('total_to')
                                    ->label('Total Penduduk Sampai')
                                    ->numeric(),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['total_from'],
                                fn(Builder $query, $value): Builder => $query->where('total_penduduk', '>=', $value),
                            )
                            ->when(
                                $data['total_to'],
                                fn(Builder $query, $value): Builder => $query->where('total_penduduk', '<=', $value),
                            );
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
                    Tables\Actions\ExportBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListDemografiPenduduks::route('/'),
            'create' => Pages\CreateDemografiPenduduk::route('/create'),
            'edit' => Pages\EditDemografiPenduduk::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function canView($record): bool
    {
        return true;
    }

    public static function canEdit($record): bool
    {
        return true;
    }

    public static function canDelete($record): bool
    {
        return true;
    }
}
