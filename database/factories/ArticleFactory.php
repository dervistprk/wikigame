<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Mmo\Faker\FakeimgProvider;
use Mmo\Faker\LoremSpaceProvider;
use Mmo\Faker\PicsumProvider;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(4);
        $this->faker->addProvider(new PicsumProvider($this->faker));
        $this->faker->addProvider(new LoremSpaceProvider($this->faker));
        $this->faker->addProvider(new FakeimgProvider($this->faker));
        return [
            'title'     => $title,
            'slug'      => Str::slug($title),
            'sub_title' => $this->faker->sentence(10),
            'writing'   => $this->faker->paragraph(10),
            'image'     => $this->faker->picsumUrl(1920, 1080)
        ];
    }
}
