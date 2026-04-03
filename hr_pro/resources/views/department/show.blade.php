<h2>Department Details</h2>

<p>Name: {{ $department->name }}</p>
<p>Description: {{ $department->description }}</p>
<p>Manager ID: {{ $department->manager_id }}</p>

<a href="{{ route('departments.index') }}">Back</a>