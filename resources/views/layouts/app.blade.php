<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="An elegant wrapper around Webpack for the 80% use case.">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <title>{{ config('app.name', 'Laravel Mix') }}</title>

        <script type="application/ld+json">
        {
            "@context": "http://schema.org/",
            "@type": "Organization",
            "url": "https://laravel-mix.com",
            "logo": "https://laravel-mix.com/images/logo.png"
            "sameAs": [
                "https://github.com/JeffreyWay/laravel-mix"
            ]
        }
        </script>

        {!! Analytics::render() !!}
    </head>

    <body>

    <div id="app" class="border-t-8">
        @yield('body')
    </div>

    </body>
</html>
