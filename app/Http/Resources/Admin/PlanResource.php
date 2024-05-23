<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $defaultCurrency = Currency::where('default', 1)->first();
        return [
            '_id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            // 'currency' => $defaultCurrency->symbol,
            'credits' => $this->credits,
            'plan_type' => $this->type == 0 ? "regular" : "custom",
            'features' => json_decode($this->features),
            'minimum_buying' => $this->minimum,
            'is_active' => $this->status == 1 ? true : false,
            'is_sold_or_rented' => $this->is_sold_or_rented == 1 ? true : false,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
