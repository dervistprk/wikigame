<?php

namespace Database\Seeders;

use App\Models\WhiteList;
use Illuminate\Database\Seeder;

class WhiteListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WhiteList::factory()->count(1)->create();
    }
}
