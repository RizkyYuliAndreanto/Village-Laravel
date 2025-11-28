{{-- Charts Section --}}
@if($grafikData)
<div class="space-y-8 mb-12">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold apbdes-title mb-2">Visualisasi Data Keuangan</h2>
        <p class="text-gray-600">Grafik dan chart untuk mempermudah analisis data APBDes</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Pie Chart: Pendapatan vs Belanja --}}
        <div class="apbdes-card p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-chart-pie text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold apbdes-title">Perbandingan Keuangan</h3>
                    <p class="text-gray-600 text-sm">Rasio pendapatan vs belanja</p>
                </div>
            </div>
            <div class="relative bg-white rounded-lg p-3 shadow-inner" style="height: 320px;">
                <canvas id="pendapatanBelanjaChart" class="w-full h-full"></canvas>
            </div>
        </div>

        {{-- Bar Chart: Belanja per Bidang --}}
        <div class="apbdes-card p-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-r from-cyan-500 to-teal-500 text-white rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-chart-bar text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold apbdes-title">Distribusi Belanja</h3>
                    <p class="text-gray-600 text-sm">Belanja per bidang</p>
                </div>
            </div>
            <div class="relative bg-white rounded-lg p-3 shadow-inner" style="height: 320px;">
                <canvas id="belanjaBidangChart" class="w-full h-full"></canvas>
            </div>
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
    <div class="relative bg-white rounded-lg p-4 shadow-inner" style="height: 400px;">
        <canvas id="yearlyComparisonChart" class="w-full h-full"></canvas>
    </div>
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500 mt-1"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-800">
                    <strong>Informasi:</strong> Grafik tren menampilkan perbandingan data keuangan desa selama 5 tahun terakhir. 
                    Hover pada titik grafik untuk melihat detail nilai. Data ini diambil dari laporan APBDes resmi.
                </p>
            </div>
        </div>
    </div>
</div>
@endif
