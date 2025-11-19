<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slice extends Model
{
    protected $fillable = [
        'title_en',
        'title_ar',
        'subTitle_ar',
        'subTitle_en',
        'link_video',
        'video_path',
        'image',
    ];
}
