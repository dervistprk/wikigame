<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Developer;
use App\Models\GameDetail;
use App\Models\Game;
use App\Models\GameImage;
use App\Models\GameVideo;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Publisher;
use App\Models\Setting;
use App\Models\SystemRequirementsMin;
use App\Models\SystemRequirementsRec;
use App\Models\User;
use App\Models\UserVerify;
use App\Models\WhiteList;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(5)->create();
        Developer::factory(5)->create();
        Publisher::factory(5)->create();
        GameDetail::factory(5)->create();
        Platform::factory(5)->create();
        Genre::factory(5)->create();
        SystemRequirementsMin::factory(5)->create();
        SystemRequirementsRec::factory(5)->create();
        Setting::factory(1)->create();
        Article::factory(5)->create();
        WhiteList::factory(1)->create();
        User::factory(1)->create();
        UserVerify::factory(1)->create();
        GameImage::factory(10)->create();
        GameVideo::factory(10)->create();
        Comment::factory(7)->create();
        Game::factory(10)->hasImages()->hasGenres()->hasPlatforms()->hasVideos()->hasComments(3)->create();
    }
}
