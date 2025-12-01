<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ApbdesBalanceOverview;
use App\Models\LaporanApbdes;
use App\Models\DetailApbdes;
use App\Models\TahunData;
use Filament\Pages\Page;
use Filament\Widgets\ChartWidget;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Attributes\Url;

class ApbdesDashboard extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static string $view = 'filament.pages.apbdes-dashboard';

    protected static ?string $navigationLabel = 'Dashboard APBDes';

    protected static ?string $navigationGroup = 'APBDes';

    protected static ?int $navigationSort = 0;

    public ?string $selectedYear = null;

    public int $widgetRefreshKey = 0;

    public function mount(): void
    {
        // Set tahun default ke tahun terbaru jika belum dipilih
        if (!$this->selectedYear) {
            $latestYear = TahunData::orderBy('tahun', 'desc')->first();
            $this->selectedYear = $latestYear?->tahun ?? date('Y');
        }

        // Fill form dengan nilai selectedYear
        $this->form->fill([
            'selectedYear' => $this->selectedYear
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('selectedYear')
                    ->label('Pilih Tahun APBDes')
                    ->options(function () {
                        return TahunData::orderBy('tahun', 'desc')
                            ->pluck('tahun', 'tahun')
                            ->toArray();
                    })
                    ->selectablePlaceholder(false)
                    ->live()
                    ->afterStateUpdated(function ($state) {
                        $this->selectedYear = $state;
                    })
            ]);
    }

    public function updatedSelectedYear()
    {
        // Dispatch event untuk refresh widget
        $this->dispatch('yearChanged', $this->selectedYear);

        // Reset cached computed properties
        unset($this->laporan);
        unset($this->statistik);

        // Form fill ulang dengan tahun yang dipilih
        $this->form->fill([
            'selectedYear' => $this->selectedYear
        ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ApbdesBalanceOverview::class,
        ];
    }

    protected function getHeaderWidgetProperties(): array
    {
        return [
            'selectedYear' => $this->selectedYear,
            'refreshKey' => $this->widgetRefreshKey,
        ];
    }

    public function getLaporanProperty()
    {
        // Computed property untuk laporan yang akan ter-update otomatis saat selectedYear berubah
        return LaporanApbdes::with(['tahunData', 'detailApbdes.bidangApbdes'])
            ->whereHas('tahunData', function ($query) {
                $query->where('tahun', $this->selectedYear);
            })
            ->whereIn('status', ['selesai', 'diterbitkan']) // Tampilkan yang selesai atau diterbitkan
            ->latest()
            ->first();
    }

    public function getStatistikProperty()
    {
        $laporanTerpilih = $this->laporan;
        $statistik = [];

        if ($laporanTerpilih) {
            // Hitung statistik dasar
            $totalPendapatan = DetailApbdes::where('laporan_apbdes_id', $laporanTerpilih->id)
                ->where('tipe', 'pendapatan')
                ->sum('anggaran'); // Pendapatan menggunakan anggaran

            $totalBelanja = DetailApbdes::where('laporan_apbdes_id', $laporanTerpilih->id)
                ->where('tipe', 'belanja')
                ->sum('realisasi'); // Belanja menggunakan realisasi

            $balance = $totalPendapatan - $totalBelanja;

            // Hitung realisasi per bidang belanja
            $realisasiBidang = DetailApbdes::with('bidangApbdes')
                ->where('laporan_apbdes_id', $laporanTerpilih->id)
                ->where('tipe', 'belanja')
                ->selectRaw('bidang_apbdes_id, SUM(anggaran) as total_anggaran, SUM(realisasi) as total_realisasi')
                ->groupBy('bidang_apbdes_id')
                ->get()
                ->map(function ($item) {
                    return [
                        'bidang' => $item->bidangApbdes->nama_bidang ?? 'Tidak Terkategorisasi',
                        'anggaran' => $item->total_anggaran,
                        'realisasi' => $item->total_realisasi,
                        'persentase' => $item->total_anggaran > 0
                            ? round(($item->total_realisasi / $item->total_anggaran) * 100, 2)
                            : 0,
                    ];
                });

            $statistik = [
                'total_pendapatan' => $totalPendapatan,
                'total_belanja' => $totalBelanja,
                'balance' => $balance,
                'status_balance' => $balance >= 0 ? 'surplus' : 'defisit',
                'realisasi_bidang' => $realisasiBidang,
            ];
        }

        return $statistik;
    }

    public function getViewData(): array
    {
        return [
            'laporan' => $this->laporan,
            'statistik' => $this->statistik,
            'selectedYear' => $this->selectedYear,
            'availableYears' => TahunData::orderBy('tahun', 'desc')->pluck('tahun', 'tahun')->toArray(),
        ];
    }
}
