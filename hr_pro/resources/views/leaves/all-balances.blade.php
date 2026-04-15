@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Soldes de congés - Année {{ date('Y') }}</h1>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employé</th>
                <th>Département</th>
                <th>Total</th>
                <th>Utilisés</th>
                <th>Restant</th>
                <th>Utilisation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($balances as $balance)
            <tr>
                <td>{{ $balance->employee->first_name }} {{ $balance->employee->last_name }}</td>
                <td>{{ $balance->employee->department->name ?? 'N/A' }}</td>
                <td>{{ $balance->total_days }}</td>
                <td>{{ $balance->used_days }}</td>
                <td class="{{ $balance->remaining_days < 5 ? 'text-danger' : 'text-success' }}">
                    <strong>{{ $balance->remaining_days }}</strong>
                </td>
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
    
    {{ $balances->links() }}
    
    <a href="{{ route('leaves.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection