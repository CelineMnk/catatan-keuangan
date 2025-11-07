<?php
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/bootstrap/app.php';

use Illuminate\Support\Facades\Hash;
use App\Models\User;

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $user = new User();
    $user->name = 'Admin';
    $user->email = 'admin@admin.com';
    $user->password = Hash::make('password');
    $user->save();
    
    echo "User created successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}