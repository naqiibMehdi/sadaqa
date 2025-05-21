<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('un utilisateur peut s\'inscrire et se connecter', function () {
  // Test d'inscription
  $registerData = [
    'name' => 'Doe',
    'first_name' => 'John',
    'public_name' => 'JohnDoe',
    'email' => 'john@example.com',
    'password' => 'Password123*',
    'password_confirmation' => 'Password123*',
    'birth_date' => '2000-01-01',
  ];

  $registerResponse = $this->postJson('/api/auth/register', $registerData);

  $registerResponse->assertStatus(201)
    ->assertJson([
      'message' => 'votre compte a été crée avec succès'
    ]);

  $this->assertDatabaseHas('users', [
    'email' => 'john@example.com',
  ]);

  // Test de connexion
  $loginResponse = $this->postJson('/api/auth/login', [
    'email' => 'john@example.com',
    'password' => 'Password123*'
  ]);

  $loginResponse->assertStatus(200)
    ->assertJsonStructure(['token']);
});

it('permet à un utilisateur de se déconnecter', function () {
  // Arrangement - Créer et connecter un utilisateur
  $user = User::create([
    'name' => 'Doe',
    'first_name' => 'John',
    'public_name' => 'JohnDoe',
    'email' => 'john@example.com',
    'password' => Hash::make('Password123*'),
    'birth_date' => '2000-03-26',
    'subscribe_date' => now(),
    'img_profile' => 'https://ui-avatars.com/api/?name=John+Doe&background=3078c0',
  ]);

  $token = $user->createToken('TestToken')->plainTextToken;

  // Action - Déconnecter l'utilisateur
  $response = $this->withHeader('Authorization', 'Bearer ' . $token)
    ->postJson('/api/auth/logout');

  // Assertion
  $response->assertStatus(200)
    ->assertJson([
      'message' => 'token supprimé avec succès'
    ]);

  // Vérifier que le token a été supprimé
  $this->assertDatabaseCount('personal_access_tokens', 0);
});
