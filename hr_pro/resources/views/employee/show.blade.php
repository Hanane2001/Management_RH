@extends('layouts.app')

@section('content')
<h1>Employee Details</h1>

<p>Name: {{ $employee->first_name }} {{ $employee->last_name }}</p>
<p>Email: {{ $employee->email }}</p>
<p>Phone: {{ $employee->phone }}</p>
<p>Address: {{ $employee->address }}</p>
<p>Birth Date: {{ $employee->birth_date?->format('d-m-Y') }}</p>
<p>ID Number: {{ $employee->id_number }}</p>
<p>SSN: {{ $employee->social_security_number }}</p>
<p>Department: {{ $employee->department?->name }}</p>
<p>Role: {{ $employee->role->name }}</p>

<a href="{{ route('employees.edit', $employee->id) }}">Edit</a>
<a href="{{ route('employees.index') }}">Back to list</a>
@endsection