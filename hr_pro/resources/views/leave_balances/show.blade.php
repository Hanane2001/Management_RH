@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détail du solde de congés</h1>
    
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>{{ $leaveBalance->employee->first_name }} {{ $leaveBalance->employee->last_name }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th>Année</th>
                            <td>{{ $leaveBalance->year }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $leaveBalance->employee->email }}</td>
                        </tr>
                        <tr>
                            <th>Département</th>
                            <td>{{ $leaveBalance->employee->department->name ?? 'Non assigné' }}</td>
                        </tr>
                        <tr>
                            <th>Date de création</th>
                            <td>{{ $leaveBalance->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Dernière modification</th>
                            <td>{{ $leaveBalance->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h3>Solde de congés {{ $leaveBalance->year }}</h3>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="alert alert-info">
                                        <h5>Total</h5>
                                        <h2>{{ $leaveBalance->total_days }}</h2>
                                        <small>jours</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-warning">
                                        <h5>Utilisés</h5>
                                        <h2>{{ $leaveBalance->used_days }}</h2>
                                        <small>jours</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-success">
                                        <h5>Restant</h5>
                                        <h2>{{ $leaveBalance->remaining_days }}</h2>
                                        <small>jours</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="progress mt-3" style="height: 30px;">
                                <div class="progress-bar {{ $leaveBalance->getUsedPercentage() > 80 ? 'bg-danger' : ($leaveBalance->getUsedPercentage() > 50 ? 'bg-warning' : 'bg-success') }}" 
                                     role="progressbar" 
                                     style="width: {{ $leaveBalance->getUsedPercentage() }}%"
                                     aria-valuenow="{{ $leaveBalance->getUsedPercentage() }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ number_format($leaveBalance->getUsedPercentage(), 1) }}% utilisé
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('leave-balances.index') }}" class="btn btn-secondary">Retour à la liste</a>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('leave-balances.edit', $leaveBalance) }}" class="btn btn-warning">Modifier</a>
        @endif
    </div>
</div>
@endsection