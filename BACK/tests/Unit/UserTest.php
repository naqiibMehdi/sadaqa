<?php

use App\Models\User;

test('un utilisateur peut être créé avec les attributs requis', function () {
  // Arrangement
  $userData = [
    'name' => 'Doe',
    'first_name' => 'John',
    'public_name' => 'JohnDoe',
    'email' => 'john@example.com',
    'password' => bcrypt('password123'),
    'birth_date' => '2000-01-01',
    'subscribe_date' => now(),
    'img_profile' => 'https://ui-avatars.com/api/?name=John+Doe&background=3078c0',
  ];

  // Action
  $user = User::create($userData);

  // Assertion
  expect($user)->toBeInstanceOf(User::class)
    ->and($user->name)->toBe('Doe')
    ->and($user->first_name)->toBe('John')
    ->and($user->email)->toBe('john@example.com');

  $this->assertDatabaseHas('users', [
    'email' => 'john@example.com',
    'name' => 'Doe'
  ]);
});
