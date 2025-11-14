<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class ApbdesChart extends ChartWidget
{
    protected ?string $heading = 'Apbdes Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
