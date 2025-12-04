import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  build: {
    outDir: "../public_html/build", // arahkan hasil build
    manifest: true,
    emptyOutDir: false, // jangan hapus folder public_html lainnya
  },
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true,
    }),
  ],
});
