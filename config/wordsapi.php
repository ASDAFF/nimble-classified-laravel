<?php

return [
    /*
        |--------------------------------------------------------------------------
        | API Keys
        |--------------------------------------------------------------------------
        |
        | Set the API key as provided by WordsApi.
        |
        */
    'api_key' => env('WORDSAPI_API_KEY', 'i6tgo0mNO5mshARXNYY3X1iih7sZp1D1w0njsnLTvGJJX5EVhr'),

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    | Various options for the service.
    |
    */
    'options' => [
        'curl_timeout' => 5,
    ],
];
