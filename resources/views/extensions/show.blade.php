@extends('layouts.app', [
    'title' => $extension->title.' | Laravel Mix Extension',
    'description' => $extension->description,
])

@section('body')
    @include('partials.header', [
        'hide_menu' => true,
    ])

    <div class="max-w-3xl mx-auto px-6">

        <div class="py-12 border-b">
            <h1 class="m-0 pb-2 text-center">{{ $extension->title }}</h1>
            <div class="text-grey-darker text-center">{{ $extension->description }}</div>
            <div class="flex justify-center mt-6">
                <div class="flex items-center bg-grey border-l-4 border-black rounded">
                    @include('svg.icons.chevron-right', ['class' => 'fill-current w-6 h-6 mx-2'])
                    <input
                        type="text"
                        size="{{ mb_strlen($extension->name)+6 }}"
                        value="npm i {{ $extension->name }}"
                        class="w-full bg-grey py-2 font-mono rounded focus:outline-none"
                    >
                </div>
            </div>
            <div class="p-4 text-center text-sm text-grey-dark">
                latest {{ $extension->latestVersion }} - released {{ $extension->updated_at->diffForHumans() }}
            </div>
            <div class="text-center text-sm">
                {{ $extension->license }} license
            </div>
            <div class="text-center text-sm">
                {{ $extension->version_count }} {{ str_plural('version', $extension->version_count) }}
            </div>
            @if ($extension->isGitRepository())
            <div class="text-center pt-6">
                <a href="{{ $extension->repositoryUrl }}">
                    @include('svg.icons.github', ['class' => 'fill-current mr-2 w-8 h-8'])
                </a>
            </div>
            @endif
        </div>
        <div class="flex justify-center py-6">
            @include('partials.carbonads')
        </div>
        <div class="flex justify-center py-6">
            <blockquote class="note">
                <div>
                    <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 5h2v6H9V5zm0 8h2v2H9v-2z"/>
                    </svg>
                </div>
                <p>Work in progress here...<br>Please come back in a while.</p>
            </blockquote>
        </div>
        <div class="py-6 text-center border-t">
            <a href="{{ route('extensions.index') }}">back to index</a>
        </div>
     </div>

    @include('partials.footer')
@endsection
