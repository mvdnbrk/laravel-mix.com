@extends('layouts.app', [
    'title' => $title . ' | Laravel Mix Documentation',
    'description' => 'Documentation for Laravel Mix.',
])

@section('body')
    @include('partials.header')

    <div class="max-w-3xl mx-auto px-6">
        <div class="lg:flex -mx-6">
            <nav id="nav" class="hidden w-full lg:block lg:w-1/4 xl:w-1/5 px-6 pt-4 lg:border-r z-40 lg:max-h-(screen-22) pin-22 lg:sticky">
                <div class="docs-index">
                    {!! $index !!}
                </div>
            </nav>
            <article id="content" class="w-full lg:w-3/4 xl:w-3/5 pt-10 px-6">
                {!! $content !!}
            </article>
            <div class="hidden pt-4 px-6 xl:flex flex-col xl:w-1/5 text-sm items-center lg:max-h-(screen-22) pin-22 lg:sticky">
                @include('partials.carbonads')
                <a
                    class="flex items-center justify-center mt-2 px-5 py-2 rounded border text-grey-darker no-underline hover:bg-grey-lighter hover:border-grey"
                    href="{{ config('documentation.repository.url') }}/edit/{{ $version }}/{{ $page }}.md"
                    target="_blank"
                >
                    @include('svg.icons.edit-pencil', ['class' => 'fill-current mr-2 w-3 h-3'])
                    edit this page
                </a>
            </div>
        </div>
    </div>

    @include('partials.footer')

    @push('scripts')
        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    @endpush
@endsection
