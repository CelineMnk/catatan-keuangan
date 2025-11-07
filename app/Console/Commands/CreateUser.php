<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    protected $signature = 'user:create';
    protected $description = 'Create a new user';

    public function handle()
    {
        $user = User::create([
            'name' => 'Iel Manik',
            'email' => 'ielmanik038@gmail.com',
            'password' => Hash::make('Celiinmaniik20'),
        ]);

        $this->info('User created successfully!');
    }
}