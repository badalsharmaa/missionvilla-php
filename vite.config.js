import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                // Section bundles load only on pages that include the section.
                'resources/css/sections/intro-shutters.css',
                'resources/js/sections/intro-shutters.js',
                'resources/css/sections/hero-cinematic.css',
                'resources/js/sections/hero-cinematic.js',
                'resources/css/sections/care-options.css',
                'resources/js/sections/care-options.js',
                'resources/css/sections/life-gallery.css',
                'resources/js/sections/life-gallery.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
