<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
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
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'paypal' => [
        'sandbox_client_id' => 'ARuYHn9_M55g1VNQaw_FKQZgV-nrcWY6OE8Nf0Sxm6J39VLfgJBv6Qh6jNVBbcHVxyySHY0oWmkFlfW2',
        'sandbox_secret' => 'EFdH50puqEfTDAjuuXfKghWKjHbt0nIj9tTL4lQF7lrUtk4ci57Gbs_fNUUQrnPdl8L0wvSN8NupRp95',
        
        'production_client_id' => 'Af0n72IpHSquHsR-yBwXbzRM4zmps_4rxtQ5X9I_Xa6fTRg3aV483AdEdI63LmLUJnXqrPwUlFPEvG0r',
        'production_secret' => 'EBKDKmNgO0TMoivpw04ecrV-P0_Gy8yK9vNcSKQ3HDKDkMTD9tu9HWWEkjJD3vrdyG7CeZhyqLS9FpQL'
    ],

];
