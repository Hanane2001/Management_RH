<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'HR Management System') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|roboto:400,500,700" rel="stylesheet" />
    
    <!-- Styles -->
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
        }
        
        .hero-section {
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            display: flex;
            flex-wrap: wrap;
        }
        
        .hero-content {
            flex: 1;
            padding: 60px;
            background: linear-gradient(135deg, #1D4ED8 0%, #1E3A8A 100%);
            color: white;
        }
        
        .hero-content h1 {
            font-family: 'Inter', sans-serif;
            font-size: 3rem;
            margin-bottom: 20px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }
        
        .hero-content p {
            font-family: 'Roboto', sans-serif;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
            opacity: 0.95;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 40px 0;
        }
        
        .feature {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Roboto', sans-serif;
        }
        
        .feature-icon {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        .hero-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            font-family: 'Inter', sans-serif;
        }
        
        .btn-primary {
            background: white;
            color: #1D4ED8;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        .btn-outline {
            border: 2px solid white;
            color: white;
            background: transparent;
        }
        
        .btn-outline:hover {
            background: white;
            color: #1D4ED8;
        }
        
        .hero-image {
            flex: 1;
            background: #F3F4F6;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        
        .hero-image svg {
            max-width: 100%;
            height: auto;
        }
        
        .stats {
            display: flex;
            justify-content: space-around;
            margin-top: 40px;
            padding-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }
        
        .stat {
            text-align: center;
            font-family: 'Roboto', sans-serif;
        }
        
        .stat-number {
            font-family: 'Inter', sans-serif;
            font-size: 2rem;
            font-weight: 800;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-top: 5px;
        }
        
        @media (max-width: 768px) {
            .hero-content {
                padding: 40px;
            }
            
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .features {
                grid-template-columns: 1fr;
            }
            
            .hero-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="hero-section">
            <div class="hero-content">
                <h1>HR Management System</h1>
                <p>Streamline your human resources management with our comprehensive solution. Manage employees, leaves, contracts, and more efficiently.</p>
                
                <div class="features">
                    <div class="feature">
                        <div class="feature-icon">👥</div>
                        <span>Employee Management</span>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">📅</div>
                        <span>Leave Tracking</span>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">📄</div>
                        <span>Contract Management</span>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">💰</div>
                        <span>Payroll Processing</span>
                    </div>
                </div>
                
                <div class="hero-buttons">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline">Create Account</a>
                            @endif
                        @endauth
                    @endif
                </div>
                
                <div class="stats">
                    <div class="stat">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Companies Trust Us</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">10k+</div>
                        <div class="stat-label">Active Users</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">99.9%</div>
                        <div class="stat-label">Uptime</div>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <svg width="300" height="300" viewBox="0 0 300 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="150" cy="150" r="120" fill="#1D4ED8" opacity="0.1"/>
                    <circle cx="150" cy="150" r="90" fill="#1D4ED8" opacity="0.2"/>
                    <circle cx="150" cy="150" r="60" fill="#1D4ED8" opacity="0.3"/>
                    <path d="M150 100 L180 130 L150 160 L120 130 Z" fill="#1D4ED8"/>
                    <path d="M150 140 L180 170 L150 200 L120 170 Z" fill="#10B981"/>
                    
                    <!-- Accent dots -->
                    <circle cx="100" cy="100" r="4" fill="#EF4444" opacity="0.8"/>
                    <circle cx="200" cy="80" r="3" fill="#10B981" opacity="0.8"/>
                    <circle cx="220" cy="180" r="5" fill="#EF4444" opacity="0.8"/>
                    <circle cx="80" cy="200" r="3" fill="#10B981" opacity="0.8"/>
                </svg>
            </div>
        </div>
    </div>
</body>
</html>