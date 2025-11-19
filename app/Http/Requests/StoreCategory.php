<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategory extends FormRequest
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
            'title_en'  => 'required|string|max:255',
            'title_ar'  => 'required|string|max:255',
            'icon_name' => 'nullable|string|max:100', // مثل: 'fa-solid fa-star'
            'bg_color'  => 'nullable', // لون HEX
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096', // 4MB max
        ];
    }
}
