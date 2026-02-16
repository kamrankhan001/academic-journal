<!DOCTYPE html>
<html>
<head>
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #86662c;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .field {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        .field:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .field-label {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 5px;
        }
        .field-value {
            font-size: 16px;
            color: #1f2937;
            font-weight: 500;
        }
        .field-value p {
            margin: 0;
            white-space: pre-line;
        }
        .badge {
            display: inline-block;
            background-color: #86662c;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Form Submission</h1>
        </div>
        
        <div class="content">
            <div class="field">
                <div class="field-label">From</div>
                <div class="field-value">{{ $data['name'] }} ({{ $data['email'] }})</div>
            </div>

            <div class="field">
                <div class="field-label">Subject</div>
                <div class="field-value">
                    <span class="badge">{{ ucfirst($data['subject']) }}</span>
                </div>
            </div>

            <div class="field">
                <div class="field-label">Message</div>
                <div class="field-value">
                    <p>{{ $data['message'] }}</p>
                </div>
            </div>

            <div class="field">
                <div class="field-label">Submitted</div>
                <div class="field-value">{{ now()->format('F j, Y \a\t g:i A') }}</div>
            </div>
        </div>

        <div class="footer">
            <p>This message was sent from the contact form on {{ config('app.name') }}</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>