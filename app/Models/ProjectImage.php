<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    protected $fillable = [
        'project_id',
        'image_path',
        'is_main',
    ];


    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
