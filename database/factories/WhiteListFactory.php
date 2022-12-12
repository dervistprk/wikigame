<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WhiteListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ip'   => '127.0.0.1',
            'name' => 'Derviş Toprak'
        ];
    }
}
