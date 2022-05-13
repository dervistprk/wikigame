<?php

namespace Database\Factories;

use App\Models\Publishers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PublishersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Publishers::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence(3);
        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'description' => $this->faker->paragraph(5),
            'image'       => $this->faker->imageUrl(),
            'created_at'  => $this->faker->dateTime(),
            'updated_at'  => now(),
        ];
    }
}
