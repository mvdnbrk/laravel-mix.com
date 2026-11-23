@extends('layouts.app', [
    'title' => 'Troubleshooting Laravel Mix 6 Build Errors',
    'description' => 'How to fix common Laravel Mix 6 errors on current Node and webpack versions, such as "Cannot find module webpack/lib/SizeFormatHelpers" and "Progress Plugin has been initialized using an options object that does not match the API schema".',
    'canonical' => route('troubleshooting'),
])

@section('body')
@include('partials.header', [
    'hide_menu' => true,
])

<div class="container mx-auto">
    <article id="content" class="pt-10 pb-12 px-6 lg:px-16 min-h-screen-16 markdown-body" v-pre>
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
