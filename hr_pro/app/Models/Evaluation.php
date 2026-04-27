<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Evaluation extends Model
{
    use Auditable;
    protected $fillable = [
        'employee_id',
        'evaluator_id',
        'evaluation_date',
        'period',
        'overall_score',
        'comments'
    ];

    protected $casts = [
        'evaluation_date' => 'date',
        'overall_score' => 'float'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function getScoreBadge(){
        if($this->overall_score >= 90){
            return '<span class="badge bg-success">Excellent ('.$this->overall_score.'%)</span>';
        } elseif ($this->overall_score >= 75) {
            return '<span class="badge bg-info">Très bien ('.$this->overall_score.'%)</span>';
        } elseif ($this->overall_score >= 60) {
            return '<span class="badge bg-warning">Satisfaisant ('.$this->overall_score.'%)</span>';
        } elseif ($this->overall_score >= 50) {
            return '<span class="badge bg-secondary">Passable ('.$this->overall_score.'%)</span>';
        } else {
            return '<span class="badge bg-danger">Insuffisant ('.$this->overall_score.'%)</span>';
        }
    }

    public function getPerformanceLevel()
    {
        if ($this->overall_score >= 90) return 'Excellent';
        if ($this->overall_score >= 75) return 'Very Good';
        if ($this->overall_score >= 60) return 'Satisfactory';
        if ($this->overall_score >= 50) return 'Passable';
        return 'Insufficient';
    }
}
