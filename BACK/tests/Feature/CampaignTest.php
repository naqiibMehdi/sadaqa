<?php

use App\Models\Campaign;
use App\Models\Category;
use App\Models\User;

test('un utilisateur peut créer une campagne', function () {
  // Arrangement
  $user = User::factory()->create();
  $category = Category::factory()->create(["id" => 1, "name" => "animaux"]);
  $this->actingAs($user);

  $campaignData = [
    'title' => 'Nouvelle campagne',
    'description' => 'Description détaillée de la campagne',
    'slug' => 'nouvelle-campagne',
    'target_amount' => 5000,
    'image' => null,
    'user_id' => $user->id,
    'category_id' => $category->id,
  ];

  // Action
  $response = $this->postJson('/api/campaigns', $campaignData);

  // Assertion
  $response->assertStatus(201)
    ->assertJsonFragment([
      'title' => 'Nouvelle campagne',
      'target_amount' => 5000
    ]);

  $this->assertDatabaseHas('campaigns', [
    'title' => 'Nouvelle campagne',
    'user_id' => $user->id,
    'category_id' => $category->id
  ]);
});

test('la liste des campagnes peut être récupérée avec pagination', function () {
  // Arrangement
  $user = User::factory()->create();
  $category = Category::factory()->create(["id" => 1, "name" => "animaux"]);
  Campaign::factory()->count(15)->create(['user_id' => $user->id, "category_id" => $category->id]);

  // Action
  $response = $this->getJson('/api/campaigns?page=1');

  // Assertion
  $response->assertStatus(200)
    ->assertJsonStructure([
      'data' => [
        '*' => [
          'id',
          'title',
          'description',
          'slug',
          'target_amount',
          'user' => ["id"],
          'category_id',
        ]
      ],
      'meta' => [
        'current_page',
        'from',
        'last_page',
        'per_page',
        'to',
        'total'
      ],
      'links' => [
        'first',
        'last',
        'prev',
        'next'
      ]
    ]);

  // Vérifier que nous avons les bons nombres d'éléments
  $responseData = $response->json();
  expect(count($responseData['data']))->toBeLessThanOrEqual(10); // Supposons que la pagination est de 10 par page
  expect($responseData['meta']['total'])->toBe(15);
});
