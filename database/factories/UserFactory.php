<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_name'         => 'dervistprk',
            'email'             => 'dervistprk@email.com',
            'password'          => bcrypt('123456Aa'),
            'birth_day'         => '2022-07-29 12:31:24',
            'name'              => 'Derviş',
            'surname'           => 'Toprak',
            'gender'            => 'erkek',
            'about'             => 'Örnek olarak oluşturulmuş kullanıcının hakkında yazısı.',
            'is_admin'          => 1,
            'is_email_verified' => 1
        ];
    }
}
