<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Code Reset</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #09090b; color: #f4f4f5; margin: 0; padding: 40px 20px; }
        .card { max-width: 500px; margin: 0 auto; background-color: #18181b; border: 1px solid #27272a; border-radius: 12px; padding: 32px; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 9999px; background-color: #27272a; color: #a1a1aa; font-size: 12px; font-weight: 600; text-transform: uppercase; margin-bottom: 16px; }
        h1 { font-size: 20px; margin: 0 0 12px; color: #ffffff; }
        p { font-size: 14px; line-height: 1.6; color: #a1a1aa; margin: 0 0 20px; }
        .button { display: inline-block; padding: 12px 24px; background-color: #ffffff; color: #09090b; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 14px; }
        .footer { font-size: 12px; color: #71717a; margin-top: 28px; border-top: 1px solid #27272a; padding-top: 16px; }
    </style>
</head>
<body>
    <div class="card">
        <span class="badge">Security Notification</span>
        <h1>Admin Access Code Reset</h1>
        <p>A request was received to reset the pre-authentication 6-digit access code for your portfolio admin portal. If you initiated this request, click the button below to define a new PIN.</p>
        <p>This reset link will expire in {{ $validMinutes }} minutes.</p>
        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetUrl }}" class="button">Reset Access Code PIN</a>
        </p>
        <p class="footer">If you did not request this reset, your existing access code remains secure. Someone may have reached the concealed entry point on your portfolio.</p>
    </div>
</body>
</html>
