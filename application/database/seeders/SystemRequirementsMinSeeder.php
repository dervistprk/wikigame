<?php

namespace Database\Seeders;

use App\Models\SystemRequirementsMin;
use Illuminate\Database\Seeder;

class SystemRequirementsMinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemRequirementsMin::factory(5)->create();
    }
}
