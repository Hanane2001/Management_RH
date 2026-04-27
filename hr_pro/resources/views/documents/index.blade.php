@extends('layouts.app')

@section('title', 'Documents')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Documents Management</h3>
                    @can('create', App\Models\Document::class)
                    <a href="{{ route('documents.create') }}" class="btn btn-primary float-end">
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
                                    <th>Employee</th>
                                    <th>Type</th>
                                    <th>File Name</th>
                                    <th>Size</th>
                                    <th>Uploaded</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                <tr>
                                    <td>{{ $document->id }}</a></td>
                                    <td><a href="{{ route('employees.show', $document->employee_id) }}">
                                        {{ $document->employee->getFullName() }}
                                    </a></a></td>
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
                                    </a></td>
                                    <td>
                                        {{ $document->file_name }}
                                    </a></td>
                                    <td>{{ $document->getFileSizeFormatted() }}</a></td>
                                    <td>{{ $document->created_at->format('d/m/Y') }}</a></td>
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
                                    </a>
                                                                        </td>
                                </tr>
                                @endforeach
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