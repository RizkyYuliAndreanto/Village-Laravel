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

    #[Url]
    public ?string $selectedYear = null;

    public function mount(): void
    {
        // Set tahun default ke tahun terbaru jika belum dipilih
        if (!$this->selectedYear) {
            $latestYear = TahunData::orderBy('tahun', 'desc')->first();
            $this->selectedYear = $latestYear?->tahun ?? date('Y');
        }
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
                    ->default($this->selectedYear)
                    ->selectablePlaceholder(false)
                    ->live()
                    ->afterStateUpdated(function ($state) {
                        $this->selectedYear = $state;
                        $this->redirect(static::getUrl(['selectedYear' => $state]));
                    })
            ])
            ->statePath('data');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ApbdesBalanceOverview::class,
        ];
    }

    public function getViewData(): array
    {
        // Ambil laporan berdasarkan tahun yang dipilih
        $laporanTerpilih = LaporanApbdes::with(['tahunData', 'detailApbdes.bidangApbdes'])
            ->whereHas('tahunData', function ($query) {
                $query->where('tahun', $this->selectedYear);
            })
            ->where('status', 'diterbitkan')
            ->latest()
            ->first();

        $statistik = [];

        if ($laporanTerpilih) {
            // Hitung statistik dasar
            $totalPendapatan = DetailApbdes::where('laporan_apbdes_id', $laporanTerpilih->id)
                ->where('tipe', 'pendapatan')
                ->sum('realisasi');

            $totalBelanja = DetailApbdes::where('laporan_apbdes_id', $laporanTerpilih->id)
                ->where('tipe', 'belanja')
                ->sum('realisasi');

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

        return [
            'laporan' => $laporanTerpilih,
            'statistik' => $statistik,
            'selectedYear' => $this->selectedYear,
            'availableYears' => TahunData::orderBy('tahun', 'desc')->pluck('tahun', 'tahun')->toArray(),
        ];
    }
}
