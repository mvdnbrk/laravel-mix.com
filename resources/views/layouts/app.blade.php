<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <title>{{ $title ?? config('app.name', 'Laravel Mix') }}</title>
        <meta name="description" content="{{ $description ?? 'An elegant wrapper around Webpack for the 80% use case.' }}">
        @if (isset($canonical))
        <link rel="canonical" href="{{ url($canonical) }}" />
        @endif
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="icon" sizes="16x16 32x32" href="/images/favicons/favicon.ico">
        <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/16x16.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/images/favicons/32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/images/favicons/96x96.png">
        <link rel="apple-touch-icon-precomposed" href="/images/favicons/152x152.png">

        @include('partials.schema-organization')

        {!! Analytics::render() !!}
    </head>
    <body>
        <div id="app">
            @yield('body')
        </div>
        @stack('scripts')
    </body>
</html>
