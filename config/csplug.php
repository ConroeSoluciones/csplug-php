<?php

return [
    'base_uri' => env('CSPLUG_BASE_URI', 'https://csplug.csfacturacion.com'),
    'username' => env('CSPLUG_USERNAME'),
    'password' => env('CSPLUG_PASSWORD'),
    'bearer_token' => env('CSPLUG_BEARER_TOKEN'),
    'contract_id' => env('CSPLUG_CONTRACT_ID'), // X-Rfc
    'auth_mode' => env('CSPLUG_AUTH_MODE', 'basic'),
    'x_servicio' => env('CSPLUG_SERVICE', 'CSP'),
    'timeout' => env('CSPLUG_TIMEOUT', 30),
    'connect_timeout' => env('CSPLUG_CONNECT_TIMEOUT', 10),
    'debug' => env('CSPLUG_DEBUG', false),
];
