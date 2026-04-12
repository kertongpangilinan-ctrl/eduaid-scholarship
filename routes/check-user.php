<?php

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::where('email', 'kurt3063@gmail.com')->first();

if ($user) {
    echo "User ID: " . $user->id . "\n";
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Email Verified At: " . ($user->email_verified_at ?? 'NULL') . "\n";
    echo "Account Status: " . $user->account_status . "\n";
    echo "Reference Number: " . ($user->reference_number ?? 'N/A') . "\n";
    echo "Created At: " . $user->created_at . "\n";
} else {
    echo "User not found!\n";
}
