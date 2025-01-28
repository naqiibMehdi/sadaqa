<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "first_name" => $this->first_name,
            "public_name" => $this->public_name,
            "birth_date" => $this->birth_date,
            "email" => $this->email,
            "subscribe_date" => $this->subscribe_date,
            "image_profile" => $this->img_profile,
            "campaigns" => CampaignRessource::collection($this->whenLoaded('campaign')),
        ];
    }
}
