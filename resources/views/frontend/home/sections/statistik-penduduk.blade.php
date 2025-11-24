<section class="py-20 bg-white" id="statistik">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Statistik Penduduk</h2>
            <div class="w-20 h-1 bg-blue-600 mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-4">Data kependudukan desa tahun {{ $tahunDataTerbaru ?? date('Y') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
            <div class="bg-blue-50 p-6 rounded-xl text-center hover:shadow-lg transition duration-300">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 counter">{{ number_format($totalPenduduk ?? 0) }}</h3>
                <p class="text-gray-600 font-medium">Total Penduduk</p>
            </div>

            <div class="bg-green-50 p-6 rounded-xl text-center hover:shadow-lg transition duration-300">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 counter">{{ number_format($totalLaki ?? 0) }}</h3>
                <p class="text-gray-600 font-medium">Laki-laki</p>
            </div>

            <div class="bg-pink-50 p-6 rounded-xl text-center hover:shadow-lg transition duration-300">
                <div class="w-16 h-16 bg-pink-100 text-pink-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 counter">{{ number_format($totalPerempuan ?? 0) }}</h3>
                <p class="text-gray-600 font-medium">Perempuan</p>
            </div>

             <div class="bg-yellow-50 p-6 rounded-xl text-center hover:shadow-lg transition duration-300">
                <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 counter">{{ number_format($pendudukSementara ?? 0) }}</h3>
                <p class="text-gray-600 font-medium">Penduduk Sementara</p>
            </div>

             <div class="bg-purple-50 p-6 rounded-xl text-center hover:shadow-lg transition duration-300">
                <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 counter">{{ number_format($mutasiPenduduk ?? 0) }}</h3>
                <p class="text-gray-600 font-medium">Mutasi</p>
            </div>
        </div>
    </div>
</section>