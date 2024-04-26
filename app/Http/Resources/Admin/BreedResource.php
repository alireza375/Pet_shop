<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BreedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            '_id'        => $this->id,
            'name'     => $this->name,
            'image'      => $this->image,
            'description' => $this->description,
            'traits'   => json_decode($this->traits),
            'origin' => $this->origin,
            'year_recognized' => $this->year_recognized,
            'specifications'   => json_decode($this->specifications),
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
