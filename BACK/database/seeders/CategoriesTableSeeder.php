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
        "name" => "santé"
      ],
      [
        "name" => "animaux"
      ],
      [
        "name" => "sport"
      ],
      [
        "name" => "agriculture"
      ],
      [
        "name" => "habitation"
      ],
      [
        "name" => "autres"
      ]
    ]);
  }
}
