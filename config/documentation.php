<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Repository URL
    |--------------------------------------------------------------------------
    |
    | Here you may specify the Git repository url of your documentation.
    */

    'repository' => [
        'url' => env('DOCUMENTATION_REPOSITORY_URL'),
    ],

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
        'master',
        '5.0',
        '4.1',
        '4.0',
        '3.0',
        '2.1',
        '2.0',
        '1.7',
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
    | Table of contents.
    |--------------------------------------------------------------------------
    |
    |  Here you may specify where your index page lives.
    |  The "table of contents" page  page will be
    |  excluded by default from viewing.
    |
    */

    'table_of_contents' => env('DOCUMENTATION_INDEX', 'index'),

    /*
    |--------------------------------------------------------------------------
    | Excluded pages.
    |--------------------------------------------------------------------------
    |
    | Here you may specify which pages are excluded from the documentation.
    | The readme and "table of contents" page which you specified in the
    | section above will be excluded by default.
    */

    'excluded_pages' => [
        'readme',
    ],

];
