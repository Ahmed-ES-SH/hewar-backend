<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'sections' => [
                [
                    'title' => [
                        'ar' => $this->first_section_title_ar,
                        'en' => $this->first_section_title_en,
                    ],
                    'content' => [
                        'ar' => $this->first_section_content_ar,
                        'en' => $this->first_section_content_en,
                    ],
                    'image' => $this->first_section_image,
                ],
                [
                    'title' => [
                        'ar' => $this->second_section_title_ar,
                        'en' => $this->second_section_title_en,
                    ],
                    'content' => [
                        'ar' => $this->second_section_content_ar,
                        'en' => $this->second_section_content_en,
                    ],
                    'image' => $this->second_section_image,
                ],
                [
                    'title' => [
                        'ar' => $this->third_section_title_ar,
                        'en' => $this->third_section_title_en,
                    ],
                    'content' => [
                        'ar' => $this->third_section_content_ar,
                        'en' => $this->third_section_content_en,
                    ],
                    'image' => $this->third_section_image,
                ],
                [
                    'title' => [
                        'ar' => $this->fourth_section_title_ar,
                        'en' => $this->fourth_section_title_en,
                    ],
                    'content' => [
                        'ar' => $this->fourth_section_content_ar,
                        'en' => $this->fourth_section_content_en,
                    ],
                    'image' => $this->fourth_section_image,
                ],
            ],

            'show_map' => $this->show_map,
            'address' => $this->address,

            'main_video' => $this->main_video,
            'link_video' => $this->link_video,
            'qr_path' => $this->qr_path,
            'merchant_phone' => $this->merchant_phone,
        ];
    }
}
