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
            'laravel-mix-banner',
            'laravel-mix-criticalcss',
            'laravel-mix-dload',
            'laravel-mix-eslint',
            'laravel-mix-prerender',
            'laravel-mix-purgecss',
            'laravel-mix-svg-sprite',
            'laravel-mix-tailwind',
            'laravel-mix-versionhash',
            'laravel-mix-merge-manifest',
            'laravel-mix-mjml',
            'laravel-mix-sri',
            'mix-html-builder',
            'mix-serve',
        ])->each(function ($package) {
            DB::table('extensions')->insert([
                'name' => $package,
            ]);
        });

        \App\Extension::whereName('laravel-mix')->first()->delete();
    }
}
