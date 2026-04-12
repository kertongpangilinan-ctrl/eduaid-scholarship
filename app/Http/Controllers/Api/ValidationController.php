<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function checkUsername(Request $request)
    {
        $username = trim($request->get('username'));
        
        // Quick validation
        if (empty($username)) {
            return response()->json([
                'valid' => false,
                'message' => 'Username is required'
            ]);
        }
        
        if (strlen($username) < 6) {
            return response()->json([
                'valid' => false,
                'message' => 'Username must be at least 6 characters'
            ]);
        }
        
        if (strlen($username) > 20) {
            return response()->json([
                'valid' => false,
                'message' => 'Username must be less than 20 characters'
            ]);
        }
        
        if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
            return response()->json([
                'valid' => false,
                'message' => 'Username must contain only letters and numbers'
            ]);
        }
        
        // Fast database check with index
        $exists = User::where('username', $username)->exists();
        
        if ($exists) {
            return response()->json([
                'valid' => false,
                'message' => 'Username is already taken'
            ]);
        }
        
        return response()->json([
            'valid' => true,
            'message' => 'Username is available!'
        ]);
    }
    
    public function checkEmail(Request $request)
    {
        $email = trim(strtolower($request->get('email')));
        
        // Quick validation
        if (empty($email)) {
            return response()->json([
                'valid' => false,
                'message' => 'Email is required'
            ]);
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid email format'
            ]);
        }
        
        // Fast database check with index
        $exists = User::where('email', $email)->exists();
        
        if ($exists) {
            return response()->json([
                'valid' => false,
                'message' => 'Email is already registered'
            ]);
        }
        
        return response()->json([
            'valid' => true,
            'message' => 'Email is available!'
        ]);
    }
}
