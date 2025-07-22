<?php

namespace App\Http\Resources;

use App\Domains\Question\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Question
 */
class QuestionResource extends JsonResource
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
            'type' => new QuestionTypeResource($this->questionType),
            'label' => $this->label,
            'description' => $this->description,
            'data' => $this->data,
        ];
    }
}
