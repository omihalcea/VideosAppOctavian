<?php

return [

    'paths' => ['*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:8100'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type, Accept, Authorization, X-Requested-With, X-CSRF-TOKEN'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
