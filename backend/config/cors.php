<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')],
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],
    'supports_credentials' => false,
];
