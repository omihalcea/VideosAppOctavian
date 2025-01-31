<?php

namespace Tests\Unit;

use App\Models\Video;
use Carbon\Carbon;
use Tests\TestCase;

class VideosTest extends TestCase
{
    /**
     * Comprova que es pot obtenir la data de publicació formatada correctament.
     *
     * @return void
     */
    public function test_can_get_formatted_published_at_date()
    {
        // Configurar una data de publicació fictícia
        $publishedAt = Carbon::create(2025, 1, 13, 12, 0, 0);

        // Crear una instància de Video
        $video = new Video([
            'title' => 'Vídeo per al test',
            'description' => 'Aquest video es un test',
            'published_at' => $publishedAt,
        ]);

        // Comprovar que el format és correcte
        $this->assertEquals(
            '13 de gener de 2025',
            $video->formatted_published_at
        );
    }

    /**
     * Comprova que el format per a una data de publicació nul·la retorna un valor esperat.
     *
     * @return void
     */
    public function test_can_get_formatted_published_at_date_when_not_published()
    {
        // Crear una instància de Video sense data de publicació
        $video = new Video([
            'title' => 'Vídeo per al test',
            'description' => 'Aquest video es un test',
            'published_at' => null,
        ]);

        // Comprovar que el format retorna un valor per defecte o buit
        $this->assertNull($video->formatted_published_at);
    }
}
