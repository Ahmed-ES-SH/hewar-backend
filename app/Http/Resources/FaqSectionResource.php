<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'texts'        => $this->decode($this->column_1),
            'image_1'      => $this->decode($this->column_2),
            'image_2'      => $this->decode($this->column_3),
            'image_3'      => $this->decode($this->column_4),
            'contact_image' => $this->decode($this->column_5),
        ];
    }

    private function decode($value)
    {
        return is_string($value) && json_decode($value) ? json_decode($value, true) : $value;
    }
}
