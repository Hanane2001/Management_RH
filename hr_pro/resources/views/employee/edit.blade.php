@extends('layouts.app')

@section('content')
<h1>Edit Employee</h1>

<form action="{{ route('employees.update', $employee->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="first_name" value="{{ $employee->first_name }}" required>
    <input type="text" name="last_name" value="{{ $employee->last_name }}" required>
    <input type="email" name="email" value="{{ $employee->email }}" required>
    <input type="text" name="phone" value="{{ $employee->phone }}">
    <input type="text" name="address" value="{{ $employee->address }}">
    <input type="date" name="birth_date" value="{{ $employee->birth_date?->format('Y-m-d') }}">
    <input type="text" name="id_number" value="{{ $employee->id_number }}">
    <input type="text" name="social_security_number" value="{{ $employee->social_security_number }}">
    
    <button type="submit">Update Employee</button>
</form>
@endsection