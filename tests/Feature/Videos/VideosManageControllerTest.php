<?php

namespace Tests\Feature\Videos;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * Test per comprovar que un usuari amb el permís de "video_manager" pot gestionar vídeos.
     */
    public function test_user_with_permissions_can_manage_videos()
    {
        // Loguegem l'usuari amb el rol de video_manager
        $videoManager = $this->loginAsVideoManager();

        // Fem una petició GET per accedir a la pàgina de gestió de vídeos
        $response = $this->actingAs($videoManager)->get('/videos/manage');

        // Comprovem que la resposta sigui exitosa
        $response->assertStatus(200);
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
        $response->assertStatus(403);
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
}
