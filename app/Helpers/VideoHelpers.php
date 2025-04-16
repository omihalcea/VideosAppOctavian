<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Video;
use App\Models\Series;
use Carbon\Carbon;

class VideoHelpers
{
    /**
     * Crear sèries per defecte a la base de dades.
     */
    public static function create_series()
    {
        $user = User::first();

        // Crear 3 sèries per defecte
        Series::create([
            'title' => 'League of Legends Highlights',
            'description' => 'Les millors jugades i moments destacats de League of Legends.',
            'image' => 'storage/app/public/alpha.png',
            'user_name' => $user->name,
            'user_photo_url' => $user->profile_photo_url ?? null,
            'published_at' => Carbon::now(),
        ]);

        Series::create([
            'title' => 'Messi Goals Collection',
            'description' => 'Recopilació dels millors gols de Messi al llarg de la seva carrera.',
            'image' => 'messi_goals.jpg',
            'user_name' => $user->name,
            'user_photo_url' => $user->profile_photo_url ?? null,
            'published_at' => Carbon::now(),
        ]);

        Series::create([
            'title' => 'Street Food Around the World',
            'description' => 'Explorant els millors llocs de menjar de carrer arreu del món.',
            'image' => 'street_food.jpg',
            'user_name' => $user->name,
            'user_photo_url' => $user->profile_photo_url ?? null,
            'published_at' => Carbon::now(),
        ]);
    }

    /**
     * Crear vídeos per defecte a la base de dades.
     */
    public static function createVideos()
    {
        $user = User::first();

        self::create_series();

        // Crear 3 vídeos per defecte
        Video::create([
            'title' => 'Kled VS Renekton',
            'description' => 'La emocionante aventura de Kled vs renekton en la TopLine.',
            'url' => 'https://www.youtube.com/embed/8qk5M6HtFs0?si=gGn0PWx7tJEmMsEU',
            'published_at' => Carbon::now(),
            'previous' => null,
            'next' => 2,
            'series_id' => 1,
            'user_id' => $user->id,
        ]);

        Video::create([
            'title' => 'Messi Is Back 🔥 Inter Miami vs América 2-2 ( 3-2 )',
            'description' => 'Messi Is Back 🔥 Inter Miami vs América 2-2 ( 3-2 ) Full penalties All Goals & Highlights 2025',
            'url' => 'https://www.youtube.com/embed/pYb4bAj9w4U?si=qb6PJ3gWcO6otbDR',
            'published_at' => Carbon::now(),
            'previous' => 1,
            'next' => 3,
            'series_id' => null,
            'user_id' => $user->id,
        ]);

        Video::create([
            'title' => '200도로 눌러버린 진짜 미국식 치즈버거?',
            'description' => '😋 200도로 눌러버린 진짜 미국식 치즈버거? 고기맛 하나로 미군기지 외국인 손님들까지 챌린지 하고간다는 버거집!',
            'url' => 'https://www.youtube.com/embed/pSK40Kwb56Y?si=sEK48NA-JXdIaobj',
            'published_at' => Carbon::now(),
            'previous' => 2,
            'next' => null,
            'series_id' => null,
            'user_id' => $user->id,
        ]);
    }
}
