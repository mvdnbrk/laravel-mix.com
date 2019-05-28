<scroll-indicator height="4px" color="#F27CC2"></scroll-indicator>
<header class="flex items-center bg-white h-16 z-50 top-0 sticky border-t-4 border-b">
    <div class="container mx-auto">
        <div class="flex items-center justify-between px-6 lg:px-16">
            <a href="{{ config('app.url') }}">
                @include('svg.laravel-mix-logo', ['class' => 'h-8 xl:h-10'])
            </a>
            @if(! isset($hide_menu))
                <toggle-menu></toggle-menu>
            @endif
        </div>
    </div>
</header>
