@extends('layouts.app')

@section('content')
<h1>Add Employee</h1>

<form action="{{ route('employees.store') }}" method="POST">
    @csrf
    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="text" name="last_name" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="text" name="phone" placeholder="Phone">
    <input type="text" name="address" placeholder="Address">
    <input type="date" name="birth_date" placeholder="Birth Date">
    <input type="text" name="id_number" placeholder="ID Number">
    <input type="text" name="social_security_number" placeholder="SSN">
    
    <button type="submit">Add Employee</button>
</form>
@endsection