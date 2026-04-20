@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Document Details</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Document Information</h4>
                </div>
                <div class="card-body">
                    <p><strong>Employee:</strong> {{ $document->employee->first_name }} {{ $document->employee->last_name }}</p>
                    <p><strong>Document Name:</strong> {{ $document->file_name }}</p>
                    <p><strong>Type:</strong> {!! $document->getTypeBadge() !!}</p>
                    <p><strong>File Size:</strong> {{ $document->getFileSizeFormatted() }}</p>
                    <p><strong>MIME Type:</strong> {{ $document->mime_type }}</p>
                    <p><strong>Uploaded:</strong> {{ $document->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Last Update:</strong> {{ $document->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4>Preview & Actions</h4>
                </div>
                <div class="card-body text-center">
                    <div style="font-size: 80px;">{{ $document->getIcon() }}</div>
                    <h5>{{ $document->file_name }}</h5>
                    
                    <div class="mt-3">
                        <a href="{{ route('documents.download', $document) }}" class="btn btn-success">
                            Download Document
                        </a>
                        
                        @can('update', $document)
                            <a href="{{ route('documents.edit', $document) }}" class="btn btn-warning">
                                Edit
                            </a>
                        @endcan
                        
                        @can('delete', $document)
                            <form action="{{ route('documents.destroy', $document) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this document?')">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <a href="{{ route('documents.index') }}" class="btn btn-secondary">Back to Documents</a>
    </div>
</div>
@endsection