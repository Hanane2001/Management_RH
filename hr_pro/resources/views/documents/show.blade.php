@extends('layouts.app')

@section('title', 'Document Details')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Document Details</h3>
                    <a href="{{ route('documents.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Employee</th>
                                    <td>{{ $document->employee->getFullName() }}</td>
                                </tr>
                                <tr>
                                    <th>Document Type</th>
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
                                </tr>
                                <tr>
                                    <th>File Name</th>
                                    <td>{{ $document->file_name }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">File Size</th>
                                    <td>{{ $document->getFileSizeFormatted() }}</td>
                                </tr>
                                <tr>
                                    <th>MIME Type</th>
                                    <td>{{ $document->mime_type ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Uploaded Date</th>
                                    <td>{{ $document->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        @if(in_array(pathinfo($document->file_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                            <img src="{{ $document->getFileUrl() }}" alt="Document Preview" class="img-fluid" style="max-height: 400px;">
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-file-pdf fa-3x"></i>
                                <p>Preview not available for this file type.</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('documents.download', $document) }}" class="btn btn-success">
                            <i class="fas fa-download"></i> Download
                        </a>
                        @can('update', $document)
                        <a href="{{ route('documents.edit', $document) }}" class="btn btn-warning">Edit</a>
                        @endcan
                        @can('delete', $document)
                        <form method="POST" action="{{ route('documents.destroy', $document) }}" class="d-inline" 
                              onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection