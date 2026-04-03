<h2>Departments List</h2>

<a href="{{ route('departments.create') }}">Add Department</a>

<hr>

@foreach($departments as $dep)
    <div style="margin-bottom:10px;">
        <strong>{{ $dep->name }}</strong><br>
        {{ $dep->description }}<br>
        Manager ID: {{ $dep->manager_id }}

        <br>

        <a href="{{ route('departments.edit', $dep->id) }}">Edit</a>

        <form action="{{ route('departments.destroy', $dep->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </div>
@endforeach