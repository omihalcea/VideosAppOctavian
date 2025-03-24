<?php

namespace Tests\Feature;

use App\Helpers\UserHelpers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        UserHelpers::create_permissions();
    }

    // LOGIN FUNCTIONS
    private function loginAsSuperAdmin()
    {
        $user = UserHelpers::create_superadmin_user();
        $this->actingAs($user);
        return $user;
    }

    private function loginAsRegularUser()
    {
        $user = UserHelpers::create_regular_user();
        $this->actingAs($user);
        return $user;
    }

    private function createRoles()
    {
        $roles = ['super-admin', 'regular-user', 'video_manager'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }

    // TESTS
    public function test_user_with_permissions_can_see_add_users()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('users.create'));
        $response->assertStatus(200);
    }

    public function test_user_without_users_manage_create_cannot_see_add_users()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('users.create'));
        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_store_users()
    {
        $this->createRoles();
        $this->loginAsSuperAdmin();

        $response = $this->post(route('users.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'video_manager',
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_without_permissions_cannot_store_users()
    {
        $this->loginAsRegularUser();

        $response = $this->post(route('users.store'), [
            'name' => 'Unauthorized User',
            'email' => 'unauthorized@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', ['email' => 'unauthorized@example.com']);
    }

    public function test_user_with_permissions_can_destroy_users()
    {
        $this->loginAsSuperAdmin();
        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', $user));

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_user_without_permissions_cannot_destroy_users()
    {
        $this->loginAsRegularUser();
        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', $user));

        $response->assertStatus(403);
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    public function test_user_with_permissions_can_see_edit_users()
    {
        $this->loginAsSuperAdmin();
        $user = User::factory()->create();

        $response = $this->get(route('users.edit', $user));

        $response->assertStatus(200);
    }

    public function test_user_without_permissions_cannot_see_edit_users()
    {
        $this->loginAsRegularUser();
        $user = User::factory()->create();

        $response = $this->get(route('users.edit', $user));

        $response->assertStatus(403);
    }

    public function test_user_with_permissions_can_update_users()
    {
        $this->createRoles();
        $this->loginAsSuperAdmin();
        $user = User::factory()->create();

        $response = $this->put(route('users.update', $user), [
            'name' => 'Updated Name',
            'email' => $user->email,
            'role' => 'regular-user'
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['name' => 'Updated Name']);
    }

    public function test_user_without_permissions_cannot_update_users()
    {
        $this->loginAsRegularUser();
        $user = User::factory()->create();

        $response = $this->put(route('users.update', $user), [
            'name' => 'Should Not Update',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', ['name' => 'Should Not Update']);
    }

    public function test_user_with_permissions_can_manage_users()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
    }

    public function test_regular_users_cannot_manage_users()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('users.manage.index'));
        $response->assertStatus(403);
    }

    public function test_guest_users_cannot_manage_users()
    {
        $response = $this->get(route('users.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_superadmins_can_manage_users()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('users.index'));
        $response->assertStatus(200);
    }


}
