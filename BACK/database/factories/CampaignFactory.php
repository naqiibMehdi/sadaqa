<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\User;
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
    $datas = [
      "title" => [
        "Construisons un puit",
        "Achat d'un jardin",
        "Réhabilitation d'une maison",
        "SOS animaux en détresse"
      ],

      "description" => [
        "<p>Nous avons d'aide pour construire un puit.</p>",
        "<p>Nous avons d'aide pour construire et/ou louer un jardin afin de faire découvrir cette univers</p>",
        "<p>Des retraités ont besoin de rénover leur maison</p>",
        "<p>Tous les jours, des animaux sont abandonnés.</p><p>Il faut les aider</p>",
      ]
    ];

    return [
      "title" => $datas["title"][rand(0, 3)],
      "description" => $datas["description"][rand(0, 3)],
      "image" => "campaigns/default_cover_campaign.webp",
      "slug" => $this->faker->slug(),
      "target_amount" => $this->faker->randomNumber(rand(3, 6), true),
      "collected_amount" => $this->faker->randomNumber(rand(3, 4), true),
      "created_at" => $this->faker->datetimethismonth(),
      "limit_date" => $this->faker->datetimethismonth("+20 days"),
      "closing_date" => null,
      "is_anonymous" => $this->faker->boolean(),
    ];
  }
}
