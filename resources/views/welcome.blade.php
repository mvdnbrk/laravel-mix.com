@extends('layouts.app')

@section('body')
    <div class="flex items-center justify-center min-h-screen border-t-4">
        <div class="flex flex-col items-center">
            @include('svg.laravel-mix-logo', ['class' => 'w-64'])

            <p class="px-4 mt-6 text-lg leading-normal text-center">An elegant wrapper around Webpack for the 80% use case.</p>

            <div class="mt-16 md:flex">
                <a
                    href="{{ $documentation_url }}"
                    class="flex items-center px-4 py-2 mx-2 mt-2 text-gray-700 bg-white border rounded-lg hover:bg-gray-200 hover:border-gray-500"
                >
                    @include('svg.icons.book-reference', ['class' => 'fill-current mr-2 w-4 h-4'])
                    Documentation
                </a>

                <a
                    href="https://github.com/JeffreyWay/laravel-mix"
                    class="flex items-center px-4 py-2 mx-2 mt-2 text-gray-700 bg-white border rounded-lg hover:bg-gray-200 hover:border-gray-500"
                >
                    @include('svg.icons.github', ['class' => 'fill-current mr-2 w-4 h-4'])
                    Source on Github
                </a>

                <a
                    href="https://laracasts.com/series/learn-laravel-mix"
                    class="flex items-center px-4 py-2 mx-2 mt-2 text-gray-700 bg-white border rounded-lg hover:bg-gray-200 hover:border-gray-500"
                    title="Watch screencasts at Laracasts: Learn Laravel Mix"
                >
                    @include('svg.icons.video-solid', ['class' => 'fill-current mr-2 w-4 h-4'])
                    Laracasts
                </a>

                <a
                    href="{{ route('extensions.index') }}"
                    class="flex items-center px-4 py-2 mx-2 mt-2 text-gray-700 bg-white border rounded-lg hover:bg-gray-200 hover:border-gray-500"
                >
                    @include('svg.icons.puzzle-piece-solid', ['class' => 'fill-current mr-2 w-4 h-4'])
                    Extensions
                </a>
            </div>

            <x-footer></x-footer>
        </div>
    </div>
@endsection
