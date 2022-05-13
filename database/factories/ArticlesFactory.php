<?php

namespace Database\Factories;

use App\Models\Articles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticlesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Articles::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(4);
        return [
            'title'     => $title,
            'slug'      => Str::slug($title),
            'sub_title' => $this->faker->sentence(10),
            'writing'   => $this->faker->paragraph(10),
            'image'     => $this->faker->imageUrl(1920, 1080)
        ];
    }
}
