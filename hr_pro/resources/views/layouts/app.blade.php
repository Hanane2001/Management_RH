<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HR Management System')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|roboto:400,500,700" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #F3F4F6;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #1D4ED8 0%, #1E3A8A 100%);
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .sidebar-brand {
            padding: 24px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand h3 {
            color: white;
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 5px;
        }
        
        .sidebar-brand small {
            color: rgba(255,255,255,0.7);
            font-family: 'Roboto', sans-serif;
            font-size: 0.8rem;
        }
        
        .sidebar-nav {
            padding: 20px 0;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .nav-link i {
            width: 20px;
            font-size: 1.1rem;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            border-right: 3px solid #10B981;
        }
        
        .nav-link.text-danger {
            color: #FEE2E2 !important;
        }
        
        .nav-link.text-danger:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #FEE2E2 !important;
        }
        
        .badge-notification {
            background: #EF4444;
            color: white;
            border-radius: 20px;
            padding: 2px 8px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: auto;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 30px;
            min-height: 100vh;
        }
        
        /* Alert Styles */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-family: 'Roboto', sans-serif;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-success {
            background: #D1FAE5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }
        
        .alert-danger {
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }
        
        .alert-info {
            background: #DBEAFE;
            color: #1E40AF;
            border: 1px solid #BFDBFE;
        }
        
        .btn-close {
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: inherit;
            opacity: 0.6;
        }
        
        .btn-close:hover {
            opacity: 1;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .menu-toggle {
                display: block;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 1100;
                background: #1D4ED8;
                color: white;
                border: none;
                padding: 10px 15px;
                border-radius: 8px;
                cursor: pointer;
            }
        }
        
        @media (min-width: 769px) {
            .menu-toggle {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h3>HR System</h3>
            <small>{{ auth()->user()->getFullName() }}</small>
        </div>
        
        <div class="sidebar-nav">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.show') }}">
                <i class="fas fa-user"></i> My Profile
            </a>
            @can('viewAny', App\Models\User::class)
            <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                <i class="fas fa-users"></i> Employees
            </a>
            @endcan
            <a class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}" href="{{ route('departments.index') }}">
                <i class="fas fa-building"></i> Departments
            </a>
            <a class="nav-link {{ request()->routeIs('contracts.*') ? 'active' : '' }}" href="{{ route('contracts.index') }}">
                <i class="fas fa-file-signature"></i> Contracts
            </a>
            <a class="nav-link {{ request()->routeIs('leaves.*') ? 'active' : '' }}" href="{{ route('leaves.index') }}">
                <i class="fas fa-calendar-alt"></i> Leaves
            </a>
            <a class="nav-link {{ request()->routeIs('evaluations.*') ? 'active' : '' }}" href="{{ route('evaluations.index') }}">
                <i class="fas fa-star"></i> Evaluations
            </a>
            <a class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}" href="{{ route('documents.index') }}">
                <i class="fas fa-folder"></i> Documents
            </a>
            <a class="nav-link {{ request()->routeIs('attendances.*') ? 'active' : '' }}" href="{{ route('attendances.index') }}">
                <i class="fas fa-clock"></i> Attendance
            </a>
            <a class="nav-link {{ request()->routeIs('payrolls.*') ? 'active' : '' }}" href="{{ route('payrolls.index') }}">
                <i class="fas fa-money-bill"></i> Payrolls
            </a>
            <a class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                <i class="fas fa-bell"></i> Notifications
                @php
                    $unreadCount = auth()->user()->unreadNotifications()->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="badge-notification">{{ $unreadCount }}</span>
                @endif
            </a>
            @can('viewAny', App\Models\AuditLog::class)
            <a class="nav-link {{ request()->routeIs('audit-logs.*') ? 'active' : '' }}" href="{{ route('audit-logs.index') }}">
                <i class="fas fa-history"></i> Audit Logs
            </a>
            @endcan
            <div style="margin-top: 20px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link text-danger" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Main content -->
    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">&times;</button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">&times;</button>
            </div>
        @endif
        
        @yield('content')
    </main>
    
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        }

        document.querySelectorAll('.btn-close').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.alert').style.display = 'none';
            });
        });
    </script>
    @stack('scripts')
</body>
</html>