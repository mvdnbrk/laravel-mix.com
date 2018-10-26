@extends('layouts.app', [
    'title' => 'Laravel Mix Extensions',
    'description' => 'Discover Laravel Mix Extensions.'
])

@section('body')
    @include('partials.header', [
        'hide_menu' => true,
    ])

    <div class="max-w-3xl mx-auto px-6">
        <h1 class="p-12 text-center">Discover Laravel Mix Extensions</h1>

        <div class="flex flex-wrap -mx-2 -mb-4">
            @foreach($extensions as $extension)
                <div class="w-full lg:w-1/2 xl:w-1/3 px-2 mb-4">
                    <div class="flex flex-col h-48 bg-grey-lightest shadow border-t-4 border-blue-light">
                        <div class="flex flex-col flex-1 p-4">
                            <a href="{{ route('extensions.show', $extension) }}">
                                <h2 class="mt-0 mb-2 text-xl text-grey-darkest hover:text-blue">{{ $extension->title }}</h2>
                            </a>
                            <p class="flex-1">{{ $extension->description }}</p>
                            <a class="flex items-center text-sm" href="{{ route('extensions.show', $extension) }}">
                                Learn more
                            </a>
                        </div>
                        <div class="flex justify-between px-4 py-2 bg-grey-lighter border-t border-grey-light text-xs text-blue-dark ">
                            <div class="font-semibold uppercase">{{ $extension->author_name }}</div>
                            <div class="text-grey-dark">{{ $extension->latestVersion }}</div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="w-full text-center p-6 text-grey-darker">
                Would you like to be listed on this page? Please open an issue <a href="https://github.com/mvdnbrk/laravel-mix-docs/issues" target="_blank">here</a>
            </div>
        </div>
    </div>

    @include('partials.footer')
@endsection
