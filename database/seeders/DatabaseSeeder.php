<?php

namespace Database\Seeders;

use App\Models\Extension;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        collect([
            'laravel-mix',
            'laravel-mix-aero',
            'laravel-mix-angular-templatecache',
            'laravel-mix-alias',
            'laravel-mix-artisan-serve',
            'laravel-mix-auto-extract',
            'laravel-mix-banner',
            'laravel-mix-blade-reload',
            'laravel-mix-browser-sync-multi',
            'laravel-mix-bundle',
            'laravel-mix-bundle-analyzer',
            'laravel-mix-clean',
            'laravel-mix-clean-css',
            'laravel-compress',
            'laravel-mix-compress-images',
            'laravel-mix-copy-watched',
            'laravel-mix-critical',
            'laravel-mix-criticalcss',
            'laravel-mix-css-partial',
            'laravel-mix-definitions',
            'laravel-mix-dl',
            'laravel-mix-dload',
            'laravel-mix-dump',
            'laravel-mix-ejs',
            'laravel-mix-eslint',
            'laravel-mix-eslint-config',
            'laravel-mix-eta',
            'laravel-mix-filesystem-deployment',
            'laravel-mix-glob',
            'laravel-mix-handlebars',
            'laravel-mix-ignore',
            'laravel-mix-imagemin',
            'laravel-mix-jigsaw',
            'laravel-mix-js-partial',
            'laravel-mix-make-file-hash',
            'laravel-mix-merge-manifest',
            'laravel-mix-mjml',
            'laravel-mix-modernizr',
            'laravel-mix-nunjucks',
            'laravel-mix-pluton',
            'laravel-mix-polyfill',
            'laravel-mix-postcss-config',
            'laravel-mix-prerender',
            'laravel-mix-pug-recursive',
            'laravel-mix-purgecss',
            'laravel-mix-remove-flow-types',
            'laravel-mix-serve',
            'laravel-mix-sri',
            'laravel-mix-string-replace',
            'laravel-mix-svelte',
            'laravel-mix-svg-sprite',
            'laravel-mix-svg-vue',
            'laravel-mix-tailwind',
            'laravel-mix-twig',
            'laravel-mix-twig-to-html',
            'laravel-mix-versionhash',
            'laravel-mix-vue-auto-routing',
            'laravel-mix-vue-css-modules',
            'laravel-mix-vue-svgicon',
            'laravel-mix-workbox',
            'laravel-mix-wp-blocks',
            'lmvh',
            'mix-env-file',
            'mix-html-builder',
            'mix-replacer',
            'mix-serve',
            'mix-tailwindcss',
            'single-file-blade-components',
            'vuetifyjs-mix-extension',
            'webpack-s3-pusher',
        ])->each(function ($package) {
            DB::table('extensions')->insert([
                'name' => $package,
            ]);
        });

        Extension::whereName('laravel-mix')->first()->delete();
    }
}
