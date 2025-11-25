<section id="visi-misi" class="mb-24 scroll-mt-24">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                    🎯 Visi & Misi Desa
                </h2>
                <div class="section-divider"></div>
                <p class="text-lg text-body max-w-3xl mx-auto">
                    Landasan filosofis dan arah pengembangan Desa Ngengor menuju masa depan yang lebih sejahtera
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="card-profil rounded-3xl p-8 lg:p-12 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-profil-primary rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-cyan-500/30">
                            <span class="text-3xl text-white">🎯</span>
                        </div>
                        <h3 class="text-3xl font-bold text-heading">VISI</h3>
                    </div>

                    <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl p-8 text-center border border-cyan-100">
                        <blockquote class="text-xl lg:text-2xl font-semibold text-heading leading-relaxed italic">
                            "MEMBANGUN DESA NGENGOR LEBIH MAJU, MANDIRI, SEJAHTERA, SEHAT, AMAN, BERAHLAK MULIA DENGAN MENJUNJUNG TRANSPARANSI"
                        </blockquote>
                    </div>
                </div>

                <div class="card-profil rounded-3xl p-8 lg:p-12 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-profil-primary rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-cyan-500/30">
                            <span class="text-3xl text-white">🚀</span>
                        </div>
                        <h3 class="text-3xl font-bold text-heading">MISI</h3>
                    </div>

                    <div class="space-y-4">
                        @php
                        $misiList = [
                        'Meningkatkan kualitas sumber daya manusia (SDM)',
                        'Menumbuh kembangkan potensi asli desa',
                        'Meningkatkan taraf hidup masyarakat dengan ekonomi lemah',
                        'Meningkatkan pembangunan infrastruktur',
                        'Meningkatkan derajat kesehatan masyarakat',
                        'Meningkatkan bidang keamanan dan ketertiban'
                        ];
                        @endphp

                        @foreach($misiList as $index => $misi)
                        <div class="flex items-start space-x-4 p-4 bg-white hover:bg-cyan-50 rounded-xl transition-colors border border-gray-100 hover:border-cyan-100">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0 text-sm">
                                {{ $index + 1 }}
                            </div>
                            <p class="text-body font-medium pt-1">{{ $misi }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>