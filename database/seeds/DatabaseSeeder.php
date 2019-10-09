<?php

use Illuminate\Database\Seeder;

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
            'laravel-mix-copy-watched',
            'laravel-mix-critical',
            'laravel-mix-criticalcss',
            'laravel-mix-dl',
            'laravel-mix-dload',
            'laravel-mix-ejs',
            'laravel-mix-eslint',
            'laravel-mix-eslint-config',
            'laravel-mix-glob',
            'laravel-mix-imagemin',
            'laravel-mix-merge-manifest',
            'laravel-mix-mjml',
            'laravel-mix-polyfill',
            'laravel-mix-postcss-config',
            'laravel-mix-prerender',
            'laravel-mix-purgecss',
            'laravel-mix-sri',
            'laravel-mix-svelte',
            'laravel-mix-svg-sprite',
            'laravel-mix-svg-vue',
            'laravel-mix-tailwind',
            'laravel-mix-twig-to-html',
            'laravel-mix-versionhash',
            'laravel-mix-vue-auto-routing',
            'laravel-mix-vue-svgicon',
            'mix-env-file',
            'mix-html-builder',
            'mix-serve',
            'mix-html-builder',
        ])->each(function ($package) {
            DB::table('extensions')->insert([
                'name' => $package,
            ]);
        });

        \App\Extension::whereName('laravel-mix')->first()->delete();
    }
}
