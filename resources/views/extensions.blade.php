@extends('layouts.app', [
    'title' => 'Laravel Mix Extensions',
    'description' => 'List of Laravel Mix extenstions.',
])

@section('body')
    <div class="min-h-screen flex flex-col items-center justify-center">
        <div>
            <h1 class="border-b">Laravel Mix Extensions</h1>

            <ul class="mt-8 list-reset">
                <li class="border-b mb-2 pb-1">
                    <a href="https://github.com/ankurk91/laravel-mix-auto-extract" target="_blank" class="text-black no-underline hover:text-blue">
                        Auto extract
                    </a>
                </li>
                <li class="border-b mb-2 pb-1">
                    <a href="https://github.com/Rias500/laravel-mix-banner" target="_blank" class="text-black no-underline hover:text-blue">
                        Banner
                    </a>
                </li>
                <li class="border-b mb-2 pb-1">
                    <a href="https://github.com/dadamotion/laravel-mix-dload" target="_blank" class="text-black no-underline hover:text-blue">
                        Download
                    </a>
                </li>
                <li class="border-b mb-2 pb-1">
                    <a href="https://github.com/spatie/laravel-mix-purgecss" target="_blank" class="text-black no-underline hover:text-blue">
                        Purgecss
                    </a>
                </li>
                <li class="border-b mb-2 pb-1">
                    <a href="https://github.com/swisnl/laravel-mix-svg-sprite" target="_blank" class="text-black no-underline hover:text-blue">
                        SVG Sprite
                    </a>
                </li>
                <li class="border-b mb-2 pb-1">
                    <a href="https://github.com/JeffreyWay/laravel-mix-tailwind" target="_blank" class="text-black no-underline hover:text-blue">
                        Tailwind
                    </a>
                </li>
                <li class="border-b mb-2 pb-1">
                    <a href="https://github.com/ctf0/laravel-mix-versionhash" target="_blank" class="text-black no-underline hover:text-blue">
                        Version hash
                    </a>
                </li>
            </ul>
        </div>

        <div class="mt-8">
            <a
                href="/"
                class="flex items-center mt-2 mx-2 px-4 py-2 rounded-full border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
            >
                back to homepage
            </a>
        </div>

        <div class="flex items-center mt-32 text-grey-light text-xs">
            <span>proudly hosted with</span>
            <a href="https://m.do.co/c/7a24c68b1e6d" class="text-grey-light hover:text-blue-light">
                @include('svg.digital-ocean-logo', ['class' => 'ml-2 fill-current w-24'])
            </a>
        </div>
    </div>
@endsection
