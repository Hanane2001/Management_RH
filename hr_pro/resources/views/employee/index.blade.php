@extends('layouts.app')

@section('content')
<h1>Employees List</h1>
<table>
    <thead>
        <tr>
            <th>First Name</th><th>Last Name</th><th>Email</th><th>Role</th><th>Department</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employees as $employee)
        <tr>
            <td>{{ $employee->first_name }}</td>
            <td>{{ $employee->last_name }}</td>
            <td>{{ $employee->email }}</td>
            <td>{{ $employee->role->name }}</td>
            <td>{{ $employee->department?->name }}</td>
            <td>
                <a href="{{ route('employees.show', $employee->id) }}">View</a>
                <a href="{{ route('employees.edit', $employee->id) }}">Edit</a>
                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $employees->links() }}
@endsection