<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Theme Configuration
    |--------------------------------------------------------------------------
    |
    | ملف واحد لتغيير كل ألوان وشكل الداش بورد.
    | غيّر القيم هنا وهتتطبق في كل مكان تلقائيًا.
    |
    */

    'theme' => [
        'mode' => env('STACKWAY_THEME_MODE', 'system'), // 'light', 'dark', 'system'

        'colors' => [
            'primary'   => '#6D28D9',
            'secondary' => '#0891B2',
            'accent'    => '#D97706',
            'success'   => '#059669',
            'danger'    => '#DC2626',
            'warning'   => '#D97706',
            'info'      => '#0284C7',
        ],

        'sidebar' => [
            'style'    => 'collapsible', // 'fixed', 'collapsible'
            'position' => 'left',
            'width'    => '260px',
            'collapsed_width' => '72px',
        ],

        'fonts' => [
            'heading' => 'Inter',
            'body'    => 'Inter',
            'arabic'  => 'IBM Plex Sans Arabic',
            'mono'    => 'JetBrains Mono',
        ],

        'border_radius' => '12px',
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard Route Configuration
    |--------------------------------------------------------------------------
    */

    'dashboard' => [
        'prefix'     => 'admin', // Access via /admin or /dashboard
        'middleware' => ['web', 'auth'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Configuration
    |--------------------------------------------------------------------------
    */

    'module' => [
        'base_path' => 'app/Modules',
        'namespace' => 'App\\Modules',
    ],

    /*
    |--------------------------------------------------------------------------
    | Performance Configuration
    |--------------------------------------------------------------------------
    */

    'performance' => [
        'cache_ttl'       => 3600,    // seconds
        'pagination'      => 15,
        'max_upload_size'  => 5120,   // KB
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Configuration
    |--------------------------------------------------------------------------
    */

    'auth' => [
        'dashboard_guard' => 'web',
        'api_guard'       => 'sanctum',
    ],

    /*
    |--------------------------------------------------------------------------
    | Localization Configuration
    |--------------------------------------------------------------------------
    */

    'localization' => [
        'supported_locales' => ['ar', 'en'],
        'default_locale'    => 'ar',
        'fallback_locale'   => 'en',
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Authentication
    |--------------------------------------------------------------------------
    */

    'social_auth' => [
        'enabled_providers' => ['google', 'facebook'],
        'auto_register'     => true,
        'redirect_after'    => '/dashboard',
    ],

    /*
    |--------------------------------------------------------------------------
    | Audit Log
    |--------------------------------------------------------------------------
    */

    'audit' => [
        'enabled'    => true,
        'log_name'   => 'stackway',
        'tenant_aware' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Media Configuration
    |--------------------------------------------------------------------------
    */

    'media' => [
        'disk'           => 'public',
        'max_file_size'  => 10240, // KB
        'allowed_types'  => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'pdf'],
        'image_sizes'    => [
            'thumb'  => [150, 150],
            'medium' => [600, 600],
            'large'  => [1200, 1200],
        ],
    ],
];
