<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $description ?? 'An elegant wrapper around Webpack for the 80% use case.' }}">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="icon" sizes="16x16 32x32" href="/images/favicons/favicon.ico">
        <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/16x16.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/images/favicons/32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/images/favicons/96x96.png">
        <link rel="apple-touch-icon-precomposed" href="/images/favicons/152x152.png">

        <title>{{ $title ?? config('app.name', 'Laravel Mix') }}</title>

        <script type="application/ld+json">
        {
            "@context": "http://schema.org/",
            "@type": "Organization",
            "url": "https://laravel-mix.com",
            "logo": "https://laravel-mix.com/images/logo.png",
            "sameAs": [
                "https://github.com/JeffreyWay/laravel-mix"
            ]
        }
        </script>

        {!! Analytics::render() !!}
    </head>

    <body>

    <div id="app">
        @yield('body')
    </div>

    @stack('scripts')
    </body>
</html>
