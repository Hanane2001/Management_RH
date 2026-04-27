@extends('layouts.app')

@section('title', 'Audit Log Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Audit Log Details</h3>
                    <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="35%">ID</th>
                                    <td>{{ $auditLog->id }}</a></td>
                                </tr>
                                <tr>
                                    <th>User</th>
                                    <td>
                                        @if($auditLog->user)
                                            {{ $auditLog->user->getFullName() }} ({{ $auditLog->user->email }})
                                        @else
                                            System
                                        @endif
                                    </a></td>
                                </tr>
                                <tr>
                                    <th>Action</th>
                                    <td>{!! $auditLog->getActionBadge() !!}</a></td>
                                </tr>
                                <tr>
                                    <th>Entity Type</th>
                                    <td>{{ $auditLog->entity_type }}</a></td>
                                </tr>
                                <tr>
                                    <th>Entity ID</th>
                                    <td>{{ $auditLog->entity_id }}</a></td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $auditLog->created_at->format('d/m/Y H:i:s') }}</a></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            @if($auditLog->old_values)
                            <div class="card mb-3">
                                <div class="card-header bg-warning">
                                    <h6 class="mb-0">Old Values</h6>
                                </div>
                                <div class="card-body">
                                    <pre class="mb-0" style="font-size: 12px;">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                            @endif
                            @if($auditLog->new_values)
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">New Values</h6>
                                </div>
                                <div class="card-body">
                                    <pre class="mb-0" style="font-size: 12px;">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($auditLog->action == 'update' && $auditLog->old_values && $auditLog->new_values)
                    <div class="mt-4">
                        <h5>Changes Summary</h5>
                        <table class="table table-bordered table-sm">
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
                                <tr class="table-warning">
                                    <td><strong>{{ $key }}</strong></a>
                                                                        <td>{{ is_array($auditLog->old_values[$key]) ? json_encode($auditLog->old_values[$key]) : $auditLog->old_values[$key] }}</a>
                                    <td>{{ is_array($value) ? json_encode($value) : $value }}</a>
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
    </div>
</div>
@endsection