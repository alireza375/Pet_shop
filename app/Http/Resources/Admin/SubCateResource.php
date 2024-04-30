<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $category = ServiceCategory::find($this->service_categories_id);
        return [
            '_id' => $this->id,
            'name' => $this->name,
            // 'category' => $this->service_categories_id,
            'category' => [
                    '_id' => $category->id,
                    'name' => $category->name
                ],
            'createdAt' => $this-> created_at,
            'updatedAt' => $this-> updated_at
        ];
    }
}
