<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'availlable' => $this->availlable,
            'sector_id' => $this->sector->id,
            'user_id' => $this->user->id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'total_price' => $this->total_price
        ];
    }
}
