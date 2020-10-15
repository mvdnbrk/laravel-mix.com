@extends('layouts.app', [
    'title' => $extension->title.' | Laravel Mix Extension',
    'description' => $extension->description,
])

@section('body')
@include('partials.header', [
    'hide_menu' => true,
])

    <div class="max-w-screen-xl px-6 mx-auto">
        <div class="py-12">
            <h1 class="pb-2 m-0 text-center">{{ $extension->title }}</h1>
            <div class="text-center">{{ $extension->description }}</div>
            <div class="flex justify-center mt-6">
                <div class="flex items-center bg-gray-500 border-l-4 border-black rounded">
                    @include('svg.icons.chevron-right', ['class' => 'fill-current w-6 h-6 mx-2'])
                    <input
                        type="text"
                        size="{{ mb_strlen($extension->name)+6 }}"
                        value="npm i {{ $extension->name }}"
                        class="w-full py-2 font-mono bg-gray-500 rounded focus:outline-none"
                    >
                </div>
            </div>
            <div class="py-4 text-sm text-center text-gray-700">
                latest {{ $extension->latestVersion }} - released <time datetime="{{ $extension->updated_at->toISOString() }}">{{ $extension->updated_at->diffForHumans() }}</time>
            </div>
            @if (count($extension->maintainers))
            <div class="flex justify-center py-4">
                @foreach($extension->maintainers as $name => $email)
                    <img src="https://secure.gravatar.com/avatar/{{ md5(\Illuminate\Support\Str::lower($email)) }}?size=100&d=retro" alt="{{ $name }}" class="w-16 h-16 mx-2 rounded-full"/>
                @endforeach
            </div>
            @endif
            <div class="py-2 text-sm font-semibold text-center semibold">
                <count :to="{{ $extension->weekly_download_count }}">{{ $extension->weekly_download_count }}</count> {{ \Illuminate\Support\Str::plural('download', $extension->weekly_download_count) }} last week
            </div>
            <div class="text-sm text-center">
                {{ $extension->license }} license
            </div>
            <div class="text-sm text-center">
                {{ $extension->version_count }} {{ Str::plural('version', $extension->version_count) }}
            </div>
            @if ($extension->isGitRepository())
            <div class="pt-6 text-center">
                <a href="{{ $extension->repositoryUrl }}">
                    @include('svg.icons.github', ['class' => 'fill-current inline mr-2 w-8 h-8'])
                </a>
            </div>
            @endif
            @if (count($extension->keyWords))
            <div class="flex justify-center pt-6">
                @foreach($extension->keyWords as $keyword)
                <div class="px-4 py-2 mx-2 text-sm text-white bg-blue-500 rounded">{{ $keyword }}</div>
                @endforeach
            </div>
            @endif
        </div>

        <x-ads.ohdear/>

        @if($extension->hasLocalReadme())
        <article class="py-12 border-b lg:px-10 markdown-body" v-pre>
            {!! $extension->readme !!}
        </article>
        @endif

        <div class="py-6 text-center">
            <a href="{{ route('extensions.index') }}" class="underline hover:no-underline hover:text-gray-900">back to index</a>
        </div>
     </div>

    @push('scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    @endpush

    <x-footer></x-footer>
@endsection
