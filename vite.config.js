import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import vueI18n from "@intlify/vite-plugin-vue-i18n";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.js",
            buildDirectory: "build", // Customize the build directory...
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    // The Vue plugin will re-write asset URLs, when referenced
                    // in Single File Components, to point to the Laravel web
                    // server. Setting this to `null` allows the Laravel plugin
                    // to instead re-write asset URLs to point to the Vite
                    // server instead.
                    base: null,

                    // The Vue plugin will parse absolute URLs and treat them
                    // as absolute paths to files on disk. Setting this to
                    // `false` will leave absolute URLs un-touched so they can
                    // reference assets in the public directly as expected.
                    includeAbsolute: false,
                },
            },
        }),

        /**
         * vite-plugin-vue-i18n plugin does i18n resources pre-compilation / optimizations
         *
         * @see https://github.com/intlify/bundle-tools/tree/main/packages/vite-plugin-vue-i18n
         */
        vueI18n({
            include: path.resolve(__dirname, "./src/locales/**"),
        }),
    ],
});
