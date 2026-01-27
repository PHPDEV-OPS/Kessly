<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use App\Models\EmailTracking;

class AdminNewUserEmail extends Mailable implements ShouldQueue
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
            subject: 'New User Registration - ' . $this->user->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Create tracking record
        $tracking = EmailTracking::create([
            'email_type' => 'admin-new-user',
            'recipient_email' => $this->user->email, // This will be the admin's email
            'user_id' => $this->user->id,
            'tracking_id' => EmailTracking::generateTrackingId(),
            'metadata' => [
                'new_user_name' => $this->user->name,
                'new_user_email' => $this->user->email,
                'new_user_role' => $this->user->role?->name,
                'sent_at' => now()->toISOString(),
            ],
        ]);

        $trackingUrl = route('email.track', $tracking->tracking_id);

        return new Content(
            view: 'emails.admin-new-user',
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
