<?php

namespace Database\Seeders;

use App\Models\GameDetail;
use Illuminate\Database\Seeder;

class GameDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GameDetail::factory(5)->create();
    }
}
