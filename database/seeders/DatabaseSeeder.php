<?php

namespace Database\Seeders;

use App\Helpers\UserHelpers;
use App\Helpers\VideoHelpers;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserHelpers::createUsers();
        VideoHelpers::createVideos();
    }
}
