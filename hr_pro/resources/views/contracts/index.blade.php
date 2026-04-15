@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-xl font-bold mb-4">Contracts</h1>

    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
        <a href="{{ route('contracts.create') }}" class="bg-blue-500 text-white px-3 py-1 rounded">
            Add Contract
        </a>
    @endif

    <table class="w-full mt-4 border">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Type</th>
                <th>Salary</th>
                <th>Position</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        @foreach($contracts as $contract)
            <tr class="border-t">
                <td>{{ $contract->employee->first_name }} {{ $contract->employee->last_name }}</td>
                <td>{{ $contract->type }}</td>
                <td>{{ $contract->base_salary }}</td>
                <td>{{ $contract->position }}</td>

                <td class="flex gap-2">
                    <a href="{{ route('contracts.show', $contract->id) }}">View</a>

                    @if(auth()->user()->isAdmin() || auth()->user()->isManager())
                        <a href="{{ route('contracts.edit', $contract->id) }}">Edit</a>

                        <form method="POST" action="{{ route('contracts.destroy', $contract->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection