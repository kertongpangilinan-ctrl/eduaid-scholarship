<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$students = DB::table('users')->where('role', 'student')->whereNull('qr_code')->get();

foreach ($students as $student) {
    do {
        $qrCode = 'QR-' . strtoupper(\Illuminate\Support\Str::random(16));
    } while (DB::table('users')->where('qr_code', $qrCode)->exists());
    
    DB::table('users')->where('id', $student->id)->update(['qr_code' => $qrCode]);
    
    echo "Generated QR code for student: {$student->name} - {$qrCode}\n";
}

echo "QR codes generated successfully for {$students->count()} students.\n";
