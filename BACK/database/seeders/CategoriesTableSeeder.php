<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Category::factory()->createMany([
      [
        "name" => "health",
        "translate_name" => "santé"
      ],
      [
        "name" => "animals",
        "translate_name" => "animaux"
      ],
      [
        "name" => "sport",
        "translate_name" => "sport"
      ],
      [
        "name" => "farming",
        "translate_name" => "agriculture"
      ],
      [
        "name" => "home",
        "translate_name" => "habitation"
      ],
      [
        "name" => "others",
        "translate_name" => "autres"
      ]
    ]);
  }
}
