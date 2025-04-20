<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #4a5568; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 5px; padding: 25px; }
        .header { text-align: center; margin-bottom: 25px; }
        .logo { width: 150px; }
        .title { color: #3490dc; margin-top: 15px; font-size: 28px; }
        .content { font-size: 16px; }
        .credentials-panel { background-color: #f8fafc; border-left: 4px solid #3490dc; padding: 15px; margin: 20px 0; }
        .button-container { text-align: center; margin: 30px 0; }
        .button { display: inline-block; background-color: #3490dc; color: white; padding: 12px 25px; text-decoration: none; border-radius: 4px; font-weight: bold; }
        .footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0; color: #718096; font-size: 14px; }
        .important { color: #e3342f; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="HealthGate Logo" class="logo">
            <h1 class="title">Welcome to the HealthGate Team</h1>
        </div>

        <p class="content">Dear Doctor,</p>

        <p class="content">We're delighted to have you join our healthcare network. Your account has been successfully created in our system. Please find your login credentials below:</p>

        <div class="credentials-panel">
            <div style="padding: 10px 0;">
                <p style="margin: 5px 0; font-size: 16px;"><strong style="color: #3490dc;">Email:</strong> {{ $credentials['email'] }}</p>
                <p style="margin: 5px 0; font-size: 16px;"><strong style="color: #3490dc;">Password:</strong> {{ $credentials['password'] }}</p>
            </div>
        </div>

        <p class="content">
            <span class="important">Important:</span> For your security, we strongly recommend changing your password after your first login.
        </p>

        <div class="button-container">
            <a href="{{ route('login') }}" class="button">Access Your Account</a>
        </div>

        <p class="content">Thank you for joining our medical team. We look forward to your valuable contribution!</p>

        <div class="footer">
            <p>Warm Regards,<br>
            <strong style="color: #3490dc;">HealthGate Team</strong></p>
        </div>
    </div>
</body>
</html>