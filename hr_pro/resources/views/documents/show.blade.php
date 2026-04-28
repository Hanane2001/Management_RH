@extends('layouts.app')

@section('title', 'Document Details')

@section('content')
<style>
    .details-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto;
    }
    
    .card-header-custom {
        padding: 20px 24px;
        border-bottom: 1px solid #E5E7EB;
        background: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .card-header-custom h3 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1.25rem;
        color: #1F2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .card-header-custom h3 i {
        color: #1D4ED8;
    }
    
    .btn-back {
        background: #F3F4F6;
        color: #374151;
        padding: 8px 16px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-back:hover {
        background: #E5E7EB;
        color: #1F2937;
    }
    
    .card-body-custom {
        padding: 24px;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }
    
    .info-section {
        background: #F9FAFB;
        border-radius: 16px;
        padding: 20px;
    }
    
    .info-section h5 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        color: #1F2937;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #E5E7EB;
    }
    
    .info-row {
        display: flex;
        margin-bottom: 12px;
    }
    
    .info-label {
        width: 110px;
        font-family: 'Inter', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
        color: #6B7280;
    }
    
    .info-value {
        flex: 1;
        font-family: 'Roboto', sans-serif;
        font-size: 0.85rem;
        color: #374151;
    }
    
    .badge-doc {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
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
    
    .preview-box {
        background: #F9FAFB;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        margin-top: 24px;
    }
    
    .preview-box img {
        max-width: 100%;
        max-height: 400px;
        border-radius: 8px;
    }
    
    .action-buttons {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #E5E7EB;
    }
    
    .btn-download {
        background: #10B981;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    
    .btn-download:hover {
        background: #059669;
    }
    
    .btn-edit {
        background: #FEF3C7;
        color: #D97706;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-edit:hover {
        background: #FDE68A;
    }
    
    .btn-delete {
        background: #FEE2E2;
        color: #DC2626;
        padding: 10px 20px;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-delete:hover {
        background: #FECACA;
    }
    
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        
        .card-header-custom {
            padding: 16px 20px;
        }
        
        .card-body-custom {
            padding: 20px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-download, .btn-edit, .btn-delete {
            justify-content: center;
        }
    }
</style>

<div class="container-fluid">
    <div class="details-card">
        <div class="card-header-custom">
            <h3>
                <i class="fas fa-file-alt"></i> Document Details
            </h3>
            <a href="{{ route('documents.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
        <div class="card-body-custom">
            <div class="info-grid">
                <div class="info-section">
                    <h5><i class="fas fa-user"></i> Employee Information</h5>
                    <div class="info-row">
                        <div class="info-label">Full Name</div>
                        <div class="info-value"><strong>{{ $document->employee->getFullName() }}</strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $document->employee->email }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Department</div>
                        <div class="info-value">{{ $document->employee->department->name ?? '—' }}</div>
                    </div>
                </div>
                
                <div class="info-section">
                    <h5><i class="fas fa-info-circle"></i> Document Information</h5>
                    <div class="info-row">
                        <div class="info-label">Document Type</div>
                        <div class="info-value">
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
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">File Name</div>
                        <div class="info-value">{{ $document->file_name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">File Size</div>
                        <div class="info-value">{{ $document->getFileSizeFormatted() }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">MIME Type</div>
                        <div class="info-value">{{ $document->mime_type ?? '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Uploaded Date</div>
                        <div class="info-value">{{ $document->created_at->format('d/m/Y H:i:s') }}</div>
                    </div>
                </div>
            </div>
            
            @php
                $extension = strtolower(pathinfo($document->file_name, PATHINFO_EXTENSION));
                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            @endphp
            
            @if($isImage)
            <div class="preview-box">
                <h5 style="font-family: 'Inter', sans-serif; margin-bottom: 15px;">Preview</h5>
                <img src="{{ $document->getFileUrl() }}" alt="Document Preview">
            </div>
            @elseif($extension == 'pdf')
            <div class="preview-box">
                <h5 style="font-family: 'Inter', sans-serif; margin-bottom: 15px;">PDF Preview</h5>
                <embed src="{{ $document->getFileUrl() }}" type="application/pdf" width="100%" height="500px" style="border-radius: 8px;">
            </div>
            @else
            <div class="preview-box">
                <i class="fas fa-file-alt" style="font-size: 4rem; color: #9CA3AF;"></i>
                <p style="font-family: 'Roboto', sans-serif; color: #6B7280; margin-top: 15px;">
                    Preview not available for this file type. Click download to view the file.
                </p>
            </div>
            @endif
            
            <div class="action-buttons">
                <a href="{{ route('documents.download', $document) }}" class="btn-download">
                    <i class="fas fa-download"></i> Download File
                </a>
                @can('update', $document)
                <a href="{{ route('documents.edit', $document) }}" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
                @endcan
                @can('delete', $document)
                <form method="POST" action="{{ route('documents.destroy', $document) }}" class="d-inline" 
                      onsubmit="return confirm('Are you sure? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection