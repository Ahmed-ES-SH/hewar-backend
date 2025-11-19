<?php

namespace App\Models;

use App\Helpers\TextNormalizer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    protected $fillable = [
        'title_en',
        'title_ar',
        'icon_name',
        'bg_color',
        'image',
    ];


    public function scopeFilter(Builder $query, array $filters)
    {
        // 🔍 بحث نصي
        if (!empty($filters['query'])) {
            $normalized = TextNormalizer::normalizeArabic($filters['query']);
            $normalizedSql = TextNormalizer::sqlNormalizeColumn('title_ar');

            $query->where(function ($q) use ($normalized, $normalizedSql) {
                $q->whereRaw("$normalizedSql LIKE ?", ["%$normalized%"])
                    ->orWhere('title_en', 'LIKE', "%$normalized%");
            });
        }

        return $query;
    }
}
