<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\TahunData;
use App\Models\DemografiPenduduk;
use App\Services\PopulationValidationService;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Attributes\Reactive;

class YearFilterWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.widgets.year-filter-widget';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    public ?int $selectedYear = null;
    public array $validationResults = [];

    public function mount(): void
    {
        $this->selectedYear = TahunData::orderBy('tahun', 'desc')->first()?->id_tahun;
        $this->loadValidationResults();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('selectedYear')
                    ->label('Pilih Tahun')
                    ->placeholder('Pilih tahun untuk melihat data validasi')
                    ->options(function () {
                        return TahunData::orderBy('tahun', 'desc')
                            ->pluck('tahun', 'id_tahun')
                            ->toArray();
                    })
                    ->default($this->selectedYear)
                    ->selectablePlaceholder(false)
                    ->live()
                    ->afterStateUpdated(function ($state) {
                        $this->selectedYear = $state;
                        $this->loadValidationResults();
                    }),
            ]);
    }

    public function loadValidationResults(): void
    {
        if (!$this->selectedYear) {
            $this->validationResults = [];
            return;
        }

        $validationService = new PopulationValidationService();
        $totalPopulation = $validationService->getTotalPopulation($this->selectedYear);

        if (!$totalPopulation) {
            $this->validationResults = [
                'error' => 'Data demografis untuk tahun ini belum tersedia'
            ];
            return;
        }

        $statisticTypes = [
            'umur' => 'Statistik Umur',
            'pekerjaan' => 'Statistik Pekerjaan',
            'pendidikan' => 'Statistik Pendidikan',
            'agama' => 'Statistik Agama',
            'perkawinan' => 'Statistik Perkawinan',
            'wajib_pilih' => 'Statistik Wajib Pilih',
        ];

        $results = [];
        $allValid = true;
        $totalInconsistencies = 0;

        foreach ($statisticTypes as $type => $name) {
            $result = $validationService->getExistingDataValidation($this->selectedYear, $type);
            $results[$type] = [
                'name' => $name,
                'isValid' => $result['isValid'],
                'totalCount' => $result['totalCount'],
                'expectedCount' => $result['expectedCount'],
                'difference' => $result['difference'],
                'status' => $result['isValid'] ? 'valid' : 'invalid',
            ];

            if (!$result['isValid']) {
                $allValid = false;
                $totalInconsistencies++;
            }
        }

        $this->validationResults = [
            'totalPopulation' => $totalPopulation,
            'statistics' => $results,
            'allValid' => $allValid,
            'totalInconsistencies' => $totalInconsistencies,
            'yearName' => TahunData::find($this->selectedYear)->tahun ?? 'Unknown',
        ];
    }

    public function getSelectedYearName(): string
    {
        if (!$this->selectedYear) {
            return 'Belum dipilih';
        }

        return TahunData::find($this->selectedYear)->tahun ?? 'Unknown';
    }
}
