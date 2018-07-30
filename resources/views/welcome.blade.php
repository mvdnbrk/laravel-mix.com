@extends('layouts.app')

@section('body')
    <div class="min-h-screen flex items-center justify-center">
        <div class="flex flex-col items-center">
            @include('svg.logo')

            <h2 class="flex justify-center mt-2 text-sm text-grey">v2.1.11</h2>

            <div class="md:flex mt-16">
                <a
                    href="https://github.com/JeffreyWay/laravel-mix"
                    class="flex items-center mt-2 mx-2 px-4 py-2 rounded-full border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
                >
                    @include('svg.icons.github', ['class' => 'current-fill w-4 h-4'])
                    <span class="ml-2">Source on Github</span>
                </a>

                <a
                    href="https://github.com/JeffreyWay/laravel-mix/tree/master/docs#readme"
                    class="flex items-center mt-2 mx-2 px-4 py-2 rounded-full border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
                >
                    @include('svg.icons.github', ['class' => 'current-fill w-4 h-4'])
                    <span class="ml-2">Docs on Github</span>
                </a>
                <a
                    href="https://laracasts.com/series/learn-laravel-mix"
                    class="flex items-center mt-2 mx-2 px-4 py-2 rounded-full border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
                    title="Watch screencasts at Laracasts: Learn Laravel Mix"
                >
                    @include('svg.icons.video-solid', ['class' => 'current-fill w-4 h-4'])
                    <span class="ml-2">Laracasts</span>
                </a>
            </div>
        </div>
    </div>
@endsection
