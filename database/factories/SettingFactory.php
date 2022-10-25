<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Setting::class;

    public function definition()
    {
        return [
            'site_status'      => 1,
            'footer_text'      => 'Oyunla ilgili aradığınız her şey.',
            'about_text'       => 'Site hakkında yazısı eklenecektir.',
            'meta_description' => 'WikiGame oyunlar hakkında her türlü bilgiye ulaşabileceğiniz adres.',
            'facebook'         => 'https://www.facebook.com',
            'twitter'          => 'https://www.twitter.com/dervistprk',
            'github'           => 'https://www.github.com/dervistprk',
            'linkedin'         => 'https://www.linkedin.com/in/derviş-toprak-0698a81b7/',
            'youtube'          => 'https://www.youtube.com',
            'instagram'        => 'https://www.instagram.com/dervistprk',
            'favicon'          => '/assets/favicon.png',
            'logo'             => '/assets/logo.png',
            'backend_favicon'  => '/assets/backend_favicon.png'
        ];
    }
}
