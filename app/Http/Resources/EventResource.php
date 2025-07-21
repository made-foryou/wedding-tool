<?php

namespace App\Http\Resources;

use App\Domains\Presence\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Event */
class EventResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'location' => $this->location,
            'date' => $this->date,
            'start' => $this->start,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
