@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Nouvelle évaluation</h1>
    
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
            <form method="POST" action="{{ route('evaluations.store') }}">
                @csrf
                
                <div class="mb-3">
                    <label>Employé *</label>
                    <select name="employee_id" class="form-control" required>
                        <option value="">Sélectionner un employé</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Date d'évaluation *</label>
                        <input type="date" name="evaluation_date" class="form-control" value="{{ old('evaluation_date', date('Y-m-d')) }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Période *</label>
                        <input type="text" name="period" class="form-control" placeholder="Ex: Q1 2024, Janvier 2024, Annuel 2024" value="{{ old('period') }}" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label>Score global (%) *</label>
                    <input type="number" name="overall_score" class="form-control" min="0" max="100" step="1" value="{{ old('overall_score') }}" required>
                    <small class="text-muted">Score entre 0 et 100</small>
                </div>
                
                <div class="mb-3">
                    <label>Commentaires</label>
                    <textarea name="comments" class="form-control" rows="5" placeholder="Commentaires sur la performance...">{{ old('comments') }}</textarea>
                </div>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Créer l'évaluation</button>
                    <a href="{{ route('evaluations.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection