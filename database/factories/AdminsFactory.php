<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdminsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'     => 'Admin',
            'email'    => 'admin@email.com',
            'password' => bcrypt('123456Aa'),
        ];
    }
}
