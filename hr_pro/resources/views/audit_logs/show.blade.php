@extends('layouts.app')

@section('title', 'Audit Log Details')

@section('content')
<style>
    .details-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
    }
    
    .card-header-custom {
        padding: 20px 24px;
        border-bottom: 1px solid #E5E7EB;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .card-header-custom h3 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1.25rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .card-header-custom h3 i {
        color: #1D4ED8;
    }
    
    .btn-back {
        background: #F3F4F6;
        color: #374151;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-back:hover {
        background: #E5E7EB;
        color: #1F2937;
    }
    
    .card-body-custom {
        padding: 24px;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }
    
    .info-section {
        background: #F9FAFB;
        border-radius: 16px;
        padding: 20px;
    }
    
    .info-section h4 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        color: #1F2937;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #E5E7EB;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .info-section h4 i {
        color: #1D4ED8;
    }
    
    .info-row {
        display: flex;
        margin-bottom: 12px;
    }
    
    .info-label {
        width: 120px;
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
    
    .badge-action {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-create {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .badge-update {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .badge-delete {
        background: #FEE2E2;
        color: #991B1B;
    }
    
    .badge-login {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .values-box {
        background: #1F2937;
        border-radius: 12px;
        padding: 16px;
        margin-top: 12px;
    }
    
    .values-box pre {
        color: #10B981;
        font-family: 'Monaco', 'Menlo', monospace;
        font-size: 0.75rem;
        margin: 0;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    
    .changes-table {
        width: 100%;
        font-family: 'Roboto', sans-serif;
        border-collapse: collapse;
        margin-top: 16px;
    }
    
    .changes-table th {
        background: #F3F4F6;
        padding: 10px 12px;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6B7280;
        text-align: left;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .changes-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #F3F4F6;
        font-size: 0.8rem;
    }
    
    .changes-table tr.changed-row {
        background: #FEF3C7;
    }
    
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .card-header-custom {
            padding: 16px 20px;
        }
        
        .card-body-custom {
            padding: 20px;
        }
    }
</style>

<div class="container-fluid">
    <div class="details-card">
        <div class="card-header-custom">
            <h3>
                <i class="fas fa-history"></i> Audit Log Details
            </h3>
            <a href="{{ route('audit-logs.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Logs
            </a>
        </div>
        <div class="card-body-custom">
            <div class="info-grid">
                <div class="info-section">
                    <h4><i class="fas fa-info-circle"></i> Log Information</h4>
                    <div class="info-row">
                        <div class="info-label">ID</div>
                        <div class="info-value"><strong>#{{ $auditLog->id }}</strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">User</div>
                        <div class="info-value">
                            @if($auditLog->user)
                                <strong>{{ $auditLog->user->getFullName() }}</strong>
                                <div style="font-size: 0.75rem; color: #6B7280;">{{ $auditLog->user->email }}</div>
                            @else
                                <strong>System</strong>
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Action</div>
                        <div class="info-value">
                            @php
                                $badgeClass = match($auditLog->action) {
                                    'create' => 'badge-create',
                                    'update' => 'badge-update',
                                    'delete' => 'badge-delete',
                                    'login', 'logout', 'login_success' => 'badge-login',
                                    default => 'badge-other'
                                };
                            @endphp
                            <span class="badge-action {{ $badgeClass }}">
                                <i class="fas 
                                    @if($auditLog->action == 'create') fa-plus
                                    @elseif($auditLog->action == 'update') fa-edit
                                    @elseif($auditLog->action == 'delete') fa-trash
                                    @elseif($auditLog->action == 'login') fa-sign-in-alt
                                    @elseif($auditLog->action == 'logout') fa-sign-out-alt
                                    @else fa-clock @endif"></i>
                                {{ ucfirst($auditLog->action) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <h4><i class="fas fa-database"></i> Entity Information</h4>
                    <div class="info-row">
                        <div class="info-label">Entity Type</div>
                        <div class="info-value">{{ $auditLog->entity_type }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Entity ID</div>
                        <div class="info-value">#{{ $auditLog->entity_id }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Created At</div>
                        <div class="info-value">{{ $auditLog->created_at->format('d/m/Y H:i:s') }}</div>
                    </div>
                </div>
            </div>
            
            @if($auditLog->old_values || $auditLog->new_values)
            <div class="info-section" style="margin-bottom: 24px;">
                <h4><i class="fas fa-code"></i> Data Changes</h4>
                <div class="info-grid" style="grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 0;">
                    @if($auditLog->old_values)
                    <div class="values-box" style="background: #FEF2F2;">
                        <div style="color: #DC2626; font-size: 0.7rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase;">
                            <i class="fas fa-arrow-left"></i> Old Values
                        </div>
                        <pre>{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                    @endif
                    @if($auditLog->new_values)
                    <div class="values-box" style="background: #F0FDF4;">
                        <div style="color: #10B981; font-size: 0.7rem; font-weight: 600; margin-bottom: 8px; text-transform: uppercase;">
                            <i class="fas fa-arrow-right"></i> New Values
                        </div>
                        <pre>{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            @if($auditLog->action == 'update' && $auditLog->old_values && $auditLog->new_values)
            <div class="info-section">
                <h4><i class="fas fa-list-ul"></i> Changes Summary</h4>
                <table class="changes-table">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Old Value</th>
                            <th>New Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($auditLog->new_values as $key => $value)
                        @if(isset($auditLog->old_values[$key]) && $auditLog->old_values[$key] != $value)
                        <tr class="changed-row">
                            <td><strong>{{ $key }}</strong></td>
                            <td style="color: #DC2626;">
                                {{ is_array($auditLog->old_values[$key]) ? json_encode($auditLog->old_values[$key]) : $auditLog->old_values[$key] }}
                            </td>
                            <td style="color: #10B981;">
                                {{ is_array($value) ? json_encode($value) : $value }}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection