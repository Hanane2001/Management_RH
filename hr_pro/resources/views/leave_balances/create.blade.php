@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer un solde de congés</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('leave-balances.store') }}">
                @csrf
                
                <div class="form-group mb-3">
                    <label>Employé *</label>
                    <select name="employee_id" class="form-control" required>
                        <option value="">Sélectionner un employé</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }} - {{ $employee->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label>Année *</label>
                    <select name="year" class="form-control" required>
                        @for($year = date('Y')-2; $year <= date('Y')+1; $year++)
                            <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : ($year == date('Y') ? 'selected' : '') }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label>Total des jours *</label>
                    <input type="number" name="total_days" class="form-control" value="{{ old('total_days', 30) }}" min="1" max="365" required>
                    <small class="text-muted">Nombre total de jours de congé pour l'année</small>
                </div>
                
                <div class="form-group mb-3">
                    <label>Jours déjà utilisés *</label>
                    <input type="number" name="used_days" class="form-control" value="{{ old('used_days', 0) }}" min="0" required>
                </div>
                
                <div class="alert alert-info">
                    <strong>Solde restant:</strong> <span id="remaining_days">0</span> jours
                </div>
                
                <button type="submit" class="btn btn-primary">Créer le solde</button>
                <a href="{{ route('leave-balances.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelector('input[name="total_days"], input[name="used_days"]').forEach(input => {
        input.addEventListener('input', calculateRemaining);
    });
    
    function calculateRemaining() {
        const total = parseInt(document.querySelector('input[name="total_days"]').value) || 0;
        const used = parseInt(document.querySelector('input[name="used_days"]').value) || 0;
        const remaining = total - used;
        document.getElementById('remaining_days').textContent = remaining;
        if(remaining < 0) {
            document.getElementById('remaining_days').style.color = 'red';
        } else {
            document.getElementById('remaining_days').style.color = 'green';
        }
    }
    
    calculateRemaining();
</script>
@endsection