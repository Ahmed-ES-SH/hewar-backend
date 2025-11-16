<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\Builder;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'category_id',
        'author_id',
        'status',
        'published_at',
        'scheduled_for',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'view_count',
        'share_count',
        'like_count',
        'project_id',
        'order',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'meta_keywords' => 'array',
    ];

    /**
     * العلاقة مع الوسوم (Many-to-Many)
     */
    public function tags(): Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tag')
            ->withTimestamps(); // إذا أردت الوصول ل timestamps الجدول الوسيط
    }

    /**
     * العلاقة مع التصنيف (Many-to-One)
     */
    public function category(): Relations\BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    /**
     * العلاقة مع الكاتب (Many-to-One)
     */
    public function author(): Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * العلاقة مع المشروع (Many-to-One)
     */
    public function project(): Relations\BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }


    public function scopeFilter(Builder $query, array $filters)
    {
        // 🔍 بحث نصي بالعربية (title, excerpt, content)
        if (!empty($filters['query'])) {
            $normalized = \App\Helpers\TextNormalizer::normalizeArabic($filters['query']);

            $normalizedColumns = [
                "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(title, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))",
                "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(content, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))",
                "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(excerpt, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))",
            ];

            $query->where(function ($inner) use ($normalized, $normalizedColumns) {
                foreach ($normalizedColumns as $col) {
                    $inner->orWhereRaw("$col LIKE ?", ["%$normalized%"]);
                }
            });
        }

        // 🧩 فلترة حسب الحالة
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // 🧩 فلترة حسب الفئات (Many-to-Many)
        if (!empty($filters['categories'])) {
            $categoryIds = explode(',', $filters['categories']);
            $query->whereHas('category', fn($q) => $q->whereIn('category_id', $categoryIds));
        }

        return $query;
    }
}
