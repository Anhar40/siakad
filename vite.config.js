import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        VitePWA({
            registerType: 'autoUpdate',
            manifest: {
                name: 'SIAKAD - Sistem Informasi Akademik Kampus',
                short_name: 'SIAKAD',
                theme_color: '#0d6efd',
                background_color: '#ffffff',
                display: 'standalone',
                start_url: '/',
                icons: [
                    {
                        src: '/android-chrome-192x192.png',
                        sizes: '192x192',
                        type: 'image/png'
                    },
                    {
                        src: '/android-chrome-512x512.png',
                        sizes: '512x512',
                        type: 'image/png'
                    }
                ]
            }
        }),
    ],
});
