<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>
<body>
    <h2>Hello {{ $user->full_name }}</h2>

    <p>Thank you for registering.</p>

    <p>Please click the button below to verify your email:</p>

    <p>
        <a href="{{ route('verify-email', $user->email_verification_token) }}"
           style="padding:10px 15px;background:#0d6efd;color:#fff;text-decoration:none;">
            Verify Email
        </a>
    </p>

    <p>If you did not create an account, ignore this email.</p>
</body>
</html>
