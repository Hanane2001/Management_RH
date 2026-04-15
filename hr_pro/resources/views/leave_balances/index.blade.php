@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des Soldes de Congés</h1>
    
    <div class="mb-3">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('leave-balances.create') }}" class="btn btn-primary">Nouveau solde</a>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#initializeModal">
                Initialiser l'année
            </button>
            <a href="{{ route('leave-balances.export') }}" class="btn btn-info">Exporter CSV</a>
            <a href="{{ route('leave-balances.statistics') }}" class="btn btn-secondary">Statistiques</a>
        @endif
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card">
        <div class="card-header">
            <h4>Soldes - Année {{ date('Y') }}</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Employé</th>
                        <th>Email</th>
                        <th>Département</th>
                        <th>Total (jours)</th>
                        <th>Utilisés</th>
                        <th>Restant</th>
                        <th>Utilisation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($balances as $balance)
                    <tr>
                        <td>{{ $balance->employee->first_name }} {{ $balance->employee->last_name }}</td>
                        <td>{{ $balance->employee->email }}</td>
                        <td>{{ $balance->employee->department->name ?? 'N/A' }}</td>
                        <td>{{ $balance->total_days }}</td>
                        <td>{{ $balance->used_days }}</td>
                        <td class="{{ $balance->remaining_days < 5 ? 'text-danger fw-bold' : 'text-success' }}">
                            {{ $balance->remaining_days }}
                        </td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar {{ $balance->getUsedPercentage() > 80 ? 'bg-danger' : ($balance->getUsedPercentage() > 50 ? 'bg-warning' : 'bg-success') }}" 
                                     role="progressbar" 
                                     style="width: {{ $balance->getUsedPercentage() }}%"
                                     aria-valuenow="{{ $balance->getUsedPercentage() }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ number_format($balance->getUsedPercentage(), 1) }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('leave-balances.show', $balance) }}" class="btn btn-sm btn-info">Voir</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('leave-balances.edit', $balance) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addDaysModal{{ $balance->id }}">
                                    + Jours
                                </button>
                                <form action="{{ route('leave-balances.destroy', $balance) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce solde ?')">Supprimer</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Modal Add Days -->
                    @if(auth()->user()->isAdmin())
                    <div class="modal fade" id="addDaysModal{{ $balance->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('leave-balances.add-days', $balance) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ajouter des jours - {{ $balance->employee->first_name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nombre de jours à ajouter</label>
                                            <input type="number" name="days" class="form-control" min="1" required>
                                        </div>
                                        <div class="alert alert-info mt-2">
                                            Solde actuel: {{ $balance->remaining_days }} jours
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary">Ajouter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Aucun solde trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            {{ $balances->links() }}
        </div>
    </div>
</div>

<!-- Modal Initialize Year -->
@if(auth()->user()->isAdmin())
<div class="modal fade" id="initializeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('leave-balances.initialize') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Initialiser les soldes pour {{ date('Y') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Cette action va créer des soldes pour tous les employés qui n'en ont pas pour l'année {{ date('Y') }}.</p>
                    <div class="alert alert-warning">
                        <strong>Attention:</strong> Les employés qui ont déjà un solde ne seront pas modifiés.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Initialiser</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection