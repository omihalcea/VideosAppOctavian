<?php
return [
    'user' => [
        'id' => env('DEFAULT_USER_ID', 1),
        'name' => env('DEFAULT_USER', 'default_user'),
        'email' => env('DEFAULT_MAIL', 'default@default.com'),
        'password' => env('DEFAULT_PASSWORD', 'password'),
        'current_team_id' => env('DEFAULT_CURRENT_TEAM_ID', 1),
    ],

    'professor' => [
        'id' => env('DEFAULT_PROFESSOR_ID', 2),
        'name' => env('DEFAULT_PROFESSOR', 'default_professor'),
        'email' => env('DEFAULT_PROFESSOR_MAIL', 'professor@default.com'),
        'password' => env('DEFAULT_PROFESSOR_PASSWORD', 'password'),
        'current_team_id' => env('DEFAULT_CURRENT_PROFESSOR_TEAM_ID', 1),
    ],
];
