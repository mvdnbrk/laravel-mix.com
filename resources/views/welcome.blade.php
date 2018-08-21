@extends('layouts.app')

@section('body')
    <div class="min-h-screen flex items-center justify-center">
        <div class="flex flex-col items-center">
            @include('svg.laravel-mix-logo', ['class' => 'w-64'])

            <p class="mt-6 text-lg px-4 text-center leading-normal">An elegant wrapper around Webpack for the 80% use case.</p>

            <p class="flex justify-center mt-6 text-sm text-grey">{{ $latest_release }}</p>

            <div class="md:flex mt-16">
                <a
                    href="{{ $documentation_url }}"
                    class="flex items-center mt-2 mx-2 px-4 py-2 rounded-full border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
                >
                    @include('svg.icons.file-alt-regular', ['class' => 'fill-current mr-2 w-4 h-4'])
                    Documentation
                </a>

                <a
                    href="https://github.com/JeffreyWay/laravel-mix"
                    class="flex items-center mt-2 mx-2 px-4 py-2 rounded-full border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
                >
                    @include('svg.icons.github', ['class' => 'fill-current mr-2 w-4 h-4'])
                    Source on Github
                </a>

                <a
                    href="https://laracasts.com/series/learn-laravel-mix"
                    class="flex items-center mt-2 mx-2 px-4 py-2 rounded-full border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
                    title="Watch screencasts at Laracasts: Learn Laravel Mix"
                >
                    @include('svg.icons.video-solid', ['class' => 'fill-current mr-2 w-4 h-4'])
                    Laracasts
                </a>

                <a
                    href="/extensions"
                    class="flex items-center mt-2 mx-2 px-4 py-2 rounded-full border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
                >
                    @include('svg.icons.puzzle-piece-solid', ['class' => 'fill-current mr-2 w-4 h-4'])
                    Extensions
                </a>
            </div>

            @include('partials.footer')
        </div>
    </div>
@endsection
