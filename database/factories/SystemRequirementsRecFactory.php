<?php

namespace Database\Factories;

use App\Models\SystemRequirementsRec;
use Carbon\Carbon;
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
            'cpu'          => $this->faker->word(),
            'gpu'          => $this->faker->word(),
            'ram'          => $this->faker->numberBetween(1, 16),
            'ram_unit'     => 1,
            'storage'      => $this->faker->numberBetween(20, 120),
            'storage_unit' => 1,
            'os'           => $this->faker->sentence(2),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ];
    }
}
