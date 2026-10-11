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
        'mode' => env('STACKWAY_THEME_MODE', 'light'), // 'light', 'dark', 'system'

        'colors' => [
            'primary'   => '#C85A32', // Terracotta (Dominant)
            'secondary' => '#5C554E', // Warm Ink Charcoal
            'accent'    => '#3A5A40', // Deep Olive (Sharp Accent)
            'sand'      => '#DDB892', // Warm Sand
            'success'   => '#3A5A40', // Deep Olive
            'danger'    => '#C0392B', // Warm Rust Red
            'warning'   => '#D48B28', // Warm Amber
            'info'      => '#4A7C59', // Muted Sage Green
        ],

        'sidebar' => [
            'style'    => 'collapsible', // 'fixed', 'collapsible'
            'position' => 'left',
            'width'    => '240px',
            'collapsed_width' => '68px',
        ],

        'fonts' => [
            'heading' => 'Poppins',
            'body'    => 'Poppins',
            'arabic'  => 'IBM Plex Sans Arabic',
            'mono'    => 'JetBrains Mono',
        ],

        'border_radius' => '8px',
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
