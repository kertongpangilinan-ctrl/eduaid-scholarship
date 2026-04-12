<?php

namespace App\Mail;

use App\Models\PayoutEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PayoutEventNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $payoutEvent;

    /**
     * Create a new message instance.
     */
    public function __construct(PayoutEvent $payoutEvent)
    {
        $this->payoutEvent = $payoutEvent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Payout Event Scheduled - ' . $this->payoutEvent->event_name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payout-event-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
