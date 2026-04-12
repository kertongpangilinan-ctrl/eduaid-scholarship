<?php

namespace App\Console\Commands;

use App\Models\PayoutEvent;
use App\Models\PayoutDocument;
use App\Models\PayoutAttendance;
use App\Models\PayoutHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessPayoutTracking extends Command
{
    protected $signature = 'payout:process-tracking';
    protected $description = 'Process late payouts and mark inactive students';

    public function handle()
    {
        $this->info('Processing payout tracking...');

        // Process late payouts (within 3 days after event)
        $this->processLatePayouts();

        // Mark inactive students (3 consecutive missed payouts)
        $this->markInactiveStudents();

        $this->info('Payout tracking processed successfully.');

        return Command::SUCCESS;
    }

    private function processLatePayouts()
    {
        $this->info('Processing late payouts...');

        // Get payout events that are completed but within 3 days
        $recentEvents = PayoutEvent::where('status', 'completed')
            ->where('event_date', '>=', Carbon::now()->subDays(3))
            ->get();

        foreach ($recentEvents as $event) {
            // Get students with approved documents but no attendance
            $approvedDocuments = PayoutDocument::where('payout_id', $event->event_id)
                ->where('status', 'approved')
                ->pluck('user_id');

            foreach ($approvedDocuments as $userId) {
                // Check if attendance exists
                $attendance = PayoutAttendance::where('payout_id', $event->event_id)
                    ->where('user_id', $userId)
                    ->first();

                // Check if history already exists
                $history = PayoutHistory::where('payout_id', $event->event_id)
                    ->where('user_id', $userId)
                    ->first();

                if (!$attendance && !$history) {
                    // Create payout history as missed
                    PayoutHistory::create([
                        'payout_id' => $event->event_id,
                        'user_id' => $userId,
                        'status' => 'missed',
                    ]);

                    // Increment consecutive missed payouts
                    $user = User::find($userId);
                    if ($user) {
                        $user->increment('consecutive_missed_payouts');
                    }

                    $this->info("Marked missed payout for user ID: {$userId}");
                }
            }
        }
    }

    private function markInactiveStudents()
    {
        $this->info('Marking inactive students...');

        // Get students with 3 or more consecutive missed payouts
        $inactiveStudents = User::where('role', 'student')
            ->where('consecutive_missed_payouts', '>=', 3)
            ->where('account_status', '!=', 'inactive')
            ->get();

        foreach ($inactiveStudents as $student) {
            $student->update(['account_status' => 'inactive']);
            $this->info("Marked student as inactive: {$student->name}");
        }
    }
}
