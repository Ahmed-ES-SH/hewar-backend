<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'type'];

    /**
     * العلاقة مع المقالات (Many-to-Many)
     */
    public function articles(): Relations\BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_tag')
            ->withTimestamps();
    }

    /**
     * الحصول على الوسوم حسب النوع
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
