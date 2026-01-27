<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use App\Models\EmailTracking;

class UserVerifiedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account Verified - Welcome to ' . config('app.name') . '!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Create tracking record
        $tracking = EmailTracking::create([
            'email_type' => 'user-verified',
            'recipient_email' => $this->user->email,
            'user_id' => $this->user->id,
            'tracking_id' => EmailTracking::generateTrackingId(),
            'metadata' => [
                'user_name' => $this->user->name,
                'role' => $this->user->role?->name,
                'verified_at' => now()->toISOString(),
            ],
        ]);

        $trackingUrl = route('email.track', $tracking->tracking_id);

        return new Content(
            view: 'emails.user-verified',
            with: [
                'user' => $this->user,
                'trackingUrl' => $trackingUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
