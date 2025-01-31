<?php

namespace Tests\Feature\Videos;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideosTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Comprova que els usuaris poden veure vídeos existents.
     *
     * @return void
     */
    public function test_users_can_view_videos()
    {
        // Crear un vídeo a la base de dades
        $video = Video::factory()->create([
            'title' => 'Video de test',
            'description' => 'Video de test (Feature/Videos/VideosTest.php)',
            'url' => 'https://www.youtube.com/embed/8qk5M6HtFs0?si=gGn0PWx7tJEmMsEU',
            'published_at' => Carbon::now(),
        ]);

        // Simular una sol·licitud GET a la ruta del vídeo
        $response = $this->get(route('videos.show', $video->id));

        // Comprovar que la resposta és 200 OK
        $response->assertStatus(200);

        // Comprovar que el contingut de la pàgina inclou el títol i descripció del vídeo
        $response->assertSee($video->title);
        $response->assertSee($video->description);
    }

    /**
     * Comprova que els usuaris no poden veure vídeos inexistents.
     *
     * @return void
     */
    public function test_users_cannot_view_not_existing_videos()
    {
        // Simular una sol·licitud GET a un vídeo amb ID que no existeix
        $response = $this->get(route('videos.show', 9999));

        // Comprovar que la resposta és 404 Not Found
        $response->assertStatus(404);
    }
}
