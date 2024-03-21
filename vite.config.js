import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        // basicSsl({
        //     /** name of certification */
        //     name: "ei-maintenance.fajarpaper.com",
        //     /** custom trust domains */
        //     domains: ["https://ei-maintenance.fajarpaper.com"],
        //     /** custom certification directory */
        //     // certDir: "/Users/.../.devServer/cert",
        // }),
    ],

    // build: {
    //     outDir: "public/build", // Specify the desired output directory here
    // },
});
