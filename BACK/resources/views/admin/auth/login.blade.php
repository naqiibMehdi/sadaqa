<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion Administrateur - Sadaqa</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen flex items-center justify-center">
<div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-md">
  <div class="text-center mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Administration</h1>
    <p class="text-gray-600">Connectez-vous à votre espace administrateur</p>
  </div>

  <form method="POST" action="{{ \App\Helpers\UrlHelper::assetUrl("admin/login") }}">
    @csrf

    <!-- Email -->
    <div class="mb-4">
      <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
        Adresse email
      </label>
      <input type="email"
             id="email"
             name="email"
             value="{{ old('email') }}"
             class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
             placeholder="admin@example.com"
             required>
      @error('email')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Password -->
    <div class="mb-6">
      <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
        Mot de passe
      </label>
      <input type="password"
             id="password"
             name="password"
             class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
             placeholder="••••••••"
             required>
      @error('password')
      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <!-- Remember Me -->
    <div class="flex items-center justify-between mb-6">
      <label class="flex items-center">
        <input type="checkbox" name="remember"
               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
        <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
      </label>
    </div>

    <!-- Submit Button -->
    <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-300">
      Se connecter
    </button>
  </form>

  @if(session('error'))
    <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
      {{ session('error') }}
    </div>
  @endif
</div>
</body>
</html>
