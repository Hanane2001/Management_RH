@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Documents Management</h1>
    
    <div class="mb-3">
        @can('create', App\Models\Document::class)
            <a href="{{ route('documents.create') }}" class="btn btn-primary">+ Upload Document</a>
        @endcan
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Employee</th>
                            <th>Document Name</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Uploaded</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $document)
                        <tr>
                            <td>{{ $document->getIcon() }}</td>
                            <td>
                                <a href="{{ route('employees.show', $document->employee_id) }}">
                                    {{ $document->employee->first_name }} {{ $document->employee->last_name }}
                                </a>
                            </td>
                            <td>{{ $document->file_name }}</td>
                            <td>{!! $document->getTypeBadge() !!}</td>
                            <td>{{ $document->getFileSizeFormatted() }}</td>
                            <td>{{ $document->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('documents.show', $document) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-success">Download</a>
                                    @can('update', $document)
                                        <a href="{{ route('documents.edit', $document) }}" class="btn btn-sm btn-warning">Edit</a>
                                    @endcan
                                    @can('delete', $document)
                                        <form action="{{ route('documents.destroy', $document) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this document?')">Delete</button>
                                        </form>
                                    @endcan
                                </div>
                             </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No documents found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $documents->links() }}
        </div>
    </div>
</div>
@endsection