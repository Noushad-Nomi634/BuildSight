<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Timelapse extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'created_by',
        'start_date',
        'end_date',
        'fps',
        'status',
        'video_path',
        'error',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /*
    |----------------------------------------
    | Relationships
    |----------------------------------------
    */

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |----------------------------------------
    | Helpers
    |----------------------------------------
    */

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isProcessing(): bool
    {
        return $this->status === 'processing';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }
}
