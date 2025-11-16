<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'title_en'  => 'sometimes|string|max:255',
            'title_ar'  => 'sometimes|string|max:255',
            'icon_name' => 'sometimes|string|max:100',
            'bg_color'  => 'sometimes|string|regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
            'image'     => 'sometimes|image|mimes:jpg,jpeg,png,webp|max:4096',
        ];
    }
}
