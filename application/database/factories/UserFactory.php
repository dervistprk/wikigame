<?php

namespace Database\Factories;

use Carbon\Carbon;
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
            'user_name'            => 'dervistprk',
            'email'                => 'dervistprk@email.com',
            'password'             => bcrypt('123456Aa'),
            'birth_day'            => '1996-06-11 12:31:24',
            'name'                 => 'Derviş',
            'surname'              => 'Toprak',
            'gender'               => 'erkek',
            'about'                => 'Örnek olarak oluşturulmuş kullanıcının hakkında yazısı. Kullanıcı yönetici olarak oluşturulmuştur.',
            'is_admin'             => 1,
            'is_email_verified'    => 1,
            'password_change_time' => Carbon::now()
        ];
    }
}
