<?php

namespace Database\Factories;

use App\Models\SystemRequirementsMin;
use Carbon\Carbon;
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
            'cpu'          => $this->faker->word(3),
            'gpu'          => $this->faker->word(3),
            'ram'          => $this->faker->numberBetween(1, 16),
            'ram_unit'     => 0,
            'storage'      => $this->faker->numberBetween(20, 120),
            'storage_unit' => 0,
            'os'           => $this->faker->sentence(2),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ];
    }
}
