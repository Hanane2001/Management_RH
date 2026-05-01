<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset OTP - HR Management System</title>
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|roboto:400,500,700" rel="stylesheet" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1D4ED8 0%, #1E3A8A 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .otp-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            text-align: center;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo h2 {
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            font-size: 1.8rem;
            background: linear-gradient(135deg, #1D4ED8 0%, #1E3A8A 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .title {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: #1F2937;
            margin-bottom: 8px;
        }
        
        .subtitle {
            font-family: 'Roboto', sans-serif;
            font-size: 0.85rem;
            color: #6B7280;
            margin-bottom: 28px;
        }
        
        .otp-input {
            width: 100%;
            padding: 14px;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            letter-spacing: 8px;
            transition: all 0.2s;
            outline: none;
            margin-bottom: 20px;
        }
        
        .otp-input:focus {
            border-color: #1D4ED8;
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-family: 'Roboto', sans-serif;
            font-size: 0.85rem;
        }
        
        .alert-danger {
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }
        
        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
            background: #1D4ED8;
            color: white;
        }
        
        .btn:hover {
            background: #1E3A8A;
            transform: translateY(-2px);
        }
        
        .otp-tip {
            font-family: 'Roboto', sans-serif;
            font-size: 0.7rem;
            color: #9CA3AF;
            margin-top: 16px;
        }
        
        @media (max-width: 480px) {
            .otp-card {
                padding: 30px 20px;
            }
            
            .title {
                font-size: 1.3rem;
            }
            
            .otp-input {
                font-size: 1.2rem;
                letter-spacing: 6px;
            }
        }
    </style>
</head>
<body>
    <div class="otp-card">
        <div class="logo">
            <h2>HR_PRO</h2>
        </div>
        
        <h1 class="title">Reset Password</h1>
        <p class="subtitle">Enter the 6-digit code sent to your email</p>
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <form method="POST" action="{{ route('verify-reset-otp') }}">
            @csrf
            
            <input type="text" name="otp" class="otp-input" 
                   maxlength="6" pattern="[0-9]{6}" 
                   placeholder="000000"
                   autocomplete="off" required>
            
            <button type="submit" class="btn">Verify OTP</button>
            
            <div class="otp-tip">
                <i class="fas fa-clock"></i> The code expires in 5 minutes
            </div>
        </form>
    </div>
    
    <script>
        document.querySelector('.otp-input').focus();
        
        document.querySelector('.otp-input').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
        });
    </script>
</body>
</html>