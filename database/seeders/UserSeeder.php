<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'type' => 1,
            'email' => 'superadmin@nrxen.com',
            'mobile' => '11111111',
            'password' => 'Nrxen@2026',
        ]);
    }
}
