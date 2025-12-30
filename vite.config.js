import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { VitePWA } from "vite-plugin-pwa";

export default defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/app.css", "resources/js/app.js"],
      refresh: true,
    }),

    VitePWA({
      registerType: "autoUpdate",

      includeAssets: [
        "favicon.ico",
        "apple-touch-icon.png"
      ],

      manifest: {
        name: "SIAKAD - Sistem Informasi Akademik Kampus",
        short_name: "SIAKAD",
        description: "Sistem Informasi Akademik Kampus",
        theme_color: "#0d6efd",
        background_color: "#ffffff",
        display: "standalone",
        start_url: "/",
        scope: "/",

        icons: [
          {
            src: "/android-chrome-192x192.png",
            sizes: "192x192",
            type: "image/png"
          },
          {
            src: "/android-chrome-512x512.png",
            sizes: "512x512",
            type: "image/png"
          }
        ]
      },

      workbox: {
        cleanupOutdatedCaches: true,
        navigateFallback: "/login",

        runtimeCaching: [
          {
            urlPattern: ({ url }) =>
              url.pathname.startsWith("/login") ||
              url.pathname.startsWith("/dashboard") ||
              url.pathname.startsWith("/admin") ||
              url.pathname.startsWith("/mahasiswa") ||
              url.pathname.startsWith("/dosen"),
            handler: "NetworkOnly"
          },

          {
            urlPattern: ({ request }) =>
              request.destination === "style" ||
              request.destination === "script" ||
              request.destination === "image" ||
              request.destination === "font",
            handler: "CacheFirst",
            options: {
              cacheName: "siakad-assets",
              expiration: {
                maxEntries: 100,
                maxAgeSeconds: 60 * 60 * 24 * 30
              }
            }
          }
        ]
      }
    })
  ]
});
