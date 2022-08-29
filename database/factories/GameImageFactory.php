<?php

namespace Database\Factories;

use App\Models\GameImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'game_id'    => rand(1, 10),
            'image_hash' => \Str::random(20),
            'path'       => $this->faker->imageUrl(1920, 1080)
        ];
    }
}
