<h2>Create Department</h2>

<form action="{{ route('departments.store') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Name"><br><br>

    <textarea name="description" placeholder="Description"></textarea><br><br>

    <input type="number" name="manager_id" placeholder="Manager ID"><br><br>

    <button type="submit">Save</button>
</form>

<a href="{{ route('departments.index') }}">Back</a>