<?php

namespace App\Http\Resources\Admin;

use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        $userDetails = UserDetails::where(['user_id' => $this->id])->first();

        return [
            // 'name' => $this->name,
            // 'email' => $this->email,
            // 'phone' => $this->phone,
            // 'role' => $this->role,
            'facebook' => $userDetails->facebook,
            // 'image' => $this->image,
            'about' => $userDetails->about,
            'address' => $userDetails->address,
            'instagram' => $userDetails->instagram,
            'twitter' => $userDetails->twitter,
            'linkedin' => $userDetails->linkedin,
        ];
    }
}
