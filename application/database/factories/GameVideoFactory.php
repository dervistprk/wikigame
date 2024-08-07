<?php

namespace Database\Factories;

use App\Models\GameVideo;
use Faker\Provider\Youtube;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameVideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameVideo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new Youtube($this->faker));
        return [
            'game_id'    => $this->faker->numberBetween(1, 10),
            'video_hash' => \Str::random(20),
            'url'        => $this->faker->youtubeEmbedUri()
        ];
    }
}
