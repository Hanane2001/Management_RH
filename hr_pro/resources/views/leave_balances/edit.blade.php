@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le solde de congés</h1>
    
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
            <form method="POST" action="{{ route('leave-balances.update', $leaveBalance) }}">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label>Employé *</label>
                    <select name="employee_id" class="form-control" required>
                        <option value="">Sélectionner un employé</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id', $leaveBalance->employee_id) == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }} - {{ $employee->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label>Année *</label>
                    <select name="year" class="form-control" required>
                        @for($year = date('Y')-2; $year <= date('Y')+1; $year++)
                            <option value="{{ $year }}" {{ old('year', $leaveBalance->year) == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label>Total des jours *</label>
                    <input type="number" name="total_days" class="form-control" value="{{ old('total_days', $leaveBalance->total_days) }}" min="1" max="365" required>
                </div>
                
                <div class="form-group mb-3">
                    <label>Jours déjà utilisés *</label>
                    <input type="number" name="used_days" class="form-control" value="{{ old('used_days', $leaveBalance->used_days) }}" min="0" required>
                </div>
                
                <div class="alert alert-info">
                    <strong>Solde restant actuel:</strong> {{ $leaveBalance->remaining_days }} jours<br>
                    <strong>Nouveau solde restant:</strong> <span id="remaining_days">{{ $leaveBalance->remaining_days }}</span> jours
                </div>
                
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('leave-balances.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>

<script>
    const totalInput = document.querySelector('input[name="total_days"]');
    const usedInput = document.querySelector('input[name="used_days"]');
    const remainingSpan = document.getElementById('remaining_days');
    
    function calculateRemaining() {
        const total = parseInt(totalInput.value) || 0;
        const used = parseInt(usedInput.value) || 0;
        const remaining = total - used;
        remainingSpan.textContent = remaining;
        remainingSpan.style.color = remaining < 0 ? 'red' : 'green';
    }
    
    totalInput.addEventListener('input', calculateRemaining);
    usedInput.addEventListener('input', calculateRemaining);
</script>
@endsection