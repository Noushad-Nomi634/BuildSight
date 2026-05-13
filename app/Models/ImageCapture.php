<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Camera;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ImageCapture extends Model
{
    use HasFactory;

    protected $fillable = [
        'camera_id',
        'project_id',
        'file_path',
        'thumbnail_path',
        'captured_at',
    ];

    protected $casts = [
        'captured_at' => 'datetime',
    ];

    /*
    |----------------------------------------
    | Relationships
    |----------------------------------------
    */

    public function camera()
    {
        return $this->belongsTo(Camera::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}