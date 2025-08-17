<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignRecoveryRessource extends JsonResource
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
      "campaign_id" => $this->campaign_id,
      "user_id" => $this->user_id,
      "amount" => $this->amount,
      "amount_assoc" => $this->amount_assoc,
      "total_amount" => $this->total_amount,
      "status" => $this->status,
      "created_at" => $this->created_at,
      "campaign" => new CampaignRessource($this->whenLoaded('campaign')),
    ];
  }
}
