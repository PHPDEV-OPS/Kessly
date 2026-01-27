{{-- User verification notification --}}
<x-emails.layout title="Account Verified - Welcome to {{ config('app.name') }}!">
    <div class="greeting">
        Congratulations, {{ $user->name }}! ✅
    </div>

    <div class="message">
        <p>Great news! Your account has been <strong>verified and approved</strong> by our administrators.</p>

        <div class="highlight-box">
            <h3 style="margin-top: 0; color: #333;">Your Account is Now Active:</h3>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $user->role->name ?? 'Assigned' }}</p>
            <p><strong>Verification Date:</strong> {{ now()->format('M j, Y \a\t g:i A') }}</p>
        </div>

        <p>You can now access all features and functionality available to your role. Welcome to the team!</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('login') }}" class="btn">Login to Your Account</a>
        </div>

        <p>If you have any questions about using the platform or need assistance getting started, please don't hesitate to contact our support team.</p>

        <p>Welcome to the {{ config('app.name') }} family!</p>

        <p>Best regards,<br>The {{ config('app.name') }} Team</p>
    </div>
</x-emails.layout>