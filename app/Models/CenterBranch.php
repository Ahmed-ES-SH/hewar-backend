<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CenterBranch extends Model
{
    protected $fillable = [
        'email',
        'phone',
        'location',
    ];

    protected $casts = [
        'location' => 'array', // {address, lat, lng}
    ];
}
