<?php

namespace Database\Seeders;

use App\Models\SystemRequirementsRec;
use Illuminate\Database\Seeder;

class SystemRequirementsRecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemRequirementsRec::factory(5)->create();
    }
}
