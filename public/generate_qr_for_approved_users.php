<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Str;

// Find users with approved status or active status without QR codes
$usersWithoutQR = User::whereIn('account_status', ['approved', 'active'])
    ->whereNull('qr_code')
    ->get();

echo "Found " . $usersWithoutQR->count() . " approved/active users without QR codes.\n";

foreach ($usersWithoutQR as $user) {
    $qrCode = 'QR-' . strtoupper(Str::random(16));
    
    $user->update([
        'qr_code' => $qrCode
    ]);
    
    echo "Generated QR code for user: {$user->name} ({$user->email}) - Status: {$user->account_status} - QR Code: {$qrCode}\n";
}

echo "\nQR code generation completed.\n";
