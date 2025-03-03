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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // 'facebook' => [
    //     'client_id' => '539138461964175',  //client face của bạn
    //     'client_secret' => '22863788e9a6c509341985ac639dbe1a',  //client app service face của bạn
    //     'redirect' => 'http://localhost:8080/laravel/webbanhang_tutorial/public/admin/callback' //callback trả về
    // ],

    // 'google' => [
    //     'client_id' => '127442467300-810us8tpc5scs7l26fb93p172lu3uqfr.apps.googleusercontent.com',
    //     'client_secret' => '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',
    //     'redirect' => 'http://localhost:8080/laravel/webbanhang_tutorial/public/google/callback' 
    // ],



];
