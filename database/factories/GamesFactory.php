<?php

namespace Database\Factories;

use App\Models\Games;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GamesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Games::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence(3);
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
            'cover_image'     => $this->faker->imageUrl(200, 320),
            'image1'          => $this->faker->imageUrl(1920, 1080),
            'video1'          => $this->faker->url(),
            'created_at'      => $this->faker->dateTime(),
            'updated_at'      => now(),
        ];
    }
}
