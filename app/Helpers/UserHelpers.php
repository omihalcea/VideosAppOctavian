<?php

namespace App\Helpers;

use App\Models\Team;
use App\Models\User;
use Tests\TestCase;

class UserHelpers extends TestCase
{
    public static function createUsers()
    {
        $userData = config('users.user');
        $profData = config('users.professor');
        $teamuserData = config('team.user_team');
        $teamprofData = config('team.professor_team');

        $user = User::create([
            'id' => $userData['id'],
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => $userData['password'],
            'current_team_id' => $userData['current_team_id'],
        ]);

        $professor = User::create([
            'id' => $profData['id'],
            'name' => $profData['name'],
            'email' => $profData['email'],
            'password' => $profData['password'],
            'current_team_id' => $profData['current_team_id'],
        ]);

        $teamuser = Team::create([
            'id' => $teamuserData['id'],
            'user_id' => $teamuserData['user_id'],
            'name' => $teamuserData['name'],
            'personal_team' => $teamuserData['personal_team'],
        ]);

        $teamprof = Team::create([
            'id' => $teamprofData['id'],
            'user_id' => $teamprofData['user_id'],
            'name' => $teamprofData['name'],
            'personal_team' => $teamprofData['personal_team'],
        ]);

        return [
            'user' => $user,
            'professor' => $professor,
            'teamuser' => $teamuser,
            'teamprof' => $teamprof,
        ];
    }
}
