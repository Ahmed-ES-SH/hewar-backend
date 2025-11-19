<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCenterMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'nullable|string|max:255',
            'job_title'   => 'nullable|string|max:255',
            'description' => 'nullable|string',

            // Upload image (optional)
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            // Social media links
            'facebook'  => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'x'         => 'nullable|url|max:255',
            'linkedin'  => 'nullable|url|max:255',
            'youtube'   => 'nullable|url|max:255',
            'whatsapp'  => 'nullable|string|max:255',
            'tiktok'    => 'nullable|url|max:255',

            'sort'      => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }
}
