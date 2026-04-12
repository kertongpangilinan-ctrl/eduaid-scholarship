<x-mail::message>
# New Payout Event Scheduled

Dear Student,

We are pleased to inform you that a new payout event has been scheduled!

## Event Details

**Event Name:** {{ $payoutEvent->event_name }}

**Date:** {{ \Carbon\Carbon::parse($payoutEvent->event_date)->format('F d, Y') }}

**Time:** {{ $payoutEvent->event_time ? \Carbon\Carbon::parse($payoutEvent->event_time)->format('g A') : 'TBD' }}

**Location:** {{ $payoutEvent->location ?? 'TBD' }}

@if($payoutEvent->description)
**Description:** {{ $payoutEvent->description }}
@endif

## Important Reminder

Please ensure that you have submitted all required documents (COR/COE/COG) and grades for this payout period. Make sure to complete your document submissions before the payout event date to avoid any delays in receiving your payout.

If you have already submitted your documents, please verify that they have been approved by checking your dashboard.

<x-mail::button :url="route('student.dashboard')">
View Dashboard
</x-mail::button>

If you have any questions or concerns, please contact us through the support section in your dashboard.

Best regards,<br>
{{ config('app.name') }}
</x-mail::message>
