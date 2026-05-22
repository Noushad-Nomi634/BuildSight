<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Camera extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'ip_address',
        'port',
        'username',
        'password',
        'snapshot_url',
        'upload_method',
        'is_active',
        'last_seen_at',
    ];

    /*
    |-----------------------------------------
    | CASTS (important for proper types)
    |-----------------------------------------
    */
    protected $casts = [
        'port' => 'integer',
        'is_active' => 'boolean',
        'last_seen_at' => 'datetime',
    ];

    /*
    |-----------------------------------------
    | RELATION: Camera belongs to Project
    |-----------------------------------------
    */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}