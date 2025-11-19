<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class OrganizationMember extends Model
{
    protected $fillable = [
        'national_id',
        'position',
        'bio',
        'department',
        'employment_type',
        'status',
        'join_date',
        'leave_date',
        'social_media',
        'user_id',
        'can_login',
    ];

    protected $casts = [
        'social_media' => 'array'
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user(): Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }


    public function updateSocialMedia(array $platforms): void
    {
        $this->social_media = $platforms;
    }

    public function getSocialLinksAttribute(): array
    {
        return $this->social_media ?? [];
    }


    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope للمتطوعين
     */
    public function scopeVolunteers($query)
    {
        return $query->where('employment_type', 'volunteer');
    }

    /**
     * Scope للموظفين بدوام كامل
     */
    public function scopeFullTime($query)
    {
        return $query->where('employment_type', 'full_time');
    }

    /**
     * Scope حسب القسم
     */
    public function scopeInDepartment($query, $department)
    {
        return $query->where('department', $department);
    }
}
