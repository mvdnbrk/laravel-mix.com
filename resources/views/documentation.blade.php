@extends('layouts.app', [
    'title' => $title . ' | Laravel Mix Documentation',
    'description' => 'Documentation for Laravel Mix.',
])

@section('body')
    <div class="container mx-auto">
        <div class="flex">
            <section class="flex flex-col lg:w-1/4 xl:w-1/5 p-8 border-r">
                <div class="flex justify-center mb-10">
                    <a href="{{ config('app.url') }}">
                        @include('svg.laravel-mix-logo', ['class' => 'w-32 h-8'])
                    </a>
                </div>
                <div>
                    <script
                        async
                        type="text/javascript"
                        src="//cdn.carbonads.com/carbon.js?serve=CK7DV27M&placement=laravel-mixcom"
                        id="_carbonads_js">
                    </script>
                </div>
                <div class="docs-index">
                    {!! $index !!}
                </div>
            </section>

            <article class="lg:w-3/4 xl:w-4/5 p-8">
                {!! $content !!}
            </article>
        </div>

        @include('partials.footer')
    </div>
@endsection
