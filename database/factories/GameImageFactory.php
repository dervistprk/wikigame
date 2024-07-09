<?php

namespace Database\Factories;

use App\Models\GameImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mmo\Faker\FakeimgProvider;
use Mmo\Faker\LoremSpaceProvider;
use Mmo\Faker\PicsumProvider;

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
        //$faker = Faker\Factory::create();
        $this->faker->addProvider(new PicsumProvider($this->faker));
        $this->faker->addProvider(new LoremSpaceProvider($this->faker));
        $this->faker->addProvider(new FakeimgProvider($this->faker));
        return [
            'game_id'    => rand(1, 10),
            'image_hash' => \Str::random(20),
            //'path'       => $this->faker->imageUrl(1920, 1080),
            'path'       => $this->faker->picsumUrl(1920, 1080)
        ];
    }
}
