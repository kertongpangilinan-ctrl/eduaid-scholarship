<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateQRCodes extends Command
{
    protected $signature = 'qr:generate';
    protected $description = 'Generate unique QR codes for all students';

    public function handle()
    {
        $students = User::where('role', 'student')->whereNull('qr_code')->get();
        
        foreach ($students as $student) {
            do {
                $qrCode = 'QR-' . strtoupper(Str::random(16));
            } while (User::where('qr_code', $qrCode)->exists());
            
            $student->update([
                'qr_code' => $qrCode
            ]);
            
            $this->info("Generated QR code for student: {$student->name}");
        }
        
        $this->info("QR codes generated successfully for {$students->count()} students.");
        
        return Command::SUCCESS;
    }
}
