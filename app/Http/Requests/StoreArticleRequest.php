<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // المعلومات الأساسية
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:articles,slug'],
            'content' => ['required', 'string'],
            'excerpt' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'], // صورة بحد أقصى 2MB

            // التصنيف والتنظيم
            'category_id' => ['nullable', 'exists:article_categories,id'],
            'author_id' => ['required', 'exists:users,id'],

            // الحالة والنشر
            'status' => ['nullable', Rule::in(['draft', 'under_review', 'published', 'scheduled', 'rejected', 'archived'])],
            'published_at' => ['nullable', 'date'],
            'scheduled_for' => ['nullable', 'date', 'after:now'],

            // SEO
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'array'],
            'meta_keywords.*' => ['string'],

            // العلاقة مع المشاريع
            'project_id' => ['nullable', 'exists:projects,id'],

            // الوسوم (tags)
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:100'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // توليد slug تلقائي إذا لم يُرسل من الواجهة
        if (!$this->slug && $this->title) {
            $this->merge([
                'slug' => Str::slug($this->title),
            ]);
        }



        if ($this->has('meta_keywords') && is_string($this->meta_keywords)) {
            $this->merge([
                'meta_keywords' => json_decode($this->meta_keywords, true),
            ]);
        }
    }
}
