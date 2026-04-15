@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Statistiques des congés - {{ date('Y') }}</h1>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Employés</h5>
                    <h2>{{ $stats['total_employees'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>Soldes créés</h5>
                    <h2>{{ $stats['total_balances'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Jours alloués</h5>
                    <h2>{{ $stats['total_days_allocated'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5>Jours utilisés</h5>
                    <h2>{{ $stats['total_days_used'] }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5>Alertes - Solde faible (&lt; 5 jours)</h5>
                </div>
                <div class="card-body">
                    <h3>{{ $stats['employees_with_low_balance'] }} employés</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5>Solde épuisé</h5>
                </div>
                <div class="card-body">
                    <h3>{{ $stats['employees_with_zero_balance'] }} employés</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h5>Employés avec solde faible (&lt; 5 jours)</h5>
        </div>
        <div class="card-body">
            @if($lowBalances->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Employé</th>
                            <th>Département</th>
                            <th>Solde restant</th>
                            <th>Utilisation</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowBalances as $balance)
                        <tr>
                            <td>{{ $balance->employee->first_name }} {{ $balance->employee->last_name }}</td>
                            <td>{{ $balance->employee->department->name ?? 'N/A' }}</td>
                            <td class="text-danger fw-bold">{{ $balance->remaining_days }} jours</td>
                            <td>{{ number_format($balance->getUsedPercentage(), 1) }}%</td>
                            <td>
                                <a href="{{ route('leave-balances.show', $balance) }}" class="btn btn-sm btn-info">Voir</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-success">Aucun employé avec solde faible</p>
            @endif
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('leave-balances.index') }}" class="btn btn-secondary">Retour</a>
        <a href="{{ route('leave-balances.export') }}" class="btn btn-success">Exporter CSV</a>
    </div>
</div>
@endsection