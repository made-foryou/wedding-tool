<?php

declare(strict_types=1);

namespace App\Http\Resources\Guests;

use App\Domains\Guests\Models\GuestType;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends GuestType
 */
class GuestTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),

            'guests' => $this->whenLoaded(
                relationship: 'guests',
                value: fn (mixed $value): AnonymousResourceCollection => GuestResource::collection(
                    $value
                ),
                default: collect()
            ),

            'events' => $this->whenLoaded(
                relationship: 'events',
                value: fn (mixed $value): AnonymousResourceCollection => EventResource::collection(
                    $value
                ),
                default: collect()
            ),
        ];
    }
}
