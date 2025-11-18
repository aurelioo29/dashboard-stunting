<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:*',
        'http://127.0.0.1:*',
        'http://192.168.1.*:*',
        'http://10.0.2.2:*', // Android emulator
    ],

    'allowed_origins_patterns' => [
        '/^http:\/\/localhost:\d+$/',
        '/^http:\/\/127\.0\.0\.1:\d+$/',
        '/^http:\/\/192\.168\.1\.\d+:\d+$/',
        '/^http:\/\/192\.168\.\d+\.\d+:\d+$/',
    ],

    'allowed_headers' => [
        'Accept',
        'Authorization',
        'Content-Type',
        'X-Requested-With',
        'X-CSRF-TOKEN',
    ],

    'exposed_headers' => [
        'Content-Length',
        'Content-Type',
    ],

    'max_age' => 3600,

    'supports_credentials' => false,
];
