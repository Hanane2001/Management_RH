@extends('layouts.app')

@section('title', 'Evaluation Details')

@section('content')
<style>
    .details-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #E5E7EB;
        overflow: hidden;
        max-width: 800px;
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
        width: 120px;
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
    
    .score-box {
        text-align: center;
        padding: 20px;
        background: #F9FAFB;
        border-radius: 16px;
        margin-bottom: 24px;
    }
    
    .score-value {
        font-family: 'Inter', sans-serif;
        font-size: 3rem;
        font-weight: 800;
        margin: 10px 0;
    }
    
    .score-value.excellent {
        color: #10B981;
    }
    
    .score-value.very-good {
        color: #3B82F6;
    }
    
    .score-value.satisfactory {
        color: #F59E0B;
    }
    
    .score-value.insufficient {
        color: #EF4444;
    }
    
    .progress-custom {
        height: 12px;
        background: #E5E7EB;
        border-radius: 10px;
        overflow: hidden;
        margin: 15px 0;
    }
    
    .progress-bar-custom {
        height: 100%;
        border-radius: 10px;
        transition: width 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 600;
        color: white;
    }
    
    .comments-box {
        background: #F9FAFB;
        border-radius: 16px;
        padding: 20px;
        margin-top: 20px;
    }
    
    .comments-box h5 {
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        color: #1F2937;
        margin-bottom: 12px;
    }
    
    .comments-box p {
        font-family: 'Roboto', sans-serif;
        font-size: 0.9rem;
        color: #374151;
        line-height: 1.5;
    }
    
    .action-buttons {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #E5E7EB;
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
        
        .btn-edit, .btn-delete {
            justify-content: center;
        }
    }
</style>

<div class="container-fluid">
    <div class="details-card">
        <div class="card-header-custom">
            <h3>
                <i class="fas fa-star"></i> Evaluation Details
            </h3>
            <a href="{{ route('evaluations.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
        <div class="card-body-custom">
            <div class="info-grid">
                <div class="info-section">
                    <h5><i class="fas fa-user"></i> Employee Information</h5>
                    <div class="info-row">
                        <div class="info-label">Full Name</div>
                        <div class="info-value"><strong>{{ $evaluation->employee->getFullName() }}</strong></div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Department</div>
                        <div class="info-value">{{ $evaluation->employee->department->name ?? '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Position</div>
                        <div class="info-value">{{ $evaluation->employee->contracts->first()->position ?? '—' }}</div>
                    </div>
                </div>
                
                <div class="info-section">
                    <h5><i class="fas fa-clipboard-list"></i> Evaluation Information</h5>
                    <div class="info-row">
                        <div class="info-label">Evaluator</div>
                        <div class="info-value">{{ $evaluation->evaluator->getFullName() }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Evaluation Date</div>
                        <div class="info-value">{{ $evaluation->evaluation_date->format('d/m/Y') }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Period</div>
                        <div class="info-value">{{ $evaluation->period }}</div>
                    </div>
                </div>
            </div>
            
            <div class="score-box">
                <h5 style="margin-bottom: 10px;">Overall Score</h5>
                <div class="score-value 
                    @if($evaluation->overall_score >= 90) excellent
                    @elseif($evaluation->overall_score >= 75) very-good
                    @elseif($evaluation->overall_score >= 60) satisfactory
                    @else insufficient @endif">
                    {{ $evaluation->overall_score }}%
                </div>
                <div class="progress-custom">
                    <div class="progress-bar-custom 
                        @if($evaluation->overall_score >= 90) excellent
                        @elseif($evaluation->overall_score >= 75) very-good
                        @elseif($evaluation->overall_score >= 60) satisfactory
                        @else insufficient @endif" 
                        style="width: {{ $evaluation->overall_score }}%">
                    </div>
                </div>
                <div class="badge-score 
                    @if($evaluation->overall_score >= 90) badge-excellent
                    @elseif($evaluation->overall_score >= 75) badge-very-good
                    @elseif($evaluation->overall_score >= 60) badge-satisfactory
                    @else badge-insufficient @endif" 
                    style="display: inline-block;">
                    {{ $evaluation->getPerformanceLevel() }}
                </div>
            </div>
            
            @if($evaluation->comments)
            <div class="comments-box">
                <h5><i class="fas fa-comment-dots"></i> Comments & Feedback</h5>
                <p>{{ $evaluation->comments }}</p>
            </div>
            @endif
            
            <div class="action-buttons">
                @can('update', $evaluation)
                <a href="{{ route('evaluations.edit', $evaluation) }}" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit Evaluation
                </a>
                @endcan
                @can('delete', $evaluation)
                <form method="POST" action="{{ route('evaluations.destroy', $evaluation) }}" class="d-inline" 
                      onsubmit="return confirm('Are you sure? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <i class="fas fa-trash"></i> Delete Evaluation
                    </button>
                </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection