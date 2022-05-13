<?php

namespace Database\Seeders;

use App\Models\Publishers;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Publishers::factory()->count(5)->create();
    }
}
