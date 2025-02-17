<?php

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Campaign>
 */
class CampaignFactory extends Factory
{

  protected $model = Campaign::class;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      "title" => $this->faker->sentence(rand(6, 12), true),
      "description" => $this->faker->paragraph(rand(1, 5), true),
      "image" => "campaigns/default_cover_campaign.png",
      "slug" => $this->faker->slug(),
      "target_amount" => $this->faker->randomNumber(rand(3, 6), true),
      "collected_amount" => $this->faker->randomNumber(rand(3, 4), true),
      "created_at" => $this->faker->datetimethismonth(),
      "limit_date" => $this->faker->datetimethismonth("+20 days"),
      "closing_date" => $this->faker->datetimethismonth("+30 days"),
    ];
  }
}
