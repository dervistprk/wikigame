<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class GenreGameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            \DB::table('genre_game')->insert([
                'game_id'     => $faker->numberBetween(1,10),
                'genre_id' => $faker->numberBetween(1,5)
            ]);
        }
    }
}
