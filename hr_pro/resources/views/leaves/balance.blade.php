@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mon solde de congés</h1>
    
    @if($currentBalance)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>Année {{ $currentBalance->year }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="alert alert-info">
                            <strong>Total:</strong> {{ $currentBalance->total_days }} jours
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-warning">
                            <strong>Utilisés:</strong> {{ $currentBalance->used_days }} jours
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-success">
                            <strong>Restant:</strong> {{ $currentBalance->remaining_days }} jours
                        </div>
                    </div>
                </div>
                
                <div class="progress mt-3">
                    <div class="progress-bar" role="progressbar" 
                         style="width: {{ $currentBalance->getUsedPercentage() }}%"
                         aria-valuenow="{{ $currentBalance->getUsedPercentage() }}" 
                         aria-valuemin="0" aria-valuemax="100">
                        {{ number_format($currentBalance->getUsedPercentage(), 1) }}%
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">Aucun solde trouvé pour l'année en cours</div>
    @endif
    
    <h3>Historique des soldes</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Année</th>
                <th>Total</th>
                <th>Utilisés</th>
                <th>Restant</th>
                <th>Utilisation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($balances as $balance)
            <tr>
                <td>{{ $balance->year }}</td>
                <td>{{ $balance->total_days }}</td>
                <td>{{ $balance->used_days }}</td>
                <td>{{ $balance->remaining_days }}</td>
                <td>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $balance->getUsedPercentage() }}%">
                            {{ number_format($balance->getUsedPercentage(), 1) }}%
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <a href="{{ route('leaves.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection