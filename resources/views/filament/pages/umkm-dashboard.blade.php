<x-filament-panels::page>
    {{-- Menggunakan getWidgets() karena class Page tidak memiliki getVisibleWidgets() --}}
    <x-filament-widgets::widgets
        :widgets="$this->getWidgets()"
        :columns="$this->getColumns()"
    />
</x-filament-panels::page>