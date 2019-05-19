@extends('layouts.app', [
    'title' => $title . ' | Laravel Mix Documentation',
    'description' => 'Documentation for Laravel Mix.',
])

@section('body')
    @include('partials.header')

    <div class="w-full max-w-screen-xl mx-auto px-6">
        <div class="lg:flex -mx-6">
            <nav id="nav" class="hidden w-full lg:block lg:w-1/4 xl:w-1/5 px-6 pt-4 lg:border-r z-40 lg:max-h-(screen-22) pin-22 lg:sticky">

                <div class="flex -mx-1 mt-2 mb-4">
                @foreach($pageExistsInVersions as $version => $url)
                    @if($version == 'master')
                        @continue
                    @endif
                    @if($currentVersion !== $version)
                    <a class="px-2 py-1 mx-1 bg-gray-200 text-sm text-gray-500 rounded border hover:border-gray-500 hover:text-gray-700" href="{{ $url }}">
                        {{ $version }}
                    </a>
                    @else
                    <div class="px-2 py-1 mx-1 bg-gray-400 text-sm text-gray-700 rounded border border-gray-500">
                        {{ $version }}
                    </div>
                    @endif
                @endforeach
                </div>

                <div class="docs-index">
                    {!! $index !!}
                </div>
            </nav>
            <article id="content" class="w-full lg:w-3/4 xl:w-3/5 pt-10 px-6 lg:px-12 min-h-(screen-16) markdown-body">
                {!! $content !!}
            </article>
            <div class="hidden pt-4 px-6 xl:flex flex-col xl:w-1/5 text-sm items-center lg:max-h-(screen-22) pin-22 lg:sticky">
                @include('partials.carbonads')
                <a
                    class="flex items-center justify-center mt-4 px-5 py-2 rounded border text-gray-700 no-underline hover:bg-gray-200 hover:border-gray-500"
                    href="{{ config('documentation.repository.url') }}/edit/{{ $currentVersion }}/{{ $page }}.md"
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
