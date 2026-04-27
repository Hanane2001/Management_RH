@extends('layouts.app')

@section('title', 'Employee Documents')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Documents for {{ $employee->getFullName() }}</h3>
                    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary float-end">Back to Employee</a>
                    @can('create', App\Models\Document::class)
                    <a href="{{ route('documents.create') }}?employee_id={{ $employee->id }}" class="btn btn-primary float-end me-2">
                        <i class="fas fa-upload"></i> Upload Document
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>File Name</th>
                                    <th>Size</th>
                                    <th>Uploaded</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $document)
                                <tr>
                                    <td>{{ $document->id }}</td>
                                    <td>
                                        @if($document->type == 'cv')
                                            <span class="badge bg-info">CV</span>
                                        @elseif($document->type == 'contract')
                                            <span class="badge bg-primary">Contract</span>
                                        @elseif($document->type == 'attestation')
                                            <span class="badge bg-success">Attestation</span>
                                        @else
                                            <span class="badge bg-secondary">Other</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="fas {{ $document->getIcon() }}"></i>
                                        {{ $document->file_name }}
                                    </td>
                                    <td>{{ $document->getFileSizeFormatted() }}</td>
                                    <td>{{ $document->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('documents.show', $document) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        @can('update', $document)
                                        <a href="{{ route('documents.edit', $document) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('delete', $document)
                                        <form method="POST" action="{{ route('documents.destroy', $document) }}" class="d-inline" 
                                              onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No documents found for this employee</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $documents->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection