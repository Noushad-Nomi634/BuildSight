<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Company extends Model
{
    protected $fillable = [
        'name',
        'description',
        'email',
        'mobile',
        'phone',
        'logo',
        'address_1',
        'address_2',
        'country_id',
        'city_id',

        'website',
        'state_province',
        'postal_code',
        'status',
        'created_by',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    // public function users()
    // {
    //     return $this->belongsToMany(User::class);
    // }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
