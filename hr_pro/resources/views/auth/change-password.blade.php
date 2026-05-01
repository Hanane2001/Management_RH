<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - HR Management System</title>
    
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
        
        .password-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            width: 100%;
            max-width: 450px;
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
            text-align: center;
            margin-bottom: 8px;
        }
        
        .subtitle {
            font-family: 'Roboto', sans-serif;
            font-size: 0.85rem;
            color: #6B7280;
            text-align: center;
            margin-bottom: 28px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }
        
        input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            font-family: 'Roboto', sans-serif;
            font-size: 0.9rem;
            transition: all 0.2s;
            outline: none;
        }
        
        input:focus {
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
        
        .alert ul {
            margin: 0;
            padding-left: 20px;
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
        
        @media (max-width: 480px) {
            .password-card {
                padding: 30px 20px;
            }
            
            .title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="password-card">
        <div class="logo">
            <h2>HR_PRO</h2>
        </div>
        
        <h1 class="title">Change Password</h1>
        <p class="subtitle">Enter your new password</p>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('change-password') }}">
            @csrf
            
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" placeholder="Enter new password" required>
            </div>
            
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm your password" required>
            </div>
            
            <button type="submit" class="btn">Change Password</button>
        </form>
    </div>
</body>
</html>