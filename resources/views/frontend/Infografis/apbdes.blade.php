@extends('layouts.infografis')

@section('content')
{{-- 
    Kita membungkus seluruh section dengan komponen Alpine.js (x-data).
    Data awal di-passing dari PHP (Controller) ke JavaScript.
--}}
<section 
    x-data="apbdesManager(
        '{{ route('api.apbdes.data', '') }}', {{-- URL API (base) --}}
        {{ $latestApbdes->tahun ?? date('Y') }}, {{-- Tahun terpilih --}}
        {{ $latestApbdes->toJson() }} {{-- Data awal (JSON) --}}
    )"
    x-init="init()" {{-- Fungsi init untuk kalkulasi awal --}}
    class="bg-gray-100 dark:bg-gray-900 py-16 px-4"
>
    
    <div class="container mx-auto max-w-7xl px-6 mb-6 flex justify-end">
      @include('layouts.partials.submenu')  
    </div>

    <div class="max-w-7xl mx-auto bg-white dark:bg-gray-800 p-6 md:p-8 rounded-2xl shadow-lg grid grid-cols-1 lg:grid-cols-5 gap-8">

        <div class="lg:col-span-2">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                APB Desa Tamang
                {{-- Judul tahun sekarang reaktif menggunakan x-text --}}
                <span class="text-red-600 block text-2xl md:text-3xl mt-1" x-text="`TAHUN ${selectedYear}`"></span>
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-4 leading-relaxed">
                Desa Tamang, Kecamatan Nanga Mahap, Kabupaten Sekadau, Provinsi Kalimantan Barat
            </p>
        </div>

        <div class="lg:col-span-3">
            
            <div class="flex justify-end mb-4">
                {{-- 
                  Dropdown ini di-bind ke 'selectedYear'.
                  @change akan memanggil fungsi 'fetchData' saat nilai berubah.
                --}}
                <select 
                    x-model="selectedYear"
                    @change="fetchData"
                    class="p-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    :disabled="isLoading" {{-- Nonaktifkan saat loading --}}
                >
                    {{-- Loop data tahun dari controller --}}
                    @forelse ($availableYears as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @empty
                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                    @endforelse
                </select>
            </div>

            {{-- Overlay Loading --}}
            <div x-show="isLoading" class="relative">
                <div class="absolute inset-0 bg-white/50 dark:bg-gray-800/50 z-10 flex items-center justify-center">
                    <span class="text-gray-700 dark:text-gray-200">Memuat data...</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" :class="{ 'opacity-50': isLoading }">
                
                <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-5">
                    <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2 flex items-center gap-2">
                        <span class="text-green-600 text-lg">▲</span>
                        Pendapatan
                    </h4>
                    {{-- Ganti teks statis dengan x-text --}}
                    <p class="text-2xl font-bold text-green-600" x-text="formatCurrency(data.total_pendapatan)"></p>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-5">
                    <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2 flex items-center gap-2">
                        <span class="text-red-600 text-lg">▼</span>
                        Belanja
                    </h4>
                    <p class="text-2xl font-bold text-red-600" x-text="formatCurrency(data.total_belanja)"></p>
                </div>

                <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-5">
                    <h4 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-3">
                        Pembiayaan
                    </h4>
                    <div class="flex flex-col sm:flex-row gap-4 sm:gap-8">
                        <div class="flex items-start gap-2 flex-1">
                            <span class="text-gray-500 dark:text-gray-400 text-lg mt-1">●</span>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-300 block">Penerimaan</span>
                                <p class="text-xl font-semibold text-gray-900 dark:text-white mt-1" x-text="formatCurrency(data.penerimaan_pembiayaan)"></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2 flex-1">
                            <span class="text-gray-500 dark:text-gray-400 text-lg mt-1">●</span>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-300 block">Pengeluaran</span>
                                <p class="text-xl font-semibold text-gray-900 dark:text-white mt-1" x-text="formatCurrency(data.pengeluaran_pembiayaan)"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-5 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <h4 class="text-base font-semibold text-gray-700 dark:text-gray-200 normal-case mb-2 sm:mb-0">
                        Surplus/Defisit
                    </h4>
                    {{-- Surplus/Defisit adalah data kalkulasi --}}
                    <p class="text-2xl font-bold" x-text="formatCurrency(surplusDefisit)" :class="surplusDefisit < 0 ? 'text-red-600' : 'text-green-600'"></p>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- 
    Menambahkan logika Alpine.js di sini. 
    Bisa juga dipindah ke app.js jika Anda mau.
--}}
@push('scripts')
<script>
    function apbdesManager(baseUrl, initialYear, initialData) {
        return {
            isLoading: false,
            apiUrlBase: baseUrl, // '.../api/apbdes/'
            selectedYear: initialYear,
            data: initialData,
            surplusDefisit: 0,

            // Fungsi untuk inisialisasi
            init() {
                this.calculateSurplus();
            },

            // Fungsi untuk mengambil data baru saat tahun diubah
            async fetchData() {
                this.isLoading = true;
                try {
                    const response = await fetch(`${this.apiUrlBase}/${this.selectedYear}`);
                    if (!response.ok) {
                        throw new Error('Data tidak ditemukan');
                    }
                    const newData = await response.json();
                    this.data = newData;
                    this.calculateSurplus(); // Hitung ulang surplus
                } catch (error) {
                    console.error('Error fetching data:', error);
                    // Anda bisa tambahkan notifikasi error di sini
                } finally {
                    this.isLoading = false;
                }
            },

            // Fungsi untuk menghitung surplus/defisit
            calculateSurplus() {
                // Pastikan datanya adalah angka (float)
                const pendapatan = parseFloat(this.data.total_pendapatan || 0);
                const belanja = parseFloat(this.data.total_belanja || 0);
                const penerimaan = parseFloat(this.data.penerimaan_pembiayaan || 0);
                const pengeluaran = parseFloat(this.data.pengeluaran_pembiayaan || 0);
                
                // (Pendapatan - Belanja) + (Penerimaan - Pengeluaran)
                this.surplusDefisit = (pendapatan - belanja) + (penerimaan - pengeluaran);
            },

            // Fungsi helper untuk memformat mata uang
            formatCurrency(value) {
                if (value === null || value === undefined) value = 0;
                
                // Tentukan tanda positif/negatif
                const sign = parseFloat(value) < 0 ? "-" : "";
                
                // Ambil nilai absolut dan format ke Rupiah
                const formatted = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 2
                }).format(Math.abs(parseFloat(value)));
                
                // Hapus 'Rp' dan tambahkan kembali 'Rp' dengan tanda
                return `${sign}${formatted.replace('Rp', 'Rp')}`;
            }
        }
    }
</script>
@endpush