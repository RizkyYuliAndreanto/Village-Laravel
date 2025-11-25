{{-- Header Section --}}
<div class="text-center mb-12 px-4">
    <div class="flex justify-center w-full mb-6">
            @include('frontend.layouts.partials.submenu')
        </div>    
    <div class="bg-white rounded-3xl shadow-2xl p-10 md:p-16 text-black relative overflow-hidden border border-gray-200">
    <div class="flex flex-col items-center justify-center">
            <div class="bg-cyan-500 rounded-full p-8 mb-8 shadow-lg border-4 border-cyan-600">
                <div class="text-6xl font-black text-white">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                APBDes - Transparansi Keuangan Desa
            </h1>
            <div class="w-32 h-1 bg-cyan-600 rounded-full mb-6"></div>
            <p class="text-base md:text-lg text-gray-700 font-normal max-w-3xl mx-auto leading-relaxed mb-10">
                Portal transparansi pengelolaan keuangan desa yang akuntabel, mudah dipahami, dan memudahkan masyarakat untuk memantau penggunaan dana desa secara real-time.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-5xl">
                <div class="flex flex-col items-center p-6 bg-white rounded-xl shadow-lg border border-gray-200 transition-all duration-300 ease-in-out hover:shadow-xl hover:-translate-y-2">
                    <div class="w-16 h-16 bg-cyan-500 rounded-full mb-4 transition-transform duration-300 ease-in-out hover:scale-110 flex items-center justify-center shadow-md">
                        <i class="fas fa-eye text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Transparansi Penuh</h3>
                    <p class="text-sm text-gray-700 text-center leading-relaxed">Pantau setiap transaksi keuangan desa dengan mudah dan akurat.</p>
                </div>
                <div class="flex flex-col items-center p-6 bg-white rounded-xl shadow-lg border border-gray-200 transition-all duration-300 ease-in-out hover:shadow-xl hover:-translate-y-2">
                    <div class="w-16 h-16 bg-cyan-500 rounded-full mb-4 transition-transform duration-300 ease-in-out hover:scale-110 flex items-center justify-center shadow-md">
                        <i class="fas fa-chart-bar text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Laporan Akuntabel</h3>
                    <p class="text-sm text-gray-700 text-center leading-relaxed">Akses laporan keuangan yang terstruktur dan mudah diinterpretasi.</p>
                </div>
                <div class="flex flex-col items-center p-6 bg-white rounded-xl shadow-lg border border-gray-200 transition-all duration-300 ease-in-out hover:shadow-xl hover:-translate-y-2">
                    <div class="w-16 h-16 bg-cyan-500 rounded-full mb-4 transition-transform duration-300 ease-in-out hover:scale-110 flex items-center justify-center shadow-md">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Akses Masyarakat</h3>
                    <p class="text-sm text-gray-700 text-center leading-relaxed">Platform yang ramah pengguna untuk semua warga desa.</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Year Selector --}}
@if($tahunTersedia && count($tahunTersedia) > 0)
<div class="bg-white rounded-2xl shadow-lg p-6 mb-12 border border-gray-200">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div class="mb-4 sm:mb-0">
            <div class="flex items-center mb-2">
                <div class="bg-cyan-600 text-white px-4 py-2 rounded-lg mr-3 font-bold flex items-center shadow-md">
                    <i class="fas fa-calendar-alt mr-2"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Pilih Tahun Anggaran</h3>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            @foreach($tahunTersedia as $tahunItem)
                <a href="{{ route('frontend.apbdes.index', ['tahun' => $tahunItem->tahun]) }}" 
                   class="px-5 py-2 rounded-xl font-semibold transition-all duration-300 shadow-sm
                          {{ $tahunItem->tahun == $tahunDipilih 
                             ? 'bg-gradient-to-r from-cyan-600 to-teal-600 text-white shadow-lg transform scale-105' 
                             : 'bg-white text-gray-700 hover:bg-cyan-50 hover:text-cyan-700 border border-gray-300' }}">
                    {{ $tahunItem->tahun }}
                    @if($tahunItem->tahun == $tahunDipilih)
                        <span class="ml-1">✅</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- No Data State --}}
@if(!$laporan)
<div class="bg-white rounded-2xl shadow-xl p-12 text-center border border-gray-200">
    <div class="bg-gradient-to-r from-amber-400 to-orange-500 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
        <i class="fas fa-file-invoice-dollar text-white text-3xl"></i>
    </div>
    <h3 class="text-3xl font-bold text-gray-900 mb-4">Data APBDes Tidak Tersedia</h3>
    <p class="text-lg text-gray-600 mb-6">
        @if($tahunDipilih)
            Data APBDes untuk tahun <span class="font-semibold text-orange-600">{{ $tahunDipilih }}</span> belum tersedia.
        @else
            Belum ada data APBDes yang tersedia saat ini.
        @endif
    </p>
    @if($tahunTersedia && count($tahunTersedia) > 0)
    <div class="bg-amber-50 rounded-lg p-4 inline-block border border-amber-200">
        <p class="text-sm text-amber-800 font-medium flex items-center">
            <i class="fas fa-lightbulb mr-2"></i> Silakan pilih tahun lain yang tersedia di atas untuk melihat data APBDes
        </p>
    </div>
    @endif
</div>
@endif
