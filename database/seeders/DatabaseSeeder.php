<?php

namespace Database\Seeders;

use App\Models\Articles;
use App\Models\Categories;
use App\Models\Developers;
use App\Models\GameDetails;
use App\Models\Games;
use App\Models\Publishers;
use App\Models\Settings;
use App\Models\SystemRequirementsMin;
use App\Models\SystemRequirementsRec;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();
        Categories::factory(5)->create();
        Developers::factory(5)->create();
        Publishers::factory(5)->create();
        GameDetails::factory(5)->create();
        SystemRequirementsMin::factory(5)->create();
        SystemRequirementsRec::factory(5)->create();
        Settings::factory()->count(1)->create();
        Articles::factory()->count(5)->create();
        WhiteList::factory()->count(1)->create();
        User::factory()->count(1)->create();
        Games::factory(10)->create();
    }
}
