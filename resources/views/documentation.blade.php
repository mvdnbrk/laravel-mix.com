@extends('layouts.app', [
    'title' => $title . ' | Laravel Mix Documentation',
    'description' => 'Documentation for Laravel Mix.',
])

@section('body')
    @include('partials.header')
    <div class="container mx-auto">
        <div class="flex">
            <section class="flex flex-col lg:w-1/4 xl:w-1/5 p-8 border-r">
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
    </div>
    @include('partials.footer')
@endsection
