<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignRessource extends JsonResource
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
            "title" => $this->title,
            "description" => $this->description,
            "slug" => $this->slug,
            "target_amount" => $this->target_amount,
            "collected_amount" => $this->collected_amount,
            "created_at" => $this->created_at,
            "limit_date" => $this->limit_date,
            "category_id" => $this->category_id,
            "closing_date" => $this->closing_date,
            "url_image" => asset("storage/" . $this->image),
            "participants" => ParticipantRessource::collection($this->whenLoaded('participant')),
        ];
    }
}
