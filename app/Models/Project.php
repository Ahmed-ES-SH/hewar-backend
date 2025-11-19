<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'overview',
        'metadata',
        'image',
        'location',
        'start_date',
        'completed_at',
        'status',
        'target_amount',
        'collected_amount',
        'is_urgent',
        'volunteers_needed',
        'created_by',
        'category_id',
        'order',
    ];

    protected $guarded = ['collected_amount'];


    protected $casts = [
        'location' => 'array',
        'metadata' => 'array',
        'is_urgent' => 'boolean',
        'start_date' => 'date',
        'completed_at' => 'date',
    ];


    // ضمان أن metadata تعود كـ object
    public function getMetadataAttribute($value)
    {
        $decoded = json_decode($value, true);

        // لو القيمة null أو فارغة أو مش JSON صحيح، رجّع مصفوفة فاضية
        if (empty($decoded) || !is_array($decoded)) {
            return [];
        }

        return $decoded;
    }


    // ضمان أن location تعود كمصفوفة
    public function getLocationAttribute($value)
    {
        $decoded = json_decode($value, true);

        // إذا فشل أو القيمة فارغة
        if (empty($decoded) || !is_array($decoded)) {
            return [];
        }

        return $decoded;
    }


    public function images()
    {
        return $this->hasMany(ProjectImage::class, 'project_id');
    }


    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['approved', 'in_progress']);
    }


    public function scopeFilter(Builder $query, array $filters)
    {
        // 🔍 بحث نصي بالعربية (title, overview, description)
        if (!empty($filters['query'])) {
            $normalized = \App\Helpers\TextNormalizer::normalizeArabic($filters['query']);

            $normalizedColumns = [
                "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(title, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))",
                "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(description, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))",
                "LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(overview, 'ة', 'ه'), 'ى', 'ي'), 'أ', 'ا'), 'إ', 'ا'), 'آ', 'ا'), 'ؤ', 'و'))",
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
