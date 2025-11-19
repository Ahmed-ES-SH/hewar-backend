<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // يمكنك تخصيص من له صلاحية التحديث
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'slug' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('projects', 'slug')->ignore($this->project),
            ],
            'description' => ['sometimes', 'string'],
            'overview' => ['sometimes', 'string', 'max:1000'],
            'image' => ['nullable'],

            'location' => ['sometimes'],
            'images' => ['sometimes', 'array'],
            'deletedImages' => ['sometimes', 'array'],
            'metadata' => ['sometimes'],

            'start_date' => ['sometimes', 'date'],
            'completed_at' => ['nullable', 'date', 'after_or_equal:start_date'],

            'status' => ['sometimes', 'in:draft,pending,approved,in_progress,completed,rejected,canceled'],

            'target_amount' => ['nullable', 'numeric', 'min:0'],
            'collected_amount' => ['nullable', 'numeric', 'min:0'],
            'is_urgent' => ['boolean'],
            'volunteers_needed' => ['nullable', 'integer', 'min:0'],

            'order' => ['nullable', 'integer', Rule::unique('projects', 'order')->ignore($this->project)],

            'category_id' => ['sometimes', 'exists:project_categories,id'],
        ];
    }




    protected function prepareForValidation()
    {
        if ($this->has('images') && is_string($this->images)) {
            $this->merge([
                'images' => json_decode($this->images, true),
            ]);
        }


        if ($this->has('deletedImages') && is_string($this->deletedImages)) {
            $this->merge([
                'deletedImages' => json_decode($this->deletedImages, true),
            ]);
        }
    }

    /**
     * Customize validation messages.
     */
    public function messages(): array
    {
        return [
            'slug.unique' => 'المعرف (slug) مستخدم بالفعل لمشروع آخر.',
            'location.city.required_with' => 'المدينة مطلوبة عند تحديث بيانات الموقع.',
            'completed_at.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البدء.',
            'category_id.exists' => 'الفئة المحددة غير موجودة.',
        ];
    }
}
