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
            <div class="py-4 text-center text-sm text-grey-dark">
                latest {{ $extension->latestVersion }} - released {{ $extension->updated_at->diffForHumans() }}
            </div>
            @if (count($extension->maintainers))
                <div class="flex justify-center py-4">
                    @foreach($extension->maintainers as $name => $email)
                        <img src="https://secure.gravatar.com/avatar/{{ md5($email) }}?size=128&d=identicon" alt="{{ $name }}" class="mx-2 rounded-full w-16 h-16"/>
                    @endforeach
                </div>
            @endif
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
            @if (count($extension->keyWords))
                <div class="flex justify-center pt-6">
                    @foreach($extension->keyWords as $keyword)
                        <div class="bg-blue text-white text-sm rounded px-4 py-2 mx-2">{{ $keyword }}</div>
                    @endforeach
                </div>
            @endif
        </div>

        @if($extension->hasLocalReadme())
            <article class="py-12 lg:px-10 markdown-body border-b">
                {!! $extension->readme !!}
            </article>
        @endif

        <div class="py-6 text-center">
            <a href="{{ route('extensions.index') }}">back to index</a>
        </div>
     </div>

    @push('scripts')
        <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
    @endpush

    @include('partials.footer')
@endsection
