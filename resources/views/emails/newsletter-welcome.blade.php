<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Newsletter</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #86662c; color: white; padding: 20px; text-align: center; }
        .content { padding: 30px 20px; }
        .button { display: inline-block; background-color: #86662c; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
        .unsubscribe { color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $isResubscribe ? 'Welcome Back!' : 'Welcome Aboard!' }}</h1>
        </div>
        <div class="content">
            @if($isResubscribe)
                <p>Great to have you back, {{ $subscription->name ?? 'Subscriber' }}!</p>
                <p>You've been successfully resubscribed to our newsletter. You'll continue receiving updates about the latest research and journal publications.</p>
            @else
                <p>Hello {{ $subscription->name ?? 'Subscriber' }},</p>
                <p>Thank you for verifying your email address! You're now officially subscribed to our newsletter.</p>
                <p>You'll receive:</p>
                <ul>
                    <li>Weekly updates on new journal publications</li>
                    <li>Announcements about special issues</li>
                    <li>Research highlights and featured articles</li>
                    <li>Conference and event notifications</li>
                </ul>
            @endif
            
            <p style="text-align: center; margin: 30px 0;">
                <a href="{{ route('home') }}" class="button">Browse Latest Journals</a>
            </p>
            
            <p class="unsubscribe">
                If you wish to unsubscribe at any time, 
                <a href="{{ route('newsletter.unsubscribe', ['email' => $subscription->email, 'token' => $subscription->verification_token]) }}">click here</a>.
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>