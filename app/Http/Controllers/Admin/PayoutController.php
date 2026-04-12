<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Models\Batch;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PayoutController extends Controller
{
    public function index()
    {
        $payouts = Payout::with(['user', 'batch'])
            ->orderBy('payout_date', 'desc')
            ->paginate(20);
        
        return view('admin.payouts.index', compact('payouts'));
    }

    public function create()
    {
        $activeBatch = Batch::where('status', 'active')->first();
        return view('admin.payouts.create', compact('activeBatch'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|exists:batches,batch_id',
            'amount' => 'required|numeric|min:0',
            'payout_date' => 'required|date'
        ]);

        $batch = Batch::find($request->batch_id);
        
        // Create payouts for all scholars in the batch
        $scholars = $batch->scholars;
        $createdCount = 0;

        foreach ($scholars as $scholar) {
            // Check if payout already exists for this user and batch
            $existingPayout = Payout::where('user_id', $scholar->user_id)
                ->where('batch_id', $batch->batch_id)
                ->where('payout_date', $request->payout_date)
                ->first();

            if (!$existingPayout) {
                Payout::create([
                    'user_id' => $scholar->user_id,
                    'batch_id' => $batch->batch_id,
                    'amount' => $request->amount,
                    'status' => 'pending',
                    'payout_date' => $request->payout_date
                ]);
                $createdCount++;
            }
        }

        return redirect()->route('admin.payouts.index')
            ->with('success', "Created {$createdCount} payouts for batch {$batch->batch_number}");
    }

    public function show(Payout $payout)
    {
        $payout->load(['user', 'batch']);
        return view('admin.payouts.show', compact('payout'));
    }

    public function release(Request $request, Payout $payout)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000'
        ]);

        $payout->update([
            'status' => 'released',
            'released_by' => auth()->id()
        ]);

        // Send notification to user
        try {
            $user = $payout->user;

            \Mail::raw(
                "Dear {$user->name},\n\n" .
                "Your scholarship payout has been released.\n\n" .
                "Amount: ₱{$payout->amount}\n" .
                "Payout Date: {$payout->payout_date->format('F d, Y')}\n\n" .
                "Please visit the scholarship office to claim your payout.\n\n" .
                "Bring your school ID for verification.\n\n" .
                "Best regards,\n" .
                "EduAid Scholarship Team",
                function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('EduAid - Payout Released');
                }
            );
        } catch (\Exception $e) {
            \Log::error('Failed to send payout release email: ' . $e->getMessage());
        }

        return back()->with('success', 'Payout released successfully');
    }

    public function releaseBatch(Request $request, Batch $batch)
    {
        $pendingPayouts = Payout::where('batch_id', $batch->batch_id)
            ->where('status', 'pending')
            ->get();

        foreach ($pendingPayouts as $payout) {
            $payout->update([
                'status' => 'released',
                'released_by' => auth()->id()
            ]);
        }

        return back()->with('success', "Released {$pendingPayouts->count()} payouts for batch {$batch->batch_number}");
    }

    public function claim(Request $request, Payout $payout)
    {
        $request->validate([
            'signature_path' => 'required|string'
        ]);

        $payout->update([
            'status' => 'claimed',
            'date_received' => Carbon::now(),
            'signature_path' => $request->signature_path
        ]);

        return back()->with('success', 'Payout claimed successfully');
    }

    public function cancel(Request $request, Payout $payout)
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        if ($payout->status === 'claimed') {
            return back()->withErrors(['error' => 'Cannot cancel a claimed payout']);
        }

        $payout->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Payout cancelled successfully');
    }
}
