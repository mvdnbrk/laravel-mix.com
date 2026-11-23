@extends('layouts.app', [
    'title' => 'Troubleshooting Laravel Mix 6 Build Errors',
    'description' => 'How to fix common Laravel Mix 6 errors on current Node and webpack versions, such as "Cannot find module webpack/lib/SizeFormatHelpers" and "Progress Plugin has been initialized using an options object that does not match the API schema".',
    'canonical' => route('troubleshooting'),
])

@section('body')
@include('partials.header', [
    'hide_menu' => true,
])

@php($documentation = app(\Mvdnbrk\Documentation\Documentation::class))

<div class="w-full max-w-screen-xl mx-auto px-6">
    <div class="lg:flex -mx-6">
        <nav id="nav" class="docs-index hidden w-full lg:block lg:w-1/4 xl:w-1/5 pt-6 px-6 lg:border-r z-10 lg:max-h-screen-22 pin-22 lg:sticky overflow-y-auto">
            {!! $documentation->getIndex($documentation->defaultVersion()) !!}
        </nav>
        <article id="content" class="w-full min-w-0 lg:w-3/4 xl:w-3/5 pt-10 px-6 lg:px-12 min-h-screen-16 markdown-body" v-pre>
            {!! \Mvdnbrk\Documentation\Markdown::parse(file_get_contents(resource_path('pages/troubleshooting.md'))) !!}
        </article>
    </div>
</div>

<x-footer></x-footer>

@push('scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
@endsection
