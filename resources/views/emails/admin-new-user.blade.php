{{-- Admin notification for new user registration --}}
<x-emails.layout title="New User Registration Requires Verification">
    <div class="greeting">
        Hello Administrator! 👋
    </div>

    <div class="message">
        <p>A new user has registered on <strong>{{ config('app.name') }}</strong> and requires your verification.</p>

        <div class="highlight-box">
            <h3 style="margin-top: 0; color: #333;">New User Details:</h3>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role Requested:</strong> {{ $user->role->name ?? 'Not specified' }}</p>
            <p><strong>Registration Date:</strong> {{ $user->created_at->format('M j, Y \a\t g:i A') }}</p>
        </div>

        <p>Please review this user's information and either approve or reject their account access.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('settings.users') }}" class="btn">Review User Accounts</a>
        </div>

        <p><strong>Important:</strong> Users cannot access the system until their accounts are verified by an administrator.</p>

        <p>Best regards,<br>The {{ config('app.name') }} System</p>
    </div>
</x-emails.layout>