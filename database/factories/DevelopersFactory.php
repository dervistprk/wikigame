<?php

namespace Database\Factories;

use App\Models\Developers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DevelopersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Developers::class;

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
            'created_at'  => now(),
            'updated_at'  => now(),
        ];

    }
}
