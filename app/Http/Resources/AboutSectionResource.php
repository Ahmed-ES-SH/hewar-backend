<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'charities'    => $this->decode($this->column_1),
            'texts'        => $this->decode($this->column_2),
            'about_image'  => $this->decode($this->column_3),
            'banner_cards' => $this->decode($this->column_4),
            'banner_texts' => $this->decode($this->column_5),
        ];
    }

    private function decode($value)
    {
        return is_string($value) && json_decode($value) ? json_decode($value, true) : $value;
    }
}
