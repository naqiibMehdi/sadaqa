@extends('admin.layouts.app')

@section('title', 'Modifier l\'utilisateur')

@section('content')
  <div class="mb-6">
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-3xl font-bold text-gray-800">Modifier l'utilisateur</h1>
        <p class="text-gray-600">Modification des informations de {{ $user->name }}</p>
      </div>
      <a href="{{ route('admin.users.show', $user) }}"
         class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
        <i class="fas fa-arrow-left mr-2"></i>Retour
      </a>
    </div>
  </div>

  <div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md">
      <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">
          <i class="fas fa-user-edit mr-2"></i>Informations de l'utilisateur
        </h2>
      </div>

      <form method="POST" action="{{ route('admin.users.update', $user) }}" class="p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Nom -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
              Nom complet <span class="text-red-500">*</span>
            </label>
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name', $user->name) }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                   required>
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
              Adresse email <span class="text-red-500">*</span>
            </label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email', $user->email) }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                   required>
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
          </div>

          <!-- Nouveau mot de passe -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
              Nouveau mot de passe
            </label>
            <input type="password"
                   id="password"
                   name="password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                   placeholder="Laissez vide pour conserver l'actuel">
            @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-1">Minimum 8 caractères</p>
          </div>

          <!-- Confirmation mot de passe -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
              Confirmer le mot de passe
            </label>
            <input type="password"
                   id="password_confirmation"
                   name="password_confirmation"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <p class="text-sm text-gray-500 mt-1">Seulement si vous changez le mot de passe</p>
          </div>
        </div>

        <!-- Statut -->
        <div class="mt-6">
          <label class="flex items-center">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
            <span class="ml-2 text-sm font-medium text-gray-700">Compte actif</span>
          </label>
          <p class="text-sm text-gray-500 mt-1">Si décoché, l'utilisateur ne pourra pas se connecter</p>
        </div>

        <!-- Informations de modification -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
          <h3 class="text-sm font-medium text-gray-800 mb-2">Informations</h3>
          <div class="text-sm text-gray-600 space-y-1">
            <p><strong>Compte créé le :</strong> {{ $user->subscribe_date->format('d/m/Y') }}</p>
            {{--            <p><strong>Dernière modification :</strong> {{ $user->updated_at->format('d/m/Y à H:i') }}</p>--}}
            {{--            @if($user->email_verified_at)--}}
            {{--              <p><strong>Email vérifié :</strong> {{ $user->email_verified_at->format('d/m/Y à H:i') }}</p>--}}
            {{--            @else--}}
            {{--              <p class="text-yellow-600"><strong>Email non vérifié</strong></p>--}}
            {{--            @endif--}}
          </div>
        </div>

        <!-- Boutons -->
        <div class="mt-8 flex justify-end space-x-4">
          <a href="{{ route('admin.users.show', $user) }}"
             class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
            Annuler
          </a>
          <button type="submit"
                  class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
            <i class="fas fa-save mr-2"></i>Enregistrer les modifications
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
