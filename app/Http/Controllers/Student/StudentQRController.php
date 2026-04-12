<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QRCode;
use App\Models\Application;

class StudentQRController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $application = Application::where('user_id', $user->id)->first();
        $qrCode = null;
        
        // Check if user has QR code in users table (new system)
        if ($user->qr_code) {
            $qrCode = (object) [
                'qr_code_value' => $user->qr_code,
                'status' => 'active',
                'qr_image_path' => null
            ];
        }
        
        return view('student.qr', compact('qrCode', 'application'));
    }
}
