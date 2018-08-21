<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Latest release.
    |--------------------------------------------------------------------------
    |
    | Here you may specify the latest release version of your package.
    | If no value is specified we will fall back to the default version.
    */

    'latest_release' => env('DOCUMENTATION_LATEST_RELEASE', null),

    /*
    |--------------------------------------------------------------------------
    | Documentation versions.
    |--------------------------------------------------------------------------
    |
    | Here you may specify all versions of the documentation.
    | Documentation files should be placed in /storage/docs/{version}.
    */

    'versions' => [
        '2.1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default page.
    |--------------------------------------------------------------------------
    |
    | Here you may specify which page should be displayed as a default.
    */

    'default_page' => env('DOCUMENTATION_DEFAULT_PAGE', 'installation'),

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
    | Excluded pages.
    |--------------------------------------------------------------------------
    |
    | Here you may specify which pages are excluded from the documentation.
    / The readme page is excluded by default.
    */

    'excluded_pages' => [
        'readme',
    ],

];
