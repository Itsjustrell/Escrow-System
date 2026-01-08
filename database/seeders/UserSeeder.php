<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. BUAT BUYER
        $buyer = User::factory()->create([
            'name' => 'Buyer Account',
            'email' => 'buyer@test.com',
            'password' => bcrypt('password'), // Kita set password manual biar gampang diingat
        ]);

        $buyer->roles()->attach(
            Role::where('name', 'buyer')->first()
        );

        // 2. BUAT SELLER (Ini yang sebelumnya kurang)
        $seller = User::factory()->create([
            'name' => 'Seller Account',
            'email' => 'seller@test.com',
            'password' => bcrypt('password'),
        ]);

        $seller->roles()->attach(
            Role::where('name', 'seller')->first()
        );

        // 3. BUAT ADMIN (Supaya dashboard admin Anda bisa dites)
        $admin = User::factory()->create([
            'name' => 'Admin Super',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);

        $admin->roles()->attach(
            Role::where('name', 'admin')->first()
        );

        // 4. BUAT ARBITER
        $arbiter = User::factory()->create([
            'name' => 'Arbiter Account',
            'email' => 'arbiter@test.com',
            'password' => bcrypt('password'),
        ]);

        $arbiter->roles()->attach(
            Role::where('name', 'arbiter')->first()
        );
    }
}