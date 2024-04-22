<?php

namespace App\Http\Resources\Admin;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            '_id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'short_description' =>$this->short_description,
            'category' => [
                    '_id' => $this->category_id,
                    'name' => ServiceCategory::find($this->category_id)->name
                ],
            'createdAt' => $this-> created_at,
            'updatedAt' => $this-> updated_at
        ];
    }
}
