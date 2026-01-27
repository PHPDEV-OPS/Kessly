{{-- Base email layout template --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Kessly Notification' }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.7;
        }
        .highlight-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .tracking-pixel {
            display: none !important;
        }
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
            }
            .content {
                padding: 30px 20px;
            }
            .header {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">{{ config('app.name') }}</div>
            <h1>{{ $title ?? 'Notification' }}</h1>
        </div>

        <!-- Content -->
        <div class="content">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>Streamlining Supply Chain Operations</p>
            <div class="social-links">
                <a href="#">Website</a> |
                <a href="#">Support</a> |
                <a href="#">Privacy Policy</a>
            </div>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This email was sent to {{ $email ?? 'you' }}</p>
        </div>
    </div>

    {{-- Email tracking pixel for analytics --}}
    @if(isset($trackingUrl))
        <img src="{{ $trackingUrl }}" class="tracking-pixel" alt="" width="1" height="1" />
    @endif
</body>
</html>