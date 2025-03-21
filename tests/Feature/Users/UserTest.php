<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_without_permissions_can_see_default_users_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('users.index'));

        $response->assertStatus(200);
    }

    public function test_user_with_permissions_can_see_default_users_page()
    {
        Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('super-admin');

        // Fes login amb aquest usuari
        $response = $this->actingAs($user)->get(route('users.index'));

        // Comprova que la pàgina es mostra correctament
        $response->assertStatus(200);
    }

    public function test_not_logged_users_cannot_see_default_users_page()
    {
        $response = $this->get(route('users.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_without_permissions_can_see_user_show_page()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $response = $this->actingAs($user)->get(route('users.show', $otherUser->id));

        $response->assertStatus(200);
    }

    public function test_user_with_permissions_can_see_user_show_page()
    {
        Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);

        $user = User::factory()->create();
        $user->assignRole('super-admin');;

        $response = $this->actingAs($user)->get(route('users.show', $user->id));

        $response->assertStatus(200);
    }

    public function test_not_logged_users_cannot_see_user_show_page()
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.show', $user->id));

        $response->assertRedirect(route('login'));
    }
}
