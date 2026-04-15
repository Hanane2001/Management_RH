@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mon solde de congés</h1>
    
    @if($currentBalance)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4>Année en cours - {{ $currentBalance->year }}</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="alert alert-info">
                            <h5>Total</h5>
                            <h2 class="display-4">{{ $currentBalance->total_days }}</h2>
                            <p>jours</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-warning">
                            <h5>Utilisés</h5>
                            <h2 class="display-4">{{ $currentBalance->used_days }}</h2>
                            <p>jours</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert alert-success">
                            <h5>Restant</h5>
                            <h2 class="display-4">{{ $currentBalance->remaining_days }}</h2>
                            <p>jours</p>
                        </div>
                    </div>
                </div>
                
                <div class="progress mt-3" style="height: 35px;">
                    <div class="progress-bar {{ $currentBalance->getUsedPercentage() > 80 ? 'bg-danger' : ($currentBalance->getUsedPercentage() > 50 ? 'bg-warning' : 'bg-success') }}" 
                         role="progressbar" 
                         style="width: {{ $currentBalance->getUsedPercentage() }}%"
                         aria-valuenow="{{ $currentBalance->getUsedPercentage() }}" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                        {{ number_format($currentBalance->getUsedPercentage(), 1) }}% utilisé
                    </div>
                </div>
                
                <div class="mt-4">
                    <div class="alert alert-info">
                        <strong>Information:</strong> Vous pouvez demander un congé via l'onglet "Nouvelle demande" dans le menu Congés.
                    </div>
                </div>
            </div>
        </div>
        
        <h3>Historique des soldes</h3>
        <div class="table-responsive">
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
                        <td class="{{ $balance->remaining_days < 5 ? 'text-danger fw-bold' : '' }}">
                            {{ $balance->remaining_days }}
                        </td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar" style="width: {{ $balance->getUsedPercentage() }}%">
                                    {{ number_format($balance->getUsedPercentage(), 1) }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning">
            <strong>Aucun solde trouvé pour l'année {{ date('Y') }}</strong><br>
            Veuillez contacter votre administrateur pour initialiser votre solde de congés.
        </div>
    @endif
    
    <div class="mt-3">
        <a href="{{ route('leaves.create') }}" class="btn btn-primary">Faire une demande de congé</a>
        <a href="{{ route('leaves.index') }}" class="btn btn-info">Voir mes demandes</a>
    </div>
</div>
@endsection