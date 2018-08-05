<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default page.
    |--------------------------------------------------------------------------
    |
    | Here you may specify which page should be displayed as a default.
    */

    'default_page' => env('DOCUMENTATION_DEFAULT_PAGE', 'index'),

    /*
    |--------------------------------------------------------------------------
    | Default version.
    |--------------------------------------------------------------------------
    |
    | Here you may specify which version of the documentation should be
    | displayed by default. If not specified it will default to the
    | latest version.
    */

    'default_version' => env('DOCUMENTATION_DEFAULT_VERSION', null),

    /*
    |--------------------------------------------------------------------------
    | Documentation versions.
    |--------------------------------------------------------------------------
    |
    | Here you can specify all versions of the documentation.
    | Documentation files should be placed in /storage/docs/{version}.
    */

    'versions' => [
        '2.1',
    ]

];
