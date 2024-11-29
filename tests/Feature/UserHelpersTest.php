<?php

namespace Tests\Feature;

use App\Helpers\UserHelpers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserHelpersTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_default_users_and_teams()
    {
        $UserData = config('users.user');
        $ProfData = config('users.professor');
        $TeamUserData = config('team.user_team');
        $TeamProfData = config('team.professor_team');

        $results = UserHelpers::createUsers();

        // Comprova l'usuari per defecte
        $this->assertDatabaseHas('users', [
            'id' => $UserData['id'],
            'name' => $UserData['name'],
            'email' => $UserData['email'],
        ]);

        $this->assertTrue(Hash::check(config('users.user.password'), $results['user']->password));

        // Comprova el professor per defecte
        $this->assertDatabaseHas('users', [
            'id' => $ProfData['id'],
            'name' => $ProfData['name'],
            'email' => $ProfData['email'],
        ]);

        $this->assertTrue(Hash::check(config('users.professor.password'), $results['professor']->password));

        // Comprova l'equip de l'usuari per defecte
        $this->assertDatabaseHas('teams', [
            'id' => $TeamUserData['id'],
            'user_id' => $TeamUserData['user_id'],
        ]);

        // Comprova l'equip del professor per defecte
        $this->assertDatabaseHas('teams', [
            'id' => $TeamProfData['id'],
            'user_id' => $TeamProfData['user_id'],
        ]);
    }
}
