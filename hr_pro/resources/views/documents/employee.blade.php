@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Documents of {{ $employee->first_name }} {{ $employee->last_name }}</h1>
    
    <div class="mb-3">
        <a href="{{ route('documents.create') }}" class="btn btn-primary">+ Upload Document for this Employee</a>
        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary">Back to Employee</a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Icon</th>
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
                            <td>{{ $document->file_name }}</td>
                            <td>{!! $document->getTypeBadge() !!}</td>
                            <td>{{ $document->getFileSizeFormatted() }}</td>
                            <td>{{ $document->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('documents.show', $document) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-success">Download</a>
                                @can('delete', $document)
                                    <form action="{{ route('documents.destroy', $document) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this document?')">Delete</button>
                                    </form>
                                @endcan
                             </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No documents found for this employee</td>
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