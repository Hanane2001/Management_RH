@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des Congés</h1>
    
    <div class="mb-3">
        <a href="{{ route('leaves.create') }}" class="btn btn-primary">Nouvelle demande</a>
        <a href="{{ route('leaves.balance') }}" class="btn btn-info">Mon solde</a>
        @if(auth()->user()->isManager() || auth()->user()->isAdmin())
            <a href="{{ route('leaves.all-balances') }}" class="btn btn-secondary">Tous les soldes</a>
        @endif
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date demande</th>
                @if(auth()->user()->isManager() || auth()->user()->isAdmin())
                    <th>Employé</th>
                @endif
                <th>Type</th>
                <th>Période</th>
                <th>Durée</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaves as $leave)
            <tr>
                <td>{{ $leave->request_date->format('d/m/Y') }}</td>
                @if(auth()->user()->isManager() || auth()->user()->isAdmin())
                    <td>{{ $leave->employee->first_name }} {{ $leave->employee->last_name }}</td>
                @endif
                <td>
                    @if($leave->type == 'paid') Payé
                    @elseif($leave->type == 'sick') Maladie
                    @elseif($leave->type == 'unpaid') Non payé
                    @else Exceptionnel
                    @endif
                </td>
                <td>{{ $leave->start_date->format('d/m/Y') }} → {{ $leave->end_date->format('d/m/Y') }}</td>
                <td>{{ $leave->duration }} jour(s)</td>
                <td>
                    @if($leave->status == 'pending')
                        <span class="badge bg-warning">En attente</span>
                    @elseif($leave->status == 'approved')
                        <span class="badge bg-success">Approuvé</span>
                    @else
                        <span class="badge bg-danger">Refusé</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('leaves.show', $leave) }}" class="btn btn-sm btn-info">Voir</a>
                    
                    @if($leave->isPending() && (auth()->user()->isManager() || auth()->user()->isAdmin()))
                        <form action="{{ route('leaves.approve', $leave) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Approuver</button>
                        </form>
                        <form action="{{ route('leaves.reject', $leave) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Refuser</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $leaves->links() }}
</div>
@endsection