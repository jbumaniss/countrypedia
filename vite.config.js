import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import copy from 'rollup-plugin-copy';

export default defineConfig({
    plugins: [
        vue({
            template: {
                compilerOptions: {
                    isCustomElement: tag => tag.startsWith('ion-'),
                },
            },
        }),
        laravel({
            input: ['resources/js/app.js', 'resources/css/app.css'],
            refresh: true,
        }),
        copy({
            targets: [
                {
                    src: [
                        'node_modules/@ionic/core/dist/ionic/*',
                        'node_modules/@ionic/core/css/ionic.bundle.css'
                    ],
                    dest: 'public/ionic'
                },
            ],
            hook: 'writeBundle',
        }),
    ],
});
