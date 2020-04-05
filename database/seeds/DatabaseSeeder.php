<?php

use App\Extension;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        collect([
            'laravel-mix',
            'laravel-mix-aero',
            'laravel-mix-auto-extract',
            'laravel-mix-banner',
            'laravel-mix-bundle-analyzer',
            'laravel-mix-clean-css',
            'laravel-mix-compress-images',
            'laravel-mix-copy-watched',
            'laravel-mix-critical',
            'laravel-mix-criticalcss',
            'laravel-mix-css-partial',
            'laravel-mix-definitions',
            'laravel-mix-dl',
            'laravel-mix-dload',
            'laravel-mix-ejs',
            'laravel-mix-eslint',
            'laravel-mix-eslint-config',
            'laravel-mix-glob',
            'laravel-mix-ignore',
            'laravel-mix-imagemin',
            'laravel-mix-merge-manifest',
            'laravel-mix-mjml',
            'laravel-mix-modernizr',
            'laravel-mix-polyfill',
            'laravel-mix-postcss-config',
            'laravel-mix-prerender',
            'laravel-mix-purgecss',
            'laravel-mix-remove-flow-types',
            'laravel-mix-sri',
            'laravel-mix-svelte',
            'laravel-mix-svg-sprite',
            'laravel-mix-svg-vue',
            'laravel-mix-tailwind',
            'laravel-mix-twig-to-html',
            'laravel-mix-versionhash',
            'laravel-mix-vue-auto-routing',
            'laravel-mix-vue-svgicon',
            'laravel-mix-workbox',
            'mix-env-file',
            'mix-html-builder',
            'mix-serve',
            'mix-tailwindcss',
        ])->each(function ($package) {
            DB::table('extensions')->insert([
                'name' => $package,
            ]);
        });

        Extension::whereName('laravel-mix')->first()->delete();
    }
}
