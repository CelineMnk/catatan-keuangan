<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->insert([
            'name' => 'Iel Manik',
            'email' => 'ielmanik038@gmail.com',
            'password' => bcrypt('Celiinmaniik20'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('users')->where('email', 'ielmanik038@gmail.com')->delete();
    }
};
