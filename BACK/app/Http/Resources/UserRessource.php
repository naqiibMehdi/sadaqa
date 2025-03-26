<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
      "birth_date" => Carbon::parse($this->birth_date)->toIso8601String(),
      "email" => $this->email,
      "subscribe_date" => Carbon::parse($this->subscribe_date)->toIso8601String(),
      "image_profile" => Str::contains($this->img_profile, "http") ? $this->img_profile : asset("storage/" . $this->img_profile),
      "campaigns" => CampaignRessource::collection($this->whenLoaded('campaign')),
    ];
  }
}
