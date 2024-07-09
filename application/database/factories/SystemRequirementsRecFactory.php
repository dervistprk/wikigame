<?php

namespace Database\Factories;

use App\Models\SystemRequirementsRec;
use Illuminate\Database\Eloquent\Factories\Factory;

class SystemRequirementsRecFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SystemRequirementsRec::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cpu_rec'          => $this->faker->word(),
            'gpu_rec'          => $this->faker->word(),
            'ram_rec'          => $this->faker->numberBetween(1, 16),
            'ram_rec_unit'     => 1,
            'storage_rec'      => $this->faker->numberBetween(20, 120),
            'storage_rec_unit' => 1,
            'os_rec'           => $this->faker->sentence(2),
        ];
    }
}
