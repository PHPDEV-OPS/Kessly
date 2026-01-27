{{-- Welcome email template --}}
<x-emails.layout title="Welcome to {{ config('app.name') }}!">
    <div class="greeting">
        Welcome aboard, {{ $user->name }}! 🎉
    </div>

    <div class="message">
        <p>Thank you for joining <strong>{{ config('app.name') }}</strong>! We're excited to have you as part of our supply chain management platform.</p>

        <div class="highlight-box">
            <h3 style="margin-top: 0; color: #333;">Your Account Details:</h3>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->role->name ?? 'Pending Assignment' }}</p>
            <p><strong>Status:</strong> {{ $user->is_verified ? 'Verified' : 'Pending Verification' }}</p>
        </div>

        @if(!$user->is_verified)
            <p>Your account is currently pending administrator verification. You'll receive an email notification once your account is approved and ready to use.</p>
        @else
            <p>Your account is now active! You can start using all the features available to your role.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('dashboard') }}" class="btn">Access Your Dashboard</a>
            </div>
        @endif

        <p>If you have any questions or need assistance, don't hesitate to reach out to our support team.</p>

        <p>Best regards,<br>The {{ config('app.name') }} Team</p>
    </div>
</x-emails.layout>