<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

$username = 'Kurt1234';

$user = User::where('username', $username)->first();

if ($user) {
    echo "User found:\n";
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Username: {$user->username}\n";
    echo "Account Status: {$user->account_status}\n";
    echo "QR Code: " . ($user->qr_code ?? 'None') . "\n";
    echo "Role: {$user->role}\n";
} else {
    echo "User with username '{$username}' not found.\n";
}
