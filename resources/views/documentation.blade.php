@extends('layouts.app', [
    'title' => $title . ' | Laravel Mix Documentation',
    'description' => 'Documentation for Laravel Mix.',
])

@section('body')
    @include('partials.header')

    <div class="max-w-3xl mx-auto px-6">
        <div class="lg:flex -mx-6">
            <nav id="nav" class="hidden w-full lg:block lg:w-1/4 xl:w-1/5 px-6 pt-10 lg:border-r z-40">
                @include('partials.carbonads')
                <div class="docs-index">
                    {!! $index !!}
                </div>
            </nav>
            <article id="content" class="w-full lg:w-3/4 xl:w-3/5 pt-10 px-6">
                {!! $content !!}
            </article>
            <div class="hidden pt-10 px-6 xl:block xl:w-1/5 text-sm">
            </div>
        </div>
    </div>

    @include('partials.footer')

    @push('scripts')
        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    @endpush
@endsection
