<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {

    $this->call([
      CategoriesTableSeeder::class,
    ]);

    $users = User::factory()->count(5)->create();

    $users->each(function ($user) {
      Campaign::factory()->count(5)->create(["user_id" => $user->id, "category_id" => rand(1, 6)]);
    });


  }
}
