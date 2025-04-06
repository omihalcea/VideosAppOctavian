<?php
namespace Tests\Unit;

use App\Models\Series;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SerieTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prova que una sèrie té vídeos associats correctament.
     *
     * @return void
     */
    public function test_serie_have_videos()
    {

        $user = User::factory()->create(); // Usar el factory per crear un usuari de prova

        // Crear una sèrie
        $serie = Series::create([
            'title' => 'League of Legends Highlights',
            'description' => 'Les millors jugades i moments destacats de League of Legends.',
            'image' => 'storage/app/public/alpha.png',
            'user_name' => $user->name,
            'user_photo_url' => $user->profile_photo_url ?? null,
            'published_at' => Carbon::now(),
        ]);

        // Crear vídeos associats a la sèrie
        $video1 = Video::create([
            'title' => 'Kled VS Renekton',
            'description' => 'La emocionante aventura de Kled vs renekton en la TopLine.',
            'url' => 'https://www.youtube.com/embed/8qk5M6HtFs0?si=gGn0PWx7tJEmMsEU',
            'published_at' => Carbon::now(),
            'previous' => null,
            'next' => 2,
            'series_id' => $serie->id,
            'user_id' => 1,
        ]);

        $video2 = Video::create([
            'title' => 'Messi Is Back 🔥 Inter Miami vs América 2-2 ( 3-2 )',
            'description' => 'Messi Is Back 🔥 Inter Miami vs América 2-2 ( 3-2 ) Full penalties All Goals & Highlights 2025',
            'url' => 'https://www.youtube.com/embed/pYb4bAj9w4U?si=qb6PJ3gWcO6otbDR',
            'published_at' => Carbon::now(),
            'previous' => 1,
            'next' => 3,
            'series_id' => $serie->id,
            'user_id' => 1,
        ]);

        $video3 = Video::create([
            'title' => '200도로 눌러버린 진짜 미국식 치즈버거?',
            'description' => '😋 200도로 눌러버린 진짜 미국식 치즈버거? 고기맛 하나로 미군기지 외국인 손님들까지 챌린지 하고간다는 버거집!',
            'url' => 'https://www.youtube.com/embed/pSK40Kwb56Y?si=sEK48NA-JXdIaobj',
            'published_at' => Carbon::now(),
            'previous' => 2,
            'next' => null,
            'series_id' => $serie->id,
            'user_id' => 1,
        ]);

        // Comprovar que la sèrie té vídeos associats
        $this->assertCount(3, $serie->videos); // Comprovar que la sèrie té 3 vídeos associats

        // Comprovar que els vídeos tenen la sèrie associada
        $this->assertTrue($video1->series->is($serie));
        $this->assertTrue($video2->series->is($serie));
        $this->assertTrue($video3->series->is($serie));
    }
}
