<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HelpSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'texts'      => $this->decode($this->column_1),
            'stats'      => $this->decode($this->column_2),
            'image_path' => $this->decode($this->column_3),
            'video_path' => $this->decode($this->column_4),
        ];
    }

    private function decode($value)
    {
        return is_string($value) && json_decode($value) ? json_decode($value, true) : $value;
    }
}
