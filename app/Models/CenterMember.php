<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CenterMember extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'job_title',
        'description',
        'image',

        // Social media
        'facebook',
        'instagram',
        'x',
        'linkedin',
        'youtube',
        'whatsapp',
        'tiktok',

        'sort',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort'      => 'integer',
    ];

    // Create full URL for the image automatically
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return asset('uploads/center_members/' . $this->image);
    }

    // Reusable scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort');
    }
}
