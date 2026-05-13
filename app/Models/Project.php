<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Camera;
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'project_code',
        'description',
        'lat',
        'lng',
        'address_1',
        'address_2',
        'country',
        'state_province',
        'postal_code',
        'start_date',
        'end_date',
        'alerts_email',
        'status',
        'ftp_folder',
        'priority',
        'created_by',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function cameras()
    {
        return $this->hasMany(Camera::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
