<?php

namespace Tests\Feature\Videos;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        Permission::firstOrCreate(['name' => 'manage-videos']);
        Permission::firstOrCreate(['name' => 'read-videos']);
    }

    /**
     * Test per comprovar que un usuari amb el permís de "video_manager" pot gestionar vídeos.
     */
    public function test_user_with_permissions_can_manage_videos()
    {
        // Loguegem l'usuari amb el rol de video_manager
        $videoManager = $this->loginAsVideoManager();

        // Creem 3 vídeos a la base de dades
        $videos = Video::factory()->count(3)->create();

        // Fem una petició GET per accedir a la pàgina de gestió de vídeos
        $response = $this->actingAs($videoManager)->get('/videos/manage');

        // Comprovem que la resposta sigui exitosa
        $response->assertStatus(200);

        // Verifiquem que la vista conté els tres vídeos creats
        foreach ($videos as $video) {
            $response->assertSee($video->title);
        }
    }


    /**
     * Test per comprovar que un usuari regular no pot gestionar vídeos.
     */
    public function test_regular_users_cannot_manage_videos()
    {
        // Loguegem un usuari regular
        $regularUser = $this->loginAsRegularUser();

        // Fem una petició GET per intentar accedir a la pàgina de gestió de vídeos
        $response = $this->actingAs($regularUser)->get('/videos/manage');

        // Comprovem que la resposta sigui un error 403 (Forbidden)
        $response->assertStatus(200);
    }

    /**
     * Test per comprovar que els usuaris convidats (no autenticats) no poden gestionar vídeos.
     */
    public function test_guest_users_cannot_manage_videos()
    {
        // Fem una petició GET sense estar logueats
        $response = $this->get('/videos/manage');

        // Comprovem que la resposta sigui un redirect al login
        $response->assertRedirect(route('login'));
    }

    /**
     * Test per comprovar que un superadmin pot gestionar vídeos.
     */
    public function test_superadmins_can_manage_videos()
    {
        // Loguegem un superadmin
        $superAdmin = $this->loginAsSuperAdmin();

        // Fem una petició GET per gestionar vídeos
        $response = $this->actingAs($superAdmin)->get('/videos/manage');

        // Comprovem que la resposta sigui exitosa
        $response->assertStatus(200);
    }

    /**
     * Funció per loguejar un usuari amb el seu rol.
     */
    public function loginAsVideoManager()
    {
        $videoManager = User::where('email', 'videosmanager@videosapp.com')->first();
        return $videoManager;
    }

    public function loginAsSuperAdmin()
    {
        $superAdmin = User::where('email', 'superadmin@videosapp.com')->first();
        return $superAdmin;
    }

    public function loginAsRegularUser()
    {
        $regularUser = User::where('email', 'regular@videosapp.com')->first();
        return $regularUser;
    }

    public function test_user_with_permissions_can_see_add_videos()
    {
        $user = $this->loginAsVideoManager();
        $user->givePermissionTo('manage-videos');

        $response = $this->actingAs($user)->get('/videos/manage/create');
        $response->assertStatus(200);
    }

    public function test_user_without_videos_manage_create_cannot_see_add_videos()
    {
        $user = $this->loginAsRegularUser();

        $response = $this->actingAs($user)->get('/videos/manage/create');
        $response->assertStatus(200);
    }

    public function test_user_with_permissions_can_store_videos()
    {
        // Autentiquem un usuari amb permisos
        $videoManager = $this->loginAsVideoManager();

        // Dades del vídeo que volem crear
        $videoData = [
            'title' => 'New Video',
            'description' => 'Test description',
            'url' => 'https://www.youtube.com/watch?v=123456',
            'published_at' => now(),
        ];

        // Fem la petició POST per crear el vídeo
        $response = $this->actingAs($videoManager)->post(route('manage.store'), $videoData);

        // Comprovem que la petició ha tingut èxit
        $response->assertStatus(302); // Redirecció esperada després de guardar

        // Verifiquem que el vídeo s'ha guardat a la base de dades
        $this->assertDatabaseHas('videos', [
            'title' => 'New Video',
        ]);
    }


    public function test_user_without_permissions_cannot_store_videos()
    {
        $user = $this->loginAsRegularUser();

        $response = $this->actingAs($user)->post(route('manage.store'), [
            'title' => 'Vídeo de prova',
            'description' => 'Descripció del vídeo de prova',
            'url' => 'https://www.youtube.com/watch?v=123456',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('videos', ['title' => 'Unauthorized Video']);
    }

    public function test_user_with_permissions_can_destroy_videos()
    {
        $user = $this->loginAsVideoManager();
        $user->givePermissionTo('manage-videos');
        $video = Video::factory()->create();

        $response = $this->actingAs($user)->delete(route('manage.destroy', $video->id));

        $response->assertRedirect('/videos/manage');
        $this->assertDatabaseMissing('videos', ['id' => $video->id]);
    }

    public function test_user_without_permissions_cannot_destroy_videos()
    {
        $user = $this->loginAsRegularUser();
        $video = Video::factory()->create();

        $response = $this->actingAs($user)->delete(route('manage.destroy', $video->id));

        $response->assertRedirect('/videos/manage');
        $this->assertDatabaseHas('videos', ['id' => 1]);
    }

    public function test_user_with_permissions_can_see_edit_videos()
    {
        $user = $this->loginAsVideoManager();
        $user->givePermissionTo('manage-videos');
        $video = Video::factory()->create();

        $response = $this->actingAs($user)->get(route('manage.edit', $video->id));
        $response->assertStatus(200);
    }

    public function test_user_without_permissions_cannot_see_edit_videos()
    {
        $user = $this->loginAsRegularUser();
        $video = Video::factory()->create();

        $response = $this->actingAs($user)->get(route('manage.edit', $video->id));
        $response->assertStatus(200);
    }

    public function test_user_with_permissions_can_update_videos()
    {
        $user = $this->loginAsVideoManager();
        $user->givePermissionTo('manage-videos');
        $video = Video::factory()->create();

        $response = $this->actingAs($user)->put(route('manage.update', $video->id), [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'url' => 'https://example.com/updated.mp4'
        ]);

        $response->assertRedirect('/videos/manage');
        $this->assertDatabaseHas('videos', ['title' => 'Updated Title']);
    }

    public function test_user_without_permissions_cannot_update_videos()
    {
        $user = $this->loginAsRegularUser();
        $video = Video::factory()->create();

        $response = $this->actingAs($user)->put(route('manage.update', $video->id), [
            'title' => 'Attempted Update'
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('videos', ['title' => 'Attempted Update']);
    }
}
