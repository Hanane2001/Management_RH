@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Audit Log Details</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Log #{{ $auditLog->id }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Field</th>
                            <th>Value</th>
                        </tr>
                        <tr>
                            <td>ID</th>
                            <td>{{ $auditLog->id }}</td>
                        </tr>
                        <tr>
                            <td>User</th>
                            <td>
                                @if($auditLog->user)
                                    {{ $auditLog->user->first_name }} {{ $auditLog->user->last_name }}
                                    ({{ $auditLog->user->email }})
                                @else
                                    System
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Action</th>
                            <td>{!! $auditLog->getActionBadge() !!}</td>
                        </tr>
                        <tr>
                            <td>Entity Type</th>
                            <td>{{ $auditLog->getEntityIcon() }} {{ $auditLog->entity_type }}</td>
                        </tr>
                        <tr>
                            <td>Entity ID</th>
                            <td>{{ $auditLog->entity_id ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Created At</th>
                            <td>{{ $auditLog->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Actions</h5>
                </div>
                <div class="card-body">
                    @if($auditLog->entity_id)
                        <a href="{{ route('audit-logs.entity', [$auditLog->entity_type, $auditLog->entity_id]) }}" 
                           class="btn btn-secondary w-100 mb-2">
                            View All History for this Entity
                        </a>
                    @endif
                    
                    @if($auditLog->user_id)
                        <a href="{{ route('audit-logs.user', $auditLog->user_id) }}" 
                           class="btn btn-info w-100">
                            View All Activity by this User
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    @if($auditLog->old_values || $auditLog->new_values)
    <div class="card mt-4">
        <div class="card-header bg-warning">
            <h4>Data Changes</h4>
        </div>
        <div class="card-body">
            <div class="row">
                @if($auditLog->old_values)
                <div class="col-md-6">
                    <h5>Old Values</h5>
                    <table class="table table-bordered table-sm">
                        @foreach($auditLog->old_values as $key => $value)
                        <tr>
                            <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                            <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
                
                @if($auditLog->new_values)
                <div class="col-md-6">
                    <h5>New Values</h5>
                    <table class="table table-bordered table-sm">
                        @foreach($auditLog->new_values as $key => $value)
                        <tr>
                            <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                            <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
    
    <div class="mt-3">
        <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary">Back to Logs</a>
    </div>
</div>
@endsection