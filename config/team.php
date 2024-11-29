<?php
return [
    'user_team' => [
        'id' => env('DEFAULT_TEAM_USER_ID', 1),
        'user_id' => env('DEFAULT_USER_TEAM_ID', 1),
        'name' => env('DEFAULT_USER_TEAM_NAME', 'default_user'),
        'personal_team' => env('DEFAULT_USER_PERSONAL_TEAM', 1),
        'created_at' => now(),
        'updated_at' => now(),
    ],
    'professor_team' => [
        'id' => env('DEFAULT_TEAM_PROFESSOR_ID', 2),
        'user_id' => env('DEFAULT_PROFESSOR_TEAM_ID', 2),
        'name' => env('DEFAULT_PROFESSOR_TEAM_NAME', 'default_professor'),
        'personal_team' => env('DEFAULT_PROFESSOR_PERSONAL_TEAM', 2),
        'created_at' => now(),
        'updated_at' => now(),
    ]
];
