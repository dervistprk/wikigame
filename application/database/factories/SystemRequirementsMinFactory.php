<?php

namespace Database\Factories;

use App\Models\SystemRequirementsMin;
use Illuminate\Database\Eloquent\Factories\Factory;

class SystemRequirementsMinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SystemRequirementsMin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cpu_min'          => $this->faker->word(3),
            'gpu_min'          => $this->faker->word(3),
            'ram_min'          => $this->faker->numberBetween(1, 16),
            'ram_min_unit'     => 0,
            'storage_min'      => $this->faker->numberBetween(20, 120),
            'storage_min_unit' => 0,
            'os_min'           => $this->faker->sentence(2),
        ];
    }
}
