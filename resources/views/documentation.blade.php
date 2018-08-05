@extends('layouts.app', [
    'title' => $title . ' | Laravel Mix Documentation',
    'description' => 'Documentation for Laravel Mix.',
])

@section('body')
    <div class="container mx-auto">
        <div class="mt-4 p-8">
            <a
                href="/docs"
                class="flex items-center px-4 py-2 rounded-full border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
            >
                @include('svg.icons.file-alt-regular', ['class' => 'fill-current mr-2 w-4 h-4'])
                {{ config('app.name') }} Documentation
            </a>
        </div>
        <article class="p-8">
            {!! $content !!}
        </article>
        <div class="flex items-center justify-center mt-16 mb-24 text-grey-light text-xs">
            <span>proudly hosted with</span>
            <a href="https://m.do.co/c/7a24c68b1e6d" class="text-grey-light hover:text-blue-light">
                @include('svg.digital-ocean-logo', ['class' => 'ml-2 fill-current w-24'])
            </a>
        </div>
    </div>
@endsection
