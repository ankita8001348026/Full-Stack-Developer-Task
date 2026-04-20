<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'myfatoora' => [
        'local' => [
            'api_url' => env('MYFATOORA_LOCAL_API_URL'),
            'api_key' => env('MYFATOORA_LOCAL_API_KEY'),
            'success_url' => env('MYFATOORA_LOCAL_SUCCESS_URL'),
            'error_url' => env('MYFATOORA_LOCAL_ERROR_URL'),
        ],
        'staging' => [
            'api_url' => env('MYFATOORA_STAGING_API_URL'),
            'api_key' => env('MYFATOORA_STAGING_API_KEY'),
            'success_url' => env('MYFATOORA_STAGING_SUCCESS_URL'),
            'error_url' => env('MYFATOORA_STAGING_ERROR_URL'),
        ],
        'production' => [
            'api_url' => env('MYFATOORA_PRODUCTION_API_URL'),
            'api_key' => env('MYFATOORA_PRODUCTION_API_KEY'),
            'success_url' => env('MYFATOORA_PRODUCTION_SUCCESS_URL'),
            'error_url' => env('MYFATOORA_PRODUCTION_ERROR_URL'),
        ]
    ]

];
