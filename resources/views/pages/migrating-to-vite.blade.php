@extends('layouts.app', [
    'title' => 'Migrating from Laravel Mix to Vite',
    'description' => 'How to migrate a Laravel Mix project to Vite: what each webpack.mix.js option becomes in vite.config.js, the errors you will run into, and the Vite replacements for popular Mix extensions.',
    'canonical' => 'migrating-to-vite',
])

@section('body')
@include('partials.header', [
    'hide_menu' => true,
])

<div class="w-full max-w-screen-xl mx-auto px-6">
    <article id="content" class="w-full lg:w-3/4 xl:w-3/5 mx-auto pt-10 px-6 lg:px-12 min-h-screen-16 markdown-body" v-pre>
        {!! Mvdnbrk\Documentation\Markdown::parse(file_get_contents(resource_path('pages/migrating-to-vite.md'))) !!}
    </article>
</div>

<x-footer></x-footer>

@push('scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
@endsection
