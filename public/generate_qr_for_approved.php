<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Str;

// Find approved users without QR codes
$approvedUsersWithoutQR = User::where('account_status', 'active')
    ->whereNull('qr_code')
    ->get();

echo "Found " . $approvedUsersWithoutQR->count() . " approved users without QR codes.\n";

foreach ($approvedUsersWithoutQR as $user) {
    $qrCode = 'QR-' . strtoupper(Str::random(16));
    
    $user->update([
        'qr_code' => $qrCode
    ]);
    
    echo "Generated QR code for user: {$user->name} ({$user->email}) - QR Code: {$qrCode}\n";
}

echo "\nQR code generation completed.\n";
