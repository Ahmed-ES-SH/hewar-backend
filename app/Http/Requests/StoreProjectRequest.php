<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // يمكنك تعديلها حسب سياسة الأذونات لديك
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug'],
            'description' => ['required', 'string'],
            'overview' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],

            'location' => ['required', 'array'],
            'images' => ['nullable', 'array'],
            'metadata' => ['nullable', 'array'],

            'start_date' => ['required', 'date'],
            'completed_at' => ['nullable', 'date', 'after_or_equal:start_date'],


            'status' => ['nullable', 'in:draft,pending,approved,in_progress,completed,rejected,canceled'],

            'target_amount' => ['nullable', 'numeric', 'min:0'],
            'collected_amount' => ['nullable', 'numeric', 'min:0'],
            'is_urgent' => ['boolean'],
            'volunteers_needed' => ['nullable', 'integer', 'min:0'],

            'order' => ['nullable', 'integer', 'unique:projects,order'],

            'created_by' => ['required', 'exists:users,id'],
            'category_id' => ['required', 'exists:project_categories,id'],
        ];
    }


    protected function prepareForValidation()
    {
        // فك JSON addons إن كانت سلسلة
        if ($this->has('location') && is_string($this->location)) {
            $this->merge([
                'location' => json_decode($this->location, true),
            ]);
        }


        if ($this->has('images') && is_string($this->images)) {
            $this->merge([
                'images' => json_decode($this->images, true),
            ]);
        }


        if ($this->has('metadata') && is_string($this->metadata)) {
            $this->merge([
                'metadata' => json_decode($this->metadata, true),
            ]);
        }
    }

    /**
     * Customize validation messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'عنوان المشروع مطلوب.',
            'slug.unique' => 'المعرف (slug) مستخدم بالفعل لمشروع آخر.',
            'location.city.required' => 'المدينة مطلوبة في بيانات الموقع.',
            'start_date.required' => 'تاريخ البدء مطلوب.',
            'completed_at.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البدء.',
            'created_by.exists' => 'المستخدم غير موجود.',
            'category_id.exists' => 'الفئة المحددة غير موجودة.',
        ];
    }
}
