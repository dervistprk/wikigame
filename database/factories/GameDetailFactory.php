<?php

namespace Database\Factories;

use App\Models\GameDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameDetail::class;

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
            'age_rating'   => $value,
            'release_date' => $this->faker->date(),
            'website'      => $this->faker->url(),
        ];
    }
}
