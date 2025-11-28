/**
 * Simple Infografis Year Selector Handler
 * Menangani perubahan tahun data untuk halaman infografis
 */

document.addEventListener("DOMContentLoaded", function () {
    // Attach event listeners ke semua tahun selectors
    document.querySelectorAll(".tahun-selector").forEach((selector) => {
        selector.addEventListener("change", function () {
            const tahun = this.value;

            // Reload halaman dengan parameter tahun
            const url = new URL(window.location);
            url.searchParams.set("tahun", tahun);
            window.location.href = url.toString();
        });
    });
});
