<?php

use App\Models\Campaign;
use App\Models\Category;
use App\Models\User;

test('une campagne peut être créée avec les attributs requis', function () {
  // Arrangement
  $user = User::factory()->create();
  $category = Category::factory()->create(["id" => 1, "name" => "animaux"]);

  $campaignData = [
    'title' => 'Ma campagne de test',
    'description' => 'Description de la campagne de test',
    "slug" => "ma-campagne-de-test",
    'target_amount' => 1000,
    'start_date' => now(),
    'end_date' => now()->addDays(30),
    'user_id' => $user->id,
    'category_id' => $category->id,
  ];

  // Action
  $campaign = Campaign::create($campaignData);

  // Assertion
  expect($campaign)->toBeInstanceOf(Campaign::class)
    ->and($campaign->title)->toBe('Ma campagne de test')
    ->and($campaign->target_amount)->toBe(1000)
    ->and($campaign->user_id)->toBe($user->id);

  $this->assertDatabaseHas('campaigns', [
    'title' => 'Ma campagne de test',
    'user_id' => $user->id
  ]);
});

test('une campagne appartient à un utilisateur', function () {
  // Arrangement
  $user = User::factory()->create();
  $category = Category::factory()->create(["id" => 1, "name" => "animaux"]);
  $campaign = Campaign::factory()->create([
    'user_id' => $user->id,
    "category_id" => $category->id,
  ]);

  // Action & Assertion
  expect($campaign->user)->toBeInstanceOf(User::class)
    ->and($campaign->user->id)->toBe($user->id)
    ->and($campaign->category)->toBeInstanceOf(Category::class)
    ->and($campaign->category->id)->toBe($category->id);
});
