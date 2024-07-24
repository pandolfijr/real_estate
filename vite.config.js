import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        port: 3010,
        watch: {
            usePolling: true, // Adicionado para resolver problemas de watch em alguns ambientes
        },
    },
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/assets/sass/app.scss',
                'resources/sass/login.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            lodash: 'lodash-es',
        },
    },
    logLevel: 'info' // Adicionado para obter mais informações no console
});
