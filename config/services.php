<?php
use NZS\Core\ApplicationUser;

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => ApplicationUser::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'trello' => [
        'key' => 'd7a6d96eb1c149b7a4ea17056cb3f69a',
        'token' => 'ea853a20340f8050017246c6323cb333b59f1a54130833f7cc803b15c0523495',
        'releases' => [
            'P65XhLWT' => [
                'from' => ['JEFdzApw'],
            ],
        ],
    ],

    'zapier' => [
        'token' => 'e70I0wltavDqTJJSEFxW82z5aojtxrpU',
    ],
];
