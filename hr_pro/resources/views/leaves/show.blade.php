@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détail de la demande de congé</h1>
    
    <div class="card">
        <div class="card-body">
            <p><strong>Employé:</strong> {{ $leave->employee->first_name }} {{ $leave->employee->last_name }}</p>
            <p><strong>Type:</strong> 
                @if($leave->type == 'paid') Congé payé
                @elseif($leave->type == 'sick') Congé maladie
                @elseif($leave->type == 'unpaid') Congé sans solde
                @else Congé exceptionnel
                @endif
            </p>
            <p><strong>Période:</strong> {{ $leave->start_date->format('d/m/Y') }} → {{ $leave->end_date->format('d/m/Y') }}</p>
            <p><strong>Durée:</strong> {{ $leave->duration }} jour(s)</p>
            <p><strong>Motif:</strong> {{ $leave->reason ?? 'Non spécifié' }}</p>
            <p><strong>Statut:</strong>
                @if($leave->status == 'pending')
                    <span class="badge bg-warning">En attente</span>
                @elseif($leave->status == 'approved')
                    <span class="badge bg-success">Approuvé</span>
                @else
                    <span class="badge bg-danger">Refusé</span>
                @endif
            </p>
            <p><strong>Date de demande:</strong> {{ $leave->request_date->format('d/m/Y H:i') }}</p>
            
            @if($leave->processed_date)
                <p><strong>Traité le:</strong> {{ $leave->processed_date->format('d/m/Y H:i') }}</p>
                <p><strong>Traité par:</strong> {{ $leave->processedBy->first_name ?? '' }} {{ $leave->processedBy->last_name ?? '' }}</p>
            @endif
        </div>
    </div>
    
    <br>
    <a href="{{ route('leaves.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection