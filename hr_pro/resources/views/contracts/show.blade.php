@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Contract Details</h1>

    @if($contract->employee)
        <p><strong>Employee:</strong> {{ $contract->employee->first_name }} {{ $contract->employee->last_name }}</p>
    @else
        <p><strong>Employee:</strong> Not found</p>
    @endif
    
    <p><strong>Type:</strong> {{ $contract->type }}</p>
    <p><strong>Base Salary:</strong> {{ $contract->base_salary }}</p>
    <p><strong>Bonus:</strong> {{ $contract->bonus }}</p>
    <p><strong>Position:</strong> {{ $contract->position }}</p>
    <p><strong>Start Date:</strong> {{ $contract->start_date }}</p>
    <p><strong>End Date:</strong> {{ $contract->end_date ?? 'Not specified' }}</p>

    @if($contract->document_path)
        <a href="{{ asset('storage/'.$contract->document_path) }}" target="_blank">View Document</a>
    @endif
    
    <br><br>
    <a href="{{ route('contracts.index') }}">Back to Contracts</a>
</div>
@endsection