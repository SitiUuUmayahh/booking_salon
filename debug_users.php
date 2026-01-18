<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "=== DAFTAR SEMUA USER DI DATABASE ===\n\n";

$users = User::all(['id', 'name', 'email', 'role']);

foreach ($users as $user) {
    echo "ID: {$user->id}\n";
    echo "Nama: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Role: {$user->role}\n";
    echo "---\n";
}

echo "\n=== TOTAL USER: " . $users->count() . " ===\n";
echo "Admin: " . User::where('role', 'admin')->count() . "\n";
echo "User biasa: " . User::where('role', 'user')->count() . "\n";