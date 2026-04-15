@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nouvelle demande de congé</h1>
    
    <div class="alert alert-info">
        <strong>Solde disponible:</strong> {{ $balance->remaining_days }} jours sur {{ $balance->total_days }}
    </div>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="POST" action="{{ route('leaves.store') }}">
        @csrf
        
        <div class="form-group">
            <label>Type de congé *</label>
            <select name="type" class="form-control" required>
                <option value="">Sélectionner</option>
                <option value="paid">Congé payé</option>
                <option value="sick">Congé maladie</option>
                <option value="unpaid">Congé sans solde</option>
                <option value="exceptional">Congé exceptionnel</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Date début *</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Date fin *</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Motif</label>
            <textarea name="reason" class="form-control" rows="3" placeholder="Expliquez la raison de votre demande..."></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Envoyer la demande</button>
        <a href="{{ route('leaves.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection