<section id="potensi-desa" class="mb-24 scroll-mt-24">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                    🌾 Potensi Desa
                </h2>
                <div class="section-divider"></div>
                <p class="text-lg text-body max-w-3xl mx-auto">
                    Berbagai potensi dan kekayaan yang dimiliki Desa Ngengor sebagai modal pembangunan
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300 border-t-4 border-green-500">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">🌾</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Sumber Daya Alam</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                            <h4 class="font-semibold text-heading mb-1">Lahan Pertanian: 100 ha</h4>
                            <p class="text-sm text-body">Lahan produktif padi & palawija</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                            <h4 class="font-semibold text-heading mb-1">Lahan Perkebunan: 13 ha</h4>
                            <p class="text-sm text-body">Kebun kelapa & tanaman keras</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                            <h4 class="font-semibold text-heading mb-1">Fasilitas: 0,37 ha</h4>
                            <p class="text-sm text-body">Perkantoran & Lapangan Olahraga</p>
                        </div>
                    </div>
                </div>

                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300 border-t-4 border-blue-500">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">👥</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Sumber Daya Manusia</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                            <h4 class="font-semibold text-heading mb-1">Laki-laki: {{ number_format($sdmStats['laki_laki']) }} jiwa</h4>
                            <p class="text-sm text-body">Populasi penduduk laki-laki</p>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                            <h4 class="font-semibold text-heading mb-1">Perempuan: {{ number_format($sdmStats['perempuan']) }} jiwa</h4>
                            <p class="text-sm text-body">Populasi penduduk perempuan</p>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                            <h4 class="font-semibold text-heading mb-1">Total KK: {{ number_format($sdmStats['kk']) }} Keluarga</h4>
                            <p class="text-sm text-body">Jumlah Kepala Keluarga</p>
                        </div>
                    </div>
                </div>

                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300 border-t-4 border-purple-500">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">🎓</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Tingkat Pendidikan</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                            <h4 class="font-semibold text-heading mb-1">Perguruan Tinggi: {{ number_format($pendidikanStats['sarjana']) }}</h4>
                            <p class="text-sm text-body">Lulusan Diploma, S1, S2, S3</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                            <h4 class="font-semibold text-heading mb-1">Menengah (SMA/SMP): {{ number_format($pendidikanStats['slta'] + $pendidikanStats['sltp']) }}</h4>
                            <p class="text-sm text-body">Lulusan SMA/SMK dan SMP/Mts</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                            <h4 class="font-semibold text-heading mb-1">Dasar (SD): {{ number_format($pendidikanStats['sd']) }}</h4>
                            <p class="text-sm text-body">Lulusan Sekolah Dasar/MI</p>
                        </div>
                    </div>
                </div>

                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300 border-t-4 border-orange-500">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">💼</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Sektor Pekerjaan</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">
                            <h4 class="font-semibold text-heading mb-1">Petani: {{ number_format($pekerjaanStats['pertanian']) }} orang</h4>
                            <p class="text-sm text-body">Sektor pertanian & perkebunan</p>
                        </div>
                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">
                            <h4 class="font-semibold text-heading mb-1">Wiraswasta: {{ number_format($pekerjaanStats['wiraswasta']) }} orang</h4>
                            <p class="text-sm text-body">Pedagang & pengusaha mandiri</p>
                        </div>
                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">
                            <h4 class="font-semibold text-heading mb-1">Pegawai Swasta: {{ number_format($pekerjaanStats['pegawai_swasta']) }} orang</h4>
                            <p class="text-sm text-body">Karyawan perusahaan swasta</p>
                        </div>
                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">
                            <h4 class="font-semibold text-heading mb-1">Belum Bekerja: {{ number_format($pekerjaanStats['belum_bekerja']) }} orang</h4>
                            <p class="text-sm text-body">Sedang mencari pekerjaan</p>
                        </div>
                    </div>
                </div>

                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300 border-t-4 border-teal-500">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">🏫</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Fasilitas Umum</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-teal-50 rounded-xl p-4 border border-teal-100">
                            <h4 class="font-semibold text-heading mb-1">Pendidikan: 0,20 ha</h4>
                            <p class="text-sm text-body">Sekolah & sarana belajar</p>
                        </div>
                        <div class="bg-teal-50 rounded-xl p-4 border border-teal-100">
                            <h4 class="font-semibold text-heading mb-1">Pemakaman: 0,38 ha</h4>
                            <p class="text-sm text-body">Area pemakaman umum</p>
                        </div>
                        <div class="bg-teal-50 rounded-xl p-4 border border-teal-100">
                            <h4 class="font-semibold text-heading mb-1">Masjid/Musholla</h4>
                            <p class="text-sm text-body">Sarana ibadah masyarakat</p>
                        </div>
                    </div>
                </div>

                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300 border-t-4 border-indigo-500">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">📊</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Ringkasan Potensi</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                            <h4 class="font-semibold text-heading mb-1">Total Wilayah: 113,87 ha</h4>
                            <p class="text-sm text-body">Luas wilayah administratif</p>
                        </div>

                        <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                            <h4 class="font-semibold text-heading mb-1">Penduduk: {{ number_format($sdmStats['laki_laki'] + $sdmStats['perempuan']) }} jiwa</h4>
                            <p class="text-sm text-body">Total populasi saat ini</p>
                        </div>

                        <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                            <h4 class="font-semibold text-heading mb-1">Sektor Utama: Pertanian</h4>
                            <p class="text-sm text-body">Basis ekonomi ({{ number_format($pekerjaanStats['pertanian']) }} petani)</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>