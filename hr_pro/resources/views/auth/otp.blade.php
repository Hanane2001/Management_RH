<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification - HR_PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .otp-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        .otp-input {
            font-size: 32px;
            letter-spacing: 10px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="otp-card">
        <h2>OTP Verification</h2>
        <p>Please enter the 6-digit code sent to your email</p>
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <form method="POST" action="{{ route('verify-otp') }}">
            @csrf
            
            <div class="mb-4">
                <input type="text" name="otp" class="form-control otp-input" 
                       maxlength="6" pattern="[0-9]{6}" required autofocus>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
        </form>
        
        <div class="mt-3">
            <small>Didn't receive code? <a href="#">Resend</a></small>
        </div>
    </div>
</body>
</html>