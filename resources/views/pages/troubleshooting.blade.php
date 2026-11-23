@extends('layouts.app', [
    'title' => 'Troubleshooting Laravel Mix 6 Build Errors',
    'description' => 'How to fix common Laravel Mix 6 errors on current Node and webpack versions, such as "Cannot find module webpack/lib/SizeFormatHelpers" and "Progress Plugin has been initialized using an options object that does not match the API schema".',
    'canonical' => route('troubleshooting'),
])

@section('body')
@include('partials.header', [
    'hide_menu' => true,
])

<div class="w-full max-w-screen-lg mx-auto px-6">
    <article id="content" class="w-full pt-10 pb-12 lg:px-12 min-h-screen-16 markdown-body" v-pre>
        {!! \Mvdnbrk\Documentation\Markdown::parse(file_get_contents(resource_path('pages/troubleshooting.md'))) !!}
    </article>
</div>

<x-footer></x-footer>

@push('scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
@endsection
