<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HR Management System</title>
    
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
        
        .login-card {
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
        
        input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #E5E7EB;
            border-radius: 12px;
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }
        
        input:focus {
            border-color: #1D4ED8;
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1);
        }
        
        input.is-invalid {
            border-color: #EF4444;
        }
        
        .invalid-feedback {
            color: #EF4444;
            font-size: 0.8rem;
            margin-top: 5px;
            font-family: 'Roboto', sans-serif;
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
        
        .links {
            text-align: center;
            margin-top: 25px;
        }
        
        .links a {
            color: #1D4ED8;
            text-decoration: none;
            font-family: 'Roboto', sans-serif;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        
        .links a:hover {
            color: #1E3A8A;
            text-decoration: underline;
        }
        
        .separator {
            display: inline-block;
            margin: 0 10px;
            color: #9CA3AF;
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
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card">
            <div class="card-header">
                <h1>Welcome Back</h1>
                <p>Login to your HR Management account</p>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" 
                               class="@error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" 
                               class="@error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </form>
                
                <div class="links">
                    <a href="{{ route('forgot-password') }}">Forgot Password?</a>
                    <span class="separator">•</span>
                    <a href="{{ route('register') }}">Create an Account</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>