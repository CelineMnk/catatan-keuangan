<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Use updateOrCreate so running the seeder multiple times won't fail on unique constraint
        User::updateOrCreate(
            ['email' => 'ielmanik038@gmail.com'],
            [
                'name' => 'Iel Manik',
                'password' => Hash::make('Celiinmaniik20'),
            ]
        );
    }
}