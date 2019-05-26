<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <title>{{ $title ?? config('app.name', 'Laravel Mix') }}</title>
        @if (isset($canonical))
        <link rel="canonical" href="{{ url($canonical) }}" />
        @endif
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="apple-mobile-web-app-title" content="Laravel MIx">
        <meta name="application-name" content="Laravel MIx">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="theme-color" content="#ffffff">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $description ?? 'An elegant wrapper around Webpack for the 80% use case.' }}">
        @include('partials.schema-organization')
        {{ Breadcrumbs::view('breadcrumbs::json-ld') }}
        {!! Analytics::render() !!}
    </head>
    <body>
        <div id="app">
            @yield('body')
        </div>
        @stack('scripts')
    </body>
</html>
