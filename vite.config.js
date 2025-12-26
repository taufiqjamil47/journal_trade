import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/app.css',
                'resources/js/app.js',

                // Tambahkan analysis files
                'public/js/analysis/chart-loader.js',
                'public/js/analysis/main.js',
                'public/js/analysis/session-modal.js',
                'public/css/analysis/main.css',
                'public/css/analysis/charts.css',
                'public/css/analysis/heatmap.css'
            ],
            refresh: true,
        }),
    ],
    // konfigurasi baru untuk memisahkan chunk
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'analysis': [
                        'public/js/analysis/chart-loader.js',
                        'public/js/analysis/main.js',
                        'public/js/analysis/session-modal.js'
                    ]
                }
            }
        }
    }
});
