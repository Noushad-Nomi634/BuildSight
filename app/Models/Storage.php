<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;

    // Table name (important because table is not plural)
    protected $table = 'storage';

    // Mass assignable fields
    protected $fillable = [
        'ip',
        'server',
        'username',
        'password',
        'path',
    ];
}