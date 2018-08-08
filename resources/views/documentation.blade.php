@extends('layouts.app', [
    'title' => $title . ' | Laravel Mix Documentation',
    'description' => 'Documentation for Laravel Mix.',
])

@section('body')
    <div class="container mx-auto">
        <div class="flex">
            <section class="flex flex-col xl:w-1/5 p-8 border-r">
                <div class="flex justify-center mb-12">
                    <a href="{{ config('app.url') }}">
                        @include('svg.laravel-mix-logo', ['class' => 'w-32 h-8'])
                    </a>
                </div>
                <div class="docs-index">
                    {!! $index !!}
                </div>
            </section>

            <article class="mt-16 xl:w-4/5 p-8">
                {!! $content !!}
            </article>
        </div>

        <footer class="flex items-center justify-center mt-16 mb-24 text-grey-light text-xs">
            <span>proudly hosted with</span>
            <a href="https://m.do.co/c/7a24c68b1e6d" class="text-grey-light hover:text-blue-light">
                @include('svg.digital-ocean-logo', ['class' => 'ml-2 fill-current w-24'])
            </a>
        </footer>
    </div>
@endsection
