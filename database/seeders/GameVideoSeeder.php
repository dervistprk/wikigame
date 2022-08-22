<?php

namespace Database\Seeders;

use App\Models\GameVideo;
use Illuminate\Database\Seeder;

class GameVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GameVideo::factory(10)->create();
    }
}
