@extends('layouts.app')

@section('body')
    <div class="min-h-screen flex items-center justify-center">
        <div class="flex flex-col items-center">
            @include('svg.logo')

            <p class="mt-6 text-lg px-4 text-center leading-normal">An elegant wrapper around Webpack for the 80% use case.</p>

            <p class="flex justify-center mt-6 text-sm text-grey">v2.1.11</p>

            <div class="md:flex mt-16">
                <a
                    href="https://github.com/JeffreyWay/laravel-mix"
                    class="flex items-center mt-2 mx-2 px-4 py-2 rounded-full border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
                >
                    @include('svg.icons.github', ['class' => 'fill-current w-4 h-4'])
                    <span class="ml-2">Source on Github</span>
                </a>

                <a
                    href="https://github.com/JeffreyWay/laravel-mix/tree/master/docs#readme"
                    class="flex items-center mt-2 mx-2 px-4 py-2 rounded-full border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
                >
                    @include('svg.icons.file-alt-regular', ['class' => 'fill-current w-4 h-4'])
                    <span class="ml-2">Docs on Github</span>
                </a>
                <a
                    href="https://laracasts.com/series/learn-laravel-mix"
                    class="flex items-center mt-2 mx-2 px-4 py-2 rounded-full border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
                    title="Watch screencasts at Laracasts: Learn Laravel Mix"
                >
                    @include('svg.icons.video-solid', ['class' => 'fill-current w-4 h-4'])
                    <span class="ml-2">Laracasts</span>
                </a>
                <a
                    href="/extensions"
                    class="flex items-center mt-2 mx-2 px-4 py-2 rounded-full border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
                >
                    @include('svg.icons.puzzle-piece-solid', ['class' => 'fill-current w-4 h-4'])
                    <span class="ml-2">Extensions</span>
                </a>
            </div>

            <div class="flex items-center mt-32 text-grey-light text-xs">
                <span>proudly hosted with</span>
                <a href="https://m.do.co/c/7a24c68b1e6d" class="text-grey-light hover:text-blue-light">
                    @include('svg.digital-ocean-logo', ['class' => 'ml-2 fill-current w-24'])
                </a>
            </div>
        </div>
    </div>
@endsection
