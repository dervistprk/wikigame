<?php

namespace Database\Seeders;

use App\Models\Articles;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Articles::factory()->count(5)->create();
    }
}
