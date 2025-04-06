<?php
namespace Tests\Feature;

use App\Helpers\UserHelpers;
use App\Models\User;
use App\Models\Series;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SeriesManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        UserHelpers::create_permissions();
    }

    private function loginAsSuperAdmin()
    {
        $user = UserHelpers::create_superadmin_user();
        $this->actingAs($user);
        return $user;
    }

    private function loginAsVideoManager()
    {
        $user = UserHelpers::create_video_manager_user();
        $this->actingAs($user);
        return $user;
    }

    private function loginAsRegularUser()
    {
        $user = UserHelpers::create_regular_user();
        $this->actingAs($user);
        return $user;
    }

    // Test per comprovar que els usuaris amb permisos poden veure la pàgina de creació de sèries
    public function test_user_with_permissions_can_see_add_series()
    {
        $this->loginAsSuperAdmin();
        $response = $this->get(route('series.manage.create'));
        $response->assertStatus(200);
    }

    // Test per comprovar que els usuaris sense permisos no poden veure la pàgina de creació de sèries
    public function test_user_without_series_manage_create_cannot_see_add_series()
    {
        $this->loginAsRegularUser();
        $response = $this->get(route('series.manage.create'));
        $response->assertStatus(403);
    }

    // Test per comprovar que un usuari amb permisos pot desar una sèrie
    public function test_user_with_permissions_can_store_series()
    {
        $this->loginAsSuperAdmin();

        $response = $this->post(route('series.manage.store'), [
            'title' => 'Nova Sèrie',
            'description' => 'Descripció de la sèrie',
            'published_at' => now(),
            'image' => null,
        ]);
        $response->assertRedirect(route('series.manage.index'));
        $this->assertDatabaseHas('series', ['title' => 'Nova Sèrie']);
    }

    // Test per comprovar que un usuari sense permisos no pot desar una sèrie
    public function test_user_without_permissions_cannot_store_series()
    {
        $this->loginAsRegularUser();

        $response = $this->post(route('series.manage.store'), [
            'title' => 'Nova Sèrie',
            'description' => 'Descripció de la sèrie',
            'published_at' => now(),
            'image' => null,
        ]);
        $response->assertStatus(403);
    }

    // Test per comprovar que un usuari amb permisos pot eliminar una sèrie
    public function test_user_with_permissions_can_destroy_series()
    {
        $this->loginAsSuperAdmin();

        $user = User::factory()->create();

        $serie = Series::create([
            'title' => 'Sèrie per eliminar',
            'description' => 'Descripció per eliminar',
            'user_name' => $user->name,
            'published_at' => now(),
        ]);

        $response = $this->delete(route('series.manage.destroy', $serie));
        $response->assertRedirect(route('series.manage.index'));
        $this->assertDatabaseMissing('series', ['title' => 'Sèrie per eliminar']);
    }

    // Test per comprovar que un usuari sense permisos no pot eliminar una sèrie
    public function test_user_without_permissions_cannot_destroy_series()
    {
        $this->loginAsRegularUser();

        $user = User::factory()->create();

        $serie = Series::create([
            'title' => 'Sèrie per eliminar',
            'description' => 'Descripció per eliminar',
            'user_name' => $user->name,
            'published_at' => now(),
        ]);

        $response = $this->delete(route('series.manage.destroy', $serie));
        $response->assertStatus(403);
    }

    // Test per comprovar que un usuari amb permisos pot veure la pàgina d'edició d'una sèrie
    public function test_user_with_permissions_can_see_edit_series()
    {
        $this->loginAsSuperAdmin();

        $user = User::factory()->create();

        $serie = Series::create([
            'title' => 'Sèrie per eliminar',
            'description' => 'Descripció per editar',
            'user_name' => $user->name,
            'published_at' => now(),
        ]);

        $response = $this->get(route('series.manage.edit', $serie));
        $response->assertStatus(200);
    }

    // Test per comprovar que un usuari sense permisos no pot veure la pàgina d'edició d'una sèrie
    public function test_user_without_permissions_cannot_see_edit_series()
    {
        $this->loginAsRegularUser();

        $user = User::factory()->create();

        $serie = Series::create([
            'title' => 'Sèrie per eliminar',
            'description' => 'Descripció per editar',
            'user_name' => $user->name,
            'published_at' => now(),
        ]);

        $response = $this->get(route('series.manage.edit', $serie));
        $response->assertStatus(403);
    }

    // Test per comprovar que un usuari amb permisos pot actualitzar una sèrie
    public function test_user_with_permissions_can_update_series()
    {
        $this->loginAsSuperAdmin();

        $user = User::factory()->create();

        $serie = Series::create([
            'title' => 'Sèrie per eliminar',
            'description' => 'Descripció per eliminar',
            'user_name' => $user->name,
            'published_at' => now(),
        ]);

        $response = $this->put(route('series.manage.update', $serie), [
            'title' => 'Sèrie actualitzada',
            'description' => 'Descripció actualitzada',
            'published_at' => now(),
        ]);

        $response->assertRedirect(route('series.manage.index'));
        $this->assertDatabaseHas('series', ['title' => 'Sèrie actualitzada']);
    }

    // Test per comprovar que un usuari sense permisos no pot actualitzar una sèrie
    public function test_user_without_permissions_cannot_update_series()
    {
        $this->loginAsRegularUser();

        $user = User::factory()->create();

        $serie = Series::create([
            'title' => 'Sèrie per eliminar',
            'description' => 'Descripció per eliminar',
            'user_name' => $user->name,
            'published_at' => now(),
        ]);

        $response = $this->put(route('series.manage.update', $serie), [
            'title' => 'Sèrie actualitzada',
            'description' => 'Descripció actualitzada',
            'published_at' => now(),
        ]);

        $response->assertStatus(403);
    }

    // Test per comprovar que un usuari amb permisos pot gestionar sèries
    public function test_user_with_permissions_can_manage_series()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(200);
    }

    // Test per comprovar que un usuari regular no pot gestionar sèries
    public function test_regular_users_cannot_manage_series()
    {
        $this->loginAsRegularUser();

        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(403);
    }

    // Test per comprovar que un usuari convidat no pot gestionar sèries
    public function test_guest_users_cannot_manage_series()
    {
        $response = $this->get(route('series.manage.index'));
        $response->assertRedirect(route('login'));
    }

    // Test per comprovar que un VideoManager pot gestionar sèries
    public function test_videomanagers_can_manage_series()
    {
        $this->loginAsVideoManager();

        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(200);
    }

    // Test per comprovar que un SuperAdmin pot gestionar sèries
    public function test_superadmins_can_manage_series()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get(route('series.manage.index'));
        $response->assertStatus(200);
    }
}
