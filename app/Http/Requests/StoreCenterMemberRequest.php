<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCenterMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // التحكم يكون في Policies أو Middleware
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
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
            'whatsapp'  => 'nullable|string|max:255', // قد لا يكون URL
            'tiktok'    => 'nullable|url|max:255',

            'sort'      => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم العضو مطلوب.',
            'image.image' => 'يجب أن تكون الصورة ملفًا من نوع صورة صالح.',
        ];
    }
}
