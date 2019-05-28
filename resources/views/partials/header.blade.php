<scroll-indicator height="4px" color="#F27CC2"></scroll-indicator>
<header class="flex items-center bg-white h-16 z-20 top-0 sticky border-t-4 border-b">
    <div class="container mx-auto">
        <div class="flex items-center justify-between px-6 lg:px-16">
            <a href="{{ config('app.url') }}">
                @include('svg.laravel-mix-logo', ['class' => 'h-8 xl:h-10'])
            </a>
            @if(! isset($hide_menu))
            <toggle-menu></toggle-menu>
            <div class="hidden lg:block">
                <dropdown v-cloak>
                    <template v-slot:trigger>
                        <button type="button" class="flex text-gray-500 hover:text-gray-700 focus:text-gray-500 focus:outline-none">
                            {{ $currentVersion == 'master' ? '' : 'v' }}{{ $currentVersion }}
                            @include('svg.icons.chevron-down', ['class' => 'fill-current w-6 h-6 ml-1'])
                        </button>
                    </template>
                    @foreach($pageExistsInVersions as $version => $url)
                    <li><a href="{{ $url }}" class="px-8 text-center leading-loose hover:bg-gray-200 block">{{ $version }}</a></li>
                    @endforeach
                </dropdown>
            </div>
            @endif
        </div>
    </div>
</header>
