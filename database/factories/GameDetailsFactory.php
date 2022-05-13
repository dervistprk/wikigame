<?php

namespace Database\Factories;

use App\Models\GameDetails;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameDetails::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $age_ratings = [3, 7, 12, 16, 18];
        $age_rating  = array_rand($age_ratings);
        $value       = $age_ratings[$age_rating];
        return [
            'genre'        => $this->faker->word(),
            'age_rating'   => $value,
            'release_date' => $this->faker->date(),
            'platform'     => $this->faker->colorName(),
            'website'      => $this->faker->url(),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ];
    }
}
