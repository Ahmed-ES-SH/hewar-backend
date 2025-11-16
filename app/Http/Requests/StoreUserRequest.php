<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'image' => 'nullable|file|image|max:4096',
            'phone' => 'required|string|regex:/^[0-9]{10,15}$/',
            'role' => 'nullable|string|in:admin,user',
        ];
    }




    public function messages(): array
    {
        return [
            'name.required' => ['ar' => 'حقل الاسم مطلوب.', 'en' => 'The name field is required.'],
            'name.unique' => ['ar' => 'الاسم مستخدم بالفعل.', 'en' => 'The name has already been taken.'],

            'phone.required' => ['ar' => 'رقم الهاتف  مطلوب.', 'en' => 'The phone number is required.'],

            'email.required' => ['ar' => 'حقل البريد الإلكتروني مطلوب.', 'en' => 'The email field is required.'],
            'email.email' => ['ar' => 'يجب أن يكون البريد الإلكتروني صالحًا.', 'en' => 'The email must be a valid email address.'],
            'email.unique' => ['ar' => 'البريد الإلكتروني مستخدم بالفعل.', 'en' => 'The email has already been taken.'],

            'password.required' => ['ar' => 'حقل كلمة المرور مطلوب.', 'en' => 'The password field is required.'],
            'password.min' => ['ar' => 'يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل.', 'en' => 'The password must be at least 8 characters.'],

            'image.image' => ['ar' => 'يجب أن يكون الملف صورة.', 'en' => 'The file must be an image.'],
            'image.max' => ['ar' => 'يجب ألا يزيد حجم الصورة عن 4 ميجابايت.', 'en' => 'The image size must not exceed 4MB.'],

            'phone.regex' => ['ar' => 'رقم الهاتف غير صالح.', 'en' => 'The phone number format is invalid.'],
        ];
    }
}
