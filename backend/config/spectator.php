<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Spec Source
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default spec source that should be used
    | by the framework.
    |
    */

    'default' => env('SPEC_SOURCE', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Sources
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many sources as you wish, and you
    | may even configure multiple source of the same type. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'sources' => [
        'local' => [
            'source' => 'local',
            'base_path' => env('SPEC_PATH', './storage/api-docs'),
        ],

        'remote' => [
            'source' => 'remote',
            'base_path' => env('SPEC_PATH'),
            'params' => env('SPEC_URL_PARAMS', ''),
        ],

        'github' => [
            'source' => 'github',
            'base_path' => env('SPEC_GITHUB_PATH'),
            'repo' => env('SPEC_GITHUB_REPO'),
            'token' => env('SPEC_GITHUB_TOKEN'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | Configure path defaults, like prefixes.
    |
    */

    'path_prefix' => '/api/v1',

    /*
    |--------------------------------------------------------------------------
    | Middleware Groups
    |--------------------------------------------------------------------------
    |
    | Specify the groups that spectator's middleware should be prepended to.
    |
    */

    'middleware_groups' => ['api'],
];
