<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payout;
use App\Models\PayoutEvent;
use App\Models\PayoutDocument;

class StudentPayoutController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $payouts = Payout::where('user_id', $user->id)
                        ->orderBy('payout_date', 'desc')
                        ->paginate(10);
        
        // Group by year
        $payoutsByYear = $payouts->groupBy(function($payout) {
            return date('Y', strtotime($payout->payout_date));
        });
        
        // Get payout events that are not completed
        $payoutEvents = PayoutEvent::where('status', '!=', 'completed')
            ->orderBy('event_date', 'asc')
            ->get();
        
        // Get submitted documents
        $documents = PayoutDocument::where('user_id', $user->id)
            ->with('payout')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('student.payout', compact('payouts', 'payoutsByYear', 'payoutEvents', 'documents'));
    }
}
