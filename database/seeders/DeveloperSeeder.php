<?php

namespace Database\Seeders;

use App\Models\Developers;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Developers::factory()->count(5)->create();
    }
}
