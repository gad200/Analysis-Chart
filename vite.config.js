import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // server: {
    //     host: '192.168.1.4', // Raspberry Pi's IP address
    //     port: 5173,
    //     hmr: {
    //         host: '192.168.1.4', // Raspberry Pi's IP address
    //         protocol: 'ws', // WebSocket protocol for HMR
    //     },
    // },
    resolve: {
        alias: {
            '@': '/resources/js',
            'vue': 'vue/dist/vue.esm-bundler.js'
        },
    },
});
