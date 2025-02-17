<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

  protected $model = User::class;
  /**
   * The current password being used by the factory.
   */
  protected static ?string $password;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'name' => fake()->name(),
      "first_name" => fake()->firstName(),
      "public_name" => fake()->name(),
      "birth_date" => fake()->date(),
      'email' => fake()->unique()->safeEmail(),
      'password' => static::$password ??= Hash::make('1234'),
      "subscribe_date" => fake()->date(),
      "img_profile" => "https://ui-avatars.com/api/?name={$this->faker->name()}+{$this->faker->firstName()}&background=3078c0"
    ];
  }
}
