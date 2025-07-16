<?php

declare(strict_types=1);

namespace App\Http\Resources\Guests;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),

            'guests' => $this->whenLoaded(
                relationship: 'guests',
                value: fn(mixed $value): GuestResourceCollection => new GuestResourceCollection(
                    $value
                ),
                default: collect()
            ),
        ];
    }
}
