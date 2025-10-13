<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you configure the settings for cross-origin resource sharing.
    |
    */

    // The paths that should have CORS headers applied (usually all API routes).
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // CRITICAL: Domains from which to allow CORS requests. 
    // Set to ['*'] to allow requests from any domain during development.
    'allowed_origins' => ['*'], 

    // The HTTP methods (GET, POST, PUT, DELETE, etc) allowed. 
    'allowed_methods' => ['*'], 

    // The HTTP headers allowed in the request. 
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Set to true if you need to pass cookies or authentication headers (like Sanctum).
    'supports_credentials' => false,

];
