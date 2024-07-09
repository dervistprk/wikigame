<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Mmo\Faker\FakeimgProvider;
use Mmo\Faker\LoremSpaceProvider;
use Mmo\Faker\PicsumProvider;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence(3);
        $this->faker->addProvider(new PicsumProvider($this->faker));
        $this->faker->addProvider(new LoremSpaceProvider($this->faker));
        $this->faker->addProvider(new FakeimgProvider($this->faker));
        return [
            'name'            => $name,
            'sub_title'       => $this->faker->paragraph(4),
            'category_id'     => rand(1, 5),
            'developer_id'    => rand(1, 5),
            'publisher_id'    => rand(1, 5),
            'sys_req_min_id'  => rand(1, 5),
            'sys_req_rec_id'  => rand(1, 5),
            'game_details_id' => rand(1, 5),
            'slug'            => Str::slug($name),
            'description'     => $this->faker->paragraph(12),
            'cover_image'     => $this->faker->picsumUrl(230, 300),
            'image1'          => $this->faker->picsumUrl(1920, 1080)
        ];
    }
}
