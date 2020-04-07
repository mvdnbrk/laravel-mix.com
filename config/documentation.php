<?php

return [

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

    'default_version' => env('DOCUMENTATION_DEFAULT_VERSION', null),

    'default_page' => env('DOCUMENTATION_DEFAULT_PAGE', 'installation'),

    'index_page' => env('DOCUMENTATION_INDEX', 'index'),

    'storage' => [
        'disk' => 'docs',
    ],

    'excluded_pages' => [
        'readme',
    ],

];
