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
    'braintree' => [
        'environment' => env('BT_ENVIRONMENT', 'sandbox'),
        'merchant_id' => env('BT_MERCHANT_ID'),
        'public_key' => env('BT_PUBLIC_KEY'),
        'private_key' => env('BT_PRIVATE_KEY'),
        'with_paypal' => env('BT_WITH_PAYPAL', false),
    ],

    'stripe' => [
        'public_key' => env('STRIPE_PK'),
        'secret_key' => env('STRIPE_SK'),
        'currency' => env('STRIPE_CURRENCY', 'usd'),
    ],

    'square' => [
        'application_id' => env('SQUARE_APPLICATION_ID'),
        'location_id' => env('SQUARE_LOCATION_ID'),
        'access_token' => env('SQUARE_TOKEN'),
        'currency' => env('SQUARE_CURRENCY', 'USD'),
        'sandbox' => env('SQUARE_SANDBOX', true),
    ],

    'nexmo' => [
        'sms_from' => env('NEXMO_FROM', '15556666666'),
    ],

];
