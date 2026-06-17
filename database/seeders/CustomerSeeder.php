<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Customer Test',
            'email'    => 'customer@coffeshop.com',
            'password' => Hash::make('customer123'),
            'role'     => 'customer',
        ]);
    }
}