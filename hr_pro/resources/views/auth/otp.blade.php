<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification - HR_PRO</title>
    
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
        
        .container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
        }
        
        .otp-card {
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 500px;
            margin: 0 auto;
        }
        
        .card-header {
            background: linear-gradient(135deg, #1D4ED8 0%, #1E3A8A 100%);
            padding: 40px;
            text-align: center;
            color: white;
        }
        
        .card-header h1 {
            font-family: 'Inter', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 10px;
        }
        
        .card-header p {
            font-family: 'Roboto', sans-serif;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .card-body {
            padding: 40px;
            background: #F3F4F6;
        }
        
        .info-text {
            font-family: 'Roboto', sans-serif;
            color: #6B7280;
            text-align: center;
            margin-bottom: 25px;
            font-size: 0.95rem;
            line-height: 1.5;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            color: #1F2937;
            display: block;
            margin-bottom: 8px;
        }
        
        .otp-input-container {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .otp-input {
            width: 60px;
            height: 70px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: 2px solid #E5E7EB;
            border-radius: 12px;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .otp-input:focus {
            border-color: #1D4ED8;
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }
        
        .single-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #E5E7EB;
            border-radius: 12px;
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
            text-align: center;
            letter-spacing: 4px;
            font-weight: 600;
        }
        
        .single-input:focus {
            border-color: #1D4ED8;
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }
        
        .single-input.is-invalid {
            border-color: #EF4444;
        }
        
        .invalid-feedback {
            color: #EF4444;
            font-size: 0.8rem;
            margin-top: 5px;
            font-family: 'Roboto', sans-serif;
            text-align: center;
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-family: 'Roboto', sans-serif;
            font-size: 0.9rem;
        }
        
        .alert-danger {
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }
        
        .alert-success {
            background: #D1FAE5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }
        
        .alert-info {
            background: #DBEAFE;
            color: #1E40AF;
            border: 1px solid #BFDBFE;
        }
        
        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #1D4ED8 0%, #1E3A8A 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(29, 78, 216, 0.3);
        }
        
        .resend-section {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
        }
        
        .resend-section p {
            font-family: 'Roboto', sans-serif;
            color: #6B7280;
            font-size: 0.85rem;
            margin-bottom: 10px;
        }
        
        .resend-link {
            color: #1D4ED8;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .resend-link:hover {
            color: #1E3A8A;
            text-decoration: underline;
        }
        
        .back-link {
            text-align: center;
            margin-top: 15px;
        }
        
        .back-link a {
            color: #6B7280;
            text-decoration: none;
            font-family: 'Roboto', sans-serif;
            font-size: 0.85rem;
            transition: color 0.3s;
        }
        
        .back-link a:hover {
            color: #1D4ED8;
        }
        
        @media (max-width: 768px) {
            .card-header {
                padding: 30px;
            }
            
            .card-header h1 {
                font-size: 1.5rem;
            }
            
            .card-body {
                padding: 30px;
            }
            
            .otp-input {
                width: 50px;
                height: 60px;
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="otp-card">
            <div class="card-header">
                <h1>Verify Your Identity</h1>
                <p>OTP Verification</p>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <div class="info-text">
                    Please enter the 6-digit verification code sent to your email address.
                </div>
                
                <form method="POST" action="{{ route('verify-otp') }}" id="otpForm">
                    @csrf
                    <div class="form-group">
                        <label for="otp">Verification Code</label>
                        <input type="text" 
                               class="single-input @error('otp') is-invalid @enderror" 
                               id="otp" 
                               name="otp" 
                               maxlength="6" 
                               required
                               placeholder="000000">
                        @error('otp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Verify Code</button>
                </form>
                
                <div class="back-link">
                    <a href="{{ route('login') }}">← Back to Login</a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInput = document.getElementById('otp');
            if (otpInput) {
                otpInput.focus();

                otpInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
                });
            }
        });
    </script>
</body>
</html>