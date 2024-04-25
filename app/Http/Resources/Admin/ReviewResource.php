<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "_id" => $this->id,
            "product" => $this->product_id,
            "review" => $this->review,
            "rating" => $this->rating,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "user" => [
                "_id" => $this->user->id,
                "name" => $this->user->name,
                "email" => $this->user->email,
                "image" => $this->user->image,
            ],
        ];
    }
}
