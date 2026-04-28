@extends('layouts.app')

@section('title', 'Evaluations')

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
    
    .btn-group-header {
        display: flex;
        gap: 10px;
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
    
    .btn-stats {
        background: #F3F4F6;
        color: #374151;
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
    
    .btn-stats:hover {
        background: #E5E7EB;
        color: #1F2937;
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
    
    .badge-score {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-excellent {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .badge-very-good {
        background: #DBEAFE;
        color: #1E40AF;
    }
    
    .badge-satisfactory {
        background: #FEF3C7;
        color: #D97706;
    }
    
    .badge-insufficient {
        background: #FEE2E2;
        color: #991B1B;
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
        
        .btn-group-header {
            flex-direction: column;
            width: 100%;
        }
        
        .btn-add, .btn-stats {
            justify-content: center;
        }
        
        .table-modern thead th,
        .table-modern tbody td {
            padding: 10px 12px;
        }
    }
</style>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="page-title">Performance Evaluations</h1>
        <div class="btn-group-header">
            <a href="{{ route('evaluations.statistics') }}" class="btn-stats">
                <i class="fas fa-chart-bar"></i> Statistics
            </a>
            @can('create', App\Models\Evaluation::class)
            <a href="{{ route('evaluations.create') }}" class="btn-add">
                <i class="fas fa-plus"></i> New Evaluation
            </a>
            @endcan
        </div>
    </div>
    
    <div class="data-card">
        <div class="table-container">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Evaluator</th>
                        <th>Date</th>
                        <th>Period</th>
                        <th>Score</th>
                        <th>Performance</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($evaluations as $evaluation)
                    <tr>
                        <td>
                            <a href="{{ route('employees.show', $evaluation->employee_id) }}" class="employee-link">
                                {{ $evaluation->employee->getFullName() }}
                            </a>
                        </a>
                        <td>{{ $evaluation->evaluator->getFullName() }}</a>
                        <td>{{ $evaluation->evaluation_date->format('d/m/Y') }}</a>
                        <td>{{ $evaluation->period }}</a>
                        <td>
                            <span class="badge-score 
                                @if($evaluation->overall_score >= 90) badge-excellent
                                @elseif($evaluation->overall_score >= 75) badge-very-good
                                @elseif($evaluation->overall_score >= 60) badge-satisfactory
                                @else badge-insufficient @endif">
                                {{ $evaluation->overall_score }}%
                            </span>
                        </a>
                        <td>{{ $evaluation->getPerformanceLevel() }}</a>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('evaluations.show', $evaluation) }}" class="btn-action btn-view" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('update', $evaluation)
                                <a href="{{ route('evaluations.edit', $evaluation) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('delete', $evaluation)
                                <form method="POST" action="{{ route('evaluations.destroy', $evaluation) }}" class="d-inline" 
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
                        <td colspan="7" class="empty-state">
                            <i class="fas fa-star"></i>
                            No evaluations found
                        </a>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($evaluations->hasPages())
        <div class="pagination-container">
            {{ $evaluations->links() }}
        </div>
        @endif
    </div>
</div>
@endsection