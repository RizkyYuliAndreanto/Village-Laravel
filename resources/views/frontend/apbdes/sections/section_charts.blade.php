{{-- Charts Section --}}
@if($grafikData)
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
    {{-- Pie Chart: Pendapatan vs Belanja --}}
    <div class="bg-white rounded-2xl shadow-xl p-8 transition-all duration-300 hover:shadow-2xl">
        <div class="flex items-center mb-6">
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white p-3 rounded-lg mr-4">
                <i class="fas fa-chart-pie text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Perbandingan Keuangan</h3>
                <p class="text-gray-600">Rasio realisasi pendapatan vs belanja</p>
            </div>
        </div>
        <div class="relative h-80">
            <canvas id="pendapatanBelanjaChart"></canvas>
        </div>
    </div>

    {{-- Bar Chart: Belanja per Bidang --}}
    <div class="bg-white rounded-2xl shadow-xl p-8 transition-all duration-300 hover:shadow-2xl">
        <div class="flex items-center mb-6">
            <div class="bg-gradient-to-r from-cyan-500 to-teal-500 text-white p-3 rounded-lg mr-4">
                <i class="fas fa-chart-column text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Distribusi Belanja</h3>
                <p class="text-gray-600">Total realisasi belanja per bidang</p>
            </div>
        </div>
        <div class="relative h-80">
            <canvas id="belanjaBidangChart"></canvas>
        </div>
    </div>
</div>

{{-- Yearly Comparison Chart --}}
<div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl shadow-2xl p-8 mb-12 border border-indigo-200">
    <div class="flex items-center mb-6">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white p-3 rounded-lg mr-4">
            <i class="fas fa-chart-line text-xl"></i>
        </div>
        <div>
            <h3 class="text-3xl font-bold text-gray-900">Tren APBDes Multi-Tahun</h3>
            <p class="text-gray-600">Analisis tren pendapatan dan belanja desa dari tahun ke tahun</p>
        </div>
    </div>
    <div class="relative h-96">
        <canvas id="yearlyComparisonChart"></canvas>
    </div>
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-800 font-medium">
                    Grafik ini menampilkan perbandingan APBDes antar tahun. Saat ini menggunakan data simulasi.
                </p>
            </div>
        </div>
    </div>
</div>
@endif
