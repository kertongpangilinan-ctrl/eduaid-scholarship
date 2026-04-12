<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function showTrackForm()
    {
        return view('track-application');
    }

    public function track(Request $request, $reference = null)
    {
        $reference = $reference ?? $request->input('reference');
        
        // If no reference provided, show empty form
        if (!$reference) {
            return view('track-application');
        }

        $application = Application::with('user')
            ->where('reference_number', $reference)
            ->first();

        if (!$application) {
            return redirect()->route('track-application')
                ->withErrors(['reference' => 'No application found with this reference number.']);
        }

        return view('track-application', [
            'application' => $application
        ]);
    }

    public function trackApi(Request $request, $reference)
    {
        $application = Application::with('user')
            ->where('reference_number', $reference)
            ->first();

        if (!$application) {
            return response()->json([
                'success' => false,
                'message' => 'No application found with this reference number.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'application' => [
                'reference_number' => $application->reference_number,
                'status' => $application->status,
                'submission_date' => $application->submission_date->format('F j, Y - g:i A'),
                'approved_date' => $application->approved_date ? $application->approved_date->format('F j, Y - g:i A') : null,
                'name' => $application->user->name,
                'email' => $application->user->email
            ]
        ]);
    }
}
