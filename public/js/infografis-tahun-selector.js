/**
 * Infografis Year Selector Handler
 * Menangani perubahan tahun data untuk setiap section infografis
 */

// Global variables untuk menyimpan chart instances
window.infografisCharts = {
    piramida: null,
    pendidikan: null,
    wajibPilih: null,
    dusun: null,
};

// API endpoints
const API_ENDPOINTS = {
    data: "/infografis/data",
};

/**
 * Initialize tahun selector handlers
 */
document.addEventListener("DOMContentLoaded", function () {
    // Attach event listeners ke semua tahun selectors
    document.querySelectorAll(".tahun-selector").forEach((selector) => {
        selector.addEventListener("change", function () {
            const section = this.dataset.section;
            const tahun = this.value;

            console.log(`Changing year for ${section} to ${tahun}`);

            // Show loading
            showLoading(section);

            // Update data berdasarkan section
            updateSectionData(section, tahun);
        });
    });
});

/**
 * Show loading indicator
 */
function showLoading(sectionId) {
    const loadingEl = document.getElementById(`loading-${sectionId}`);
    if (loadingEl) {
        loadingEl.classList.remove("hidden");
    }
}

/**
 * Hide loading indicator
 */
function hideLoading(sectionId) {
    const loadingEl = document.getElementById(`loading-${sectionId}`);
    if (loadingEl) {
        loadingEl.classList.add("hidden");
    }
}

/**
 * Update section data berdasarkan tahun
 */
async function updateSectionData(section, tahun) {
    try {
        switch (section) {
            case "demografi":
                await updateDemografiData(tahun);
                break;
            case "umur":
                await updateUmurData(tahun);
                break;
            case "pendidikan":
                await updatePendidikanData(tahun);
                break;
            case "pekerjaan":
                await updatePekerjaanData(tahun);
                break;
            case "agama":
                await updateAgamaData(tahun);
                break;
            case "perkawinan":
                await updatePerkawinanData(tahun);
                break;
            case "wajib-pilih":
                await updateWajibPilihData(tahun);
                break;
            case "dusun":
                await updateDusunData(tahun);
                break;
        }

        // Update tahun display
        updateTahunDisplay(section, tahun);
    } catch (error) {
        console.error(`Error updating ${section} data:`, error);
        showError(section, "Gagal memuat data. Silakan coba lagi.");
    } finally {
        hideLoading(section);
    }
}

/**
 * Update demografi data
 */
async function updateDemografiData(tahun) {
    const response = await fetch(`${API_ENDPOINTS.statistik}?tahun=${tahun}`);
    const data = await response.json();

    // Update stat boxes
    updateStatBox("stat-total-penduduk", data.totalPenduduk);
    updateStatBox("stat-total-laki", data.totalLaki);
    updateStatBox("stat-total-perempuan", data.totalPerempuan);
    updateStatBox("stat-penduduk-sementara", data.pendudukSementara);
    updateStatBox("stat-mutasi-penduduk", data.mutasiPenduduk);
}

/**
 * Update umur data dan chart
 */
async function updateUmurData(tahun) {
    const response = await fetch(`${API_ENDPOINTS.umur}?tahun=${tahun}`);
    const data = await response.json();

    // Update piramida chart
    if (window.infografisCharts.piramida) {
        window.infografisCharts.piramida.destroy();
    }

    // Recreate chart dengan data baru
    createPiramidaChart(data.umurData);
}

/**
 * Update pendidikan data dan chart
 */
async function updatePendidikanData(tahun) {
    const response = await fetch(`${API_ENDPOINTS.pendidikan}?tahun=${tahun}`);
    const data = await response.json();

    // Update pendidikan chart
    if (window.infografisCharts.pendidikan) {
        window.infografisCharts.pendidikan.destroy();
    }

    // Recreate chart dengan data baru
    createPendidikanChart(data.data);
}

/**
 * Update pekerjaan data
 */
async function updatePekerjaanData(tahun) {
    const response = await fetch(`${API_ENDPOINTS.pekerjaan}?tahun=${tahun}`);
    const data = await response.json();

    const pekerjaan = data.pekerjaan;

    // Update tabel pekerjaan
    updateTableData("tabel-pekerjaan", {
        petani: pekerjaan.petani,
        belum_bekerja: pekerjaan.belum_bekerja,
        pelajar_mahasiswa: pekerjaan.pelajar_mahasiswa,
        ibu_rumah_tangga: pekerjaan.ibu_rumah_tangga,
        wiraswasta: pekerjaan.wiraswasta,
        pegawai_swasta: pekerjaan.pegawai_swasta,
        lainnya: pekerjaan.lainnya,
    });
}

/**
 * Update agama data
 */
async function updateAgamaData(tahun) {
    const response = await fetch(`${API_ENDPOINTS.agama}?tahun=${tahun}`);
    const data = await response.json();

    const agama = data.agama;

    // Update agama cards
    updateDataField("islam", agama.islam);
    updateDataField("katolik", agama.katolik);
    updateDataField("kristen", agama.kristen);
    updateDataField("hindu", agama.hindu);
    updateDataField("buddha", agama.buddha);
    updateDataField("konghucu", agama.konghucu);
    updateDataField("kepercayaan_lain", agama.kepercayaan_lain);
}

/**
 * Update perkawinan data
 */
async function updatePerkawinanData(tahun) {
    const response = await fetch(`${API_ENDPOINTS.perkawinan}?tahun=${tahun}`);
    const data = await response.json();

    // Update perkawinan cards - implementasi tergantung struktur HTML
    console.log("Perkawinan data updated:", data);
}

/**
 * Update wajib pilih data
 */
async function updateWajibPilihData(tahun) {
    const response = await fetch(`${API_ENDPOINTS.wajibPilih}?tahun=${tahun}`);
    const data = await response.json();

    // Update wajib pilih chart
    if (window.infografisCharts.wajibPilih) {
        window.infografisCharts.wajibPilih.destroy();
    }

    // Recreate chart dengan data baru
    createWajibPilihChart(data);
}

/**
 * Helper function untuk update stat box
 */
function updateStatBox(elementId, value) {
    const element = document.getElementById(elementId);
    if (element) {
        const valueElement =
            element.querySelector("[data-stat-value]") ||
            element.querySelector(".stat-value");
        if (valueElement) {
            // Animasi counter
            animateCounter(valueElement, parseInt(value) || 0);
        }
    }
}

/**
 * Helper function untuk update tabel data
 */
function updateTableData(tableId, data) {
    const table = document.getElementById(tableId);
    if (table) {
        Object.keys(data).forEach((field) => {
            const cell = table.querySelector(`[data-field="${field}"]`);
            if (cell) {
                cell.textContent = data[field] || 0;
            }
        });
    }
}

/**
 * Helper function untuk update data field
 */
function updateDataField(field, value) {
    const elements = document.querySelectorAll(`[data-field="${field}"]`);
    elements.forEach((element) => {
        element.textContent = value || 0;
    });
}

/**
 * Update tahun display
 */
function updateTahunDisplay(section, tahun) {
    const displayElement = document.getElementById(`tahun-display-${section}`);
    if (displayElement) {
        if (section === "demografi") {
            displayElement.textContent = tahun;
        } else {
            displayElement.textContent = `(${tahun})`;
        }
    }
}

/**
 * Animate counter untuk stat boxes
 */
function animateCounter(element, targetValue) {
    const startValue = parseInt(element.textContent) || 0;
    const increment = Math.ceil((targetValue - startValue) / 30);
    let currentValue = startValue;

    const timer = setInterval(() => {
        if (
            (increment > 0 && currentValue >= targetValue) ||
            (increment < 0 && currentValue <= targetValue)
        ) {
            element.textContent = targetValue.toLocaleString();
            clearInterval(timer);
        } else {
            currentValue += increment;
            element.textContent = currentValue.toLocaleString();
        }
    }, 50);
}

/**
 * Show error message
 */
function showError(section, message) {
    // Implementasi sesuai kebutuhan UI
    console.error(`Error in ${section}:`, message);
}

/**
 * Create piramida chart dengan data baru
 */
function createPiramidaChart(umurData) {
    const ctx = document.getElementById("chartPiramida");
    if (!ctx) return;

    window.infografisCharts.piramida = new Chart(ctx.getContext("2d"), {
        type: "bar",
        data: {
            labels: [
                "0-4",
                "5-9",
                "10-14",
                "15-19",
                "20-24",
                "25-29",
                "30-34",
                "35-39",
                "40-44",
                "45-49",
                "50+",
            ],
            datasets: [
                {
                    label: "Laki-laki",
                    data: [
                        -(umurData.umur_0_4 || 0) / 2,
                        -(umurData.umur_5_9 || 0) / 2,
                        -(umurData.umur_10_14 || 0) / 2,
                        -(umurData.umur_15_19 || 0) / 2,
                        -(umurData.umur_20_24 || 0) / 2,
                        -(umurData.umur_25_29 || 0) / 2,
                        -(umurData.umur_30_34 || 0) / 2,
                        -(umurData.umur_35_39 || 0) / 2,
                        -(umurData.umur_40_44 || 0) / 2,
                        -(umurData.umur_45_49 || 0) / 2,
                        -(umurData.umur_50_plus || 0) / 2,
                    ],
                    backgroundColor: "rgba(56, 161, 105, 0.8)",
                },
                {
                    label: "Perempuan",
                    data: [
                        (umurData.umur_0_4 || 0) / 2,
                        (umurData.umur_5_9 || 0) / 2,
                        (umurData.umur_10_14 || 0) / 2,
                        (umurData.umur_15_19 || 0) / 2,
                        (umurData.umur_20_24 || 0) / 2,
                        (umurData.umur_25_29 || 0) / 2,
                        (umurData.umur_30_34 || 0) / 2,
                        (umurData.umur_35_39 || 0) / 2,
                        (umurData.umur_40_44 || 0) / 2,
                        (umurData.umur_45_49 || 0) / 2,
                        (umurData.umur_50_plus || 0) / 2,
                    ],
                    backgroundColor: "rgba(244, 114, 182, 0.8)",
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: "y",
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                },
            },
        },
    });
}

/**
 * Create pendidikan chart dengan data baru
 */
function createPendidikanChart(pendidikanData) {
    const ctx = document.getElementById("chartPendidikan");
    if (!ctx) return;

    window.infografisCharts.pendidikan = new Chart(ctx.getContext("2d"), {
        type: "bar",
        data: {
            labels: [
                "Tidak/Belum Sekolah",
                "SD/Sederajat",
                "SMP/Sederajat",
                "SMA/Sederajat",
                "Diploma I/II/III/IV",
                "Strata 1",
                "Strata 2",
                "Strata 3",
            ],
            datasets: [
                {
                    data: [
                        pendidikanData.tidak_sekolah || 0,
                        pendidikanData.sd || 0,
                        pendidikanData.smp || 0,
                        pendidikanData.sma || 0,
                        pendidikanData.d1_d4 || 0,
                        pendidikanData.s1 || 0,
                        pendidikanData.s2 || 0,
                        pendidikanData.s3 || 0,
                    ],
                    backgroundColor: "#b80000",
                    borderColor: "#820000",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
            },
        },
    });
}

/**
 * Create wajib pilih chart dengan data baru
 */
function createWajibPilihChart(data) {
    const ctx = document.getElementById("chartWajibPilih");
    if (!ctx) return;

    window.infografisCharts.wajibPilih = new Chart(ctx.getContext("2d"), {
        type: "bar",
        data: {
            labels: data.wajibPilihLabels || [],
            datasets: [
                {
                    data: data.wajibPilihTotals || [],
                    backgroundColor: "#b80000",
                    borderColor: "#820000",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
            },
        },
    });
}

/**
 * Update dusun data dan chart
 */
async function updateDusunData(tahun) {
    try {
        const response = await fetch(`${API_ENDPOINTS.dusun}?tahun=${tahun}`);
        const data = await response.json();

        if (data.success) {
            // Update dusun chart
            if (window.infografisCharts.dusun) {
                window.infografisCharts.dusun.destroy();
            }

            // Recreate chart dengan data baru
            createDusunChart(data.dusunData);

            // Update total statistics
            updateDataField(
                "total_penduduk_dusun",
                data.dusunData.totalPendudukDusun
            );
            updateDataField("total_kk_dusun", data.dusunData.totalKKDusun);

            // Update individual dusun cards
            if (data.dusunData.dusunStatistik) {
                data.dusunData.dusunStatistik.forEach((dusun, index) => {
                    const fieldName = `penduduk_${dusun.nama_dusun
                        .replace(/\s+/g, "_")
                        .toLowerCase()}`;
                    updateDataField(fieldName, dusun.jumlah_penduduk);
                });
            }
        }
    } catch (error) {
        console.error("Error updating dusun data:", error);
        throw error;
    }
}

/**
 * Create dusun chart dengan data baru
 */
function createDusunChart(dusunData) {
    const ctx = document.getElementById("chartDusun");
    if (!ctx) return;

    const chartConfig = dusunData.dusunChartConfig || {};

    window.infografisCharts.dusun = new Chart(ctx.getContext("2d"), {
        type: "doughnut",
        data: {
            labels: chartConfig.labels || [],
            datasets: [
                {
                    data: chartConfig.data || [],
                    backgroundColor: chartConfig.colors || [
                        "rgba(59, 130, 246, 0.8)",
                        "rgba(34, 197, 94, 0.8)",
                        "rgba(251, 191, 36, 0.8)",
                        "rgba(239, 68, 68, 0.8)",
                    ],
                    borderColor: chartConfig.borderColors || [
                        "rgba(59, 130, 246, 1)",
                        "rgba(34, 197, 94, 1)",
                        "rgba(251, 191, 36, 1)",
                        "rgba(239, 68, 68, 1)",
                    ],
                    borderWidth: 2,
                    hoverBorderWidth: 3,
                    hoverBorderColor: "#ffffff",
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "bottom",
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12,
                            weight: "500",
                        },
                    },
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const label = context.label || "";
                            const value = context.parsed || 0;
                            const percentage = chartConfig.percentages
                                ? chartConfig.percentages[context.dataIndex]
                                : 0;
                            return `${label}: ${value.toLocaleString()} orang (${percentage}%)`;
                        },
                    },
                    backgroundColor: "rgba(0, 0, 0, 0.8)",
                    titleColor: "#ffffff",
                    bodyColor: "#ffffff",
                    borderColor: "#ffffff",
                    borderWidth: 1,
                },
            },
            animation: {
                animateScale: true,
                animateRotate: true,
            },
            cutout: "50%",
            layout: {
                padding: 10,
            },
        },
    });
}
