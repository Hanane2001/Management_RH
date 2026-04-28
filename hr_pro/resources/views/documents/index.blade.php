@extends('layouts.app')

@section('title', 'Documents')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .page-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 1.5rem;
        color: #1F2937;
        margin: 0;
    }
    
    .btn-add {
        background: #1D4ED8;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .btn-add:hover {
        background: #1E3A8A;
        color: white;
    }
    
    .data-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .table-modern {
        width: 100%;
        font-family: 'Roboto', sans-serif;
        border-collapse: collapse;
    }
    
    .table-modern thead th {
        background: #F9FAFB;
        padding: 14px 16px;
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #E5E7EB;
        text-align: left;
    }
    
    .table-modern tbody td {
        padding: 14px 16px;
        font-size: 0.85rem;
        color: #374151;
        border-bottom: 1px solid #F3F4F6;
    }
    
    .table-modern tbody tr:hover td {
        background: #F9FAFB;
    }
    
    .badge-doc {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
    }
    
    .badge-cv {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .badge-contract {
        background: #F0FDF4;
        color: #10B981;
    }
    
    .badge-attestation {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .badge-other {
        background: #F3F4F6;
        color: #6B7280;
    }
    
    .action-buttons {
        display: flex;
        gap: 6px;
    }
    
    .btn-action {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 0.75rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-view {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    
    .btn-view:hover {
        background: #DBEAFE;
    }
    
    .btn-download {
        background: #F0FDF4;
        color: #10B981;
    }
    
    .btn-download:hover {
        background: #D1FAE5;
    }
    
    .btn-edit {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .btn-edit:hover {
        background: #FDE68A;
    }
    
    .btn-delete {
        background: #FEE2E2;
        color: #DC2626;
    }
    
    .btn-delete:hover {
        background: #FECACA;
    }
    
    .employee-link {
        color: #1D4ED8;
        text-decoration: none;
        font-weight: 500;
    }
    
    .employee-link:hover {
        text-decoration: underline;
    }
    
    .pagination-container {
        padding: 16px 20px;
        border-top: 1px solid #E5E7EB;
        background: #F9FAFB;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9CA3AF;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        display: block;
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .table-modern thead th,
        .table-modern tbody td {
            padding: 10px 12px;
        }
        
        .action-buttons {
            flex-wrap: wrap;
        }
    }
</style>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Documents Management</h1>
        @can('create', App\Models\Document::class)
        <a href="{{ route('documents.create') }}" class="btn-add">
            <i class="fas fa-cloud-upload-alt"></i> Upload Document
        </a>
        @endcan
    </div>
    
    <div class="data-card">
        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Type</th>
                        <th>File Name</th>
                        <th>Size</th>
                        <th>Uploaded</th>
                        <th style="width: 130px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                    <tr>
                        <td>
                            <a href="{{ route('employees.show', $document->employee_id) }}" class="employee-link">
                                {{ $document->employee->getFullName() }}
                            </a>
                        </a>
                        <td>
                            <span class="badge-doc 
                                @if($document->type == 'cv') badge-cv
                                @elseif($document->type == 'contract') badge-contract
                                @elseif($document->type == 'attestation') badge-attestation
                                @else badge-other @endif">
                                <i class="fas 
                                    @if($document->type == 'cv') fa-file-alt
                                    @elseif($document->type == 'contract') fa-file-signature
                                    @elseif($document->type == 'attestation') fa-certificate
                                    @else fa-file @endif"></i>
                                {{ ucfirst($document->type) }}
                            </span>
                        </a>
                        <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                            {{ $document->file_name }}
                        </a>
                        <td>{{ $document->getFileSizeFormatted() }}</a>
                        <td>{{ $document->created_at->format('d/m/Y') }}</a>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('documents.show', $document) }}" class="btn-action btn-view" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('documents.download', $document) }}" class="btn-action btn-download" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                                @can('update', $document)
                                <a href="{{ route('documents.edit', $document) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('delete', $document)
                                <form method="POST" action="{{ route('documents.destroy', $document) }}" class="d-inline" 
                                      onsubmit="return confirm('Are you sure? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </a>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fas fa-folder-open"></i>
                            No documents found
                        </a>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($documents->hasPages())
        <div class="pagination-container">
            {{ $documents->links() }}
        </div>
        @endif
    </div>
</div>
@endsection