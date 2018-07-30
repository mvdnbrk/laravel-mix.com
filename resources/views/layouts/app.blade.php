<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <title>{{ config('app.name', 'Laravel Mix') }}</title>

        {!! Analytics::render() !!}
    </head>

    <body>

    <div id="app" class="border-t-8">
        @yield('body')
    </div>

    </body>
</html>
