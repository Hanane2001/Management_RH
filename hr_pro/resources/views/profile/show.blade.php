@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<style>
    .profile-grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 24px;
    }
    
    .profile-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
    }
    
    .card-header-custom {
        padding: 16px 20px;
        border-bottom: 1px solid #E5E7EB;
        background: #F9FAFB;
    }
    
    .card-header-custom h4 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .card-header-custom h4 i {
        color: #1D4ED8;
    }
    
    .card-body-custom {
        padding: 20px;
    }
    
    /* Profile Info Sidebar */
    .profile-avatar {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .profile-avatar i {
        font-size: 5rem;
        color: #9CA3AF;
    }
    
    .profile-name {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.25rem;
        color: #1F2937;
        margin-bottom: 5px;
    }
    
    .profile-role {
        font-family: 'Roboto', sans-serif;
        font-size: 0.85rem;
        color: #6B7280;
        margin-bottom: 3px;
    }
    
    .profile-dept {
        font-family: 'Roboto', sans-serif;
        font-size: 0.8rem;
        color: #10B981;
    }
    
    .info-divider {
        margin: 20px 0;
        border-top: 1px solid #E5E7EB;
    }
    
    .info-row {
        display: flex;
        margin-bottom: 12px;
    }
    
    .info-label {
        width: 100px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
        color: #6B7280;
    }
    
    .info-value {
        flex: 1;
        font-family: 'Roboto', sans-serif;
        font-size: 0.85rem;
        color: #374151;
    }
    
    .btn-profile {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s;
        margin-bottom: 10px;
    }
    
    .btn-edit {
        background: #1D4ED8;
        color: white;
    }
    
    .btn-edit:hover {
        background: #1E3A8A;
    }
    
    .btn-password {
        background: #F3F4F6;
        color: #374151;
    }
    
    .btn-password:hover {
        background: #E5E7EB;
        color: #1F2937;
    }
    
    /* Stats Cards */
    .stats-grid-mini {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }
    
    .stat-mini {
        background: #F9FAFB;
        border-radius: 12px;
        padding: 12px;
        text-align: center;
        border: 1px solid #E5E7EB;
    }
    
    .stat-mini h5 {
        font-family: 'Inter', sans-serif;
        font-size: 0.7rem;
        font-weight: 500;
        color: #6B7280;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
    
    .stat-mini h3 {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #1F2937;
        margin: 0;
    }
    
    /* Progress */
    .leave-balance {
        margin-top: 20px;
    }
    
    .leave-label {
        display: flex;
        justify-content: space-between;
        font-family: 'Roboto', sans-serif;
        font-size: 0.8rem;
        margin-bottom: 8px;
    }
    
    .progress-custom {
        height: 8px;
        background: #E5E7EB;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
    }
    
    .progress-used {
        background: #EF4444;
        transition: width 0.3s;
    }
    
    .progress-remaining {
        background: #10B981;
        transition: width 0.3s;
    }
    
    /* Activities */
    .activity-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .activity-item {
        padding: 12px 0;
        border-bottom: 1px solid #F3F4F6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-info strong {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        color: #1F2937;
    }
    
    .activity-info small {
        font-family: 'Roboto', sans-serif;
        font-size: 0.7rem;
        color: #6B7280;
        display: block;
        margin-top: 3px;
    }
    
    .badge-status {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-pending {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .badge-approved {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .badge-rejected {
        background: #FEE2E2;
        color: #991B1B;
    }
    
    .empty-activities {
        text-align: center;
        padding: 30px;
        color: #9CA3AF;
        font-family: 'Roboto', sans-serif;
        font-size: 0.85rem;
    }
    
    @media (max-width: 768px) {
        .profile-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }
</style>

<div class="container-fluid">
    <div class="profile-grid">
        <div>
            <div class="profile-card">
                <div class="card-header-custom">
                    <h4><i class="fas fa-user-circle"></i> Profile Information</h4>
                </div>
                <div class="card-body-custom">
                    <div class="profile-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="text-center">
                        <div class="profile-name">{{ $user->getFullName() }}</div>
                        <div class="profile-role">{{ ucfirst($user->role->name ?? 'N/A') }}</div>
                        <div class="profile-dept">
                            <i class="fas fa-building"></i> {{ $user->department->name ?? 'No Department' }}
                        </div>
                    </div>
                    
                    <div class="info-divider"></div>
                    
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $user->phone ?? '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Birth Date</div>
                        <div class="info-value">{{ $user->birth_date ? $user->birth_date->format('d/m/Y') : '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Address</div>
                        <div class="info-value">{{ $user->address ?? '—' }}</div>
                    </div>
                    
                    <div class="info-divider"></div>
                    
                    <a href="{{ route('profile.edit') }}" class="btn-profile btn-edit">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                    <a href="{{ route('profile.change-password') }}" class="btn-profile btn-password">
                        <i class="fas fa-key"></i> Change Password
                    </a>
                </div>
            </div>
        </div>

        <div>
            <div class="profile-card" style="margin-bottom: 24px;">
                <div class="card-header-custom">
                    <h4><i class="fas fa-chart-line"></i> Statistics</h4>
                </div>
                <div class="card-body-custom">
                    <div class="stats-grid-mini">
                        <div class="stat-mini">
                            <h5>Total Leaves</h5>
                            <h3>{{ $stats['total_leaves'] }}</h3>
                        </div>
                        <div class="stat-mini">
                            <h5>Approved</h5>
                            <h3>{{ $stats['approved_leaves'] }}</h3>
                        </div>
                        <div class="stat-mini">
                            <h5>Pending</h5>
                            <h3>{{ $stats['pending_leaves'] }}</h3>
                        </div>
                        <div class="stat-mini">
                            <h5>Contracts</h5>
                            <h3>{{ $stats['contracts_count'] }}</h3>
                        </div>
                    </div>
                    
                    @if(isset($stats['leave_balance']))
                    <div class="leave-balance">
                        <div class="leave-label">
                            <span>Leave balance</span>
                            <span>{{ $stats['used_leave_days'] }} / {{ $stats['total_leave_days'] }} days used</span>
                        </div>
                        <div class="progress-custom">
                            @php
                                $usedPercent = $stats['total_leave_days'] > 0 ? ($stats['used_leave_days'] / $stats['total_leave_days']) * 100 : 0;
                                $remainingPercent = $stats['total_leave_days'] > 0 ? ($stats['leave_balance'] / $stats['total_leave_days']) * 100 : 0;
                            @endphp
                            <div class="progress-used" style="width: {{ $usedPercent }}%"></div>
                            <div class="progress-remaining" style="width: {{ $remainingPercent }}%"></div>
                        </div>
                        <div class="leave-label" style="margin-top: 8px;">
                            <span>Remaining: <strong style="color: #10B981;">{{ $stats['leave_balance'] }} days</strong></span>
                            <span>Used: <strong style="color: #EF4444;">{{ $stats['used_leave_days'] }} days</strong></span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="profile-card">
                <div class="card-header-custom">
                    <h4><i class="fas fa-history"></i> Recent Activities</h4>
                </div>
                <div class="card-body-custom">
                    @php
                        $recentLeaves = $user->leaves()->latest()->limit(5)->get();
                    @endphp
                    
                    @if($recentLeaves->count() > 0)
                        <ul class="activity-list">
                            @foreach($recentLeaves as $leave)
                            <li class="activity-item">
                                <div class="activity-info">
                                    <strong>{{ ucfirst($leave->type) }} Leave</strong>
                                    <small>{{ $leave->start_date->format('d/m/Y') }} → {{ $leave->end_date->format('d/m/Y') }}</small>
                                </div>
                                <span class="badge-status 
                                    @if($leave->status == 'pending') badge-pending
                                    @elseif($leave->status == 'approved') badge-approved
                                    @else badge-rejected @endif">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="empty-activities">
                            <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                            No recent activities
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection