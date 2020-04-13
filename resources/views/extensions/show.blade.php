@extends('layouts.app', [
    'title' => $extension->title.' | Laravel Mix Extension',
    'description' => $extension->description,
])

@section('body')
@include('partials.header', [
    'hide_menu' => true,
])

    <div class="max-w-screen-xl mx-auto px-6">
        <div class="py-12">
            <h1 class="m-0 pb-2 text-center">{{ $extension->title }}</h1>
            <div class="text-center">{{ $extension->description }}</div>
            <div class="flex justify-center mt-6">
                <div class="flex items-center bg-gray-500 border-l-4 border-black rounded">
                    @include('svg.icons.chevron-right', ['class' => 'fill-current w-6 h-6 mx-2'])
                    <input
                        type="text"
                        size="{{ mb_strlen($extension->name)+6 }}"
                        value="npm i {{ $extension->name }}"
                        class="w-full bg-gray-500 py-2 font-mono rounded focus:outline-none"
                    >
                </div>
            </div>
            <div class="py-4 text-center text-sm text-gray-700">
                latest {{ $extension->latestVersion }} - released <time datetime="{{ $extension->updated_at->toISOString() }}">{{ $extension->updated_at->diffForHumans() }}</time>
            </div>
            @if (count($extension->maintainers))
            <div class="flex justify-center py-4">
                @foreach($extension->maintainers as $name => $email)
                    <img src="https://secure.gravatar.com/avatar/{{ md5(\Illuminate\Support\Str::lower($email)) }}?size=100&d=retro" alt="{{ $name }}" class="mx-2 rounded-full w-16 h-16"/>
                @endforeach
            </div>
            @endif
            <div class="py-2 font-semibold text-center text-sm semibold">
                <count :to="{{ $extension->weekly_download_count }}">{{ $extension->weekly_download_count }}</count> {{ \Illuminate\Support\Str::plural('download', $extension->weekly_download_count) }} last week
            </div>
            <div class="text-center text-sm">
                {{ $extension->license }} license
            </div>
            <div class="text-center text-sm">
                {{ $extension->version_count }} {{ Str::plural('version', $extension->version_count) }}
            </div>
            @if ($extension->isGitRepository())
            <div class="text-center pt-6">
                <a href="{{ $extension->repositoryUrl }}">
                    @include('svg.icons.github', ['class' => 'fill-current inline mr-2 w-8 h-8'])
                </a>
            </div>
            @endif
            @if (count($extension->keyWords))
            <div class="flex justify-center pt-6">
                @foreach($extension->keyWords as $keyword)
                <div class="bg-blue-500 text-white text-sm rounded px-4 py-2 mx-2">{{ $keyword }}</div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="lg:px-10">
            <div class="flex py-2 justify-center items-center bg-gray-100 rounded-b-lg border-t text-sm">
                <a href="https://m.do.co/c/7a24c68b1e6d" class="text-gray-600 ">
                    @include('svg.icons.digital-ocean', ['class' => 'mr-4 fill-current w-6'])
                </a>
                <a href="https://m.do.co/c/7a24c68b1e6d" class="text-gray-600 ">
                    Try <span class="font-medium">DigitalOcean</span>
                </a>
                <a href="https://m.do.co/c/7a24c68b1e6d" taget="_blank" class=" ml-4 text-gray-600 hover:text-digitalocean-blue" rel="noopener noreferrer">
                    Simple cloud hosting, built for developers.
                </a>
                <a href="https://m.do.co/c/7a24c68b1e6d" taget="_blank" class="ml-4 text-gray-600 hover:text-digitalocean-blue" rel="noopener noreferrer">
                    Get started now and get <span class="font-medium">$100 credit</span>.
                </a>
                <a href="https://m.do.co/c/7a24c68b1e6d">
                    <span class="bg-white border rounded-lg py-1 px-3 font-medium text-gray-600 text-2xs ml-4 hover:border-digitalocean-blue hover:text-digitalocean-blue">AD</span>
                </a>
            </div>
        </div>

        @if($extension->hasLocalReadme())
        <article class="py-12 lg:px-10 markdown-body border-b" v-pre>
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

    @include('partials.footer')
@endsection
