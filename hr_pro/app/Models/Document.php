<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Document extends Model
{
    use Auditable;
    protected $fillable = [
        'employee_id',
        'type',
        'file_name',
        'file_path',
        'file_size',
        'mime_type'
    ];

    protected $casts = [
        'file_size' => 'integer'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function getFileUrl()
    {
        return asset('storage/' . $this->file_path);
    }

    public function getFileSizeFormatted()
    {
        if (!$this->file_size) return 'N/A';
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $power = $this->file_size > 0 ? floor(log($this->file_size, 1024)) : 0;
        return number_format($this->file_size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    public function getTypeBadge()
    {
        $badges = [
            'cv' => '<span class="badge bg-info">CV</span>',
            'contract' => '<span class="badge bg-primary">Contrat</span>',
            'attestation' => '<span class="badge bg-success">Attestation</span>',
            'other' => '<span class="badge bg-secondary">Autre</span>'
        ];
        
        return $badges[$this->type] ?? '<span class="badge bg-secondary">Autre</span>';
    }

    public function getIcon()
    {
        $icons = [
            'pdf' => '📄',
            'doc' => '📝',
            'docx' => '📝',
            'jpg' => '🖼️',
            'png' => '🖼️',
            'default' => '📁'
        ];
        
        $extension = pathinfo($this->file_name, PATHINFO_EXTENSION);
        return $icons[$extension] ?? $icons['default'];
    }
}
