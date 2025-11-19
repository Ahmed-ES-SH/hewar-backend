<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSliceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title_en' => ['sometimes', 'string', 'max:255'],
            'title_ar' => ['sometimes', 'string', 'max:255'],
            'subTitle_en' => ['sometimes', 'string', 'max:255'],
            'subTitle_ar' => ['sometimes', 'string', 'max:255'],
            'link_video' => ['nullable', 'url'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'video_path' => ['nullable', 'file', 'mimetypes:video/mp4,video/mpeg,video/quicktime', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'title_en.string' => 'العنوان بالإنجليزية يجب أن يكون نصًا.',
            'title_ar.string' => 'العنوان بالعربية يجب أن يكون نصًا.',
            'link_video.url' => 'رابط الفيديو يجب أن يكون صحيحًا.',
            'image.image' => 'يجب أن يكون الملف صورة.',
            'video_path.mimetypes' => 'صيغة الفيديو غير مدعومة.',
        ];
    }
}
