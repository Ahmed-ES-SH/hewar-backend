<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharityServicesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'services' => $this->decode($this->column_1),
            'texts'    => $this->decode($this->column_2),
        ];
    }

    private function decode($value)
    {
        return is_string($value) && json_decode($value) ? json_decode($value, true) : $value;
    }
}
