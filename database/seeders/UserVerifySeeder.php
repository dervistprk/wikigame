<?php

namespace Database\Seeders;

use App\Models\UserVerify;
use Illuminate\Database\Seeder;

class UserVerifySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserVerify::factory(1)->create();
    }
}
