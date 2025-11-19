<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'sometimes|unique:users,name|min:3',
            'email' => 'sometimes|email|unique:users,email',
            'password' => 'sometimes|string',
            'image' => 'nullable|file|image|max:4096',
            'phone' => 'nullable|string|regex:/^[0-9]{10,15}$/',
            'role' => 'sometimes|in:admin,user',
        ];
    }



    public function messages(): array
    {
        return [
            'name.unique' => [
                'ar' => 'الاسم مستخدم بالفعل.',
                'en' => 'The name has already been taken.',
            ],
            'email.email' => [
                'ar' => 'يجب إدخال بريد إلكتروني صالح.',
                'en' => 'The email must be a valid email address.',
            ],
            'email.unique' => [
                'ar' => 'البريد الإلكتروني مستخدم بالفعل.',
                'en' => 'The email has already been taken.',
            ],
            'password.string' => [
                'ar' => 'كلمة المرور يجب أن تكون نصًا.',
                'en' => 'The password must be a string.',
            ],
            'image.file' => [
                'ar' => 'يجب أن يكون الملف صورة.',
                'en' => 'The image must be a file.',
            ],
            'image.image' => [
                'ar' => 'يجب أن يكون الملف صورة صالحة.',
                'en' => 'The file must be a valid image.',
            ],
            'image.max' => [
                'ar' => 'يجب ألا يتجاوز حجم الصورة 4 ميجابايت.',
                'en' => 'The image size must not exceed 4MB.',
            ],
            'phone.string' => [
                'ar' => 'يجب أن يكون رقم الهاتف نصًا.',
                'en' => 'The phone number must be a string.',
            ],
            'phone.regex' => [
                'ar' => 'رقم الهاتف غير صالح، يجب أن يحتوي على 10 إلى 15 رقمًا فقط.',
                'en' => 'The phone number is invalid, it must contain 10 to 15 digits only.',
            ],
        ];
    }
}
