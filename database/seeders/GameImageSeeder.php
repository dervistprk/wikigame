<?php

namespace Database\Seeders;

use App\Models\GameImage;
use Illuminate\Database\Seeder;

class GameImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GameImage::factory(10)->create();
    }
}
