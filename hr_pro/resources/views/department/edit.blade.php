<h2>Edit Department</h2>

<form action="{{ route('departments.update', $department->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $department->name }}"><br><br>

    <textarea name="description">{{ $department->description }}</textarea><br><br>

    <input type="number" name="manager_id" value="{{ $department->manager_id }}"><br><br>

    <button type="submit">Update</button>
</form>

<a href="{{ route('departments.index') }}">Back</a>