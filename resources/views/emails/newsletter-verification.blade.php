<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Newsletter Subscription</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #86662c; color: white; padding: 20px; text-align: center; }
        .content { padding: 30px 20px; }
        .button { display: inline-block; background-color: #86662c; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verify Your Subscription</h1>
        </div>
        <div class="content">
            <p>Thank you for subscribing to our newsletter!</p>
            <p>Please click the button below to verify your email address:</p>
            
            <p style="text-align: center; margin: 30px 0;">
                <a href="{{ route('newsletter.verify', $subscription->verification_token) }}" class="button">
                    Verify Email Address
                </a>
            </p>
            
            <p>If you did not request this subscription, you can ignore this email.</p>
            
            <p>This link will expire in 48 hours.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>