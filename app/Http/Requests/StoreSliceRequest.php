<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliceRequest extends FormRequest
{
    public function authorize(): bool
    {
        // يمكنك تفعيل الصلاحيات لاحقًا
        return true;
    }

    public function rules(): array
    {
        return [
            'title_en' => ['required', 'string', 'max:255'],
            'title_ar' => ['required', 'string', 'max:255'],
            'subTitle_en' => ['required', 'string', 'max:255'],
            'subTitle_ar' => ['required', 'string', 'max:255'],
            'link_video' => ['nullable', 'url'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:8096'],
            'video_path' => ['nullable', 'file', 'mimetypes:video/mp4,video/mpeg,video/quicktime', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'title_en.required' => 'العنوان بالإنجليزية مطلوب.',
            'title_ar.required' => 'العنوان بالعربية مطلوب.',
            'subTitle_en.required' => 'العنوان الفرعي بالإنجليزية مطلوب.',
            'subTitle_ar.required' => 'العنوان الفرعي بالعربية مطلوب.',
            'link_video.url' => 'رابط الفيديو يجب أن يكون صحيحًا.',
            'image.required' => 'الصورة مطلوبة.',
            'image.image' => 'يجب أن يكون الملف صورة.',
            'video_path.mimetypes' => 'صيغة الفيديو غير مدعومة.',
        ];
    }
}
