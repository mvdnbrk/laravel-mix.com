<header class="flex items-center bg-white h-16 z-50 pin-t sticky border-t-4 border-b">
    <div class="container mx-auto">
        <div class="flex items-center justify-between px-6 lg:px-16">
            <a href="{{ config('app.url') }}">
                @include('svg.laravel-mix-logo', ['class' => 'h-8 xl:h-10'])
            </a>
            @if(! isset($hide_menu))
                <div id="nav-open" class="text-grey-dark lg:hidden">
                    @include('svg.icons.menu', ['class' => 'fill-current w-6 h-6'])
                </div>
                <div id="nav-close" class="text-grey-dark hidden lg:hidden">
                    @include('svg.icons.close', ['class' => 'fill-current w-6 h-6'])
                </div>
            @endif
        </div>
    </div>
</header>
