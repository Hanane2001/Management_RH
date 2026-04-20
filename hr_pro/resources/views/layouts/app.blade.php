<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HR_PRO - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #1D4ED8;
        }
        .sidebar .nav-link {
            color: white;
        }
        .sidebar .nav-link:hover {
            background-color: #1e40af;
        }
        .navbar-brand {
            color: white !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block sidebar p-0">
                <div class="position-sticky">
                    <a class="navbar-brand d-block p-3 text-center" href="{{ route('dashboard') }}">
                        <h4>HR_PRO</h4>
                    </a>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                📊 Dashboard
                            </a>
                        </li>
                        
                        @can('isAdmin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('employees.index') }}">
                                👥 Employees
                            </a>
                        </li>
                        @endcan
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('departments.index') }}">
                                🏢 Departments
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contracts.index') }}">
                                📄 Contracts
                            </a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                🏖️ Leaves
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('leaves.index') }}">My Requests</a></li>
                                <li><a class="dropdown-item" href="{{ route('leaves.create') }}">New Request</a></li>
                                <li><a class="dropdown-item" href="{{ route('leaves.balance') }}">My Balance</a></li>
                                @can('isManager')
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('leaves.all-balances') }}">All Balances</a></li>
                                @endcan
                            </ul>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                📊 Evaluations
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('evaluations.index') }}">All Evaluations</a></li>
                                @can('isManager')
                                    <li><a class="dropdown-item" href="{{ route('evaluations.create') }}">New Evaluation</a></li>
                                @endcan
                                @can('isAdmin')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('evaluations.statistics') }}">Statistics</a></li>
                                    <li><a class="dropdown-item" href="{{ route('evaluations.export') }}">Export CSV</a></li>
                                @endcan
                            </ul>
                        </li>
                        
                        @can('isAdmin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                ⚙️ Leave Balances
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('leave-balances.index') }}">All Balances</a></li>
                                <li><a class="dropdown-item" href="{{ route('leave-balances.create') }}">Create Balance</a></li>
                                <li><a class="dropdown-item" href="{{ route('leave-balances.statistics') }}">Statistics</a></li>
                            </ul>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('documents.index') }}">
                                📁 Documents
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('attendances.index') }}">
                                ⏰ Attendance
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
                    <div class="container-fluid">
                        <span class="navbar-brand">Welcome, {{ Auth::user()->first_name }}</span>
                        <div class="ms-auto">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>
                        </div>
                    </div>
                </nav>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>