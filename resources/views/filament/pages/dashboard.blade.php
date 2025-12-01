<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6">
        @livewire(\App\Filament\Widgets\YearFilterWidget::class)
        @livewire(\App\Filament\Widgets\PopulationValidationChartWidget::class)
        @livewire(\App\Filament\Widgets\YearValidationSummaryWidget::class)
    </div>
</x-filament-panels::page>