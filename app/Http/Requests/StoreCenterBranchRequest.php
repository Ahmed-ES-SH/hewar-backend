<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCenterBranchRequest extends FormRequest
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
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:20'],

            'location' => ['required', 'array'],
            'location.address' => ['required', 'string', 'max:255'],
            'location.lat' => ['required', 'numeric'],
            'location.lng' => ['required', 'numeric'],
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
    }
}
