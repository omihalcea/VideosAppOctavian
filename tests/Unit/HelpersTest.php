<?php

namespace Tests\Feature;

use App\Helpers\UserHelpers;
use App\Models\User;
use App\Models\Video;
use App\Helpers\VideoHelpers;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    use RefreshDatabase; // Neteja la base de dades després de cada test.

    /**
     * Test per comprovar que els vídeos per defecte es creen correctament.
     */
    public function test_default_videos_are_seeded()
    {
        $user = User::factory()->create();

        // Executar el helper per crear els vídeos per defecte.
        VideoHelpers::createVideos();

        // Comprovar que exactament 3 vídeos han estat creats.
        $this->assertCount(3, Video::all());

        // Comprovar que cada vídeo té les propietats esperades.
        $this->assertDatabaseHas('videos', [
            'title' => 'Kled VS Renekton',
            'description' => 'La emocionante aventura de Kled vs renekton en la TopLine.',
            'url' => 'https://www.youtube.com/embed/8qk5M6HtFs0?si=gGn0PWx7tJEmMsEU',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('videos', [
            'title' => 'Messi Is Back 🔥 Inter Miami vs América 2-2 ( 3-2 )',
            'description' => 'Messi Is Back 🔥 Inter Miami vs América 2-2 ( 3-2 ) Full penalties All Goals & Highlights 2025',
            'url' => 'https://www.youtube.com/embed/pYb4bAj9w4U?si=qb6PJ3gWcO6otbDR',
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('videos', [
            'title' => '200도로 눌러버린 진짜 미국식 치즈버거?',
            'description' => '😋 200도로 눌러버린 진짜 미국식 치즈버거? 고기맛 하나로 미군기지 외국인 손님들까지 챌린지 하고간다는 버거집!',
            'url' => 'https://www.youtube.com/embed/pSK40Kwb56Y?si=sEK48NA-JXdIaobj',
            'user_id' => $user->id,
        ]);
    }
}
