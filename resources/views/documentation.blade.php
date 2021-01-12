@extends('layouts.app', [
    'title' => $title . ' | Laravel Mix Documentation',
    'description' => 'Documentation for Laravel Mix.',
])

@section('body')
@include('partials.header', [
    'versionsContainingPage' => $versionsContainingPage,
    'currentVersion' => $currentVersion,
])

<div class="w-full max-w-screen-xl mx-auto px-6">
    <div class="lg:flex -mx-6">
        <nav id="nav" class="docs-index hidden w-full lg:block lg:w-1/4 xl:w-1/5 pt-6 px-6 lg:border-r z-10 lg:max-h-(screen-22) pin-22 lg:sticky overflow-y-auto">
            {!! $index !!}
        </nav>
        <article id="content" class="w-full lg:w-3/4 xl:w-3/5 pt-10 px-6 lg:px-12 min-h-(screen-16) markdown-body" v-pre>
            {!! $content !!}
        </article>
        <div class="hidden pt-4 px-6 xl:flex flex-col xl:w-1/5 text-sm items-center lg:max-h-(screen-22) pin-22 lg:sticky">
            <carbon-ads></carbon-ads>
            <a
                class="flex items-center justify-center mt-4 px-5 py-2 rounded border text-gray-500 hover:text-gray-700 hover:bg-gray-200 hover:border-gray-500"
                href="https://github.com/mvdnbrk/laravel-mix-docs/edit/{{ $currentVersion }}/{{ $page }}.md"
                target="_blank"
            >
                @include('svg.icons.edit-pencil', ['class' => 'fill-current mr-2 w-3 h-3'])
                edit this page
            </a>
        </div>
    </div>
</div>

<x-footer></x-footer>

@push('scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
@endsection
