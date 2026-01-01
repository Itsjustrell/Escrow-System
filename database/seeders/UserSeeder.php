<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $buyer = User::factory()->create([
            'email' => 'buyer@test.com'
        ]);

        $buyer->roles()->attach(
            Role::where('name', 'buyer')->first()
        );
    }
}